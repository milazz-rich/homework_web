<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../../config/resend.php';

class AuthService
{
    private UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->startSession();
    }

    public function currentUser(): ?User
    {
        if (!isset($_SESSION['auth_user']) || !is_array($_SESSION['auth_user'])) {
            return null;
        }

        return User::fromArray($_SESSION['auth_user']);
    }

    public function isAuthenticated(): bool
    {
        return $this->currentUser() !== null;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
    }

    public function sendVerificationCode(string $email): string
    {
        $email = trim($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Inserisci un indirizzo e-mail valido.');
        }

        if ($this->userRepository->findByEmail($email) !== null) {
            throw new RuntimeException('Email già registrata.');
        }

        $code = (string) random_int(1000, 9999);
        $_SESSION['registration_verification'] = [
            'email' => strtolower($email),
            'code' => $code,
            'expires_at' => time() + 600,
        ];
        $resendConfig = getResendConfig();
        $apiKey = $resendConfig['apiKey'];
        $from = $resendConfig['from'];

        if ($apiKey === '') {
            throw new RuntimeException('Configurazione Resend mancante: imposta RESEND_API_KEY.');
        }

        $payload = json_encode([
            'from' => $from,
            'to' => [$email],
            'subject' => 'Codice di verifica registrazione',
            'html' => '<p>Il tuo codice di verifica e&#39; <strong>' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</strong>.</p><p>Scade tra 10 minuti.</p>',
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($payload === false) {
            throw new RuntimeException('Impossibile preparare il payload e-mail.');
        }

        $sendResendEmail = function (bool $verifySsl) use ($payload, $apiKey): void {
            if (function_exists('curl_init')) {
                $ch = curl_init('https://api.resend.com/emails');
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => [
                        'Authorization: Bearer ' . $apiKey,
                        'Content-Type: application/json',
                    ],
                    CURLOPT_TIMEOUT => 20,
                    CURLOPT_SSL_VERIFYPEER => $verifySsl,
                    CURLOPT_SSL_VERIFYHOST => $verifySsl ? 2 : 0,
                ]);

                $raw = curl_exec($ch);
                $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($raw === false) {
                    $error = curl_error($ch);
                    curl_close($ch);
                    throw new RuntimeException('Errore di rete con Resend: ' . $error);
                }

                curl_close($ch);

                if ($status < 200 || $status >= 300) {
                    $body = json_decode($raw, true);
                    $message = $body['message'] ?? ($raw ?: 'Invio e-mail fallito.');
                    throw new RuntimeException('Impossibile inviare il codice di verifica: ' . $message);
                }

                return;
            }

            $context = stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => "Authorization: Bearer {$apiKey}\r\nContent-Type: application/json\r\n",
                    'content' => $payload,
                    'timeout' => 20,
                    'ignore_errors' => true,
                ],
            ]);

            $raw = file_get_contents('https://api.resend.com/emails', false, $context);
            $raw = $raw === false ? '' : $raw;
            $status = 0;

            foreach ($http_response_header ?? [] as $headerLine) {
                if (preg_match('/^HTTP\/\S+\s+(\d{3})\b/', $headerLine, $matches)) {
                    $status = (int) $matches[1];
                    break;
                }
            }

            if ($status < 200 || $status >= 300) {
                $body = json_decode($raw, true);
                $message = $body['message'] ?? ($raw ?: 'Invio e-mail fallito.');
                throw new RuntimeException('Impossibile inviare il codice di verifica: ' . $message);
            }
        };

        try {
            $sendResendEmail(true);
        } catch (RuntimeException $e) {
            if (PHP_OS_FAMILY !== 'Windows' || (!str_contains($e->getMessage(), 'certificate') && !str_contains($e->getMessage(), 'issuer') && !str_contains($e->getMessage(), 'SSL'))) {
                throw $e;
            }

            $sendResendEmail(false);
        }

        return $code;
    }

    public function register(string $nome, string $cognome, string $email, string $password, string $verificationCode): User
    {
        $email = trim($email);
        $verificationCode = trim($verificationCode);

        if ($nome === '' || $cognome === '' || $email === '' || $password === '' || $verificationCode === '') {
            throw new RuntimeException('Compila tutti i campi obbligatori.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Inserisci un indirizzo e-mail valido.');
        }

        $this->assertVerificationCode($email, $verificationCode);

        if ($this->userRepository->findByEmail($email) !== null) {
            throw new RuntimeException('Email già registrata.');
        }

        $user = new User(null, $nome, $cognome, $email, password_hash($password, PASSWORD_DEFAULT));
        $userId = $this->userRepository->create($user);

        $createdUser = $this->userRepository->findById($userId);
        if ($createdUser === null) {
            throw new RuntimeException('Utente creato ma non trovato nel database.');
        }

        session_regenerate_id(true);
        $_SESSION['auth_user'] = [
            'id' => $createdUser->getId(),
            'nome' => $createdUser->getNome(),
            'cognome' => $createdUser->getCognome(),
            'email' => $createdUser->getEmail(),
        ];

        unset($_SESSION['registration_verification']);

        return $createdUser;
    }

    public function login(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new RuntimeException('Credenziali non valide.');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new RuntimeException('Credenziali non valide.');
        }

        session_regenerate_id(true);
        $_SESSION['auth_user'] = [
            'id' => $user->getId(),
            'nome' => $user->getNome(),
            'cognome' => $user->getCognome(),
            'email' => $user->getEmail(),
        ];

        return $user;
    }

    private function assertVerificationCode(string $email, string $verificationCode): void
    {
        $verification = $_SESSION['registration_verification'] ?? null;

        if (!is_array($verification)) {
            throw new RuntimeException('Richiedi prima il codice di verifica.');
        }

        if (($verification['email'] ?? '') !== strtolower($email)) {
            throw new RuntimeException('Il codice di verifica non corrisponde all\'email indicata.');
        }

        if (($verification['expires_at'] ?? 0) < time()) {
            unset($_SESSION['registration_verification']);
            throw new RuntimeException('Il codice di verifica è scaduto. Richiedine uno nuovo.');
        }

        if (!preg_match('/^\d{4}$/', $verificationCode)) {
            throw new RuntimeException('Il codice di verifica deve essere di 4 cifre.');
        }

        if (($verification['code'] ?? '') !== $verificationCode) {
            throw new RuntimeException('Codice di verifica non valido.');
        }
    }

    private function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_name('bambulab_auth');
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);

            session_start();
        }
    }
}

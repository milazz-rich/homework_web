<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/EmailService.php';

class AuthService
{
    private UserRepository $userRepository;
    private EmailService $emailService;

    public function __construct(?UserRepository $userRepository = null, ?EmailService $emailService = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->emailService = $emailService ?? new EmailService();
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
        $this->emailService->sendVerificationCodeEmail($email, $code);

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

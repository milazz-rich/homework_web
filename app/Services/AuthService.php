<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AuthService
{
  private const VERIFICATION_SESSION_KEY = 'registration_verification';

  // Inietta il servizio email usato per i codici di verifica.
  public function __construct(
    private EmailService $emailService
  ) {
  }

  // Recupera l'utente attualmente salvato in sessione.
  public function currentUser(): ?User
  {
    $userId = session('user_id');

    if (!$userId) {
      return null;
    }

    return User::query()->find($userId);
  }

  // Verifica se nella sessione esiste un utente autenticato.
  public function isAuthenticated(): bool
  {
    return session()->has('user_id');
  }

  // Chiude la sessione corrente e rigenera l'id sessione.
  public function logout(): void
  {
    session()->flush();
    session()->regenerate();
  }

  // Genera e invia il codice temporaneo per la registrazione.
  public function sendVerificationCode(string $email): string
  {
    $email = $this->normalizeEmail($email);

    $this->assertValidEmail($email);
    $this->assertEmailNotRegistered($email);

    $code = (string) random_int(1000, 9999);

    session([
      self::VERIFICATION_SESSION_KEY => [
        'email' => $email,
        'code' => $code,
        'expires_at' => now()->addMinutes(10)->timestamp,
      ],
    ]);

    $this->emailService->sendVerificationCodeEmail($email, $code);

    return $code;
  }

  // Crea l'utente dopo aver verificato dati e codice ricevuto via email.
  public function register(
    string $nome,
    string $cognome,
    string $email,
    string $password,
    string $verificationCode
  ): User {
    $nome = trim($nome);
    $cognome = trim($cognome);
    $email = $this->normalizeEmail($email);
    $verificationCode = trim($verificationCode);

    $this->assertRequiredRegistrationFields($nome, $cognome, $email, $password, $verificationCode);
    $this->assertValidEmail($email);
    $this->assertVerificationCode($email, $verificationCode);
    $this->assertEmailNotRegistered($email);

    $user = User::create([
      'nome' => $nome,
      'cognome' => $cognome,
      'email' => $email,
      'password' => Hash::make($password),
    ]);

    $this->loginUserInSession($user);
    session()->forget(self::VERIFICATION_SESSION_KEY);

    return $user;
  }

  // Autentica l'utente con email e password.
  public function login(string $email, string $password): User
  {
    $email = $this->normalizeEmail($email);

    if ($email === '' || $password === '') {
      throw new RuntimeException('Inserisci email e password.');
    }

    $user = User::query()
      ->where('email', $email)
      ->first();

    if (!$user || !Hash::check($password, $user->password)) {
      throw new RuntimeException('Credenziali non valide.');
    }

    $this->loginUserInSession($user);

    return $user;
  }

  // Normalizza l'email prima di validazioni e query.
  private function normalizeEmail(string $email): string
  {
    return strtolower(trim($email));
  }

  // Controlla che l'email abbia un formato valido.
  private function assertValidEmail(string $email): void
  {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new RuntimeException('Inserisci un indirizzo e-mail valido.');
    }
  }

  // Impedisce la registrazione con email già presente.
  private function assertEmailNotRegistered(string $email): void
  {
    if (User::query()->where('email', $email)->exists()) {
      throw new RuntimeException('Email già registrata.');
    }
  }

  // Controlla che tutti i campi della registrazione siano compilati.
  private function assertRequiredRegistrationFields(
    string $nome,
    string $cognome,
    string $email,
    string $password,
    string $verificationCode
  ): void {
    if ($nome !== '' && $cognome !== '' && $email !== '' && $password !== '' && $verificationCode !== '') {
      return;
    }

    throw new RuntimeException('Compila tutti i campi obbligatori.');
  }

  // Salva i dati essenziali dell'utente nella sessione.
  private function loginUserInSession(User $user): void
  {
    session()->regenerate();

    session([
      'user_id' => $user->id,
      'nome' => $user->nome,
      'cognome' => $user->cognome,
      'email' => $user->email,
    ]);
  }

  // Valida il codice di verifica salvato temporaneamente in sessione.
  private function assertVerificationCode(string $email, string $verificationCode): void
  {
    $verification = session(self::VERIFICATION_SESSION_KEY);

    if (!is_array($verification)) {
      throw new RuntimeException('Richiedi prima il codice di verifica.');
    }

    if (($verification['email'] ?? '') !== strtolower($email)) {
      throw new RuntimeException('Il codice di verifica non corrisponde all\'email indicata.');
    }

    if (($verification['expires_at'] ?? 0) < now()->timestamp) {
      session()->forget(self::VERIFICATION_SESSION_KEY);

      throw new RuntimeException('Il codice di verifica è scaduto. Richiedine uno nuovo.');
    }

    if (!preg_match('/^\d{4}$/', $verificationCode)) {
      throw new RuntimeException('Il codice di verifica deve essere di 4 cifre.');
    }

    if (($verification['code'] ?? '') !== $verificationCode) {
      throw new RuntimeException('Codice di verifica non valido.');
    }
  }
}

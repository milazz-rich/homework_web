<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AuthService
{
    public function isAuthenticated(): bool
    {
        return session()->has('auth_user');
    }

    public function login(string $email, string $password): User
    {
        $email = trim($email);

        if ($email === '' || $password === '') {
            throw new RuntimeException('Compila tutti i campi obbligatori.');
        }

        $user = User::query()->where('email', $email)->first();

        if ($user === null || ! Hash::check($password, $user->password)) {
            throw new RuntimeException('Credenziali non valide.');
        }

        session()->regenerate();
        $this->storeAuthenticatedUser($user);

        return $user;
    }

    public function register(string $nome, string $cognome, string $email, string $password, string $verificationCode): User
    {
        $nome = trim($nome);
        $cognome = trim($cognome);
        $email = trim($email);
        $verificationCode = trim($verificationCode);

        if ($nome === '' || $cognome === '' || $email === '' || $password === '' || $verificationCode === '') {
            throw new RuntimeException('Compila tutti i campi obbligatori.');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Inserisci un indirizzo e-mail valido.');
        }

        $this->assertVerificationCode($email, $verificationCode);

        if (User::query()->where('email', $email)->exists()) {
            throw new RuntimeException('Email gia registrata.');
        }

        $user = User::query()->create([
            'nome' => $nome,
            'cognome' => $cognome,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        session()->regenerate();
        session()->forget('registration_verification');
        $this->storeAuthenticatedUser($user);

        return $user;
    }

    public function sendVerificationCode(string $email): void
    {
        $email = trim($email);

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Inserisci un indirizzo e-mail valido.');
        }

        if (User::query()->where('email', $email)->exists()) {
            throw new RuntimeException('Email gia registrata.');
        }

        $code = (string) random_int(1000, 9999);
        session()->put('registration_verification', [
            'email' => strtolower($email),
            'code' => $code,
            'expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        $this->sendVerificationEmail($email, $code);
    }

    public function logout(): void
    {
        session()->forget('auth_user');
        session()->invalidate();
        session()->regenerateToken();
    }

    private function assertVerificationCode(string $email, string $verificationCode): void
    {
        $verification = session('registration_verification');

        if (! is_array($verification)) {
            throw new RuntimeException('Richiedi prima il codice di verifica.');
        }

        if (($verification['email'] ?? '') !== strtolower($email)) {
            throw new RuntimeException('Il codice di verifica non corrisponde all\'email indicata.');
        }

        if (($verification['expires_at'] ?? 0) < time()) {
            session()->forget('registration_verification');
            throw new RuntimeException('Il codice di verifica e scaduto. Richiedine uno nuovo.');
        }

        if (! preg_match('/^\d{4}$/', $verificationCode)) {
            throw new RuntimeException('Il codice di verifica deve essere di 4 cifre.');
        }

        if (($verification['code'] ?? '') !== $verificationCode) {
            throw new RuntimeException('Codice di verifica non valido.');
        }
    }

    private function storeAuthenticatedUser(User $user): void
    {
        session()->put('auth_user', [
            'id' => $user->id,
            'nome' => $user->nome,
            'cognome' => $user->cognome,
            'email' => $user->email,
        ]);
    }

    private function sendVerificationEmail(string $to, string $code): void
    {
        $apiKey = (string) env('RESEND_API_KEY', '');
        $from = (string) env('RESEND_FROM', '');

        if ($apiKey === '') {
            throw new RuntimeException('Configurazione Resend mancante: imposta RESEND_API_KEY.');
        }

        $response = Http::withToken($apiKey)
            ->timeout(20)
            ->post('https://api.resend.com/emails', [
                'from' => $from,
                'to' => [$to],
                'subject' => 'Codice di verifica registrazione',
                'html' => '<p>Il tuo codice di verifica e <strong>'.$code.'</strong>.</p><p>Scade tra 10 minuti.</p>',
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Impossibile inviare il codice di verifica: '.($response->json('message') ?? $response->body()));
        }
    }
}

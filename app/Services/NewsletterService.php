<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class NewsletterService
{
  private string $accessKey;
  private string $endpoint;
  private int $timeout;

  // Carica la configurazione Mailboxlayer usata per validare le email.
  public function __construct()
  {
    $this->accessKey = (string) config('mailboxlayer.access_key', '');
    $this->endpoint = (string) config('mailboxlayer.endpoint', 'https://apilayer.net/api/check');
    $this->timeout = (int) config('mailboxlayer.timeout', 20);
  }

  // Valida email e consenso prima di completare l'iscrizione newsletter.
  public function signup(string $email, string $consent): array
  {
    $email = trim($email);
    $consent = trim($consent);

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return $this->failure('Inserisci un indirizzo e-mail valido.');
    }

    if ($consent !== '1') {
      return $this->failure('Devi accettare il consenso marketing.');
    }

    if ($this->accessKey === '') {
      return $this->failure('Configurazione Mailboxlayer mancante: imposta MAILBOXLAYER_ACCESS_KEY.');
    }

    $data = $this->validateEmailWithMailboxlayer($email);

    if (!is_array($data)) {
      return $this->failure('Risposta API non valida.');
    }

    if (($data['success'] ?? true) === false) {
      return $this->failure($data['error']['info'] ?? 'Errore API Mailboxlayer: richiesta non valida.');
    }

    if (!empty($data['format_valid']) && !empty($data['mx_found'])) {
      return $this->success('Email valida. Iscrizione completata.');
    }

    return $this->failure('Email non valida. Controlla l\'indirizzo inserito.');
  }

  private function validateEmailWithMailboxlayer(string $email): ?array
  {
    try {
      $response = Http::timeout($this->timeout)
        ->withoutVerifying()
        ->acceptJson()
        ->get($this->endpoint, [
          'access_key' => $this->accessKey,
          'email' => $email,
          'smtp' => 1,
          'format' => 1,
        ]);
    } catch (ConnectionException $e) {
      return [
        'success' => false,
        'error' => [
          'info' => $e->getMessage() !== ''
            ? 'Errore API Mailboxlayer: ' . $e->getMessage()
            : 'Errore di rete o server non raggiungibile.',
        ],
      ];
    }

    if (!$response->successful()) {
      return [
        'success' => false,
        'error' => [
          'info' => 'Errore di rete o server non raggiungibile.',
        ],
      ];
    }

    $data = $response->json();

    return is_array($data) ? $data : null;
  }

  private function success(string $message): array
  {
    return [
      'success' => true,
      'message' => $message,
    ];
  }

  private function failure(string $message): array
  {
    return [
      'success' => false,
      'message' => $message,
    ];
  }
}

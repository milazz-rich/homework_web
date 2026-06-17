<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use RuntimeException;

class StripeService
{
  private string $secretKey;
  private string $publishableKey;
  private string $webhookSecret;
  private string $currency;
  private string $baseUrl;
  private int $timeout;

  // Carica la configurazione Stripe usata dalle chiamate API.
  public function __construct()
  {
    $this->secretKey = (string) config('stripe.secret_key', '');
    $this->publishableKey = (string) config('stripe.publishable_key', '');
    $this->webhookSecret = (string) config('stripe.webhook_secret', '');
    $this->currency = (string) config('stripe.currency', 'eur');
    $this->baseUrl = rtrim((string) config('stripe.base_url', 'https://api.stripe.com/v1'), '/');
    $this->timeout = (int) config('stripe.timeout', 30);
  }

  // Crea una sessione di checkout Stripe con gli item ricevuti.
  public function createCheckoutSession(
    array $items,
    string $successUrl,
    string $cancelUrl,
    ?string $customerEmail = null,
    array $metadata = []
  ): array {
    $payload = [
      'mode' => 'payment',
      'success_url' => $successUrl,
      'cancel_url' => $cancelUrl,
    ];

    if ($customerEmail !== null && $customerEmail !== '') {
      $payload['customer_email'] = $customerEmail;
    }

    foreach ($metadata as $key => $value) {
      $payload['metadata[' . $key . ']'] = (string) $value;
    }

    foreach ($items as $index => $item) {
      $payload += $this->buildLineItemPayload($item, $index);
    }

    return $this->request(
      'POST',
      '/checkout/sessions',
      $payload
    );
  }

  // Recupera da Stripe le righe prodotto associate a una sessione checkout.
  public function retrieveCheckoutSessionLineItems(string $sessionId): array
  {
    $sessionId = trim($sessionId);

    if ($sessionId === '') {
      throw new InvalidArgumentException('Session id non valido.');
    }

    return $this->request(
      'GET',
      '/checkout/sessions/' . rawurlencode($sessionId) . '/line_items',
      [
        'limit' => 100,
      ]
    );
  }

  // Restituisce la chiave pubblicabile Stripe per il frontend.
  public function getPublishableKey(): string
  {
    return $this->publishableKey;
  }

  // Restituisce il secret usato per verificare i webhook Stripe.
  public function getWebhookSecret(): string
  {
    return $this->webhookSecret;
  }

  // Recupera i dettagli della sessione checkout per verificarne lo stato.
  public function retrieveCheckoutSession(string $sessionId): array
  {
    $sessionId = trim($sessionId);

    if ($sessionId === '') {
      throw new InvalidArgumentException('Session id non valido.');
    }

    return $this->request(
      'GET',
      '/checkout/sessions/' . rawurlencode($sessionId)
    );
  }

  // Converte un item interno nel formato form richiesto da Stripe.
  private function buildLineItemPayload(array $item, int $index): array
  {
    if (empty($item['name']) || !isset($item['unit_amount'], $item['quantity'])) {
      throw new InvalidArgumentException('Ogni item deve contenere name, unit_amount e quantity.');
    }

    $linePrefix = 'line_items[' . $index . ']';
    $payload = [
      $linePrefix . '[quantity]' => max(1, (int) $item['quantity']),
      $linePrefix . '[price_data][currency]' => $this->currency,
      $linePrefix . '[price_data][unit_amount]' => (int) $item['unit_amount'],
      $linePrefix . '[price_data][product_data][name]' => (string) $item['name'],
    ];

    if (!empty($item['description'])) {
      $payload[$linePrefix . '[price_data][product_data][description]'] = (string) $item['description'];
    }

    if (!empty($item['image'])) {
      $payload[$linePrefix . '[price_data][product_data][images][0]'] = (string) $item['image'];
    }

    return $payload;
  }

  // Esegue una richiesta HTTP verso Stripe e normalizza gli errori.
  private function request(string $method, string $endpoint, array $payload = []): array
  {
    if ($this->secretKey === '') {
      throw new RuntimeException('Configurazione Stripe mancante: imposta STRIPE_SECRET_KEY.');
    }

    $url = $this->baseUrl . '/' . ltrim($endpoint, '/');

    try {
      $client = Http::timeout($this->timeout)
        ->withoutVerifying()
        ->withToken($this->secretKey)
        ->acceptJson();

      $response = match (strtoupper($method)) {
        'GET' => $client->get($url, $payload),
        'POST' => $client->asForm()->post($url, $payload),
        default => throw new InvalidArgumentException('Metodo HTTP non supportato.'),
      };
    } catch (ConnectionException $e) {
      throw new RuntimeException('Errore di rete con Stripe: ' . $e->getMessage());
    }

    $decoded = $response->json();

    if (!is_array($decoded)) {
      throw new RuntimeException('Risposta Stripe non valida.');
    }

    if (!$response->successful()) {
      $message = $decoded['error']['message'] ?? 'Richiesta Stripe fallita.';

      throw new RuntimeException($message);
    }

    return $decoded;
  }
}

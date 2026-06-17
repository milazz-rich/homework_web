<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class EmailService
{
  private string $apiKey;
  private string $from;
  private string $endpoint;
  private int $timeout;

  // Carica la configurazione Resend usata per l'invio email.
  public function __construct()
  {
    $this->apiKey = (string) config('resend.api_key', '');
    $this->from = (string) config('resend.from', '');
    $this->endpoint = (string) config('resend.endpoint', 'https://api.resend.com/emails');
    $this->timeout = (int) config('resend.timeout', 20);
  }

  // Invia il codice di verifica usato durante la registrazione.
  public function sendVerificationCodeEmail(string $to, string $code): void
  {
    $html = $this->buildVerificationCodeHtml($code);

    $this->sendEmail(
      $to,
      'Codice di verifica registrazione',
      $html,
      'Impossibile inviare il codice di verifica'
    );
  }

  // Invia il riepilogo dell'ordine dopo il pagamento completato.
  public function sendOrderRecapEmail(string $to, string $sessionId, array $lineItems): void
  {
    $html = $this->buildOrderRecapHtml($sessionId, $lineItems);

    $this->sendEmail(
      $to,
      'Riepilogo del tuo ordine',
      $html,
      'Impossibile inviare il recap ordine'
    );
  }

  // Costruisce il contenuto HTML per il codice di verifica.
  private function buildVerificationCodeHtml(string $code): string
  {
    return '<p>Il tuo codice di verifica è <strong>' . e($code) . '</strong>.</p>'
      . '<p>Scade tra 10 minuti.</p>';
  }

  // Costruisce il contenuto HTML completo del riepilogo ordine.
  private function buildOrderRecapHtml(string $sessionId, array $lineItems): string
  {
    $summary = $this->buildOrderRows($lineItems);

    return '<div style="font-family:Arial,sans-serif;color:#171717;line-height:1.5;">'
      . '<h1 style="margin:0 0 12px;">Grazie per il tuo ordine</h1>'
      . '<p>Il pagamento è stato completato correttamente. Qui sotto trovi il riepilogo del tuo ordine.</p>'
      . '<table style="width:100%;border-collapse:collapse;margin-top:18px;">'
      . '<thead><tr>'
      . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:left;">Prodotto</th>'
      . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:center;">Quantità</th>'
      . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:right;">Totale</th>'
      . '</tr></thead>'
      . '<tbody>' . $summary['rows'] . '</tbody>'
      . '<tfoot><tr>'
      . '<td colspan="2" style="padding:14px 10px;text-align:right;font-weight:bold;">Totale ordine</td>'
      . '<td style="padding:14px 10px;text-align:right;font-weight:bold;">'
      . e($this->formatStripeAmount($summary['total'], $summary['currency']))
      . '</td>'
      . '</tr></tfoot>'
      . '</table>'
      . '<p style="margin-top:18px;color:#666;">ID sessione Stripe: ' . e($sessionId) . '</p>'
      . '</div>';
  }

  // Prepara righe, totale e valuta per la tabella ordine.
  private function buildOrderRows(array $lineItems): array
  {
    $rows = '';
    $total = 0;
    $currency = 'eur';

    foreach ($lineItems as $item) {
      $name = (string) ($item['description'] ?? 'Prodotto');
      $quantity = (int) ($item['quantity'] ?? 1);
      $amount = (int) ($item['amount_total'] ?? 0);
      $currency = (string) ($item['currency'] ?? $currency);

      $total += $amount;
      $rows .= $this->buildOrderRowHtml($name, $quantity, $amount, $currency);
    }

    return [
      'rows' => $rows !== '' ? $rows : '<tr><td colspan="3">Ordine completato</td></tr>',
      'total' => $total,
      'currency' => $currency,
    ];
  }

  // Costruisce una singola riga HTML della tabella ordine.
  private function buildOrderRowHtml(string $name, int $quantity, int $amount, string $currency): string
  {
    return '<tr>'
      . '<td>' . e($name) . '</td>'
      . '<td>' . $quantity . '</td>'
      . '<td>' . e($this->formatStripeAmount($amount, $currency)) . '</td>'
      . '</tr>';
  }

  // Invoca Resend e gestisce errori di configurazione o rete.
  private function sendEmail(string $to, string $subject, string $html, string $errorPrefix): void
  {
    if ($this->apiKey === '') {
      throw new RuntimeException('Configurazione Resend mancante: imposta RESEND_API_KEY.');
    }

    if ($this->from === '') {
      throw new RuntimeException('Configurazione Resend mancante: imposta RESEND_FROM.');
    }

    try {
      $response = Http::timeout($this->timeout)
        ->withoutVerifying()
        ->withToken($this->apiKey)
        ->acceptJson()
        ->asJson()
        ->post($this->endpoint, [
          'from' => $this->from,
          'to' => [$to],
          'subject' => $subject,
          'html' => $html,
        ]);
    } catch (ConnectionException $e) {
      throw new RuntimeException('Errore di rete con Resend: ' . $e->getMessage());
    }

    if (!$response->successful()) {
      $message = $response->json('message')
        ?? $response->json('error')
        ?? $response->body()
        ?: 'Invio e-mail fallito.';

      throw new RuntimeException($errorPrefix . ': ' . $message);
    }
  }

  // Converte gli importi Stripe da centesimi a formato leggibile.
  private function formatStripeAmount(int $amount, string $currency): string
  {
    return number_format($amount / 100, 2, ',', '.') . ' ' . strtoupper($currency);
  }
}

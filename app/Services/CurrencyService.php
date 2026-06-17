<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
  private string $endpoint = 'https://open.er-api.com/v6/latest';

  private int $timeout = 20;

  // Converte un importo tra due valute usando ExchangeRate API.
  public function convert(float $amount, string $from, string $to): array
  {
    $from = strtoupper(trim($from));
    $to = strtoupper(trim($to));

    if (!is_finite($amount) || $amount <= 0) {
      return $this->failure('Inserisci un importo valido maggiore di zero.');
    }

    if ($from === '' || $to === '') {
      return $this->failure('Seleziona le valute.');
    }

    if ($from === $to) {
      return $this->success($this->formatSameCurrencyMessage($amount, $from, $to));
    }

    $data = $this->fetchRates($from);

    if (($data['result'] ?? '') !== 'success') {
      return $this->failure('Errore nel recupero del cambio valuta.');
    }

    $rate = $data['rates'][$to] ?? null;

    if (!is_numeric($rate)) {
      return $this->failure('Valuta di destinazione non disponibile.');
    }

    return $this->success($this->formatConversionMessage($amount, $from, $to, (float) $rate));
  }

  private function fetchRates(string $from): array
  {
    try {
      $response = Http::timeout($this->timeout)
        ->withoutVerifying()
        ->acceptJson()
        ->get($this->endpoint . '/' . urlencode($from));
    } catch (ConnectionException $e) {
      return [
        'result' => 'error',
        'message' => $e->getMessage(),
      ];
    }

    if (!$response->successful()) {
      return [
        'result' => 'error',
      ];
    }

    $data = $response->json();

    return is_array($data) ? $data : [
      'result' => 'error',
    ];
  }

  private function formatSameCurrencyMessage(float $amount, string $from, string $to): string
  {
    $formattedAmount = number_format($amount, 2, '.', '');

    return $formattedAmount . ' ' . $from . ' = ' . $formattedAmount . ' ' . $to;
  }

  private function formatConversionMessage(float $amount, string $from, string $to, float $rate): string
  {
    $converted = $amount * $rate;

    return number_format($amount, 2, '.', '') . ' ' . $from
      . ' = ' . number_format($converted, 2, '.', '') . ' ' . $to
      . ' (1 ' . $from . ' = ' . number_format($rate, 4, '.', '') . ' ' . $to . ')';
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

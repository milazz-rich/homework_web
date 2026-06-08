<?php

function processCurrencyConversion(float $amount, string $from, string $to): array
{
    if (!is_finite($amount) || $amount <= 0) {
        return ['success' => false, 'message' => 'Inserisci un importo valido maggiore di zero.'];
    }

    if ($from === '' || $to === '') {
        return ['success' => false, 'message' => 'Seleziona le valute.'];
    }

    if ($from === $to) {
        $text = number_format($amount, 2, '.', '') . ' ' . $from . ' = ' . number_format($amount, 2, '.', '') . ' ' . $to;
        return ['success' => true, 'message' => $text];
    }

    $url = 'https://open.er-api.com/v6/latest/' . urlencode($from);
    $ch = curl_init($url);

    if ($ch === false) {
        return ['success' => false, 'message' => 'Errore di rete o server non raggiungibile.'];
    }

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_HTTPHEADER => ['Accept: application/json'],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
    ]);

    $rawResponse = curl_exec($ch);

    if ($rawResponse === false) {
        $message = curl_error($ch);
        curl_close($ch);
        return ['success' => false, 'message' => $message !== '' ? 'Errore API ExchangeRate: ' . $message : 'Errore di rete o server non raggiungibile.'];
    }

    $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode < 200 || $statusCode >= 300) {
        return ['success' => false, 'message' => 'Errore di rete o server non raggiungibile.'];
    }

    $data = json_decode($rawResponse, true);

    if (!is_array($data) || ($data['result'] ?? '') !== 'success') {
        return ['success' => false, 'message' => 'Errore nel recupero del cambio valuta.'];
    }

    $rate = $data['rates'][$to] ?? null;

    if (!is_numeric($rate)) {
        return ['success' => false, 'message' => 'Valuta di destinazione non disponibile.'];
    }

    $converted = $amount * (float) $rate;
    $message = number_format($amount, 2, '.', '') . ' ' . $from . ' = ' . number_format($converted, 2, '.', '') . ' ' . $to . ' (1 ' . $from . ' = ' . number_format((float) $rate, 4, '.', '') . ' ' . $to . ')';

    return ['success' => true, 'message' => $message];
}

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metodo non consentito.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if (!isset($_POST['amount'], $_POST['from'], $_POST['to'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Compila tutti i campi obbligatori.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$result = processCurrencyConversion((float) $_POST['amount'], trim($_POST['from']), trim($_POST['to']));
http_response_code($result['success'] ? 200 : 400);
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

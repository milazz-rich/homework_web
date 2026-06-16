<?php

require_once __DIR__ . '/../../config/mailboxlayer.php';

function processNewsletterSignup(string $email, string $consent): array
{
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['success' => false, 'message' => 'Inserisci un indirizzo e-mail valido.'];
    }

    if ($consent !== '1') {
        return ['success' => false, 'message' => 'Devi accettare il consenso marketing.'];
    }

    $config = getMailboxlayerConfig();
    $url = 'https://apilayer.net/api/check?access_key=' . $config['accessKey'] . '&email=' . urlencode($email) . '&smtp=1&format=1';

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
        return ['success' => false, 'message' => $message !== '' ? 'Errore API Mailboxlayer: ' . $message : 'Errore di rete o server non raggiungibile.'];
    }

    $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode < 200 || $statusCode >= 300) {
        return ['success' => false, 'message' => 'Errore di rete o server non raggiungibile.'];
    }

    $data = json_decode($rawResponse, true);

    if (!is_array($data)) {
        return ['success' => false, 'message' => 'Risposta API non valida.'];
    }

    if (($data['success'] ?? true) === false) {
        return ['success' => false, 'message' => $data['error']['info'] ?? 'Errore API Mailboxlayer: richiesta non valida.'];
    }

    if (!empty($data['format_valid']) && !empty($data['mx_found'])) {
        return ['success' => true, 'message' => 'Email valida. Iscrizione completata.'];
    }

    return ['success' => false, 'message' => 'Email non valida. Controlla l\'indirizzo inserito.'];
}

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metodo non consentito.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if (!isset($_POST['email'], $_POST['consent'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Compila tutti i campi obbligatori.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$result = processNewsletterSignup(trim($_POST['email']), trim($_POST['consent']));
http_response_code($result['success'] ? 200 : 400);
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

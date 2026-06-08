<?php

require_once __DIR__ . '/../services/ThreeDPrinterService.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['message' => 'Metodo non consentito.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$limit = null;

if (isset($_GET['limit']) && $_GET['limit'] !== '') {
    if (!ctype_digit((string) $_GET['limit'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Il parametro limit deve essere un numero intero valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $limit = (int) $_GET['limit'];
}

try {
    $printerService = new ThreeDPrinterService();
    $printers = $printerService->getPrinters($limit);

    echo json_encode(array_map(static fn (ThreeDPrinter $printer) => $printer->toArray(), $printers), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

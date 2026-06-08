<?php

require_once __DIR__ . '/../services/ProductService.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['message' => 'Metodo non consentito.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$limit = null;
$type = null;

if (isset($_GET['limit']) && $_GET['limit'] !== '') {
    if (!ctype_digit((string) $_GET['limit'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Il parametro limit deve essere un numero intero valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $limit = (int) $_GET['limit'];
}

if (isset($_GET['type']) && $_GET['type'] !== '') {
    if (!ctype_digit((string) $_GET['type'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Il parametro type deve essere un numero intero valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $type = (int) $_GET['type'];
}

try {
    $productService = new ProductService();
    $products = $productService->getProducts($type, $limit);

    echo json_encode(array_map(static fn (Product $product) => $product->toArray(), $products), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

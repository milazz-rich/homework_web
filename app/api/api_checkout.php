<?php

require_once __DIR__ . '/../services/ShopService.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['message' => 'Metodo non consentito.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $shopService = new ShopService();
    echo json_encode($shopService->createCheckoutSession(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (ShopServiceException $e) {
    http_response_code($e->getStatusCode());
    echo json_encode(['message' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

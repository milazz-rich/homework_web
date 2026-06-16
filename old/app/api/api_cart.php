<?php

require_once __DIR__ . '/../services/ShopService.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $shopService = new ShopService();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode($shopService->getCartItems(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode($shopService->handleCartPost($_POST), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str((string) file_get_contents('php://input'), $payload);
        echo json_encode($shopService->handleCartDelete($payload), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    throw new ShopServiceException('Metodo non consentito.', 405);
} catch (ShopServiceException $e) {
    http_response_code($e->getStatusCode());
    echo json_encode(['message' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

<?php

require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../repositories/ProductRepository.php';
require_once __DIR__ . '/../services/StripeService.php';

header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['message' => 'Metodo non consentito.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $authService = new AuthService();
    $currentUser = $authService->currentUser();

    if ($currentUser === null) {
        http_response_code(401);
        echo json_encode(['message' => 'Devi essere autenticato.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if (!isset($_POST['product_id']) || !ctype_digit((string) $_POST['product_id'])) {
        http_response_code(400);
        echo json_encode(['message' => 'product_id non valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $quantity = 1;
    if (isset($_POST['quantity']) && $_POST['quantity'] !== '') {
        if (!ctype_digit((string) $_POST['quantity'])) {
            http_response_code(400);
            echo json_encode(['message' => 'quantity non valida.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        $quantity = max(1, (int) $_POST['quantity']);
    }

    $productRepository = new ProductRepository();
    $product = $productRepository->findById((int) $_POST['product_id']);

    if ($product === null) {
        http_response_code(404);
        echo json_encode(['message' => 'Prodotto non trovato.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $baseUrl = $scheme . '://' . $host;

    $lineItem = [[
        'name' => $product->getName(),
        'description' => $product->getSubtitle(),
        'unit_amount' => (int) round($product->getPrice() * 100),
        'quantity' => $quantity,
        'image' => $product->getImagePath() !== '' ? (stripos($product->getImagePath(), 'http') === 0 ? $product->getImagePath() : $baseUrl . '/' . ltrim($product->getImagePath(), '/')) : null,
    ]];

    $stripeService = new StripeService();
    $session = $stripeService->createCheckoutSession(
        $lineItem,
        $baseUrl . '/cart.php?checkout=success',
        $baseUrl . '/product.php?id=' . (int) $product->getId() . '&checkout=cancel',
        $currentUser->getEmail()
    );

    echo json_encode([
        'url' => $session['url'] ?? null,
        'id' => $session['id'] ?? null,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

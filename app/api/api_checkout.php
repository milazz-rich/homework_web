<?php

require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../services/CartService.php';
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

    $cartService = new CartService();
    $productRepository = new ProductRepository();
    $stripeService = new StripeService();

    $items = $cartService->getUserCart((int) $currentUser->getId());

    if ($items === []) {
        http_response_code(400);
        echo json_encode(['message' => 'Il carrello è vuoto.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $lineItems = [];

    foreach ($items as $item) {
        $product = $productRepository->findById($item->getProductId());

        if ($product === null) {
            continue;
        }

        $lineItems[] = [
            'name' => $product->getName(),
            'description' => $product->getSubtitle(),
            'unit_amount' => (int) round($product->getPrice() * 100),
            'quantity' => $item->getQuantity(),
            'image' => $product->getImagePath() !== '' ? (stripos($product->getImagePath(), 'http') === 0 ? $product->getImagePath() : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/' . ltrim($product->getImagePath(), '/')) : null,
        ];
    }

    if ($lineItems === []) {
        http_response_code(400);
        echo json_encode(['message' => 'Nessun prodotto valido nel carrello.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $baseUrl = $scheme . '://' . $host;

    $session = $stripeService->createCheckoutSession(
        $lineItems,
        $baseUrl . '/payment-success.php?session_id={CHECKOUT_SESSION_ID}',
        $baseUrl . '/cart.php?checkout=cancel',
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

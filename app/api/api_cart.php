<?php

require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../services/CartService.php';
require_once __DIR__ . '/../repositories/ProductRepository.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $authService = new AuthService();
    $currentUser = $authService->currentUser();

    if ($currentUser === null) {
        http_response_code(401);
        echo json_encode(['message' => 'Devi essere autenticato.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $cartService = new CartService();
    $productRepository = new ProductRepository();
    $userId = (int) $currentUser->getId();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $items = $cartService->getUserCart($userId);

        $payload = array_map(static function (Cart $item) use ($productRepository): array {
            $product = $productRepository->findById($item->getProductId());

            return [
                'id' => $item->getId(),
                'quantity' => $item->getQuantity(),
                'created_at' => $item->getCreatedAt(),
                'updated_at' => $item->getUpdatedAt(),
                'product' => $product ? $product->toArray() : null,
            ];
        }, $items);

        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['cart_id'])) {
            if (!ctype_digit((string) $_POST['cart_id'])) {
                http_response_code(400);
                echo json_encode(['message' => 'cart_id non valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
            }

            if (!isset($_POST['quantity']) || !ctype_digit((string) $_POST['quantity'])) {
                http_response_code(400);
                echo json_encode(['message' => 'quantity non valida.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
            }

            $quantity = (int) $_POST['quantity'];

            if ($quantity <= 0) {
                $cartService->removeItem((int) $_POST['cart_id']);
                echo json_encode(['message' => 'Elemento rimosso dal carrello.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                exit;
            }

            $updated = $cartService->updateQuantity((int) $_POST['cart_id'], $quantity);
            echo json_encode(['success' => $updated], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        if (!isset($_POST['product_id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Manca product_id.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        if (!ctype_digit((string) $_POST['product_id'])) {
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

            $quantity = (int) $_POST['quantity'];
        }

        $cartItem = $cartService->addToCart($userId, (int) $_POST['product_id'], $quantity);

        echo json_encode($cartItem->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str((string) file_get_contents('php://input'), $payload);

        if (isset($payload['clear']) && $payload['clear'] === '1') {
            $cartService->clearUserCart($userId);
            echo json_encode(['message' => 'Carrello svuotato.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        if (!isset($payload['id']) || !ctype_digit((string) $payload['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Manca id valido.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            exit;
        }

        $cartService->removeItem((int) $payload['id']);
        echo json_encode(['message' => 'Elemento rimosso dal carrello.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    http_response_code(405);
    echo json_encode(['message' => 'Metodo non consentito.'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

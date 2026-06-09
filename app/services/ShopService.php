<?php

require_once __DIR__ . '/AuthService.php';
require_once __DIR__ . '/CartService.php';
require_once __DIR__ . '/StripeService.php';
require_once __DIR__ . '/../repositories/ProductRepository.php';

class ShopServiceException extends RuntimeException
{
    private int $statusCode;

    public function __construct(string $message, int $statusCode = 400)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}

class ShopService
{
    private AuthService $authService;
    private CartService $cartService;
    private ProductRepository $productRepository;
    private StripeService $stripeService;

    public function __construct(
        ?AuthService $authService = null,
        ?CartService $cartService = null,
        ?ProductRepository $productRepository = null,
        ?StripeService $stripeService = null
    ) {
        $this->authService = $authService ?? new AuthService();
        $this->cartService = $cartService ?? new CartService();
        $this->productRepository = $productRepository ?? new ProductRepository();
        $this->stripeService = $stripeService ?? new StripeService();
    }

    /** @return array<int, array<string, mixed>> */
    public function getCartItems(): array
    {
        $user = $this->requireCurrentUser();
        $items = $this->cartService->getUserCart((int) $user->getId());

        return array_map(function (Cart $item): array {
            $product = $this->productRepository->findById($item->getProductId());

            return [
                'id' => $item->getId(),
                'quantity' => $item->getQuantity(),
                'created_at' => $item->getCreatedAt(),
                'updated_at' => $item->getUpdatedAt(),
                'product' => $product ? $product->toArray() : null,
            ];
        }, $items);
    }

    /** @param array<string, mixed> $payload */
    public function handleCartPost(array $payload): array
    {
        $user = $this->requireCurrentUser();
        $userId = (int) $user->getId();

        if (isset($payload['cart_id'])) {
            $cartId = $this->readRequiredInt($payload, 'cart_id', 'cart_id non valido.');
            $quantity = $this->readRequiredInt($payload, 'quantity', 'quantity non valida.');

            if ($quantity <= 0) {
                $this->cartService->removeItem($cartId);
                return ['message' => 'Elemento rimosso dal carrello.'];
            }

            return ['success' => $this->cartService->updateQuantity($cartId, $quantity)];
        }

        if (!isset($payload['product_id'])) {
            throw new ShopServiceException('Manca product_id.', 400);
        }

        $productId = $this->readRequiredInt($payload, 'product_id', 'product_id non valido.');
        $quantity = $this->readOptionalInt($payload, 'quantity', 1, 'quantity non valida.');
        $cartItem = $this->cartService->addToCart($userId, $productId, $quantity);

        return $cartItem->toArray();
    }

    /** @param array<string, mixed> $payload */
    public function handleCartDelete(array $payload): array
    {
        $user = $this->requireCurrentUser();
        $userId = (int) $user->getId();

        if (isset($payload['clear']) && $payload['clear'] === '1') {
            $this->cartService->clearUserCart($userId);
            return ['message' => 'Carrello svuotato.'];
        }

        $cartId = $this->readRequiredInt($payload, 'id', 'Manca id valido.');
        $this->cartService->removeItem($cartId);

        return ['message' => 'Elemento rimosso dal carrello.'];
    }

    public function createCheckoutSession(): array
    {
        $user = $this->requireCurrentUser();
        $items = $this->cartService->getUserCart((int) $user->getId());

        if ($items === []) {
            throw new ShopServiceException('Il carrello è vuoto.', 400);
        }

        $baseUrl = $this->getBaseUrl();
        $lineItems = [];

        foreach ($items as $item) {
            $product = $this->productRepository->findById($item->getProductId());

            if ($product !== null) {
                $lineItems[] = $this->productToLineItem($product, $item->getQuantity(), $baseUrl);
            }
        }

        if ($lineItems === []) {
            throw new ShopServiceException('Nessun prodotto valido nel carrello.', 400);
        }

        $session = $this->stripeService->createCheckoutSession(
            $lineItems,
            $baseUrl . '/payment-success.php?session_id={CHECKOUT_SESSION_ID}&clear_cart=1',
            $baseUrl . '/cart.php?checkout=cancel',
            $user->getEmail()
        );

        return $this->formatStripeSession($session);
    }

    /** @param array<string, mixed> $payload */
    public function createBuyNowCheckoutSession(array $payload): array
    {
        $user = $this->requireCurrentUser();
        $productId = $this->readRequiredInt($payload, 'product_id', 'product_id non valido.');
        $quantity = max(1, $this->readOptionalInt($payload, 'quantity', 1, 'quantity non valida.'));
        $product = $this->productRepository->findById($productId);

        if ($product === null) {
            throw new ShopServiceException('Prodotto non trovato.', 404);
        }

        $baseUrl = $this->getBaseUrl();
        $session = $this->stripeService->createCheckoutSession(
            [$this->productToLineItem($product, $quantity, $baseUrl)],
            $baseUrl . '/payment-success.php?session_id={CHECKOUT_SESSION_ID}',
            $baseUrl . '/product.php?id=' . (int) $product->getId() . '&checkout=cancel',
            $user->getEmail()
        );

        return $this->formatStripeSession($session);
    }

    private function requireCurrentUser(): User
    {
        $user = $this->authService->currentUser();

        if ($user === null) {
            throw new ShopServiceException('Devi essere autenticato.', 401);
        }

        return $user;
    }

    /** @param array<string, mixed> $payload */
    private function readRequiredInt(array $payload, string $key, string $message): int
    {
        if (!isset($payload[$key]) || !ctype_digit((string) $payload[$key])) {
            throw new ShopServiceException($message, 400);
        }

        return (int) $payload[$key];
    }

    /** @param array<string, mixed> $payload */
    private function readOptionalInt(array $payload, string $key, int $default, string $message): int
    {
        if (!isset($payload[$key]) || $payload[$key] === '') {
            return $default;
        }

        if (!ctype_digit((string) $payload[$key])) {
            throw new ShopServiceException($message, 400);
        }

        return (int) $payload[$key];
    }

    private function getBaseUrl(): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        return $scheme . '://' . $host;
    }

    private function productToLineItem(Product $product, int $quantity, string $baseUrl): array
    {
        $imagePath = $product->getImagePath();

        return [
            'name' => $product->getName(),
            'description' => $product->getSubtitle(),
            'unit_amount' => (int) round($product->getPrice() * 100),
            'quantity' => $quantity,
            'image' => $imagePath !== '' ? (stripos($imagePath, 'http') === 0 ? $imagePath : $baseUrl . '/' . ltrim($imagePath, '/')) : null,
        ];
    }

    /** @param array<string, mixed> $session */
    private function formatStripeSession(array $session): array
    {
        return [
            'url' => $session['url'] ?? null,
            'id' => $session['id'] ?? null,
        ];
    }
}

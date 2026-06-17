<?php

namespace App\Services;

use App\Exceptions\ShopServiceException;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;

class ShopService
{
  // Inietta i servizi necessari per carrello, autenticazione e checkout.
  public function __construct(
    private AuthService $authService,
    private CartService $cartService,
    private StripeService $stripeService
  ) {
  }

  // Converte il carrello dell'utente in un array pronto per le risposte JSON.
  public function getCartItems(): array
  {
    $user = $this->requireCurrentUser();

    return $this->cartService
      ->getUserCart((int) $user->id)
      ->map(function (Cart $item): array {
        return [
          'id' => $item->id,
          'quantity' => $item->quantity,
          'created_at' => $item->created_at,
          'updated_at' => $item->updated_at,
          'product' => $item->product,
        ];
      })
      ->toArray();
  }

  // Gestisce aggiunta prodotto e modifica quantità dal carrello.
  public function handleCartPost(array $payload): array
  {
    $user = $this->requireCurrentUser();
    $userId = (int) $user->id;

    if (isset($payload['cart_id'])) {
      return $this->updateCartItemQuantity($userId, $payload);
    }

    if (!isset($payload['product_id'])) {
      throw new ShopServiceException('Manca product_id.', 400);
    }

    $productId = $this->readRequiredInt($payload, 'product_id', 'product_id non valido.');
    $quantity = $this->readOptionalInt($payload, 'quantity', 1, 'quantity non valida.');

    $this->assertProductExists($productId);

    $cartItem = $this->cartService
      ->addToCart($userId, $productId, $quantity)
      ->loadMissing('product');

    return $cartItem->toArray();
  }

  // Gestisce rimozione singolo elemento o svuotamento completo del carrello.
  public function handleCartDelete(array $payload): array
  {
    $user = $this->requireCurrentUser();
    $userId = (int) $user->id;

    if (isset($payload['clear']) && (string) $payload['clear'] === '1') {
      $this->cartService->clearUserCart($userId);

      return [
        'message' => 'Carrello svuotato.',
      ];
    }

    $cartId = $this->readRequiredInt($payload, 'id', 'Manca id valido.');

    $this->cartService->removeItem($userId, $cartId);

    return [
      'message' => 'Elemento rimosso dal carrello.',
    ];
  }

  // Crea una sessione Stripe partendo dai prodotti nel carrello.
  public function createCheckoutSession(): array
  {
    $user = $this->requireCurrentUser();

    $items = $this->cartService->getUserCart((int) $user->id);

    if ($items->isEmpty()) {
      throw new ShopServiceException('Il carrello è vuoto.', 400);
    }

    $baseUrl = $this->getBaseUrl();
    $lineItems = $this->cartItemsToStripeLineItems($items, $baseUrl);

    if ($lineItems === []) {
      throw new ShopServiceException('Nessun prodotto valido nel carrello.', 400);
    }

    $session = $this->stripeService->createCheckoutSession(
      $lineItems,
      $baseUrl . '/payment-success?session_id={CHECKOUT_SESSION_ID}&clear_cart=1',
      $baseUrl . '/cart?checkout=cancel',
      $user->email,
      [
        'user_id' => (string) $user->id,
      ]
    );

    return $this->formatStripeSession($session);
  }

  // Crea una sessione Stripe per comprare subito un singolo prodotto.
  public function createBuyNowCheckoutSession(array $payload): array
  {
    $user = $this->requireCurrentUser();

    $productId = $this->readRequiredInt(
      $payload,
      'product_id',
      'product_id non valido.'
    );

    $quantity = max(
      1,
      $this->readOptionalInt($payload, 'quantity', 1, 'quantity non valida.')
    );

    $product = Product::query()->find($productId);

    if ($product === null) {
      throw new ShopServiceException('Prodotto non trovato.', 404);
    }

    $baseUrl = $this->getBaseUrl();

    $session = $this->stripeService->createCheckoutSession(
      [
        $this->productToLineItem($product, $quantity, $baseUrl),
      ],
      $baseUrl . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
      $baseUrl . '/product?id=' . (int) $product->id . '&checkout=cancel',
      $user->email,
      [
        'user_id' => (string) $user->id,
      ]
    );

    return $this->formatStripeSession($session);
  }

  // Aggiorna o rimuove un elemento carrello in base alla quantità ricevuta.
  private function updateCartItemQuantity(int $userId, array $payload): array
  {
    $cartId = $this->readRequiredInt($payload, 'cart_id', 'cart_id non valido.');
    $quantity = $this->readRequiredInt($payload, 'quantity', 'quantity non valida.');

    if ($quantity <= 0) {
      $this->cartService->removeItem($userId, $cartId);

      return [
        'message' => 'Elemento rimosso dal carrello.',
      ];
    }

    return [
      'success' => $this->cartService->updateQuantity($userId, $cartId, $quantity),
    ];
  }

  // Restituisce l'utente corrente o blocca l'azione se non autenticato.
  private function requireCurrentUser(): User
  {
    $user = $this->authService->currentUser();

    if ($user === null) {
      throw new ShopServiceException('Devi essere autenticato.', 401);
    }

    return $user;
  }

  // Legge un intero obbligatorio dal payload.
  private function readRequiredInt(array $payload, string $key, string $message): int
  {
    if (!isset($payload[$key]) || !ctype_digit((string) $payload[$key])) {
      throw new ShopServiceException($message, 400);
    }

    return (int) $payload[$key];
  }

  // Legge un intero opzionale dal payload usando un valore predefinito.
  private function readOptionalInt(
    array $payload,
    string $key,
    int $default,
    string $message
  ): int {
    if (!isset($payload[$key]) || $payload[$key] === '') {
      return $default;
    }

    if (!ctype_digit((string) $payload[$key])) {
      throw new ShopServiceException($message, 400);
    }

    return (int) $payload[$key];
  }

  // Controlla che il prodotto richiesto esista.
  private function assertProductExists(int $productId): void
  {
    if (Product::query()->whereKey($productId)->exists()) {
      return;
    }

    throw new ShopServiceException('Prodotto non trovato.', 404);
  }

  // Recupera l'URL base dell'app senza slash finale.
  private function getBaseUrl(): string
  {
    $baseUrl = config('app.url') ?: url('/');

    return rtrim($baseUrl, '/');
  }

  // Trasforma gli elementi carrello in line items Stripe.
  private function cartItemsToStripeLineItems(iterable $items, string $baseUrl): array
  {
    $lineItems = [];

    foreach ($items as $item) {
      if ($item->product === null) {
        continue;
      }

      $lineItems[] = $this->productToLineItem(
        $item->product,
        (int) $item->quantity,
        $baseUrl
      );
    }

    return $lineItems;
  }

  // Converte un prodotto in una singola riga checkout Stripe.
  private function productToLineItem(Product $product, int $quantity, string $baseUrl): array
  {
    return [
      'name' => $product->name,
      'description' => $product->subtitle,
      'unit_amount' => (int) round(((float) $product->price) * 100),
      'quantity' => $quantity,
      'image' => $this->formatProductImageUrl($product->image_path, $baseUrl),
    ];
  }

  // Rende assoluto il percorso immagine del prodotto, se presente.
  private function formatProductImageUrl(?string $imagePath, string $baseUrl): ?string
  {
    if ($imagePath === null || trim($imagePath) === '') {
      return null;
    }

    if (str_starts_with(strtolower($imagePath), 'http')) {
      return $imagePath;
    }

    return $baseUrl . '/' . ltrim($imagePath, '/');
  }

  // Espone solo i campi Stripe necessari al frontend.
  private function formatStripeSession(array $session): array
  {
    return [
      'url' => $session['url'] ?? null,
      'id' => $session['id'] ?? null,
    ];
  }
}

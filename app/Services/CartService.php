<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use RuntimeException;

class CartService
{
  // Aggiunge un prodotto al carrello o incrementa la quantità esistente.
  public function addToCart(int $userId, int $productId, int $quantity = 1): Cart
  {
    $this->assertPositiveId($userId, 'User non valido.');
    $this->assertPositiveId($productId, 'Prodotto non valido.');
    $this->assertPositiveQuantity($quantity);

    $cartItem = Cart::query()
      ->where('user_id', $userId)
      ->where('product_id', $productId)
      ->first();

    if ($cartItem !== null) {
      $cartItem->quantity += $quantity;
      $cartItem->save();

      return $cartItem->loadMissing('product');
    }

    return Cart::query()
      ->create([
        'user_id' => $userId,
        'product_id' => $productId,
        'quantity' => $quantity,
      ])
      ->loadMissing('product');
  }

  // Restituisce il carrello dell'utente con i prodotti collegati.
  public function getUserCart(int $userId): Collection
  {
    $this->assertPositiveId($userId, 'User non valido.');

    return Cart::query()
      ->with('product')
      ->where('user_id', $userId)
      ->orderByDesc('created_at')
      ->get();
  }

  // Rimuove un singolo elemento del carrello.
  public function removeItem(int $userId, int $id): bool
  {
    $this->assertPositiveId($userId, 'User non valido.');
    $this->assertPositiveId($id, 'Elemento carrello non valido.');

    return Cart::query()
      ->where('user_id', $userId)
      ->whereKey($id)
      ->delete() > 0;
  }

  // Svuota tutto il carrello di un utente.
  public function clearUserCart(int $userId): bool
  {
    $this->assertPositiveId($userId, 'User non valido.');

    return Cart::query()
      ->where('user_id', $userId)
      ->delete() > 0;
  }

  // Aggiorna la quantità di un elemento già presente nel carrello.
  public function updateQuantity(int $userId, int $id, int $quantity): bool
  {
    $this->assertPositiveId($userId, 'User non valido.');
    $this->assertPositiveId($id, 'Elemento carrello non valido.');
    $this->assertPositiveQuantity($quantity);

    $cart = Cart::query()
      ->where('user_id', $userId)
      ->whereKey($id)
      ->first();

    if ($cart === null) {
      throw new RuntimeException('Elemento carrello non trovato.');
    }

    $cart->quantity = $quantity;

    return $cart->save();
  }

  // Verifica che un id numerico sia valido.
  private function assertPositiveId(int $id, string $message): void
  {
    if ($id <= 0) {
      throw new InvalidArgumentException($message);
    }
  }

  // Verifica che la quantità sia maggiore di zero.
  private function assertPositiveQuantity(int $quantity): void
  {
    if ($quantity <= 0) {
      throw new InvalidArgumentException('La quantità deve essere maggiore di zero.');
    }
  }
}

<?php

require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../repositories/CartRepository.php';

class CartService
{
    private CartRepository $cartRepository;

    public function __construct(?CartRepository $cartRepository = null)
    {
        $this->cartRepository = $cartRepository ?? new CartRepository();
    }

    public function addToCart(int $userId, int $productId, int $quantity = 1): Cart
    {
        if ($userId <= 0 || $productId <= 0) {
            throw new InvalidArgumentException('User e prodotto devono avere un id valido.');
        }

        if ($quantity <= 0) {
            throw new InvalidArgumentException('La quantità deve essere maggiore di zero.');
        }

        $existing = $this->cartRepository->findByUserAndProduct($userId, $productId);

        if ($existing !== null) {
            $existing->setQuantity($existing->getQuantity() + $quantity);
            $this->cartRepository->update($existing);

            return $existing;
        }

        $cart = new Cart(null, $userId, $productId, $quantity);
        $this->cartRepository->create($cart);

        return $cart;
    }

    public function getUserCart(int $userId): array
    {
        if ($userId <= 0) {
            throw new InvalidArgumentException('User non valido.');
        }

        return $this->cartRepository->findByUserId($userId);
    }

    public function removeItem(int $id): bool
    {
        return $this->cartRepository->delete($id);
    }

    public function clearUserCart(int $userId): bool
    {
        if ($userId <= 0) {
            throw new InvalidArgumentException('User non valido.');
        }

        return $this->cartRepository->deleteByUserId($userId);
    }

    public function updateQuantity(int $id, int $quantity): bool
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException('La quantità deve essere maggiore di zero.');
        }

        $cart = $this->cartRepository->findById($id);

        if ($cart === null) {
            throw new RuntimeException('Elemento carrello non trovato.');
        }

        $cart->setQuantity($quantity);

        return $this->cartRepository->update($cart);
    }
}

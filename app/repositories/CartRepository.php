<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Cart.php';

class CartRepository
{
    private mysqli $mysqli;

    public function __construct(?mysqli $mysqli = null)
    {
        $this->mysqli = $mysqli ?? getDatabaseConnection();
    }

    public function create(Cart $cart): int
    {
        $userId = (int) $cart->getUserId();
        $productId = (int) $cart->getProductId();
        $quantity = (int) $cart->getQuantity();

        $sql = "INSERT INTO `cart` (`user_id`, `product_id`, `quantity`) VALUES ({$userId}, {$productId}, {$quantity}) ON DUPLICATE KEY UPDATE `quantity` = `quantity` + VALUES(`quantity`)";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query INSERT: ' . mysqli_error($this->mysqli));
        }

        $insertId = (int) $this->mysqli->insert_id;

        if ($insertId > 0) {
            $cart->setId($insertId);
            return $insertId;
        }

        $existing = $this->findByUserAndProduct($userId, $productId);
        if ($existing !== null) {
            $cart->setId($existing->getId());
            $cart->setQuantity($existing->getQuantity());
            return (int) $existing->getId();
        }

        return 0;
    }

    public function findById(int $id): ?Cart
    {
        $sql = "SELECT `id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at` FROM `cart` WHERE `id` = {$id} LIMIT 1";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $row = mysqli_fetch_assoc($result) ?: null;

        return $row ? Cart::fromArray($row) : null;
    }

    /**
     * @return Cart[]
     */
    public function findByUserId(int $userId): array
    {
        $sql = "SELECT `id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at` FROM `cart` WHERE `user_id` = {$userId} ORDER BY `id` DESC";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $items = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $items[] = Cart::fromArray($row);
        }

        return $items;
    }

    public function findByUserAndProduct(int $userId, int $productId): ?Cart
    {
        $sql = "SELECT `id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at` FROM `cart` WHERE `user_id` = {$userId} AND `product_id` = {$productId} LIMIT 1";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $row = mysqli_fetch_assoc($result) ?: null;

        return $row ? Cart::fromArray($row) : null;
    }

    public function update(Cart $cart): bool
    {
        if ($cart->getId() === null) {
            throw new InvalidArgumentException('Il carrello deve avere un id valido per essere aggiornato.');
        }

        $id = (int) $cart->getId();
        $quantity = (int) $cart->getQuantity();

        $sql = "UPDATE `cart` SET `quantity` = {$quantity} WHERE `id` = {$id}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query UPDATE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM `cart` WHERE `id` = {$id}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query DELETE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }

    public function deleteByUserId(int $userId): bool
    {
        $sql = "DELETE FROM `cart` WHERE `user_id` = {$userId}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query DELETE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }
}

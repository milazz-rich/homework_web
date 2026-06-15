<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Product.php';

class ProductRepository
{
    private mysqli $mysqli;

    public function __construct(?mysqli $mysqli = null)
    {
        $this->mysqli = $mysqli ?? getDatabaseConnection();
    }

    public function create(Product $product): int
    {
        $name = $this->escape($product->getName());
        $subtitle = $this->escape($product->getSubtitle());
        $price = (float) $product->getPrice();
        $imagePath = $this->escape($product->getImagePath());
        $type = (int) $product->getType();

        $sql = "INSERT INTO `product` (`name`, `subtitle`, `price`, `image_path`, `type`) VALUES ('{$name}', '{$subtitle}', {$price}, '{$imagePath}', {$type})";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query INSERT: ' . mysqli_error($this->mysqli));
        }

        $productId = $this->mysqli->insert_id;
        $product->setId($productId);

        return $productId;
    }

    public function findById(int $id): ?Product
    {
        $sql = "SELECT `id`, `name`, `subtitle`, `price`, `image_path`, `type` FROM `product` WHERE `id` = {$id} LIMIT 1";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $row = mysqli_fetch_assoc($result) ?: null;
        return $row ? Product::fromArray($row) : null;
    }

    public function findAll(): array
    {
        $sql = 'SELECT `id`, `name`, `subtitle`, `price`, `image_path`, `type` FROM `product` ORDER BY `id` DESC';
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $products = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $products[] = Product::fromArray($row);
        }

        return $products;
    }

    public function findByType(int $type): array
    {
        $type = (int) $type;
        $sql = "SELECT `id`, `name`, `subtitle`, `price`, `image_path`, `type` FROM `product` WHERE `type` = {$type} ORDER BY `id` DESC";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $products = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $products[] = Product::fromArray($row);
        }

        return $products;
    }

    public function findFirstN(?int $limit = null): array
    {
        if ($limit === null) {
            return $this->findAll();
        }

        $limit = max(0, $limit);
        $sql = "SELECT `id`, `name`, `subtitle`, `price`, `image_path`, `type` FROM `product` ORDER BY `id` DESC LIMIT {$limit}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $products = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $products[] = Product::fromArray($row);
        }

        return $products;
    }

    public function findFirstNByType(int $type, ?int $limit = null): array
    {
        $type = (int) $type;

        if ($limit === null) {
            return $this->findByType($type);
        }

        $limit = max(0, $limit);
        $sql = "SELECT `id`, `name`, `subtitle`, `price`, `image_path`, `type` FROM `product` WHERE `type` = {$type} ORDER BY `id` DESC LIMIT {$limit}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query SELECT: ' . mysqli_error($this->mysqli));
        }

        $products = [];
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
            $products[] = Product::fromArray($row);
        }

        return $products;
    }

    public function update(Product $product): bool
    {
        if ($product->getId() === null) {
            throw new InvalidArgumentException('Il prodotto deve avere un id valido per essere aggiornato.');
        }

        $id = (int) $product->getId();
        $name = $this->escape($product->getName());
        $subtitle = $this->escape($product->getSubtitle());
        $price = (float) $product->getPrice();
        $imagePath = $this->escape($product->getImagePath());
        $type = (int) $product->getType();

        $sql = "UPDATE `product` SET `name` = '{$name}', `subtitle` = '{$subtitle}', `price` = {$price}, `image_path` = '{$imagePath}', `type` = {$type} WHERE `id` = {$id}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query UPDATE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM `product` WHERE `id` = {$id}";
        $result = mysqli_query($this->mysqli, $sql);

        if (!$result) {
            throw new RuntimeException('Errore query DELETE: ' . mysqli_error($this->mysqli));
        }

        return true;
    }

    private function escape(string $value): string
    {
        return mysqli_real_escape_string($this->mysqli, $value);
    }
}

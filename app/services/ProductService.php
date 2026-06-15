<?php

require_once __DIR__ . '/../repositories/ProductRepository.php';

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(?ProductRepository $productRepository = null)
    {
        $this->productRepository = $productRepository ?? new ProductRepository();
    }

    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    public function getProductsByType(int $type): array
    {
        return $this->productRepository->findByType($type);
    }

    public function getLatestProducts(int $limit): array
    {
        return $this->productRepository->findLatest($limit);
    }

    public function getLatestProductsByType(int $type, int $limit): array
    {
        return $this->productRepository->findLatestByType($type, $limit);
    }
}

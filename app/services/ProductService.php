<?php

require_once __DIR__ . '/../repositories/ProductRepository.php';

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(?ProductRepository $productRepository = null)
    {
        $this->productRepository = $productRepository ?? new ProductRepository();
    }

    /** @return Product[] */
    public function getProducts(?int $type = null, ?int $limit = null): array
    {
        if ($type === null) {
            return $this->productRepository->findFirstN($limit);
        }

        return $this->productRepository->findFirstNByType($type, $limit);
    }
}

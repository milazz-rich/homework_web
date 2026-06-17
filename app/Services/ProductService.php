<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class ProductService
{
  // Restituisce tutti i prodotti ordinati per id crescente.
  public function getAllProducts(): Collection
  {
    return Product::query()
      ->orderBy('id')
      ->get();
  }

  // Filtra i prodotti per tipologia.
  public function getProductsByType(int $type): Collection
  {
    return Product::query()
      ->where('type', $type)
      ->orderBy('id')
      ->get();
  }

  // Restituisce gli ultimi prodotti inseriti.
  public function getLatestProducts(int $limit): Collection
  {
    $this->validateLimit($limit);

    return Product::query()
      ->orderByDesc('id')
      ->limit($limit)
      ->get();
  }

  // Restituisce gli ultimi prodotti inseriti per una specifica tipologia.
  public function getLatestProductsByType(int $type, int $limit): Collection
  {
    $this->validateLimit($limit);

    return Product::query()
      ->where('type', $type)
      ->orderByDesc('id')
      ->limit($limit)
      ->get();
  }

  // Valida il limite massimo di prodotti da restituire.
  private function validateLimit(int $limit): void
  {
    if ($limit <= 0) {
      throw new InvalidArgumentException('Il limite deve essere maggiore di zero.');
    }
  }
}

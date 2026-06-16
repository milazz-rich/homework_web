<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public const CATALOGS = [
        '3d-printer' => ['title' => 'Stampanti 3D', 'type' => 0],
        'filamenti' => ['title' => 'Filamenti', 'type' => 1],
        'accessori' => ['title' => 'Accessori', 'type' => 2],
        'makersupply' => ['title' => "Maker's Supply", 'type' => 3],
        'materiali' => ['title' => 'Materiali', 'type' => 4],
        'ams' => ['title' => 'AMS', 'type' => 5],
    ];

    /**
     * @return array{products: Collection<int, Product>, filaments: Collection<int, Product>, accessories: Collection<int, Product>, makersupply: Collection<int, Product>, materials: Collection<int, Product>}
     */
    public function homeProducts(): array
    {
        return [
            'products' => $this->productsByType(0),
            'filaments' => $this->productsByType(1),
            'accessories' => $this->productsByType(2),
            'makersupply' => $this->productsByType(3),
            'materials' => $this->productsByType(4),
        ];
    }

    /**
     * @return array{title: string, products: Collection<int, Product>}|null
     */
    public function catalogProducts(string $catalog): ?array
    {
        if (! isset(self::CATALOGS[$catalog])) {
            return null;
        }

        $catalogData = self::CATALOGS[$catalog];

        return [
            'title' => $catalogData['title'],
            'products' => $this->productsByType($catalogData['type']),
        ];
    }

    /** @return Collection<int, Product> */
    public function salesProducts(): Collection
    {
        return Product::orderByDesc('id')->get();
    }

    public function productById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /** @return Collection<int, Product> */
    public function apiProducts(?int $type, ?int $limit): Collection
    {
        $query = Product::query()->orderByDesc('id');

        if ($type !== null) {
            $query->where('type', $type);
        }

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /** @return Collection<int, Product> */
    public function productsByType(int $type): Collection
    {
        return Product::where('type', $type)->orderByDesc('id')->get();
    }
}

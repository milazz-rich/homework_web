<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class MaterialiController extends Controller
{
  public function index(ProductService $productService)
  {
    try {
      $products = $productService->getProductsByType(4);
    } catch (\Throwable $e) {
      Log::error($e->getMessage());
      $products = [];
    }

    return view('catalog.materiali', compact('products'));
  }
}

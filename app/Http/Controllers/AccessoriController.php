<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class AccessoriController extends Controller
{
  public function index(ProductService $productService)
  {
    try {
      $products = $productService->getProductsByType(2);
    } catch (\Throwable $e) {
      Log::error($e->getMessage());
      $products = [];
    }

    return view('catalog.accessori', compact('products'));
  }
}

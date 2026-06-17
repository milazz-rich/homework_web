<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class AmsController extends Controller
{
  public function index(ProductService $productService)
  {
    try {
      $products = $productService->getProductsByType(5);
    } catch (\Throwable $e) {
      Log::error($e->getMessage());
      $products = [];
    }

    return view('catalog.ams', compact('products'));
  }
}

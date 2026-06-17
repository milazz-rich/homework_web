<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class SaldiController extends Controller
{
  public function index(ProductService $productService)
  {
    try {
      $products = $productService->getAllProducts();
    } catch (\Throwable $e) {
      Log::error($e->getMessage());
      $products = [];
    }

    return view('catalog.saldi', compact('products'));
  }
}

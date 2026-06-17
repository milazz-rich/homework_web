<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class PrinterController extends Controller
{
  public function index(ProductService $productService)
  {
    try {
      $products = $productService->getProductsByType(0);
    } catch (\Throwable $e) {
      Log::error($e->getMessage());
      $products = [];
    }

    return view('catalog.3d-printer', compact('products'));
  }
}

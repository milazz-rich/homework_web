<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class MakerSupplyController extends Controller
{
  public function index(ProductService $productService)
  {
    try {
      $products = $productService->getProductsByType(3);
    } catch (\Throwable $e) {
      Log::error($e->getMessage());
      $products = [];
    }

    return view('catalog.makersupply', compact('products'));
  }
}

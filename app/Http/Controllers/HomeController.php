<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
  public function index(ProductService $productService)
  {
    try {
      $products = $productService->getProductsByType(0);
      $filaments = $productService->getProductsByType(1);
      $accessories = $productService->getProductsByType(2);
      $makersupply = $productService->getProductsByType(3);
      $materials = $productService->getProductsByType(4);
    } catch (\Throwable $e) {
      Log::error($e->getMessage());

      $products = [];
      $filaments = [];
      $accessories = [];
      $makersupply = [];
      $materials = [];
    }

    return view('home', compact(
      'products',
      'filaments',
      'accessories',
      'makersupply',
      'materials'
    ));
  }
}
<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;

class CartPageController extends Controller
{
  public function show(AuthService $authService, ProductService $productService)
  {
    $isAuthenticated = $authService->isAuthenticated();

    try {
      $recommendedGroups = [
        $productService->getLatestProductsByType(0, 1),
        $productService->getLatestProductsByType(1, 1),
        $productService->getLatestProductsByType(2, 1),
        $productService->getLatestProductsByType(4, 1),
      ];
    } catch (\Throwable $e) {
      Log::error($e->getMessage());
      $recommendedGroups = [[], [], [], []];
    }

    return view('cart.show', compact('isAuthenticated', 'recommendedGroups'));
  }
}

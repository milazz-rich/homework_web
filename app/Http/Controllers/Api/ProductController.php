<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Throwable;

class ProductController extends Controller
{
  public function __construct(
    private ProductService $productService
  ) {
  }

  // Restituisce i prodotti con gli stessi filtri della vecchia api_products.php.
  public function index(Request $request): JsonResponse
  {
    try {
      $limit = $this->readOptionalQueryInt($request, 'limit', 'Il parametro limit deve essere un numero intero valido.');
      $type = $this->readOptionalQueryInt($request, 'type', 'Il parametro type deve essere un numero intero valido.');

      if ($type !== null && $limit !== null) {
        $products = $this->productService->getLatestProductsByType($type, $limit);
      } elseif ($type !== null) {
        $products = $this->productService->getProductsByType($type);
      } elseif ($limit !== null) {
        $products = $this->productService->getLatestProducts($limit);
      } else {
        $products = $this->productService->getAllProducts();
      }

      return response()->json($products->values());
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore recupero prodotti');
    }
  }

  private function readOptionalQueryInt(Request $request, string $key, string $message): ?int
  {
    $value = $request->query($key);

    if ($value === null || $value === '') {
      return null;
    }

    if (!ctype_digit((string) $value)) {
      throw new InvalidArgumentException($message);
    }

    return (int) $value;
  }

  private function errorResponse(Throwable $e, string $context): JsonResponse
  {
    if ($e instanceof InvalidArgumentException) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 400);
    }

    Log::error($context, [
      'message' => $e->getMessage(),
      'trace' => $e->getTraceAsString(),
    ]);

    return response()->json([
      'message' => 'Errore interno del server.',
    ], 500);
  }
}

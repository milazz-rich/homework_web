<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ShopServiceException;
use App\Http\Controllers\Controller;
use App\Services\ShopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class ShopController extends Controller
{
  public function __construct(
    private ShopService $shopService
  ) {
  }

  // Restituisce gli elementi del carrello dell'utente autenticato.
  public function cartIndex(): JsonResponse
  {
    try {
      return response()->json($this->shopService->getCartItems());
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore recupero carrello');
    }
  }

  // Aggiunge prodotti al carrello o aggiorna una quantità esistente.
  public function cartStore(Request $request): JsonResponse
  {
    try {
      return response()->json($this->shopService->handleCartPost($request->all()));
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore aggiornamento carrello');
    }
  }

  // Rimuove un elemento dal carrello o lo svuota completamente.
  public function cartDestroy(Request $request): JsonResponse
  {
    try {
      return response()->json($this->shopService->handleCartDelete($request->all()));
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore rimozione carrello');
    }
  }

  // Crea una sessione Stripe per pagare l'intero carrello.
  public function createCheckoutSession(): JsonResponse
  {
    try {
      return response()->json($this->shopService->createCheckoutSession());
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore creazione Checkout Session', 500);
    }
  }

  // Crea una sessione Stripe per comprare subito un singolo prodotto.
  public function createBuyNowCheckoutSession(Request $request): JsonResponse
  {
    try {
      return response()->json($this->shopService->createBuyNowCheckoutSession($request->all()));
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore creazione Buy Now Checkout Session', 500);
    }
  }

  private function errorResponse(Throwable $e, string $context, int $runtimeStatusCode = 400): JsonResponse
  {
    if ($e instanceof ShopServiceException) {
      return response()->json([
        'message' => $e->getMessage(),
      ], $e->getStatusCode());
    }

    if ($e instanceof InvalidArgumentException) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 400);
    }

    if ($e instanceof RuntimeException) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], $runtimeStatusCode);
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

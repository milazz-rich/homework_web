<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CurrencyController extends Controller
{
  public function __construct(
    private CurrencyService $currencyService
  ) {
  }

  // Gestisce la conversione valuta della vecchia api_currency_converter.php.
  public function convert(Request $request): JsonResponse
  {
    try {
      if (!$request->has(['amount', 'from', 'to'])) {
        return response()->json([
          'success' => false,
          'message' => 'Compila tutti i campi obbligatori.',
        ], 400);
      }

      $result = $this->currencyService->convert(
        (float) $request->input('amount'),
        (string) $request->input('from'),
        (string) $request->input('to')
      );

      return response()->json($result, $result['success'] ? 200 : 400);
    } catch (Throwable $e) {
      Log::error('Errore conversione valuta', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
      ]);

      return response()->json([
        'success' => false,
        'message' => 'Errore interno del server.',
      ], 500);
    }
  }
}

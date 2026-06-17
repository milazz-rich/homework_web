<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NewsletterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class NewsletterController extends Controller
{
  public function __construct(
    private NewsletterService $newsletterService
  ) {
  }

  // Gestisce l'iscrizione newsletter della vecchia api_newsletter.php.
  public function signup(Request $request): JsonResponse
  {
    try {
      if (!$request->has(['email', 'consent'])) {
        return response()->json([
          'success' => false,
          'message' => 'Compila tutti i campi obbligatori.',
        ], 400);
      }

      $result = $this->newsletterService->signup(
        (string) $request->input('email'),
        (string) $request->input('consent')
      );

      return response()->json($result, $result['success'] ? 200 : 400);
    } catch (Throwable $e) {
      Log::error('Errore iscrizione newsletter', [
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class AuthController extends Controller
{
  public function __construct(
    private AuthService $authService
  ) {
  }

  // Invia via email il codice di verifica per la registrazione.
  public function sendVerificationCode(Request $request): JsonResponse
  {
    try {
      $this->authService->sendVerificationCode((string) $request->input('email', ''));

      return response()->json([
        'success' => true,
        'message' => 'Codice inviato correttamente.',
      ]);
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore invio codice verifica');
    }
  }

  // Registra un nuovo utente e lo autentica in sessione.
  public function register(Request $request): JsonResponse
  {
    try {
      $user = $this->authService->register(
        (string) $request->input('nome', ''),
        (string) $request->input('cognome', ''),
        (string) $request->input('email', ''),
        (string) $request->input('password', ''),
        (string) $request->input('codice_verifica', $request->input('verification_code', ''))
      );

      return response()->json([
        'success' => true,
        'user' => $user,
      ]);
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore registrazione');
    }
  }

  // Autentica l'utente in sessione.
  public function login(Request $request): JsonResponse
  {
    try {
      $user = $this->authService->login(
        (string) $request->input('email', ''),
        (string) $request->input('password', '')
      );

      return response()->json([
        'success' => true,
        'user' => $user,
      ]);
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore login');
    }
  }

  // Chiude la sessione dell'utente corrente.
  public function logout(): JsonResponse
  {
    try {
      $this->authService->logout();

      return response()->json([
        'success' => true,
        'message' => 'Logout effettuato correttamente.',
      ]);
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Errore logout');
    }
  }

  private function errorResponse(Throwable $e, string $context): JsonResponse
  {
    if ($e instanceof RuntimeException) {
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

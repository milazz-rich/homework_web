<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\CartService;
use App\Services\EmailService;
use App\Services\StripeService;
use Illuminate\Http\Request;

class PaymentSuccessController extends Controller
{
  public function show(
    Request $request,
    AuthService $authService,
    CartService $cartService,
    StripeService $stripeService,
    EmailService $emailService
  ) {
    $sessionId = (string) $request->query('session_id', '');
    $clearCart = (string) $request->query('clear_cart', '') === '1';
    $currentUser = $authService->currentUser();
    $recapSent = false;
    $cartCleared = false;

    if ($sessionId !== '' && $currentUser !== null) {
      try {
        $lineItemsResponse = $stripeService->retrieveCheckoutSessionLineItems($sessionId);
        $lineItems = is_array($lineItemsResponse['data'] ?? null) ? $lineItemsResponse['data'] : [];
        $emailService->sendOrderRecapEmail($currentUser->email, $sessionId, $lineItems);
        $recapSent = true;
      } catch (\Throwable) {
        $recapSent = false;
      }
    }

    if ($sessionId !== '' && $clearCart && $currentUser !== null) {
      try {
        $cartService->clearUserCart((int) $currentUser->id);
        $cartCleared = true;
      } catch (\Throwable) {
        $cartCleared = false;
      }
    }

    return view('payment-success', compact('sessionId', 'recapSent', 'cartCleared'));
  }
}

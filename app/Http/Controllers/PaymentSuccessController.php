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
    $paymentVerified = false;
    $recapSent = false;
    $cartCleared = false;

    if ($sessionId !== '' && $currentUser !== null) {
      try {
        $session = $stripeService->retrieveCheckoutSession($sessionId);

        if ($this->isVerifiedCheckoutSession($session, (int) $currentUser->id, $currentUser->email)) {
          $paymentVerified = true;
          $lineItemsResponse = $stripeService->retrieveCheckoutSessionLineItems($sessionId);
          $lineItems = is_array($lineItemsResponse['data'] ?? null) ? $lineItemsResponse['data'] : [];
          $emailService->sendOrderRecapEmail($currentUser->email, $sessionId, $lineItems);
          $recapSent = true;
        }
      } catch (\Throwable) {
        $paymentVerified = false;
        $recapSent = false;
      }
    }

    if ($sessionId !== '' && $clearCart && $currentUser !== null) {
      try {
        $session = $session ?? $stripeService->retrieveCheckoutSession($sessionId);

        if ($this->isVerifiedCheckoutSession($session, (int) $currentUser->id, $currentUser->email)) {
          $cartService->clearUserCart((int) $currentUser->id);
          $cartCleared = true;
        }
      } catch (\Throwable) {
        $cartCleared = false;
      }
    }

    return view('payment-success', compact('sessionId', 'paymentVerified', 'recapSent', 'cartCleared'));
  }

  private function isVerifiedCheckoutSession(array $session, int $userId, string $email): bool
  {
    $metadataUserId = (string) ($session['metadata']['user_id'] ?? '');
    $customerEmail = strtolower((string) ($session['customer_email'] ?? ''));

    return ($session['status'] ?? '') === 'complete'
      && ($session['payment_status'] ?? '') === 'paid'
      && $metadataUserId === (string) $userId
      && $customerEmail === strtolower($email);
  }
}

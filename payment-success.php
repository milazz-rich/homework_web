<?php
require_once __DIR__ . '/app/services/AuthService.php';
require_once __DIR__ . '/app/services/CartService.php';
require_once __DIR__ . '/app/services/StripeService.php';
require_once __DIR__ . '/config/resend.php';

$pageTitle = 'Pagamento completato | Bambu Lab EU store';
$pageStyles = [
  'css/payment-success.css',
];

$sessionId = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_SPECIAL_CHARS);
$clearCart = filter_input(INPUT_GET, 'clear_cart', FILTER_VALIDATE_INT) === 1;
$cartCleared = false;
$recapSent = false;

function formatStripeAmount(int $amount, string $currency): string
{
  return number_format($amount / 100, 2, ',', '.') . ' ' . strtoupper($currency);
}

function sendOrderRecapEmail(string $to, string $sessionId, array $lineItems): void
{
  $resendConfig = getResendConfig();
  $apiKey = $resendConfig['apiKey'];
  $from = $resendConfig['from'];

  if ($apiKey === '') {
    throw new RuntimeException('Configurazione Resend mancante: imposta RESEND_API_KEY.');
  }

  $rows = '';
  $total = 0;
  $currency = 'eur';

  foreach ($lineItems as $item) {
    $name = (string) ($item['description'] ?? 'Prodotto');
    $quantity = (int) ($item['quantity'] ?? 1);
    $amount = (int) ($item['amount_total'] ?? 0);
    $currency = (string) ($item['currency'] ?? $currency);
    $total += $amount;

    $rows .= '<tr>'
      . '<td style="padding:10px;border-bottom:1px solid #e5e5e5;">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</td>'
      . '<td style="padding:10px;border-bottom:1px solid #e5e5e5;text-align:center;">' . $quantity . '</td>'
      . '<td style="padding:10px;border-bottom:1px solid #e5e5e5;text-align:right;">' . htmlspecialchars(formatStripeAmount($amount, $currency), ENT_QUOTES, 'UTF-8') . '</td>'
      . '</tr>';
  }

  if ($rows === '') {
    $rows = '<tr><td colspan="3" style="padding:10px;border-bottom:1px solid #e5e5e5;">Ordine completato</td></tr>';
  }

  $html = '<div style="font-family:Arial,sans-serif;color:#171717;line-height:1.5;">'
    . '<h1 style="margin:0 0 12px;">Grazie per il tuo ordine</h1>'
    . '<p>Il pagamento e&#39; stato completato correttamente. Qui sotto trovi il riepilogo del tuo ordine.</p>'
    . '<table style="width:100%;border-collapse:collapse;margin-top:18px;">'
    . '<thead><tr>'
    . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:left;">Prodotto</th>'
    . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:center;">Quantita&#39;</th>'
    . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:right;">Totale</th>'
    . '</tr></thead>'
    . '<tbody>' . $rows . '</tbody>'
    . '<tfoot><tr><td colspan="2" style="padding:14px 10px;text-align:right;font-weight:bold;">Totale ordine</td>'
    . '<td style="padding:14px 10px;text-align:right;font-weight:bold;">' . htmlspecialchars(formatStripeAmount($total, $currency), ENT_QUOTES, 'UTF-8') . '</td></tr></tfoot>'
    . '</table>'
    . '<p style="margin-top:18px;color:#666;">ID sessione Stripe: ' . htmlspecialchars($sessionId, ENT_QUOTES, 'UTF-8') . '</p>'
    . '</div>';

  $payload = json_encode([
    'from' => $from,
    'to' => [$to],
    'subject' => 'Riepilogo del tuo ordine',
    'html' => $html,
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

  if ($payload === false) {
    throw new RuntimeException('Impossibile preparare il payload e-mail.');
  }

  $ch = curl_init('https://api.resend.com/emails');
  if ($ch === false) {
    throw new RuntimeException('Impossibile inizializzare cURL.');
  }

  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => [
      'Authorization: Bearer ' . $apiKey,
      'Content-Type: application/json',
    ],
    CURLOPT_TIMEOUT => 20,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => 0,
  ]);

  $raw = curl_exec($ch);
  $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

  if ($raw === false) {
    $error = curl_error($ch);
    curl_close($ch);
    throw new RuntimeException('Errore di rete con Resend: ' . $error);
  }

  curl_close($ch);

  if ($status < 200 || $status >= 300) {
    $body = json_decode($raw, true);
    $message = $body['message'] ?? ($raw ?: 'Invio e-mail fallito.');
    throw new RuntimeException('Impossibile inviare il recap ordine: ' . $message);
  }
}

$authService = new AuthService();
$currentUser = $authService->currentUser();

if ($sessionId !== null && $sessionId !== '' && $currentUser !== null) {
  $sentSessions = $_SESSION['order_recap_sent'] ?? [];

  if (!is_array($sentSessions)) {
    $sentSessions = [];
  }

  if (!in_array($sessionId, $sentSessions, true)) {
    try {
      $stripeService = new StripeService();
      $lineItemsResponse = $stripeService->retrieveCheckoutSessionLineItems($sessionId);
      $lineItems = is_array($lineItemsResponse['data'] ?? null) ? $lineItemsResponse['data'] : [];

      sendOrderRecapEmail($currentUser->getEmail(), $sessionId, $lineItems);

      $sentSessions[] = $sessionId;
      $_SESSION['order_recap_sent'] = $sentSessions;
      $recapSent = true;
    } catch (Throwable $e) {
      $recapSent = false;
    }
  }
}

if ($sessionId !== null && $sessionId !== '' && $clearCart) {
  try {
    if ($currentUser !== null) {
      $cartService = new CartService();
      $cartService->clearUserCart((int) $currentUser->getId());
      $cartCleared = true;
    }
  } catch (Throwable $e) {
    $cartCleared = false;
  }
}

include __DIR__ . '/layout/header.php';
?>

<main class="payment-success-page">
  <section class="payment-success-card">
    <div class="payment-success-icon" aria-hidden="true">
      <svg width="42" height="42" viewBox="0 0 24 24" fill="none">
        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <p class="payment-success-kicker">Pagamento riuscito</p>
    <h1 class="payment-success-title">Grazie per il tuo ordine</h1>
    <p class="payment-success-text">
      Stripe ha confermato il pagamento. Riceverai gli aggiornamenti dell'ordine all'indirizzo e-mail usato durante il checkout.
    </p>

    <?php if ($recapSent): ?>
      <p class="payment-success-note">Ti abbiamo inviato una mail con il riepilogo dell'ordine.</p>
    <?php endif; ?>

    <?php if ($sessionId !== null && $sessionId !== ''): ?>
      <p class="payment-success-session">
        ID sessione Stripe:<br>
        <strong><?= htmlspecialchars($sessionId, ENT_QUOTES, 'UTF-8') ?></strong>
      </p>
    <?php endif; ?>

    <div class="payment-success-actions">
      <a class="payment-success-primary" href="index.php">Torna alla home</a>
      <a class="payment-success-secondary" href="saldi.php">Continua gli acquisti</a>
    </div>
  </section>
</main>

<?php include __DIR__ . '/layout/footer.php'; ?>

<?php
$pageTitle = 'Pagamento completato | Bambu Lab EU store';
$pageStyles = [
  'css/payment-success.css',
];

$sessionId = filter_input(INPUT_GET, 'session_id', FILTER_SANITIZE_SPECIAL_CHARS);

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

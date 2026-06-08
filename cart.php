<?php
$pageStyles = [
  'css/cart.css',
];

$pageScripts = [
  'js/cart.js',
];

include __DIR__ . '/layout/header.php';
?>

  <!-- MAIN CONTENT -->
  <main class="cart-main">

    <!-- CART HEADER -->
    <section class="cart-header">
      <h1 class="cart-title">Carrello</h1>
      <p class="cart-subtitle" id="cart-subtitle">Accedi per sincronizzare gli articoli nel tuo carrello. <a href="login.php" class="cart-login-link">Accedi ora &rsaquo;</a></p>
    </section>

    <!-- CART ITEMS -->
    <section class="cart-items-section">
      <div id="cart-items-list"></div>
      <div id="cart-empty-state" style="display:none; text-align:center; color:#666; padding:24px 0;">
        Il carrello è vuoto.
      </div>
    </section>

    <!-- RECOMMENDED -->
    <section class="cart-recommended">
      <h2 class="cart-recommended-title">Consigliato per te</h2>
      <div class="cart-recommended-grid">

        <div class="rec-card">
          <a href="#" target="_blank" class="rec-card-img-wrap">
            <img src="img/bambulabh2d.png" alt="Bambu Lab H2D">
          </a>
          <div class="rec-card-body">
            <a href="#" target="_blank" class="rec-card-name">Bambu Lab H2D</a>
            <div class="rec-card-price">1.749,00 &euro;</div>
            <select class="rec-card-select">
              <option>Configurazione standard</option>
            </select>
            <button class="rec-card-btn" data-printer-id="2">Aggiungi al carrello</button>
          </div>
        </div>

        <div class="rec-card">
          <a href="#" target="_blank" class="rec-card-img-wrap">
            <img src="img/a1mini.png" alt="Bambu Lab A1 mini">
          </a>
          <div class="rec-card-body">
            <a href="#" target="_blank" class="rec-card-name">Bambu Lab A1 mini</a>
            <div class="rec-card-price">189,00 &euro;</div>
            <select class="rec-card-select">
              <option>Configurazione standard</option>
            </select>
            <button class="rec-card-btn" data-printer-id="9">Aggiungi al carrello</button>
          </div>
        </div>

      </div>
    </section>

    <!-- CART FOOTER BAR -->
    <div class="cart-footer-bar">
      <div class="cart-coupon">
        <span class="cart-coupon-label">Hai un codice?</span>
        <span class="cart-coupon-desc">Procedi al checkout per usare Coupon e Gift Card.</span>
        <a class="cart-continue-btn" href="index.php">Continua gli acquisti</a>
      </div>
      <div class="cart-summary">
        <div class="cart-total-line">
          <span class="cart-total-label" id="cart-total-label">Totale: 0,00 &euro;</span>
        </div>
        <div class="cart-tax-note">Tasse: calcolate al checkout</div>
        <div class="cart-shipping-note">Spedizione: Spedizione gratuita per ordini idonei</div>
        <button class="cart-checkout-btn" id="cart-checkout-btn">Checkout 0 articolo(i)</button>
      </div>
    </div>

  </main>

<?php include __DIR__ . '/layout/footer.php'; ?>

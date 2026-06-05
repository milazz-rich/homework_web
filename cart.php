<?php
$pageStyles = [
  'css/cart.css',
];

$pageScripts = [
];

include __DIR__ . '/layout/header.php';
?>

  <!-- MAIN CONTENT -->
  <main class="cart-main">

    <!-- CART HEADER -->
    <section class="cart-header">
      <h1 class="cart-title">Carrello</h1>
      <p class="cart-subtitle">Accedi per sincronizzare gli articoli nel tuo carrello. <a href="#" class="cart-login-link">Accedi ora &rsaquo;</a></p>
    </section>

    <!-- CART ITEMS -->
    <section class="cart-items-section">
      <div class="cart-item">
        <label class="cart-item-checkbox-wrap">
          <input type="checkbox" checked>
          <span class="cart-item-checkmark"></span>
        </label>
        <a href="https://eu.store.bambulab.com/it/products/bambu-lab-h2c" target="_blank" class="cart-item-img-wrap">
          <img src="img/bambulabh2d.png" alt="Bambu Lab H2C">
        </a>
        <div class="cart-item-info">
          <a href="https://eu.store.bambulab.com/it/products/bambu-lab-h2c" target="_blank" class="cart-item-name">Bambu Lab H2C</a>
          <div class="cart-item-variant">H2C Laser Full Combo / 40W Laser</div>
          <a href="#" class="cart-item-remove">Rimuovi</a>
        </div>
        <div class="cart-item-qty">
          <button class="qty-btn" aria-label="Diminuisci quantità">&#8722;</button>
          <span class="qty-value">1</span>
          <button class="qty-btn" aria-label="Aumenta quantità">&#43;</button>
        </div>
        <div class="cart-item-price">3349,00 &euro;</div>
      </div>
    </section>

    <!-- RECOMMENDED -->
    <section class="cart-recommended">
      <h2 class="cart-recommended-title">Consigliato per te</h2>
      <div class="cart-recommended-grid">

        <div class="rec-card">
          <a href="https://eu.store.bambulab.com/it/products/bambu-pla-basic-filament" target="_blank" class="rec-card-img-wrap">
            <img src="img/filamenti.png" alt="PLA Basic">
          </a>
          <div class="rec-card-body">
            <a href="https://eu.store.bambulab.com/it/products/bambu-pla-basic-filament" target="_blank" class="rec-card-name">PLA Basic</a>
            <div class="rec-card-price">25,99 &euro;</div>
            <select class="rec-card-select">
              <option>Bianco giada (10100) / Filame...</option>
            </select>
            <button class="rec-card-btn">Nel carrello</button>
          </div>
        </div>

        <div class="rec-card">
          <a href="https://eu.store.bambulab.com/it/products/cutting-material-kit-starter-pack" target="_blank" class="rec-card-img-wrap">
            <img src="img/materiale1.png" alt="Cutting Material Kit">
          </a>
          <div class="rec-card-body">
            <a href="https://eu.store.bambulab.com/it/products/cutting-material-kit-starter-pack" target="_blank" class="rec-card-name">Cutting Material Kit &ndash; Starter Pa...</a>
            <div class="rec-card-price">56,99 &euro;</div>
            <select class="rec-card-select">
              <option>Cutting Material Kit - Starter Pack...</option>
            </select>
            <button class="rec-card-btn">Nel carrello</button>
          </div>
        </div>

        <div class="rec-card">
          <a href="https://eu.store.bambulab.com/it/products/laser-material-kit-starter-pack" target="_blank" class="rec-card-img-wrap">
            <img src="img/materiale2.png" alt="Laser Material Kit">
          </a>
          <div class="rec-card-body">
            <a href="https://eu.store.bambulab.com/it/products/laser-material-kit-starter-pack" target="_blank" class="rec-card-name">Laser Material Kit &ndash; Starter Pack...</a>
            <div class="rec-card-price">101,15 &euro;</div>
            <div class="rec-card-pvc">PVC: 119,00 &euro; <span class="rec-card-pvc-icon" title="Prezzo al consumo">?</span></div>
            <select class="rec-card-select">
              <option>Laser Material Kit - Starter Pack (4...</option>
            </select>
            <button class="rec-card-btn">Nel carrello</button>
          </div>
        </div>

        <div class="rec-card">
          <a href="https://eu.store.bambulab.com/it/products/bambu-pla-matte-filament" target="_blank" class="rec-card-img-wrap">
            <img src="img/filamenti.png" alt="PLA Matte">
          </a>
          <div class="rec-card-body">
            <a href="https://eu.store.bambulab.com/it/products/bambu-pla-matte-filament" target="_blank" class="rec-card-name">PLA Matte</a>
            <div class="rec-card-price">25,99 &euro;</div>
            <select class="rec-card-select">
              <option>&#11044; Arancio mandarino (11300) / F...</option>
            </select>
            <button class="rec-card-btn">Nel carrello</button>
          </div>
        </div>

      </div>
    </section>

    <!-- CART FOOTER BAR -->
    <div class="cart-footer-bar">
      <div class="cart-coupon">
        <span class="cart-coupon-label">Hai un codice?</span>
        <span class="cart-coupon-desc">Procedi al checkout per usare Coupon e Gift Card.</span>
        <button class="cart-continue-btn">Continua gli acquisti</button>
      </div>
      <div class="cart-summary">
        <div class="cart-total-line">
          <span class="cart-total-label">Totale: 3349,00 &euro;</span>
        </div>
        <div class="cart-tax-note">Tasse: calcolate al checkout</div>
        <div class="cart-shipping-note">Spedizione: Spedizione gratuita per ordini idonei</div>
        <button class="cart-checkout-btn">Checkout 1 articolo(i)</button>
      </div>
    </div>

  </main>

<?php include __DIR__ . '/layout/footer.php'; ?>

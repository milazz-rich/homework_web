<?php

require_once __DIR__ . '/app/repositories/ProductRepository.php';

$productRepository = new ProductRepository();
$productId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$product = ($productId && $productId > 0) ? $productRepository->findById($productId) : null;

$pageStyles = [
  'css/product.css',
];

$pageScripts = [
  'js/product.js',
];

function productAssetPath(string $path): string
{
  return $path !== '' ? $path : 'img/stampanti3d.png';
}

function productCollectionLabel(int $type): string
{
  if ($type === 1) return 'Filamenti';
  if ($type === 2) return 'Accessori';
  if ($type === 3) return "Maker's Supply";
  if ($type === 4) return 'Materiali';
  if ($type === 5) return 'AMS';

  return 'Stampanti 3D';
}

function productCollectionUrl(int $type): string
{
  if ($type === 1) return 'filamenti.php';
  if ($type === 2) return 'accessori.php';
  if ($type === 3) return 'makersupply.php';
  if ($type === 4) return 'materiali.php';
  if ($type === 5) return 'ams.php';

  return '3d-printer.php';
}

if ($product === null) {
  http_response_code(404);
  include __DIR__ . '/layout/header.php';
  ?>
  <main class="product-page">
    <section class="product-hero" style="justify-content:center; min-height: 50vh;">
      <div class="product-panel" style="max-width: 720px; text-align:center;">
        <h1 class="product-panel-price-main" style="font-size:32px;">Prodotto non trovato</h1>
        <p class="product-panel-desc">L'id prodotto richiesto non esiste o non è valido.</p>
        <div class="product-cta" style="justify-content:center;">
          <a class="btn-add-cart" href="index.php" style="text-decoration:none; display:inline-flex; align-items:center; justify-content:center;">Torna alla home</a>
        </div>
      </div>
    </section>
  </main>
  <?php
  include __DIR__ . '/layout/footer.php';
  exit;
}

$currentProductName = $product->getName();
$currentProductSubtitle = $product->getSubtitle();
$productPrice = $product->getPrice();
$currentProductId = (int) $product->getId();
$productPriceFormatted = number_format($productPrice, 2, ',', '.');
$currentProductImage = productAssetPath($product->getImagePath());
$currentProductImageAlt = $currentProductName;
$currentProductDescription = $currentProductSubtitle !== '' ? $currentProductSubtitle : 'Stampante 3D disponibile nel catalogo.';
$currentProductType = $product->getType();
$currentProductCollectionLabel = productCollectionLabel($currentProductType);
$currentProductCollectionUrl = productCollectionUrl($currentProductType);

include __DIR__ . '/layout/header.php';
?>

<main class="product-page">

  <!-- BREADCRUMB -->
  <nav class="product-breadcrumb" aria-label="Breadcrumb">
    <a href="index.php">Home</a>
    <span>/</span>
    <a href="<?= htmlspecialchars($currentProductCollectionUrl, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($currentProductCollectionLabel, ENT_QUOTES, 'UTF-8') ?></a>
    <span>/</span>
    <span><?= htmlspecialchars($currentProductName, ENT_QUOTES, 'UTF-8') ?></span>
  </nav>

  <!-- PRODUCT HERO -->
  <section class="product-hero">

    <!-- GALLERY -->
    <div class="product-gallery">
      <div class="product-gallery-main">
        <img id="mainImage" src="<?= htmlspecialchars($currentProductImage, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($currentProductImageAlt, ENT_QUOTES, 'UTF-8') ?>" />
      </div>
      <div class="product-gallery-thumbs">
        <?php for ($i = 0; $i < 4; $i++): ?>
          <button class="thumb<?= $i === 0 ? ' active' : '' ?>" data-src="<?= htmlspecialchars($currentProductImage, ENT_QUOTES, 'UTF-8') ?>" data-fallback="<?= htmlspecialchars($currentProductImage, ENT_QUOTES, 'UTF-8') ?>">
            <img src="<?= htmlspecialchars($currentProductImage, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($currentProductName, ENT_QUOTES, 'UTF-8') ?>" />
          </button>
        <?php endfor; ?>
      </div>
    </div>

    <!-- PURCHASE PANEL -->
    <div class="product-panel">
      <p class="product-panel-price-main">€<?= htmlspecialchars($productPriceFormatted, ENT_QUOTES, 'UTF-8') ?> EUR</p>

      <p class="product-panel-desc">
        <?= htmlspecialchars($currentProductDescription, ENT_QUOTES, 'UTF-8') ?>
        <a href="#" class="product-panel-desc-link">Maggiori informazioni</a>
      </p>

      <div class="product-panel-shipping">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M1 12l5-5v3h8V7l5 5-5 5v-3H6v3L1 12z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>
        Consegna a domicilio disponibile
      </div>

      <div class="product-accordion">
        <button class="product-accordion-trigger" aria-expanded="false">
          Caratteristiche del prodotto
          <svg class="accordion-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </button>
        <div class="product-accordion-body" hidden>
          <ul>
            <li><?= htmlspecialchars($currentProductName, ENT_QUOTES, 'UTF-8') ?></li>
            <li><?= htmlspecialchars($currentProductSubtitle !== '' ? $currentProductSubtitle : 'Stampante 3D dinamica', ENT_QUOTES, 'UTF-8') ?></li>
            <li>Prezzo aggiornato dal database</li>
            <li>Immagine caricata da `image_path`</li>
          </ul>
        </div>
      </div>

      <form class="product-purchase-form" id="productPurchaseForm">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars((string) $currentProductId, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="unit_price" value="<?= htmlspecialchars((string) $productPrice, ENT_QUOTES, 'UTF-8') ?>">

        <div class="product-qty-row">
          <div class="product-qty">
            <button class="qty-btn" id="qtyMinus" type="button" aria-label="Diminuisci">−</button>
            <input class="qty-input" id="qtyInput" name="quantity" type="number" value="1" min="1" max="99" aria-label="Quantità" />
            <button class="qty-btn" id="qtyPlus" type="button" aria-label="Aumenta">+</button>
          </div>
          <div class="product-price-display">€<?= htmlspecialchars($productPriceFormatted, ENT_QUOTES, 'UTF-8') ?></div>
        </div>

        <div class="product-cta">
          <button class="btn-add-cart" type="button">Aggiungi al carrello</button>
          <button class="btn-buy-now" type="button">Acquista subito</button>
        </div>
      </form>

      <div class="product-payment">
        <p class="product-payment-label">Pagamento</p>
        <div class="product-payment-icons">
          <span class="payment-badge payment-badge--visa">VISA</span>
          <span class="payment-badge payment-badge--mastercard">Mastercard</span>
          <span class="payment-badge payment-badge--paypal">PayPal</span>
          <span class="payment-badge payment-badge--amex">AMEX</span>
          <span class="payment-badge payment-badge--klarna">Klarna</span>
        </div>
        <p class="product-payment-installments">
          A partire da <strong>€<?= htmlspecialchars(number_format($productPrice / 3, 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?>/mese</strong> con Klarna.
          <a href="#">Scopri di più</a>
        </p>
      </div>
    </div>
  </section>

  <section class="product-specs">
    <h2 class="product-specs-title">Dettagli prodotto</h2>
    <div class="product-specs-table-wrap">
      <table class="product-specs-table">
        <thead>
          <tr>
            <th>Criterio</th>
            <th>Valore</th>
            <th>Dato</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nome</td>
            <td>Prodotto</td>
            <td><?= htmlspecialchars($currentProductName, ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
          <tr>
            <td>Descrizione</td>
            <td>Subtitle</td>
            <td><?= htmlspecialchars($currentProductSubtitle !== '' ? $currentProductSubtitle : '-', ENT_QUOTES, 'UTF-8') ?></td>
          </tr>
          <tr>
            <td>Prezzo</td>
            <td>Listino</td>
            <td>€<?= htmlspecialchars($productPriceFormatted, ENT_QUOTES, 'UTF-8') ?> EUR</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

</main>

<?php include __DIR__ . '/layout/footer.php'; ?>

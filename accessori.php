<?php

require_once __DIR__ . '/app/services/ProductService.php';

$pageStyles = [
  'css/catalog.css',
];

$pageScripts = [
  'js/catalog.js',
  'js/accessori.js',
];

$products = [];

try {
  $productService = new ProductService();
  $products = $productService->getProductsByType(2);
} catch (Throwable $e) {
  $products = [];
}

include __DIR__ . '/layout/header.php';
?>

<main class="catalog-page">

  <h1 class="catalog-title">Accessori</h1>

  <div class="catalog-banner">
    <div class="catalog-banner-text">
      <p class="catalog-banner-heading">Quali accessori ti servono?</p>
      <p class="catalog-banner-sub">Scopri piastre, upgrade kit e componenti per potenziare il tuo setup.</p>
      <a href="https://eu.store.bambulab.com/it/collections/accessories" class="catalog-banner-cta">Aiutami a scegliere &gt;</a>
    </div>
    <div class="catalog-banner-img-wrap">
      <img src="img/accessori.png" alt="Accessori Bambu Lab" class="catalog-banner-img">
    </div>
  </div>

  <div class="catalog-search-wrap">
    <input class="catalog-search-input" type="text" placeholder="Cerca i prodotti di questa raccolta">
    <svg class="catalog-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none">
      <path d="M10.0015 3.84961C13.3989 3.84961 16.1529 6.60359 16.1529 10C16.1529 13.3964 13.3989 16.1504 10.0015 16.1504C6.60427 16.1503 3.85016 13.3963 3.85016 10C3.85016 6.60367 6.60427 3.84974 10.0015 3.84961Z" stroke="currentColor" stroke-width="1.7"/>
      <path d="M19.4524 21.5088C19.7334 21.8131 20.2079 21.832 20.5122 21.5511C20.8166 21.2701 20.8355 20.7956 20.5545 20.4912L20.0035 21L19.4524 21.5088ZM14.0024 14.5L13.4514 15.0088L19.4524 21.5088L20.0035 21L20.5545 20.4912L14.5535 13.9912L14.0024 14.5Z" fill="currentColor"/>
    </svg>
  </div>

  <div class="catalog-toolbar">
    <div class="catalog-toolbar-left">
      <button class="toolbar-view-btn" data-view="list" aria-label="Vista lista">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
          <rect x="1" y="1" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
          <rect x="11" y="1" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
          <rect x="1" y="11" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
          <rect x="11" y="11" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
        </svg>
      </button>
      <button class="toolbar-view-btn active" data-view="grid" aria-label="Vista griglia">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
          <rect x="1" y="1" width="16" height="4" stroke="currentColor" stroke-width="1.5"/>
          <rect x="1" y="7" width="16" height="4" stroke="currentColor" stroke-width="1.5"/>
          <rect x="1" y="13" width="16" height="4" stroke="currentColor" stroke-width="1.5"/>
        </svg>
      </button>
    </div>
    <div class="catalog-toolbar-right">
      <button class="toolbar-sort-btn">
        <span>Ordina</span>
        <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
          <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </button>
    </div>
  </div>

  <div class="catalog-content">
    <aside class="catalog-sidebar">
      <div class="filter-group">
        <button class="filter-group-header">
          <span>Categoria</span>
          <span class="filter-toggle-icon">&#8722;</span>
        </button>
        <ul class="filter-list">
          <li><a href="#">Piastre</a></li>
          <li><a href="#">Encoder</a></li>
          <li><a href="#">Purificatore</a></li>
          <li><a href="#">Laser</a></li>
          <li><a href="#">Taglio</a></li>
        </ul>
      </div>
    </aside>

    <div class="catalog-grid">
      <?php foreach ($products as $product): ?>
        <?php
        $name = $product->getName();
        $subtitle = $product->getSubtitle();
        $imagePath = $product->getImagePath() !== '' ? $product->getImagePath() : 'img/accessori.png';
        ?>
        <a href="product.php?id=<?= urlencode((string) $product->getId()) ?>" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="<?= htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></p>
            <p class="catalog-card-price">Da <strong><?= htmlspecialchars(number_format($product->getPrice(), 2, ',', '.'), ENT_QUOTES, 'UTF-8') ?> € EUR</strong></p>
            <?php if ($subtitle !== ''): ?>
              <div class="catalog-card-subtitle"><?= htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<?php include __DIR__ . '/layout/footer.php'; ?>

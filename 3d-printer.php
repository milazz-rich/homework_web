<?php
$pageStyles = [
  'css/3d-printer.css',
];

$pageScripts = [
];

include __DIR__ . '/layout/header.php';
?>

  <!-- MAIN CONTENT -->
  <main class="catalog-page">

    <h1 class="catalog-title">Stampanti 3D</h1>

    <!-- BANNER -->
    <div class="catalog-banner">
      <div class="catalog-banner-text">
        <p class="catalog-banner-heading">Quale stampante 3D è giusta per me?</p>
        <p class="catalog-banner-sub">Fai un breve quiz per ricevere consigli su misura per te.</p>
        <a href="#" class="catalog-banner-cta">Aiutami a scegliere &gt;</a>
      </div>
      <div class="catalog-banner-img-wrap">
        <img src="img/stampanti3d.png" alt="Stampanti 3D Bambu Lab" class="catalog-banner-img">
      </div>
    </div>

    <!-- SEARCH -->
    <div class="catalog-search-wrap">
      <input class="catalog-search-input" type="text" placeholder="Cerca i prodotti di questa raccolta">
      <svg class="catalog-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none">
        <path d="M10.0015 3.84961C13.3989 3.84961 16.1529 6.60359 16.1529 10C16.1529 13.3964 13.3989 16.1504 10.0015 16.1504C6.60427 16.1503 3.85016 13.3963 3.85016 10C3.85016 6.60367 6.60427 3.84974 10.0015 3.84961Z" stroke="currentColor" stroke-width="1.7"/>
        <path d="M19.4524 21.5088C19.7334 21.8131 20.2079 21.832 20.5122 21.5511C20.8166 21.2701 20.8355 20.7956 20.5545 20.4912L20.0035 21L19.4524 21.5088ZM14.0024 14.5L13.4514 15.0088L19.4524 21.5088L20.0035 21L20.5545 20.4912L14.5535 13.9912L14.0024 14.5Z" fill="currentColor"/>
      </svg>
    </div>

    <!-- TOOLBAR -->
    <div class="catalog-toolbar">
      <div class="catalog-toolbar-left">
        <button class="toolbar-view-btn" aria-label="Vista lista">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
            <rect x="1" y="1" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
            <rect x="11" y="1" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
            <rect x="1" y="11" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
            <rect x="11" y="11" width="6" height="6" stroke="currentColor" stroke-width="1.5"/>
          </svg>
        </button>
        <button class="toolbar-view-btn active" aria-label="Vista griglia">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
            <rect x="1" y="1" width="16" height="4" stroke="currentColor" stroke-width="1.5"/>
            <rect x="1" y="7" width="16" height="4" stroke="currentColor" stroke-width="1.5"/>
            <rect x="1" y="13" width="16" height="4" stroke="currentColor" stroke-width="1.5"/>
          </svg>
        </button>
      </div>
      <div class="catalog-toolbar-right">
        <button class="toolbar-sort-btn">
          Ordina
          <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- CONTENT: SIDEBAR + GRID -->
    <div class="catalog-content">

      <!-- SIDEBAR FILTERS -->
      <aside class="catalog-sidebar">
        <div class="filter-group">
          <button class="filter-group-header">
            <span>Per Serie</span>
            <span class="filter-toggle-icon">&#8722;</span>
          </button>
          <ul class="filter-list">
            <li><a href="#">Serie H</a></li>
            <li><a href="#">Serie X</a></li>
            <li><a href="#">Serie P</a></li>
            <li><a href="#">Serie A</a></li>
          </ul>
        </div>
      </aside>

      <!-- PRODUCT GRID -->
      <div class="catalog-grid">

        <!-- X2D -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/bambulabh2d.png" alt="Bambu Lab X2D">
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Bambu Lab X2D</p>
            <p class="catalog-card-price">Da <strong>629,00 € EUR</strong></p>
          </div>
        </a>

        <!-- H2C -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/bambulabh2d.png" alt="Bambu Lab H2C">
            <div class="catalog-card-badges">
              <span class="badge-award">&#9733;</span>
            </div>
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Bambu Lab H2C</p>
            <p class="catalog-card-price">Da <strong>2.249,00 € EUR</strong></p>
          </div>
        </a>

        <!-- H2D -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/bambulabh2d.png" alt="Bambu Lab H2D">
            <div class="catalog-card-badges">
              <span class="badge-award">&#9733;</span>
            </div>
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Bambu Lab H2D</p>
            <p class="catalog-card-price">Da <strong>1.749,00 € EUR</strong></p>
          </div>
        </a>

        <!-- H2S -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/h2s.png" alt="Bambu Lab H2S">
            <div class="catalog-card-badges">
              <span class="badge-new">New</span>
            </div>
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Bambu Lab H2S</p>
            <p class="catalog-card-price">Da <strong>1.149,00 € EUR</strong></p>
          </div>
        </a>

        <!-- P2S -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/p2s.png" alt="Stampante 3D Bambu Lab P2S">
            <div class="catalog-card-badges">
              <span class="badge-award">&#9733;</span>
            </div>
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Stampante 3D Bambu Lab P2S</p>
            <p class="catalog-card-price">Da <strong>519,00 € EUR</strong></p>
          </div>
        </a>

        <!-- P1S -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/p1s.png" alt="Stampante 3D Bambu Lab P1S">
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Stampante 3D Bambu Lab P1S</p>
            <p class="catalog-card-price">Da <strong>389,00 € EUR</strong></p>
          </div>
        </a>

        <!-- A2L -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/a1.png" alt="Bambu Lab A2L">
            <span class="catalog-card-novita">Novità</span>
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Bambu Lab A2L</p>
            <p class="catalog-card-price">Da <strong>379,00 € EUR</strong></p>
          </div>
        </a>

        <!-- A1 -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/a1.png" alt="Stampante 3D Bambu Lab A1">
            <div class="catalog-card-badges">
              <span class="badge-award">&#9733;</span>
            </div>
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Stampante 3D Bambu Lab A1</p>
            <p class="catalog-card-price">Da <strong>259,00 € EUR</strong></p>
          </div>
        </a>

        <!-- A1 Mini -->
        <a href="#" class="catalog-card">
          <div class="catalog-card-img-wrap">
            <img src="img/a1mini.png" alt="Mini stampante 3D Bambu Lab A1">
          </div>
          <div class="catalog-card-info">
            <p class="catalog-card-name">Mini stampante 3D Bambu Lab A1</p>
            <p class="catalog-card-price">Da <strong>189,00 € EUR</strong></p>
          </div>
        </a>

      </div><!-- /.catalog-grid -->
    </div><!-- /.catalog-content -->
  </main>

<?php include __DIR__ . '/layout/footer.php'; ?>

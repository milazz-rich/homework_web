<?php
$pageStyles = [
  'css/home.css',
  'css/carosel.css',
  'css/section.css',
  'css/product-categories.css',
  'css/featured-products.css',
  'css/printers-catalog.css',
  'css/store-benefits.css',
  'css/newsletter-signup.css',
  'css/currency-converter.css',
];

$pageScripts = [
  'js/script.js',
  'js/carosel.js',
  'js/slider.js',
];

include __DIR__ . '/layout/header.php';
?>

  <!-- CAROSELLO -->
  <div class="carosel">
    <div class="carosel-overlay">
      <div class="carosel-content">
        <div class="carosel-eyebrow">Bambu Lab H2C</div>

        <h1 class="carosel-title">Multi-Materiale senza compromessi.</h1>

        <div class="carosel-button-row">
          <a class="carosel-button" href="/it/products/h2c?from=home_page_3dprinter">
            <span>Acquista ora</span>
            <svg class="carosel-button-icon" xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16"
              fill="none" aria-hidden="true">
              <g>
                <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
              </g>
            </svg>
          </a>
        </div>
      </div>
    </div>

    <div class="carosel-media" id="carosel-media"></div>
  </div>

  <!-- MAIN PAGE -->
  <main>
    
    <!-- PRODUCT-CATEGORIES -->
    <section class="section product-categories">
      <a href="https://eu.store.bambulab.com/it/collections/3d-printers">
        <div>
          <div class="title">Stampanti 3d</div>
          <div class="subtitle">Stampanti avanzate potenziano progetti avanzati</div>
        </div>
        <img src="img/stampanti3d.png" alt="stampanti3d" width="189" height="129">
      </a>

      <a href="https://eu.store.bambulab.com/it/pages/bambu-filament-overview">
        <div>
          <div class="title">Filamenti</div>
          <div class="subtitle">Eccellente qualità, prestazione e facilità d'uso</div>
        </div>
        <img src="img/filamenti.png" alt="filamenti" width="189" height="129">
      </a>

      <a href="https://eu.store.bambulab.com/it/collections/accessories">
        <div>
          <div class="title">Accessori</div>
          <div class="subtitle">Potenzia la tua stampante con accessori avanzati</div>
        </div>
        <img src="img/accessori.png" alt="accessori" width="189" height="129">
      </a>

      <a href="https://eu.store.bambulab.com/it/maker-supply">
        <div>
          <div class="title">Maker's Supply</div>
          <div class="subtitle">Fornitura di accessori per completare i tuoi progetti</div>
        </div>
        <img src="img/makerssupply.png" alt="makerssupply" width="189" height="129">
      </a>

      <a href="https://eu.store.bambulab.com/it/collections/bambu-material">
        <div>
          <div class="title">Material</div>
          <div class="subtitle">Fornire materiali adatti ai processi di taglio laser e a lama</div>
        </div>
        <img src="img/material.png" alt="material" width="189" height="129">
      </a>
    </section>

    <!-- FEATURED-PRODUCTS -->
    <section class="section featured-products">
      <div class="section-title">
        <h2>Prodotti in evidenza</h2>
        <div class="featured-products-button">
          <button id="featured-products-prev" type="button">
            <svg viewBox="64 64 896 896" focusable="false" data-icon="left" width="1em" height="1em" fill="currentColor"
              aria-hidden="true">
              <path
                d="M724 218.3V141c0-6.7-7.7-10.4-12.9-6.3L260.3 486.8a31.86 31.86 0 000 50.3l450.8 352.1c5.3 4.1 12.9.4 12.9-6.3v-77.3c0-4.9-2.3-9.6-6.1-12.6l-360-281 360-281.1c3.8-3 6.1-7.7 6.1-12.6z">
              </path>
            </svg>
          </button>

          <button id="featured-products-next" type="button">
            <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em"
              fill="currentColor" aria-hidden="true">
              <path
                d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z">
              </path>
            </svg>
          </button>
        </div>
      </div>
      <div class="products-box1">
        <div class="featured-products-slider">
          <div class="featured-products-track" id="featured-products-track">

            <div class="featured-products-slide">
              <a href="https://eu.store.bambulab.com/it/products/ams-2-pro" class="product-box">
                <div>
                  <h1 class="product-title">AMS 2 PRO</h1>
                  <div class="product-subtitle">Sistema AMS di seconda generazione compatibile con la serie X1 e P1
                  </div>
                  <div class="acquista">
                    <span>Acquista</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                      <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                    </svg>
                  </div>
                </div>
                <img src="img/ams2pro.png" alt="ams2pro" width="235">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="https://eu.store.bambulab.com/it/products/vision-encoder" class="product-box">
                <div>
                  <h1 class="product-title">Vision Encoder</h1>
                  <div class="product-subtitle">Precisione a un nuovo livello</div>
                  <div class="acquista">
                    <span>Acquista</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                      <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                    </svg>
                  </div>
                </div>
                <img src="img/visionencoder.png" alt="visionencoder" width="235">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="https://eu.store.bambulab.com/it/products/bambu-high-flow-hotend-h2-p2s" class="product-box">
                <div>
                  <h1 class="product-title">Hotend ad alta portata</h1>
                  <div class="product-subtitle"></div>
                  <div class="acquista">
                    <span>Acquista</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                      <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                    </svg>
                  </div>
                </div>
                <img src="img/hotendadaltaportata.png" alt="hotendadaltaportata" width="120">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="https://eu.store.bambulab.com/it/products/laser-upgrade-kit" class="product-box">
                <div>
                  <h1 class="product-title">H2 Laser Upgrade Kit</h1>
                  <div class="product-subtitle">Potenzia il tuo H2 con il taglio laser di precisione</div>
                  <div class="acquista">
                    <span>Acquista</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                      <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                    </svg>
                  </div>
                </div>
                <img src="img/h2laserupgradekit.png" alt="h2laserupgradekit" width="235">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="https://eu.store.bambulab.com/it/products/tungsten-carbide-nozzle-h2-p2s" class="product-box">
                <div>
                  <h1 class="product-title">Tungsten Carbide Nozzle</h1>
                  <div class="product-subtitle">Perfetto per filamenti abrasivi</div>
                  <div class="acquista">
                    <span>Acquista</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                      <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                    </svg>
                  </div>
                </div>
                <img src="img/tungstencarbidenozzle.png" alt="tungstencarbidenozzle" width="120">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="https://eu.store.bambulab.com/it/products/bambu-lab-rotary-attachment" class="product-box">
                <div>
                  <h1 class="product-title">Rotary Attachment</h1>
                  <div class="product-subtitle">Incisioni laser professionali su tazze e oggetti curvi</div>
                  <div class="acquista">
                    <span>Acquista</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                      <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                    </svg>
                  </div>
                </div>
                <img src="img/rotaryattachment.png" alt="rotaryattachment" width="235">
              </a>
            </div>

          </div>
        </div>
      </div>
      <div class="products-box2">
        <a href="https://eu.store.bambulab.com/it/products/ams-2-pro" class="product-box">
          <div>
            <h1 class="product-title">AMS 2 Pro</h1>
            <div class="product-subtitle">Sistema AMS di seconda generazione compatibile con le serie X1 e P1</div>
            <div class="acquista">
              <span>Acquista</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g id="Link icon">
                  <path id="Vector 525" d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
          <img src="img/ams2pro.png" alt="ams2pro" height="124">
        </a>
        <a href="https://eu.store.bambulab.com/it/products/vision-encoder" class="product-box">
          <div>
            <h1 class="product-title">Vision Encoder</h1>
            <div class="product-subtitle">Precisione a un nuovo livello</div>
            <div class="acquista">
              <span>Acquista</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g id="Link icon">
                  <path id="Vector 525" d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
          <img src="img/visionencoder.png" alt="ams2pro" height="124">
        </a>
        <a href="https://eu.store.bambulab.com/it/products/bambu-high-flow-hotend-h2-p2s" class="product-box">
          <div>
            <h1 class="product-title">Hotend ad alta portata</h1>
            <div class="product-subtitle"></div>
            <div class="acquista">
              <span>Acquista</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g id="Link icon">
                  <path id="Vector 525" d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
          <img src="img/hotendadaltaportata.png" alt="ams2pro" height="124">
        </a>
        <a href="https://eu.store.bambulab.com/it/products/laser-upgrade-kit" class="product-box">
          <div>
            <h1 class="product-title">H2 Laser Upgrade Kit</h1>
            <div class="product-subtitle">Potenzia il tuo H2 con il taglio laser di precisione</div>
            <div class="acquista">
              <span>Acquista</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g id="Link icon">
                  <path id="Vector 525" d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
          <img src="img/h2laserupgradekit.png" alt="ams2pro" height="124">
        </a>
        <a href="https://eu.store.bambulab.com/it/products/tungsten-carbide-nozzle-h2-p2s" class="product-box">
          <div>
            <h1 class="product-title">Tungsten Carbide Nozzle</h1>
            <div class="product-subtitle">Perfetto per filamenti abrasivi</div>
            <div class="acquista">
              <span>Acquista</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g id="Link icon">
                  <path id="Vector 525" d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
          <img src="img/tungstencarbidenozzle.png" alt="ams2pro" height="124">
        </a>
        <a href="https://eu.store.bambulab.com/it/products/bambu-lab-rotary-attachment" class="product-box">
          <div>
            <h1 class="product-title">Rotary Attachment</h1>
            <div class="product-subtitle">Incisioni laser professionali su tazze e oggetti curvi</div>
            <div class="acquista">
              <span>Acquista</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g id="Link icon">
                  <path id="Vector 525" d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
          <img src="img/rotaryattachment.png" alt="ams2pro" height="124">
        </a>

      </div>
    </section>

    <!-- PRINTERS-CATALOG -->
    <section class="section printers-catalog">
      <div class="section-title">
        <h2>Stampanti 3d</h2>
        <a href="https://eu.store.bambulab.com/it/collections/3d-printer" class="seeother">
          <span>Visualizza tutti</span>
          <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor">
            <path
              d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z">
            </path>
          </svg>
        </a>
      </div>

      <div class="printers-banner">
        <img class="printers-banner-img printers-banner-img-mobile"
          src="https://store.bblcdn.eu/s8/default/efcbe7a5cd774bae8168e590b734f0dc/MO-tuya.jpg__op__resize,m_lfit,w_1920__op__format,f_auto__op__quality,q_90"
          alt="Banner Bambu Lab" loading="lazy" width="672" height="450" />

        <img class="printers-banner-img printers-banner-img-desktop"
          src="https://store.bblcdn.eu/s8/default/346dcca5804941e18569f0d89481ecd0/PC-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_90"
          alt="Banner Bambu Lab" loading="lazy" width="1200" height="400" />

        <div class="printers-banner-content">
          <div class="printers-banner-eyebrow">Bambu Lab H2C</div>

          <div class="printers-banner-title">Multi-Materiale senza compromessi.</div>

          <a class="printers-banner-button" href="/it/products/h2c">
            <span>Acquista ora</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
              aria-hidden="true">
              <g id="Link icon">
                <path id="Vector 525" d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
              </g>
            </svg>
          </a>
        </div>
      </div>

      <div class="printers-grid">
        <a href="https://eu.store.bambulab.com/it/products/h2d?from=home_page_3dprinter" class="printers-card">
          <div class="printers-card-img">
            <img src="img/bambulabh2d.png" alt="Bambu Lab H2D">
          </div>

          <div class="printers-card-info">
            <div>
              <div class="printers-card-title">Bambu Lab H2D</div>
              <div class="printers-card-subtitle">Produzione personale secondo un nuovo approccio</div>
            </div>

            <div class="printers-card-link">
              Visualizza il prodotto
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#00AE42" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/h2d?from=home_page_3dprinter" class="printers-card">
          <div class="printers-card-img">
            <img src="img/h2s.png" alt="Bambu Lab H2S">
          </div>

          <div class="printers-card-info">
            <div>
              <div class="printers-card-title">Bambu Lab H2S</div>
              <div class="printers-card-subtitle">La stampante 3D a Singolo Ugello definitiva</div>
            </div>

            <div class="printers-card-link">
              Visualizza il prodotto
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#00AE42" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/h2d?from=home_page_3dprinter" class="printers-card">
          <div class="printers-card-img">
            <img src="img/p2s.png" alt="Bambu Lab P2S">
          </div>

          <div class="printers-card-info">
            <div>
              <div class="printers-card-title">Bambu Lab P2S</div>
              <div class="printers-card-subtitle">Prestazioni di Punta. Fascia di Prezzo Media.</div>
            </div>

            <div class="printers-card-link">
              Visualizza il prodotto
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#00AE42" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/h2d?from=home_page_3dprinter" class="printers-card">
          <div class="printers-card-img">
            <img src="img/p1s.png" alt="Bambu Lab P1S">
          </div>

          <div class="printers-card-info">
            <div>
              <div class="printers-card-title">Bambu Lab P1S</div>
              <div class="printers-card-subtitle">Macchina Affidabile</div>
            </div>

            <div class="printers-card-link">
              Visualizza il prodotto
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#00AE42" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/h2d?from=home_page_3dprinter" class="printers-card">
          <div class="printers-card-img">
            <img src="img/a1.png" alt="Bambu Lab A1">
          </div>

          <div class="printers-card-info">
            <div>
              <div class="printers-card-title">Bambu Lab A1</div>
              <div class="printers-card-subtitle">Il più venduto</div>
            </div>

            <div class="printers-card-link">
              Visualizza il prodotto
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#00AE42" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/h2d?from=home_page_3dprinter" class="printers-card">
          <div class="printers-card-img">
            <img src="img/a1mini.png" alt="Bambu Lab A1 mini">
          </div>

          <div class="printers-card-info">
            <div>
              <div class="printers-card-title">Bambu Lab A1 mini</div>
              <div class="printers-card-subtitle">Il G.O.A.T delle stampanti 3D di livello entry</div>
            </div>

            <div class="printers-card-link">
              Visualizza il prodotto
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#00AE42" stroke-linecap="round"></path>
                </g>
              </svg>
            </div>
          </div>
        </a>
      </div>
    </section>

    <!-- FILMANETS-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Filamenti</h2>
        <a href="https://eu.store.bambulab.com/it/collections/bambu-lab-3d-printers-filament" class="seeother">
          <span>Visualizza tutti</span>
          <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor">
            <path
              d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z">
            </path>
          </svg>
        </a>
      </div>

      <div class="banner-wrap">
        <a class="banner banner1" href="/it/products/pla-cmyk-lithophane">
          <div class="banner-content">
            <h3 class="banner-title">PLA CMYK Lithophane Bundle</h3>

            <div class="banner-subtitle">
              Esalta la tua litofania con colori vivaci
            </div>

            <div class="banner-price-row">
              <span class="banner-discount">Sconto 38% con 4 bobinells</span>
            </div>

            <span class="banner-button">
              <span>Acquista</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
                aria-hidden="true">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </span>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/plalithophanebundle.png" alt="plalithophanebundle">
          </div>
        </a>
        <a class="banner banner2" href="/it/pages/promotions/filament-bulk-sale">
          <div class="banner-content">
            <h3 class="banner-title">Acquista di più,<br>risparmia di più!</h3>

            <div class="banner-subtitle">
              Approfitta di sconti speciali per rifornirti di filamenti di qualità.
            </div>

            <span class="banner-button">
              <span>Scopri di più</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
                aria-hidden="true">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </span>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/acquistarisparmiadipiu.png"
              alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        <a href="https://eu.store.bambulab.com/it/collections/pla" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.com/s2/default/45415374089847da961be5c21f5071ef/5.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="PLA" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">PLA</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/petg" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.com/s2/default/467d85baad41438abfceb0b873a8df79/6.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="PETG" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">PETG</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/asa-abs" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.com/s2/default/5700175e2a4a414d91cffb2229687a50/7.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="ABS &amp; ASA" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">ABS &amp; ASA</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/pc-tpu" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.com/s2/default/70baa9bbfed64c34b0fa38b1c8fee43b/8.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="PC &amp; TPU" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">PC &amp; TPU</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/pa-pet" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.com/s2/default/03fe69724b3248cea63966ccf89cd3d0/9.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="PA/PET" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">PA/PET</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/fiber-reinforced" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.com/s2/default/49ea2306adc2484da55b64cb580925ef/10.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Fiber Reinforced" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Fiber Reinforced</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/support" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/dfe92d60a2e943b0ab3b10cba0279fb4/Support.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Supporto" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Supporto</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/bambu-lab-3d-printers-filament" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.com/s2/default/5156413461524b91a094de9a13ce344f/12.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="ACQUISTA TUTTO" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">ACQUISTA TUTTO</div>
          </div>
        </a>
      </div>
    </section>

    <!-- ACCESSORIES-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Accessori</h2>
        <a href="https://eu.store.bambulab.com/it/collections/bambu-lab-3d-printers-filament" class="seeother">
          <span>Visualizza tutti</span>
          <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor">
            <path
              d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z">
            </path>
          </svg>
        </a>
      </div>

      <div class="banner-wrap">
        <a class="banner banner1" href="/it/products/pla-cmyk-lithophane">
          <div class="banner-content">
            <h3 class="banner-title">Vendita in stock di piastre 3D Effect</h3>

            <div class="banner-subtitle">
              Più Stili di Piastra, Stampe Migliori
            </div>

            <div class="banner-price-row">
              <span class="banner-discount">Sconto fino al 30%</span>
            </div>

            <span class="banner-button">
              <span>Scopri di più</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
                aria-hidden="true">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </span>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/accessori1.png" alt="plalithophanebundle">
          </div>
        </a>
        <a class="banner banner2" href="/it/pages/promotions/filament-bulk-sale">
          <div class="banner-content">
            <h3 class="banner-title">Vendita in Blocco<br>Hotend</h3>

            <div class="banner-subtitle">
              Più Compri, Più Risparmi
            </div>

            <div class="banner-price-row">
              <span class="banner-discount">Sconto fino al 30%</span>
            </div>

            <span class="banner-button">
              <span>Scopri di più</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
                aria-hidden="true">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </span>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/accessori2.png" alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        <a href="https://eu.store.bambulab.com/it/products/bambu-engineering-plate" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/8f320285d44a4331bddf0d2564bf07c2/1.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Bambu Engineering Plate" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Bambu Engineering Plate</div>
            <div class="card-subtitle">Una Piastra di Costruzione per Tutti i Filamenti</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/bambu-dual-texture-pei-plate" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/501f69dd829d4802be11e526c0b2d579/2.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Dual-Texture PEI Plate" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Dual-Texture PEI Plate</div>
            <div class="card-subtitle">Due Superfici, Una Sola Piastra</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/bambu-cool-plate-supertack" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/85a1755dc1be45cc991baa00a5a78080/3.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Cool Plate SuperTack" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Cool Plate SuperTack</div>
            <div class="card-subtitle">Dì Addio ai Fallimenti di Stampa</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/bambu-smooth-pei-plate" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/fd8627ec4c5a45a4bce444365cdabf52/4.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Smooth PEI Plate" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Smooth PEI Plate</div>
            <div class="card-subtitle">Primi Strati Ultra-Lisci per una Precisione Opaca</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/vision-encoder" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/ddb1755e3e1646809760effe2038bf10/5.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Vision Encoder" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Vision Encoder</div>
            <div class="card-subtitle">Precisione di Movimento Inferiore a 50μm</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/smoke-purifier" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/c16ee378adea4303a1c9b69c724cd6fa/6.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Smoke Purifier" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Smoke Purifier</div>
            <div class="card-subtitle">Filtra il 99% delle Particelle fino a 0,3µm e i VOC</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/h2d-laser-upgrade-kit" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/23cf4e98fc314c0a83ecd796f09495dd/7.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="H2 Laser Upgrade Kit" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">H2 Laser Upgrade Kit</div>
            <div class="card-subtitle">Potenzia le Tue Stampanti con il Taglio Laser di Precisione</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/cutting-upgrade-kit-h2-series" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/a1c2549c7df74a498931030ee645534b/8.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="H2 Cutting Upgrade Kit" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">H2 Cutting Upgrade Kit</div>
            <div class="card-subtitle">Sblocca Taglio e Disegno sulla Tua Serie H2</div>
          </div>
        </a>
      </div>
    </section>

    <!-- MAKERSUPPLY-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Maker's Supply</h2>
        <a href="https://eu.store.bambulab.com/it/collections/bambu-lab-3d-printers-filament" class="seeother">
          <span>Visualizza tutti</span>
          <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor">
            <path
              d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z">
            </path>
          </svg>
        </a>
      </div>

      <div class="banner-wrap">
        <a class="banner banner1" href="/it/products/pla-cmyk-lithophane">
          <div class="banner-content">
            <h4 class="banner-pretitle">Acquista ora</h4>
            <h3 class="banner-title">Maker's Supply</h3>

            <div class="banner-subtitle">
              Tutto ciò che serve per completare il tuo capolavoro <br> in un solo clic
            </div>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/makersuppy1.png" alt="plalithophanebundle">
          </div>
        </a>
        <a class="banner banner2" href="/it/pages/promotions/filament-bulk-sale">
          <div class="banner-content">
            <h3 class="banner-title">CyberBrick</h3>

            <div class="banner-subtitle">
              Costruisci in modo più intelligente, programma senza vincoli, condividi a livello globale.
            </div>

            <span class="banner-button">
              <span>Vedi di più</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
                aria-hidden="true">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </span>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/makersuppy2.png" alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        <a href="https://eu.store.bambulab.com/it/collections/makerlab-accessories" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/ce4b076b4e4741d0bb35d2d2be6d6411/5.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Accessoires Makerlab" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Accessoires Makerlab</div>
            <div class="card-subtitle">Accessoires conçus pour s'associer à vos créations MakerLab.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/maker-s-supply-models" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/ad201c0509dd461ebb0dd8f9e53edd2e/1.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Kit di modelli" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Kit di modelli</div>
            <div class="card-subtitle">Album di grandi progetti</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/maker-combo-kits" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/c9fa5a5b6dd24938960f8fe87c83cd53/8.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Kit Combo per Maker" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Kit Combo per Maker</div>
            <div class="card-subtitle">Kits sélectionnés pour Chaque Créateur</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/hardware-parts" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/342fbf29cf084f0f9faa3fac8b54325a/6.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Parti hardware" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Parti hardware</div>
            <div class="card-subtitle">Hardware di alta qualità</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/electronics" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/fe1561613d8348e8a6f1f410d20628de/111111.jpg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Elettronica" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Elettronica</div>
            <div class="card-subtitle">Elettronica per stimolare creatività</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/tools-others" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/20bbbf027881483881bb226b29094949/4.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Strumenti ed altro" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Strumenti ed altro</div>
            <div class="card-subtitle">Strumenti di precisione per la stampa 3DStrumenti di precisione per la stampa 3D
            </div>
          </div>
        </a>
      </div>
    </section>

    <!-- MATERIAL-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Materiali</h2>
        <a href="https://eu.store.bambulab.com/it/collections/bambu-lab-3d-printers-filament" class="seeother">
          <span>Visualizza tutti</span>
          <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor">
            <path
              d="M765.7 486.8L314.9 134.7A7.97 7.97 0 00302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 000-50.4z">
            </path>
          </svg>
        </a>
      </div>

      <div class="banner-wrap">
        <a class="banner banner1" href="/it/products/pla-cmyk-lithophane">
          <div class="banner-content">
            <h3 class="banner-title">Vendita in massa di materiale laser</h3>

            <div class="banner-price-row">
              <span class="banner-discount">Acquista 4/6/8 articoli - Fino al 15% di <br>sconto</span>
            </div>

            <span class="banner-button">
              <span>Scopri di più</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
                aria-hidden="true">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </span>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/materiale1.png" alt="plalithophanebundle">
          </div>
        </a>
        <a class="banner banner2" href="/it/pages/promotions/filament-bulk-sale">
          <div class="banner-content">
            <h3 class="banner-title">Vendita all'ingrosso<br>materiale da taglio</h3>

            <div class="banner-price-row">
              <span class="banner-discount">Acquista 4/6/8 articoli - Fino al 15% di <br>sconto</span>
            </div>

            <span class="banner-button">
              <span>Scopri di più</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none"
                aria-hidden="true">
                <g>
                  <path d="M1 4.5L4.8 8L1 11.5" stroke="#333333" stroke-linecap="round"></path>
                </g>
              </svg>
            </span>
          </div>

          <div class="banner-media">
            <img class="banner-image" src="img/materiale2.png" alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        <a href="https://eu.store.bambulab.com/it/products/bambu-basswood-plywood" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/bbc2ba11545840179342b3591471e6fd/B-YA001.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Compensato di Tiglio" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Compensato di Tiglio</div>
            <div class="card-subtitle">Facile da tagliare e texture facile da dipingere.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/birch-plywood" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/aabb12d9201a4bc6bcfc57fe0060a895/B-YA002.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Compensato di Betulla" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Compensato di Betulla</div>
            <div class="card-subtitle">Aspetto del legno chiaro.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/3mm-black-walnut-plywood-6pcs" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/be0643ea0efe42ceaa962d78cee13b21/B-YA003.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Compensato di Noce Nero" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Compensato di Noce Nero</div>
            <div class="card-subtitle">Estetica Scuri per un arredamento di lusso.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/3mm-bamboo-board-6pcs" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/3aa197247a7d4955a68becd8dc8457d4/B-YA005.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Tavola di Bambù" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Tavola di Bambù</div>
            <div class="card-subtitle">Aggiungi una texture naturale di bambù ai tuoi progetti.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/products/bambu-opaque-glossy-acrylic-sheet" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/11a97db7e631489db475f052c96ba936/B-YB001.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Acrilico" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Acrilico</div>
            <div class="card-subtitle">Personalizza portachiavi, accessori e decorazioni.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/sticker-vinyl" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/5618605f8ba6443aa6d4d7e2882033f0/B-YG001.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Adesivi e Vinile" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Adesivi e Vinile</div>
            <div class="card-subtitle">Personalizza oggetti quotidiani con vinile e adesivi.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/miscellaneous" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/9942195183ec4fd498f42682de9a85cf/B-YC001.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Varie" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Varie</div>
            <div class="card-subtitle">Tag in acciaio inossidabile e biglietti da visita in alluminio.</div>
          </div>
        </a>

        <a href="https://eu.store.bambulab.com/it/collections/bambu-material" class="card">
          <div class="card-image">
            <img
              src="https://store.bblcdn.eu/s8/default/3820e96e479b49ed8867b69998ec4aa7/B-YG018.png__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_100"
              alt="Per saperne di più" loading="lazy" width="282" height="250">
          </div>
          <div class="card-body">
            <div class="card-title">Per saperne di più</div>
            <div class="card-subtitle">Ottieni più materiali per le tue diverse esigenze.</div>
          </div>
        </a>
      </div>
    </section>

    <!-- STORE-BENEFITS -->
    <section class="section">
      <div class="store-benefits-heading">
        <h2>Perché acquistare su Bambu Lab Store</h2>
      </div>

      <div class="store-benefits-grid">
        <a class="store-benefits-card" href="/it/collections/sale">
          <div class="store-benefits-card-icon">
            <img
              src="https://store.bblcdn.com/s2/default/ccf0cf065521490ab4de917897e2059b/Download-3.svg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_80"
              alt="Offerte esclusive" width="72" height="72">
          </div>

          <div class="store-benefits-card-title">
            <span class="store-benefits-green">Offerte esclusive</span>
            <span class="store-benefits-dark">sul negozio ufficiale</span>
          </div>
        </a>

        <a class="store-benefits-card" href="/it/pages/payment-help">
          <div class="store-benefits-card-icon">
            <img
              src="https://store.bblcdn.com/s2/default/8f932d94999d4ce0bf08a9fc7c1ea124/Download-2.svg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_80"
              alt="Transazioni sicure" width="72" height="72">
          </div>

          <div class="store-benefits-card-title">
            <span class="store-benefits-green">100%</span>
            <span class="store-benefits-dark">Transazioni sicure</span>
          </div>
        </a>

        <a class="store-benefits-card" href="/it/policies/refund-policy">
          <div class="store-benefits-card-icon">
            <img
              src="https://store.bblcdn.com/s2/default/68f11b893e984ec898022a324163f522/Download-1.svg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_80"
              alt="Servizio di reso e rimborso" width="72" height="72">
          </div>

          <div class="store-benefits-card-title">
            <span class="store-benefits-green">14 giorni</span>
            <span class="store-benefits-dark">Servizio di reso e rimborso</span>
          </div>
        </a>

        <a class="store-benefits-card" href="https://support.bambulab.com/?lang=en&store=website-en" target="_blank"
          rel="noopener noreferrer">
          <div class="store-benefits-card-icon">
            <img
              src="https://store.bblcdn.com/s2/default/c943a31046324f2780b172e017ce037e/Download.svg__op__resize,m_lfit,w_640__op__format,f_auto__op__quality,q_80"
              alt="Supporto clienti" width="72" height="72">
          </div>

          <div class="store-benefits-card-title">
            <span class="store-benefits-green">Supporto clienti</span>
            <span class="store-benefits-dark">a vita</span>
          </div>
        </a>
      </div>
    </section>

    <!-- NEWSLETTER-SIGNUP -->
    <section class="section">
      <div class="newsletter-signup-box">
        <div class="newsletter-signup-media-mobile">
          <img
            src="https://store.bblcdn.eu/s8/default/40e6f41b6b244f48a342737ab2a935cb/bottom_pc.png__op__resize,m_lfit,w_1080__op__format,f_auto__op__quality,q_80"
            alt="Promo iscrizione newsletter">
        </div>

        <div class="newsletter-signup-content">
          <div class="newsletter-signup-text">
            <h2>10 € di sconto su ordini superiori a 90€!</h2>
            <p>Iscriviti allo store UE per ricevere il tuo coupon esclusivo!</p>
          </div>

          <div class="newsletter-signup-form-wrap">
            <form class="newsletter-signup-form">
              <input type="email" placeholder="Inserire l'e-mail" aria-label="Inserire l'e-mail">
              <button type="submit">Iscriviti</button>
            </form>

            <label class="newsletter-signup-consent">
              <input type="checkbox">
              <span>
                Fai clic su “Iscriviti” per acconsentire ai messaggi di marketing di Bambu Lab.
                Puoi annullare l’iscrizione in qualsiasi momento tramite il link nell’e-mail.
                Consulta la
                <a href="https://bambulab.com/en/policies/privacy" target="_blank" rel="noopener noreferrer">Informativa
                  sulla privacy</a>,
                i
                <a href="https://bambulab.com/en/policies/terms" target="_blank" rel="noopener noreferrer">Termini di
                  utilizzo</a>
                e le
                <a href="https://eu.store.bambulab.com/pages/subscription-coupon-terms-and-conditions" target="_blank"
                  rel="noopener noreferrer">Condizioni generali</a>
                per ulteriori dettagli.
              </span>
            </label>
          </div>
        </div>

        <div class="newsletter-signup-media-desktop">
          <img
            src="https://store.bblcdn.eu/s8/default/40e6f41b6b244f48a342737ab2a935cb/bottom_pc.png__op__resize,m_lfit,w_1080__op__format,f_auto__op__quality,q_80"
            alt="Promo iscrizione newsletter">
        </div>
      </div>
    </section>

    <!-- CURRENCY-CONVERTER -->
    <section class="section">
      <div class="currency-converter-box">
        <div class="currency-converter-content">
          <div class="currency-converter-text">
            <h2>Cambio valuta in tempo reale</h2>
            <p>Converti rapidamente i prezzi del tuo ordine con ExchangeRate API.</p>
          </div>

          <div class="currency-converter-form-wrap">
            <div class="currency-converter-form-row">
              <label for="fxAmount">Importo</label>
              <input id="fxAmount" type="number" min="0" step="0.01" value="90" placeholder="Inserisci importo">
            </div>

            <div class="currency-converter-form-grid">
              <div class="currency-converter-form-row">
                <label for="fxFrom">Da</label>
                <select id="fxFrom">
                  <option value="EUR">EUR</option>
                  <option value="USD">USD</option>
                  <option value="GBP">GBP</option>
                  <option value="CHF">CHF</option>
                </select>
              </div>

              <div class="currency-converter-form-row">
                <label for="fxTo">A</label>
                <select id="fxTo">
                  <option value="USD">USD</option>
                  <option value="EUR">EUR</option>
                  <option value="GBP">GBP</option>
                  <option value="CHF">CHF</option>
                </select>
              </div>
            </div>

            <button id="fxConvertButton" type="button">Converti</button>
            <p id="fxResult" class="currency-converter-result"></p>
          </div>
        </div>
      </div>
    </section>

  </main>

<?php include __DIR__ . '/layout/footer.php'; ?>

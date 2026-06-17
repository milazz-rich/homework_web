@extends('layouts.app')

@section('title', 'Acquisti stampanti 3D, filamenti e accessori | Bambu Lab EU store')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush
@push('scripts')
  <script src="{{ asset('js/script.js') }}" defer></script>
  <script src="{{ asset('js/home.js') }}" defer></script>
@endpush

@section('content')
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
      <a href="{{ url('/3d-printer') }}">
        <div>
          <div class="title">Stampanti 3d</div>
          <div class="subtitle">Stampanti avanzate potenziano progetti avanzati</div>
        </div>
        <img src="{{ asset('img/stampanti3d.png') }}" alt="stampanti3d" width="189" height="129">
      </a>

      <a href="{{ url('/filamenti') }}">
        <div>
          <div class="title">Filamenti</div>
          <div class="subtitle">Eccellente qualità, prestazione e facilità d'uso</div>
        </div>
        <img src="{{ asset('img/filamenti.png') }}" alt="filamenti" width="189" height="129">
      </a>

      <a href="{{ url('/accessori') }}">
        <div>
          <div class="title">Accessori</div>
          <div class="subtitle">Potenzia la tua stampante con accessori avanzati</div>
        </div>
        <img src="{{ asset('img/accessori.png') }}" alt="accessori" width="189" height="129">
      </a>

      <a href="{{ url('/makersupply') }}">
        <div>
          <div class="title">Maker's Supply</div>
          <div class="subtitle">Fornitura di accessori per completare i tuoi progetti</div>
        </div>
        <img src="{{ asset('img/makerssupply.png') }}" alt="makerssupply" width="189" height="129">
      </a>

      <a href="{{ url('/materiali') }}">
        <div>
          <div class="title">Material</div>
          <div class="subtitle">Fornire materiali adatti ai processi di taglio laser e a lama</div>
        </div>
        <img src="{{ asset('img/material.png') }}" alt="material" width="189" height="129">
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
            <svg viewBox="64 64 896 896" focusable="false" data-icon="right" width="1em" height="1em" fill="currentColor"
              aria-hidden="true">
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
              <a href="{{ url('/product') }}?id=49" class="product-box">
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
                <img src="{{ asset('img/ams2pro.png') }}" alt="ams2pro" width="235">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="{{ url('/product') }}?id=28" class="product-box">
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
                <img src="{{ asset('img/visionencoder.png') }}" alt="visionencoder" width="235">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="{{ url('/product') }}?id=31" class="product-box">
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
                <img src="{{ asset('img/hotendadaltaportata.png') }}" alt="hotendadaltaportata" width="120">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="{{ url('/product') }}?id=30" class="product-box">
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
                <img src="{{ asset('img/h2laserupgradekit.png') }}" alt="h2laserupgradekit" width="235">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="{{ url('/product') }}?id=31" class="product-box">
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
                <img src="{{ asset('img/tungstencarbidenozzle.png') }}" alt="tungstencarbidenozzle" width="120">
              </a>
            </div>

            <div class="featured-products-slide">
              <a href="{{ url('/product') }}?id=28" class="product-box">
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
                <img src="{{ asset('img/rotaryattachment.png') }}" alt="rotaryattachment" width="235">
              </a>
            </div>

          </div>
        </div>
      </div>
      <div class="products-box2">
        <a href="{{ url('/product') }}?id=49" class="product-box">
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
          <img src="{{ asset('img/ams2pro.png') }}" alt="ams2pro" height="124">
        </a>
        <a href="{{ url('/product') }}?id=28" class="product-box">
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
          <img src="{{ asset('img/visionencoder.png') }}" alt="ams2pro" height="124">
        </a>
        <a href="{{ url('/product') }}?id=31" class="product-box">
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
          <img src="{{ asset('img/hotendadaltaportata.png') }}" alt="ams2pro" height="124">
        </a>
        <a href="{{ url('/product') }}?id=30" class="product-box">
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
          <img src="{{ asset('img/h2laserupgradekit.png') }}" alt="ams2pro" height="124">
        </a>
        <a href="{{ url('/product') }}?id=31" class="product-box">
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
          <img src="{{ asset('img/tungstencarbidenozzle.png') }}" alt="ams2pro" height="124">
        </a>
        <a href="{{ url('/product') }}?id=28" class="product-box">
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
          <img src="{{ asset('img/rotaryattachment.png') }}" alt="ams2pro" height="124">
        </a>

      </div>
    </section>

    <!-- PRINTERS-CATALOG -->
    <section class="section printers-catalog">
      <div class="section-title">
        <h2>Stampanti 3d</h2>
        <a href="{{ url('/3d-printer') }}" class="seeother">
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
        @foreach (($products ?? []) as $product)
          @php
            $name = $product->name;
            $subtitle = $product->subtitle;
            $imagePath = $product->image_path !== '' ? $product->image_path : 'img/stampanti3d.png';
          @endphp
          <a href="{{ url('/product') }}?id={{ urlencode((string) $product->id) }}" class="printers-card">
            <div class="printers-card-img">
              <img src="{{ asset($imagePath) }}" alt="{{ $name }}">
            </div>

            <div class="printers-card-info">
              <div>
                <div class="printers-card-title">{{ $name }}</div>
                <div class="printers-card-subtitle">{{ $subtitle }}</div>
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
        @endforeach
      </div>
    </section>

    <!-- FILMANETS-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Filamenti</h2>
        <a href="{{ url('/filamenti') }}" class="seeother">
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
            <img class="banner-image" src="{{ asset('img/plalithophanebundle.png') }}" alt="plalithophanebundle">
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
            <img class="banner-image" src="{{ asset('img/acquistarisparmiadipiu.png') }}"
              alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        @foreach (($filaments ?? []) as $filament)
          @php
            $filamentName = $filament->name;
            $filamentImage = $filament->image_path !== '' ? $filament->image_path : 'img/filamenti.png';
          @endphp
          <a href="{{ url('/product') }}?id={{ urlencode((string) $filament->id) }}" class="card">
            <div class="card-image">
              <img src="{{ asset($filamentImage) }}" alt="{{ $filamentName }}" loading="lazy" width="282" height="250">
            </div>
            <div class="card-body">
              <div class="card-title">{{ $filamentName }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </section>

    <!-- ACCESSORIES-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Accessori</h2>
        <a href="{{ url('/accessori') }}" class="seeother">
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
            <img class="banner-image" src="{{ asset('img/accessori1.png') }}" alt="plalithophanebundle">
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
            <img class="banner-image" src="{{ asset('img/accessori2.png') }}" alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        @foreach (($accessories ?? []) as $accessory)
          @php
            $accessoryName = $accessory->name;
            $accessorySubtitle = $accessory->subtitle;
            $accessoryImage = $accessory->image_path !== '' ? $accessory->image_path : 'img/accessori.png';
          @endphp
          <a href="{{ url('/product') }}?id={{ urlencode((string) $accessory->id) }}" class="card">
            <div class="card-image">
              <img src="{{ asset($accessoryImage) }}" alt="{{ $accessoryName }}" loading="lazy" width="282" height="250">
            </div>
            <div class="card-body">
              <div class="card-title">{{ $accessoryName }}</div>
              <div class="card-subtitle">{{ $accessorySubtitle }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </section>

    <!-- MAKERSUPPLY-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Maker's Supply</h2>
        <a href="{{ url('/makersupply') }}" class="seeother">
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
            <img class="banner-image" src="{{ asset('img/makersuppy1.png') }}" alt="plalithophanebundle">
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
            <img class="banner-image" src="{{ asset('img/makersuppy2.png') }}" alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        @foreach (($makersupply ?? []) as $item)
          @php
            $itemName = $item->name;
            $itemSubtitle = $item->subtitle;
            $itemImage = $item->image_path !== '' ? $item->image_path : 'img/makersuppy1.png';
          @endphp
          <a href="{{ url('/product') }}?id={{ urlencode((string) $item->id) }}" class="card">
            <div class="card-image">
              <img src="{{ asset($itemImage) }}" alt="{{ $itemName }}" loading="lazy" width="282" height="250">
            </div>
            <div class="card-body">
              <div class="card-title">{{ $itemName }}</div>
              <div class="card-subtitle">{{ $itemSubtitle }}</div>
            </div>
          </a>
        @endforeach
      </div>
    </section>

    <!-- MATERIAL-CATALOG -->
    <section class="section">
      <div class="section-title">
        <h2>Materiali</h2>
        <a href="{{ url('/materiali') }}" class="seeother">
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
            <img class="banner-image" src="{{ asset('img/materiale1.png') }}" alt="plalithophanebundle">
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
            <img class="banner-image" src="{{ asset('img/materiale2.png') }}" alt="Acquista di più, risparmia di più">
          </div>
        </a>
      </div>


      <div class="card-grid">
        @foreach (($materials ?? []) as $material)
          @php
            $materialName = $material->name;
            $materialSubtitle = $material->subtitle;
            $materialImage = $material->image_path !== '' ? $material->image_path : 'img/material.png';
          @endphp
          <a href="{{ url('/product') }}?id={{ urlencode((string) $material->id) }}" class="card">
            <div class="card-image">
              <img src="{{ asset($materialImage) }}" alt="{{ $materialName }}" loading="lazy" width="282" height="250">
            </div>
            <div class="card-body">
              <div class="card-title">{{ $materialName }}</div>
              <div class="card-subtitle">{{ $materialSubtitle }}</div>
            </div>
          </a>
        @endforeach
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
    <section class="section" id="newsletter-signup">
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
            <form class="newsletter-signup-form" action="{{ url('/newsletter') }}" method="POST">
              @csrf
              <input type="email" name="email" placeholder="Inserire l'e-mail" aria-label="Inserire l'e-mail" required>

              <label class="newsletter-signup-consent">
                <input type="checkbox" name="consent" value="1">
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

              <button type="submit">Iscriviti</button>
            </form>

            <p class="newsletter-signup-message" aria-live="polite"></p>
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

@endsection
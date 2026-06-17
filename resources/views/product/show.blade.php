@extends('layouts.app')

@section('title', $productName . ' | Bambu Lab EU store')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('js/product.js') }}" defer></script>
@endpush

@section('content')
  <main class="product-page">
    <nav class="product-breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}">Home</a>
      <span>/</span>
      <a href="{{ $collectionUrl }}">{{ $collectionLabel }}</a>
      <span>/</span>
      <span>{{ $productName }}</span>
    </nav>

    <section class="product-hero">
      <div class="product-gallery">
        <div class="product-gallery-main">
          <img id="mainImage" src="{{ asset($productImage) }}" alt="{{ $productName }}" />
        </div>
        <div class="product-gallery-thumbs">
          @for ($i = 0; $i < 4; $i++)
            <button class="thumb{{ $i === 0 ? ' active' : '' }}" data-src="{{ asset($productImage) }}" data-fallback="{{ asset($productImage) }}">
              <img src="{{ asset($productImage) }}" alt="{{ $productName }}" />
            </button>
          @endfor
        </div>
      </div>

      <div class="product-panel">
        <h1 class="product-panel-title">{{ $productName }}</h1>
        <p class="product-panel-price-main">€{{ $productPriceFormatted }} EUR</p>
        <p class="product-panel-desc">
          {{ $productDescription }}
          <a href="#" class="product-panel-desc-link">Maggiori informazioni</a>
        </p>

        <div class="product-panel-shipping">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M1 12l5-5v3h8V7l5 5-5 5v-3H6v3L1 12z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" /></svg>
          Consegna a domicilio disponibile
        </div>

        <div class="product-accordion">
          <button class="product-accordion-trigger" aria-expanded="false">
            Caratteristiche del prodotto
            <svg class="accordion-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" /></svg>
          </button>
          <div class="product-accordion-body" hidden>
            <ul>
              <li>{{ $productName }}</li>
              <li>{{ $productSubtitleFallback }}</li>
              <li>Prezzo aggiornato dal database</li>
              <li>Immagine caricata da image_path</li>
            </ul>
          </div>
        </div>

        <form class="product-purchase-form" id="productPurchaseForm">
          @csrf
          <input type="hidden" name="product_id" value="{{ $productId }}">
          <input type="hidden" name="unit_price" value="{{ $productPrice }}">

          <div class="product-qty-row">
            <div class="product-qty">
              <button class="qty-btn" id="qtyMinus" type="button" aria-label="Diminuisci">-</button>
              <input class="qty-input" id="qtyInput" name="quantity" type="number" value="1" min="1" max="99" aria-label="Quantita" />
              <button class="qty-btn" id="qtyPlus" type="button" aria-label="Aumenta">+</button>
            </div>
            <div class="product-price-display">€{{ $productPriceFormatted }}</div>
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
            A partire da <strong>€{{ $productInstallmentFormatted }}/mese</strong> con Klarna.
            <a href="#">Scopri di piu</a>
          </p>
        </div>
      </div>
    </section>

    <section class="product-specs">
      <h2 class="product-specs-title">Dettagli prodotto</h2>
      <div class="product-specs-table-wrap">
        <table class="product-specs-table">
          <thead>
            <tr><th>Criterio</th><th>Valore</th><th>Dato</th></tr>
          </thead>
          <tbody>
            <tr><td>Nome</td><td>Prodotto</td><td>{{ $productName }}</td></tr>
            <tr><td>Descrizione</td><td>Subtitle</td><td>{{ $productSpecsSubtitle }}</td></tr>
            <tr><td>Prezzo</td><td>Listino</td><td>€{{ $productPriceFormatted }} EUR</td></tr>
          </tbody>
        </table>
      </div>
    </section>
  </main>
@endsection

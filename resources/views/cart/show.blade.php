@extends('layouts.app')

@section('title', 'Carrello | Bambu Lab EU store')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('js/cart.js') }}" defer></script>
@endpush

@section('content')
  <main class="cart-main">
    <section class="cart-header">
      <h1 class="cart-title">Carrello</h1>
      @if ($isAuthenticated)
        <p class="cart-subtitle" id="cart-subtitle">Carrello sincronizzato con il tuo account.</p>
      @else
        <p class="cart-subtitle" id="cart-subtitle">Accedi per sincronizzare gli articoli nel tuo carrello. <a href="{{ url('/login') }}" class="cart-login-link">Accedi ora &rsaquo;</a></p>
      @endif
    </section>

    <section class="cart-items-section">
      <div id="cart-items-list"></div>
      <div id="cart-empty-state" class="cart-empty-state">
        {{ $isAuthenticated ? 'Il carrello e vuoto.' : 'Accedi per vedere il tuo carrello.' }}
      </div>
    </section>

    <section class="cart-recommended">
      <h2 class="cart-recommended-title">Consigliato per te</h2>
      <div class="cart-recommended-grid">
        @foreach ($recommendedGroups as $group)
          @foreach ($group as $product)
            @php
              $recName = $product->name;
              $recImage = $product->image_path !== '' ? $product->image_path : 'img/stampanti3d.png';
              $recPrice = number_format((float) $product->price, 2, ',', '.');
            @endphp
            <div class="rec-card">
              <a href="{{ url('/product') }}?id={{ urlencode((string) $product->id) }}" class="rec-card-img-wrap">
                <img src="{{ asset($recImage) }}" alt="{{ $recName }}">
              </a>
              <div class="rec-card-body">
                <a href="{{ url('/product') }}?id={{ urlencode((string) $product->id) }}" class="rec-card-name">{{ $recName }}</a>
                <div class="rec-card-price">{{ $recPrice }} &euro;</div>
                <select class="rec-card-select">
                  <option>Configurazione standard</option>
                </select>
                <button class="rec-card-btn" data-product-id="{{ $product->id }}">Aggiungi al carrello</button>
              </div>
            </div>
          @endforeach
        @endforeach
      </div>
    </section>

    <div class="cart-footer-bar">
      <div class="cart-coupon">
        <span class="cart-coupon-label">Hai un codice?</span>
        <span class="cart-coupon-desc">Procedi al checkout per usare Coupon e Gift Card.</span>
        <a class="cart-continue-btn" href="{{ url('/') }}">Continua gli acquisti</a>
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
@endsection

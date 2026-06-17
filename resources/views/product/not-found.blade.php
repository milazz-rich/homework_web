@extends('layouts.app')

@section('title', 'Prodotto non trovato | Bambu Lab EU store')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endpush

@section('content')
  <main class="product-page">
    <section class="product-hero product-hero--not-found">
      <div class="product-panel product-panel--not-found">
        <h1 class="product-panel-price-main product-panel-price-main--not-found">Prodotto non trovato</h1>
        <p class="product-panel-desc">L'id prodotto richiesto non esiste o non e valido.</p>
        <div class="product-cta product-cta--not-found">
          <a class="btn-add-cart btn-add-cart--link" href="{{ url('/') }}">Torna alla home</a>
        </div>
      </div>
    </section>
  </main>
@endsection

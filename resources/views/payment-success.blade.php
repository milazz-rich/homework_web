@extends('layouts.app')

@section('title', 'Pagamento completato | Bambu Lab EU store')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/payment-success.css') }}">
@endpush

@section('content')
  <main class="payment-success-page">
    <section class="payment-success-card">
      <div class="payment-success-icon" aria-hidden="true">
        <svg width="42" height="42" viewBox="0 0 24 24" fill="none">
          <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>

      <p class="payment-success-kicker">Pagamento riuscito</p>
      <h1 class="payment-success-title">Grazie per il tuo ordine</h1>
      <p class="payment-success-text">
        Stripe ha confermato il pagamento. Riceverai gli aggiornamenti dell'ordine all'indirizzo e-mail usato durante il checkout.
      </p>

      @if ($recapSent)
        <p class="payment-success-note">Ti abbiamo inviato una mail con il riepilogo dell'ordine.</p>
      @endif

      @if ($sessionId !== '')
        <p class="payment-success-session">
          ID sessione Stripe:<br>
          <strong>{{ $sessionId }}</strong>
        </p>
      @endif

      <div class="payment-success-actions">
        <a class="payment-success-primary" href="{{ url('/') }}">Torna alla home</a>
        <a class="payment-success-secondary" href="{{ url('/saldi') }}">Continua gli acquisti</a>
      </div>
    </section>
  </main>
@endsection

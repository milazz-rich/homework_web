@extends('layouts.app')

@section('title', $title . ' | Bambu Lab EU store')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/catalog.js') }}" defer></script>
@endsection

@section('content')
    <main class="catalog-page">
        <h1 class="catalog-title">{{ $title }}</h1>

        @if ($products->isEmpty())
            <p>Nessun prodotto disponibile.</p>
        @else
            <ul>
                @foreach ($products as $product)
                    <li>
                        <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                        <span>{{ number_format($product->price, 2, ',', '.') }} &euro;</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </main>
@endsection

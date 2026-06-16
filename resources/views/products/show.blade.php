@extends('layouts.app')

@section('title', $product->name . ' | Bambu Lab EU store')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/product.js') }}" defer></script>
@endsection

@section('content')
    <main class="product-page">
        <h1>{{ $product->name }}</h1>
        <p>{{ $product->subtitle }}</p>
        <p>{{ number_format($product->price, 2, ',', '.') }} &euro;</p>
    </main>
@endsection

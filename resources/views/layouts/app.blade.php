<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Bambu Store')</title>

  <link rel="icon" type="image/x-icon" href="https://eu.store.bambulab.com/favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

  @stack('styles')

  <script src="{{ asset('js/header.js') }}" defer></script>

  @stack('scripts')
</head>

<body>

  @include('layouts.header')

  @yield('content')

  @include('layouts.footer')

</body>

</html>
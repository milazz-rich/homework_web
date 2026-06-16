<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accedi | Bambu Lab IT</title>
    <link rel="icon" type="image/x-icon" href="https://eu.store.bambulab.com/favicon.ico">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/auth.js') }}" defer></script>
</head>
<body>
    <div class="card">
        <div class="locale">Italia <span>|</span> Italiano</div>

        <h1>Accedi</h1>

        @if ($errors->has('auth'))
            <div class="form-error">{{ $errors->first('auth') }}</div>
        @endif

        <form action="{{ route('login.store') }}" method="post">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Indirizzo e-mail*" value="{{ old('email') }}" required>
            </div>

            <div class="form-group password-wrapper">
                <input type="password" name="password" id="password" placeholder="password*" required>
                <button type="button" class="toggle-eye" aria-label="Mostra o nascondi password">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">Accetto i <a href="#">Termini di utilizzo e l'Informativa sulla privacy</a></label>
            </div>

            <button type="submit" class="btn-accedi">Accedi</button>
        </form>

        <div class="forgot"><a href="#">Dimenticata?</a></div>
        <div class="divider"><span>Effettua il login con altri account</span></div>
        <div class="social-buttons">
            <button class="social-btn" type="button">Apple</button>
            <button class="social-btn" type="button">Google</button>
            <button class="social-btn" type="button">Facebook</button>
        </div>
        <div class="signup-row">Non hai un account? <a href="{{ route('register') }}">Crea il tuo Account</a></div>
        <div class="copyright">Copyright &copy; 2026 Bambu Lab Tutti i diritti riservati.</div>
    </div>
</body>
</html>

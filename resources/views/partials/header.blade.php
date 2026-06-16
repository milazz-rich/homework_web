<div class="notice">
    <div class="notice-inner">
        <a class="notice-site" href="https://bambulab.com/">Bambulab.com</a>

        <div class="notice-message">
            La stampante 3D a Singolo Ugello Definitiva! Per saperne di piu &gt;&gt;
        </div>

        <div class="notice-meta">
            <span class="notice-meta-item">Europe</span>
            <span class="notice-meta-item">Italiano</span>
        </div>
    </div>
</div>

<nav class="navbar-mobile" aria-label="Navigazione mobile">
    <div class="navbar-mobile-inner">
        <div class="navbar-mobile-left">
            <button class="navbar-mobile-toggle" type="button" aria-label="Apri il menu" aria-expanded="false">
                <svg class="navbar-mobile-menu-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M7.50024 5H20.0034" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M7.50024 12H20.0034" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M7.50024 19H20.0034" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </button>
        </div>

        <a class="navbar-mobile-brand" href="{{ route('home') }}" aria-label="Bambu Lab">
            <img class="navbar-mobile-logo" src="https://store.bblcdn.com/s2/default/febc4874843645f38149a05caa0f8a6d/logo.png" alt="Bambu Lab">
        </a>

        <div class="navbar-mobile-actions">
            <button class="navbar-mobile-icon-button search" type="button" aria-label="Apri ricerca" aria-haspopup="dialog" aria-expanded="false" aria-controls="search-modal" data-search-open>
                Cerca
            </button>

            <a class="navbar-mobile-icon-button cart" href="#" aria-label="Apri carrello" title="Vai al carrello">
                Carrello
                <span class="cart-badge" aria-label="Articoli nel carrello">0</span>
            </a>
        </div>
    </div>
</nav>

<nav class="navbar-desktop" aria-label="Navigazione principale">
    <div class="navbar-inner">
        <div class="navbar-brand">
            <a href="{{ route('home') }}">
                <img class="navbar-logo" src="https://store.bblcdn.com/s2/default/febc4874843645f38149a05caa0f8a6d/logo.png" alt="Bambu Lab">
            </a>
        </div>

        <nav class="navbar-menu no-scrollbar" aria-label="Menu principale">
            <ul>
                <li><a href="{{ route('catalog.sales') }}">Saldi</a></li>
                <li><a href="{{ route('catalog.show', '3d-printer') }}">Stampanti</a></li>
                <li><a href="{{ route('catalog.show', 'ams') }}">AMS</a></li>
                <li><a href="{{ route('catalog.show', 'filamenti') }}">Filamenti</a></li>
                <li><a href="{{ route('catalog.show', 'accessori') }}">Accessori</a></li>
                <li><a href="{{ route('catalog.show', 'materiali') }}">Materiale</a></li>
                <li><a href="{{ route('catalog.show', 'makersupply') }}">Maker's Supply</a></li>
                <li>
                    <a href="#" data-dropdown-trigger="supporto">Supporto</a>
                    <div class="dropdown-menu hidden" data-dropdown-menu="supporto">
                        <a href="#">Tracciamento Ordine</a>
                        <a href="#">Centro di supporto</a>
                        <a href="#">FAQ</a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="navbar-actions">
            <button class="search" type="button" aria-label="Apri ricerca" aria-haspopup="dialog" aria-expanded="false" aria-controls="search-modal" data-search-open>
                Cerca
            </button>

            <a class="cart" href="#" aria-label="Apri carrello">
                Carrello
                <span class="cart-badge" aria-label="Articoli nel carrello">0</span>
            </a>

            <button class="user" type="button" data-dropdown-trigger="user" aria-label="Account">
                {{ session('auth_user.nome', 'Account') }}
            </button>
            <div class="dropdown-menu hidden" data-dropdown-menu="user">
                @if (session()->has('auth_user'))
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('register') }}">Registrati</a>
                    <a href="{{ route('login') }}">Login</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="search-modal hidden" id="search-modal" role="dialog" aria-modal="true" aria-labelledby="search-modal-title">
    <div class="search-modal-backdrop" data-search-close></div>
    <div class="search-modal-panel">
        <div class="search-modal-header">
            <div>
                <p class="search-modal-kicker">Cerca nello store</p>
                <h2 class="search-modal-title" id="search-modal-title">Trova prodotti</h2>
            </div>
            <button class="search-modal-close" type="button" aria-label="Chiudi ricerca" data-search-close>&times;</button>
        </div>

        <div class="search-modal-field">
            <input class="search-modal-input" type="search" placeholder="Cerca stampanti, filamenti, accessori..." autocomplete="off">
        </div>

        <div class="search-modal-status" data-search-status>Inizia a digitare per cercare un prodotto.</div>
        <div class="search-modal-results" data-search-results></div>
    </div>
</div>

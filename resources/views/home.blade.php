@extends('layouts.app')

@section('title', 'Home | Bambu Lab EU store')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="{{ asset('js/home.js') }}" defer></script>
@endsection

@php
    $categories = [
        ['title' => 'Stampanti 3d', 'subtitle' => 'Stampanti avanzate potenziano progetti avanzati', 'image' => 'stampanti3d.png', 'route' => route('catalog.show', '3d-printer')],
        ['title' => 'Filamenti', 'subtitle' => "Eccellente qualita, prestazione e facilita d'uso", 'image' => 'filamenti.png', 'route' => route('catalog.show', 'filamenti')],
        ['title' => 'Accessori', 'subtitle' => 'Potenzia la tua stampante con accessori avanzati', 'image' => 'accessori.png', 'route' => route('catalog.show', 'accessori')],
        ['title' => "Maker's Supply", 'subtitle' => 'Fornitura di accessori per completare i tuoi progetti', 'image' => 'makerssupply.png', 'route' => route('catalog.show', 'makersupply')],
        ['title' => 'Material', 'subtitle' => 'Fornire materiali adatti ai processi di taglio laser e a lama', 'image' => 'material.png', 'route' => route('catalog.show', 'materiali')],
    ];

    $featuredProducts = [
        ['id' => 49, 'title' => 'AMS 2 PRO', 'subtitle' => 'Sistema AMS di seconda generazione compatibile con la serie X1 e P1', 'image' => 'ams2pro.png', 'width' => 235],
        ['id' => 28, 'title' => 'Vision Encoder', 'subtitle' => 'Precisione a un nuovo livello', 'image' => 'visionencoder.png', 'width' => 235],
        ['id' => 31, 'title' => 'Hotend ad alta portata', 'subtitle' => '', 'image' => 'hotendadaltaportata.png', 'width' => 120],
        ['id' => 30, 'title' => 'H2 Laser Upgrade Kit', 'subtitle' => 'Potenzia il tuo H2 con il taglio laser di precisione', 'image' => 'h2laserupgradekit.png', 'width' => 235],
        ['id' => 31, 'title' => 'Tungsten Carbide Nozzle', 'subtitle' => 'Perfetto per filamenti abrasivi', 'image' => 'tungstencarbidenozzle.png', 'width' => 120],
        ['id' => 28, 'title' => 'Rotary Attachment', 'subtitle' => 'Incisioni laser professionali su tazze e oggetti curvi', 'image' => 'rotaryattachment.png', 'width' => 235],
    ];

    $homeSections = [
        ['title' => 'Filamenti', 'catalogUrl' => route('catalog.show', 'filamenti'), 'products' => $filaments, 'fallbackImage' => 'img/filamenti.png', 'bannerOneTitle' => 'PLA CMYK Lithophane Bundle', 'bannerOneSubtitle' => 'Esalta la tua litofania con colori vivaci', 'bannerOneImage' => 'img/plalithophanebundle.png', 'bannerTwoTitle' => 'Acquista di piu, risparmia di piu!', 'bannerTwoSubtitle' => 'Approfitta di sconti speciali per rifornirti di filamenti di qualita.', 'bannerTwoImage' => 'img/acquistarisparmiadipiu.png'],
        ['title' => 'Accessori', 'catalogUrl' => route('catalog.show', 'accessori'), 'products' => $accessories, 'fallbackImage' => 'img/accessori.png', 'bannerOneTitle' => 'Vendita in stock di piastre 3D Effect', 'bannerOneSubtitle' => 'Piu Stili di Piastra, Stampe Migliori', 'bannerOneImage' => 'img/accessori1.png', 'bannerTwoTitle' => 'Vendita in Blocco Hotend', 'bannerTwoSubtitle' => 'Piu Compri, Piu Risparmi', 'bannerTwoImage' => 'img/accessori2.png'],
        ['title' => "Maker's Supply", 'catalogUrl' => route('catalog.show', 'makersupply'), 'products' => $makersupply, 'fallbackImage' => 'img/makersuppy1.png', 'bannerOneTitle' => "Maker's Supply", 'bannerOneSubtitle' => 'Tutto cio che serve per completare il tuo capolavoro in un solo clic', 'bannerOneImage' => 'img/makersuppy1.png', 'bannerTwoTitle' => 'CyberBrick', 'bannerTwoSubtitle' => 'Costruisci in modo piu intelligente, programma senza vincoli, condividi a livello globale.', 'bannerTwoImage' => 'img/makersuppy2.png'],
        ['title' => 'Materiali', 'catalogUrl' => route('catalog.show', 'materiali'), 'products' => $materials, 'fallbackImage' => 'img/material.png', 'bannerOneTitle' => 'Vendita in massa di materiale laser', 'bannerOneSubtitle' => 'Acquista 4/6/8 articoli - Fino al 15% di sconto', 'bannerOneImage' => 'img/materiale1.png', 'bannerTwoTitle' => "Vendita all'ingrosso materiale da taglio", 'bannerTwoSubtitle' => 'Acquista 4/6/8 articoli - Fino al 15% di sconto', 'bannerTwoImage' => 'img/materiale2.png'],
    ];
@endphp

@section('content')
    <div class="carosel">
        <div class="carosel-overlay">
            <div class="carosel-content">
                <div class="carosel-eyebrow">Bambu Lab H2C</div>
                <h1 class="carosel-title">Multi-Materiale senza compromessi.</h1>
                <div class="carosel-button-row">
                    <a class="carosel-button" href="{{ route('catalog.show', '3d-printer') }}">
                        <span>Acquista ora</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="carosel-media" id="carosel-media"></div>
    </div>

    <main>
        <section class="section product-categories">
            @foreach ($categories as $category)
                <a href="{{ $category['route'] }}">
                    <div>
                        <div class="title">{{ $category['title'] }}</div>
                        <div class="subtitle">{{ $category['subtitle'] }}</div>
                    </div>
                    <img src="{{ asset('img/' . $category['image']) }}" alt="{{ $category['title'] }}" width="189" height="129">
                </a>
            @endforeach
        </section>

        <section class="section featured-products">
            <div class="section-title">
                <h2>Prodotti in evidenza</h2>
                <div class="featured-products-button">
                    <button id="featured-products-prev" type="button" aria-label="Prodotto precedente">&lsaquo;</button>
                    <button id="featured-products-next" type="button" aria-label="Prodotto successivo">&rsaquo;</button>
                </div>
            </div>

            <div class="products-box1">
                <div class="featured-products-slider">
                    <div class="featured-products-track" id="featured-products-track">
                        @foreach ($featuredProducts as $featured)
                            <div class="featured-products-slide">
                                <a href="{{ route('products.show', $featured['id']) }}" class="product-box">
                                    <div>
                                        <h1 class="product-title">{{ $featured['title'] }}</h1>
                                        <div class="product-subtitle">{{ $featured['subtitle'] }}</div>
                                        <div class="acquista"><span>Acquista</span></div>
                                    </div>
                                    <img src="{{ asset('img/' . $featured['image']) }}" alt="{{ $featured['title'] }}" width="{{ $featured['width'] }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="products-box2">
                @foreach ($featuredProducts as $featured)
                    <a href="{{ route('products.show', $featured['id']) }}" class="product-box">
                        <div>
                            <h1 class="product-title">{{ $featured['title'] }}</h1>
                            <div class="product-subtitle">{{ $featured['subtitle'] }}</div>
                            <div class="acquista"><span>Acquista</span></div>
                        </div>
                        <img src="{{ asset('img/' . $featured['image']) }}" alt="{{ $featured['title'] }}" height="124">
                    </a>
                @endforeach
            </div>
        </section>

        <section class="section printers-catalog">
            <div class="section-title">
                <h2>Stampanti 3d</h2>
                <a href="{{ route('catalog.show', '3d-printer') }}" class="seeother"><span>Visualizza tutti</span></a>
            </div>

            <div class="printers-banner">
                <img class="printers-banner-img printers-banner-img-mobile" src="https://store.bblcdn.eu/s8/default/efcbe7a5cd774bae8168e590b734f0dc/MO-tuya.jpg__op__resize,m_lfit,w_1920__op__format,f_auto__op__quality,q_90" alt="Banner Bambu Lab" loading="lazy" width="672" height="450">
                <img class="printers-banner-img printers-banner-img-desktop" src="https://store.bblcdn.eu/s8/default/346dcca5804941e18569f0d89481ecd0/PC-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_90" alt="Banner Bambu Lab" loading="lazy" width="1200" height="400">
                <div class="printers-banner-content">
                    <div class="printers-banner-eyebrow">Bambu Lab H2C</div>
                    <div class="printers-banner-title">Multi-Materiale senza compromessi.</div>
                    <a class="printers-banner-button" href="{{ route('catalog.show', '3d-printer') }}"><span>Acquista ora</span></a>
                </div>
            </div>

            <div class="printers-grid">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="printers-card">
                        <div class="printers-card-img">
                            <img src="{{ asset($product->image_path ?: 'img/stampanti3d.png') }}" alt="{{ $product->name }}">
                        </div>
                        <div class="printers-card-info">
                            <div>
                                <div class="printers-card-title">{{ $product->name }}</div>
                                <div class="printers-card-subtitle">{{ $product->subtitle }}</div>
                            </div>
                            <div class="printers-card-link">Visualizza il prodotto</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        @foreach ($homeSections as $homeSection)
            <section class="section">
                <div class="section-title">
                    <h2>{{ $homeSection['title'] }}</h2>
                    <a href="{{ $homeSection['catalogUrl'] }}" class="seeother"><span>Visualizza tutti</span></a>
                </div>

                <div class="banner-wrap">
                    <a class="banner banner1" href="{{ $homeSection['catalogUrl'] }}">
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $homeSection['bannerOneTitle'] }}</h3>
                            <div class="banner-subtitle">{{ $homeSection['bannerOneSubtitle'] }}</div>
                            <span class="banner-button"><span>Scopri di piu</span></span>
                        </div>
                        <div class="banner-media">
                            <img class="banner-image" src="{{ asset($homeSection['bannerOneImage']) }}" alt="{{ $homeSection['bannerOneTitle'] }}">
                        </div>
                    </a>

                    <a class="banner banner2" href="{{ $homeSection['catalogUrl'] }}">
                        <div class="banner-content">
                            <h3 class="banner-title">{{ $homeSection['bannerTwoTitle'] }}</h3>
                            <div class="banner-subtitle">{{ $homeSection['bannerTwoSubtitle'] }}</div>
                            <span class="banner-button"><span>Scopri di piu</span></span>
                        </div>
                        <div class="banner-media">
                            <img class="banner-image" src="{{ asset($homeSection['bannerTwoImage']) }}" alt="{{ $homeSection['bannerTwoTitle'] }}">
                        </div>
                    </a>
                </div>

                <div class="card-grid">
                    @foreach ($homeSection['products'] as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="card">
                            <div class="card-image">
                                <img src="{{ asset($product->image_path ?: $homeSection['fallbackImage']) }}" alt="{{ $product->name }}" loading="lazy" width="282" height="250">
                            </div>
                            <div class="card-body">
                                <div class="card-title">{{ $product->name }}</div>
                                <div class="card-subtitle">{{ $product->subtitle }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach

        <section class="section">
            <div class="store-benefits-heading">
                <h2>Perche acquistare su Bambu Lab Store</h2>
            </div>

            <div class="store-benefits-grid">
                <a class="store-benefits-card" href="{{ route('catalog.sales') }}">
                    <div class="store-benefits-card-title">
                        <span class="store-benefits-green">Offerte esclusive</span>
                        <span class="store-benefits-dark">sul negozio ufficiale</span>
                    </div>
                </a>
                <a class="store-benefits-card" href="#">
                    <div class="store-benefits-card-title">
                        <span class="store-benefits-green">100%</span>
                        <span class="store-benefits-dark">Transazioni sicure</span>
                    </div>
                </a>
                <a class="store-benefits-card" href="#">
                    <div class="store-benefits-card-title">
                        <span class="store-benefits-green">14 giorni</span>
                        <span class="store-benefits-dark">Servizio di reso e rimborso</span>
                    </div>
                </a>
                <a class="store-benefits-card" href="https://support.bambulab.com/?lang=en&store=website-en" target="_blank" rel="noopener noreferrer">
                    <div class="store-benefits-card-title">
                        <span class="store-benefits-green">Supporto clienti</span>
                        <span class="store-benefits-dark">a vita</span>
                    </div>
                </a>
            </div>
        </section>

        <section class="section" id="newsletter-signup">
            <div class="newsletter-signup-box">
                <div class="newsletter-signup-content">
                    <div class="newsletter-signup-text">
                        <h2>10 euro di sconto su ordini superiori a 90 euro!</h2>
                        <p>Iscriviti allo store UE per ricevere il tuo coupon esclusivo!</p>
                    </div>

                    <div class="newsletter-signup-form-wrap">
                        <form class="newsletter-signup-form" action="#" method="post">
                            @csrf
                            <input type="email" name="email" placeholder="Inserire l'e-mail" aria-label="Inserire l'e-mail" required>
                            <label class="newsletter-signup-consent">
                                <input type="checkbox" name="consent" value="1">
                                <span>Fai clic su Iscriviti per acconsentire ai messaggi di marketing di Bambu Lab.</span>
                            </label>
                            <button type="submit">Iscriviti</button>
                        </form>

                        <p class="newsletter-signup-message" aria-live="polite"></p>
                    </div>
                </div>

                <div class="newsletter-signup-media-desktop">
                    <img src="https://store.bblcdn.eu/s8/default/40e6f41b6b244f48a342737ab2a935cb/bottom_pc.png__op__resize,m_lfit,w_1080__op__format,f_auto__op__quality,q_80" alt="Promo iscrizione newsletter">
                </div>
            </div>
        </section>

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

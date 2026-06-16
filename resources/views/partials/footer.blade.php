<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-column">
                <h2 class="footer-heading">Menu</h2>
                <ul class="footer-list">
                    <li><a href="{{ route('catalog.sales') }}">Saldi</a></li>
                    <li><a href="{{ route('catalog.show', '3d-printer') }}">Stampanti</a></li>
                    <li><a href="{{ route('catalog.show', 'ams') }}">AMS</a></li>
                    <li><a href="{{ route('catalog.show', 'filamenti') }}">Filamenti</a></li>
                    <li><a href="{{ route('catalog.show', 'accessori') }}">Accessori</a></li>
                    <li><a href="{{ route('catalog.show', 'materiali') }}">Materiale</a></li>
                    <li><a href="{{ route('catalog.show', 'makersupply') }}">Maker's Supply</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h2 class="footer-heading">Supporto</h2>
                <ul class="footer-list">
                    <li><a href="#">Tracker ordini</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="https://wiki.bambulab.com/home">Wiki ufficiale</a></li>
                    <li><a href="#">Politica di spedizione</a></li>
                    <li><a href="#">Resi &amp; Rimborsi</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h2 class="footer-heading">Esplora</h2>
                <ul class="footer-list">
                    <li><a href="https://www.bambulab.com">Sito ufficiale</a></li>
                    <li><a href="https://bambulab.com/corporate-sales">Vendite aziendali</a></li>
                    <li><a href="https://bambulab.com/dealer">Rivenditore autorizzato</a></li>
                    <li><a href="https://bambulab.com/contact-us">Contattaci</a></li>
                    <li><a href="https://bambulab.com/about-us">Su di noi</a></li>
                </ul>
            </div>

            <div class="footer-column footer-column-info">
                <h2 class="footer-heading">Informazioni su Bambu Lab</h2>
                <div class="footer-text">
                    <p>Bambu Lab e' un'azienda di tecnologia di consumo che si concentra sulle stampanti 3D desktop.</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <a href="{{ route('home') }}" class="footer-copyright">&copy; Bambu Lab EU</a>
        </div>
    </div>
</footer>

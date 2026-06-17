// Interazioni homepage: carosello hero e slider prodotti in evidenza.

const HERO_SLIDES = [
  {
    eyebrow: '',
    title: 'Eccellenza resa semplice.',
    subtitle: '14 Aprile 2026, ore 16:00 CEST',
    textColor: '#ffffff',
    mobile: 'https://store.bblcdn.eu/s8/default/5bfa336a05e340ff8d761ddd299f88c1/X2D-EN.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    desktop: 'https://store.bblcdn.eu/s8/default/f4b73400f4824c63a973f4a92db9903b/X2D-EN.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    buttons: [{ text: 'Scopri di più', href: 'https://bambulab.com/launch-0414', type: 'solid' }],
  },
  {
    eyebrow: 'Bambu Lab P2S',
    title: "L'Icona, Ridefinita.",
    subtitle: '',
    textColor: '#1a1a1a',
    mobile: 'https://store.bblcdn.eu/s8/default/14cc20d466044712a4b8d1600d342b97/H2D-MO-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    desktop: 'https://store.bblcdn.eu/s8/default/fe995023db7440f8963309dc1a32bc65/H2D-PC-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    buttons: [{ text: 'Acquista ora', href: '/it/products/p2s?from=home_page_3dprinter', type: 'solid' }],
  },
  {
    eyebrow: 'Bambu Lab H2C',
    title: 'Multi-Materiale senza compromessi.',
    subtitle: '',
    textColor: '#ffffff',
    mobile: 'https://store.bblcdn.eu/s8/default/1bd724a38cd7494fad1fc0e326b3c6a2/MO-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    desktop: 'https://store.bblcdn.eu/s8/default/629e8d63b2d44d9f8f7bbde5caa01e77/PC-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    buttons: [{ text: 'Acquista ora', href: '/it/products/h2c?from=home_page_3dprinter', type: 'solid' }],
  },
  {
    eyebrow: 'Bambu Lab A1',
    title: 'Stampante multicolore di dimensioni complete per principianti.',
    subtitle: '',
    textColor: '#000000',
    mobile: 'https://store.bblcdn.com/s4/default/8fe39d801afe4c7aaecd6eaf874b2f6a/MO_A1_(5).png__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    desktop: 'https://store.bblcdn.com/s4/default/8a3c3b6625774e3b90e55b5cd5563cd0/PC_A1_(8)_(1).png__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    buttons: [{ text: 'Acquista ora', href: '/it/products/A1', type: 'solid' }],
  },
  {
    eyebrow: 'Bambu Lab P1S',
    title: 'Chiusa per filamenti avanzati',
    subtitle: '',
    textColor: '#ffffff',
    mobile: 'https://store.bblcdn.eu/s8/default/fa908e7293f041b596775a98ce49c744/MO_P1S.png__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    desktop: 'https://store.bblcdn.eu/s8/default/df9a54f19e074fb9975af7786510c453/PC_P1S.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    buttons: [{ text: 'Acquista ora', href: '/it/products/P1S', type: 'solid' }],
  },
  {
    eyebrow: 'Bambu Lab H2S',
    title: 'Il Tuo Hub di Produzione Personale',
    subtitle: '',
    textColor: '#ffffff',
    mobile: 'https://store.bblcdn.eu/s8/default/4ad0494c9e1d43c7921a7f7efc8748ec/H2S_MO.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    desktop: 'https://store.bblcdn.eu/s8/default/dc3ac3f014994c52843ffea70644224f/H2S_PC.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    buttons: [{ text: 'Acquista ora', href: '/it/products/h2s?from=home_page_3dprinter', type: 'solid' }],
  },
  {
    eyebrow: '',
    title: "Maker's Supply",
    subtitle: 'Tutto ciò che serve per completare il tuo capolavoro, in un solo clic',
    textColor: '#ffffff',
    mobile: 'https://store.bblcdn.eu/s8/default/071c80f86500463f9bddcb62c4d572e1/MO_MW-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    desktop: 'https://store.bblcdn.eu/s8/default/6f26598f38d3475c87283c40c6fe2a52/PC_MW-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95',
    buttons: [
      { text: 'Per saperne di più', href: 'https://blog.bambulab.com/makers-supply-powering-up-your-3d-projects/', type: 'solid' },
      { text: 'Acquista ora', href: '/it/maker-supply', type: 'outline' },
    ],
  },
];

const heroElements = {
  root: document.querySelector('.carosel'),
  eyebrow: document.querySelector('.carosel-eyebrow'),
  title: document.querySelector('.carosel-title'),
  subtitle: document.querySelector('.carosel-subtitle'),
  buttonRow: document.querySelector('.carosel-button-row'),
  media: document.querySelector('#carosel-media'),
};

const featuredSlider = {
  track: document.querySelector('#featured-products-track'),
  slides: document.querySelectorAll('.featured-products-slide'),
  previousButton: document.querySelector('#featured-products-prev'),
  nextButton: document.querySelector('#featured-products-next'),
  gap: 16,
  index: 0,
};

let heroIndex = 0;

// Mostra o nasconde un elemento.
function setVisible(element, visible) {
  element?.classList.toggle('hidden', !visible);
}

// Crea il sottotitolo hero se manca.
function ensureHeroSubtitle() {
  if (heroElements.subtitle || !heroElements.title) return;

  heroElements.subtitle = document.createElement('div');
  heroElements.subtitle.className = 'carosel-subtitle';
  heroElements.title.parentNode.appendChild(heroElements.subtitle);
}

// Crea un'immagine del carosello hero.
function createHeroImage(className, alt) {
  const image = document.createElement('img');
  image.className = className;
  image.alt = alt;

  return image;
}

// Prepara le immagini mobile e desktop hero.
function setupHeroMedia() {
  if (!heroElements.root) return null;

  document.querySelector('.carosel-img-mobile')?.remove();
  document.querySelector('.carosel-img-desktop')?.remove();

  if (!heroElements.media) {
    heroElements.media = document.createElement('div');
    heroElements.media.className = 'carosel-media';
    heroElements.media.id = 'carosel-media';
    heroElements.root.appendChild(heroElements.media);
  }

  const mobileImage = createHeroImage('carosel-img carosel-img-mobile', 'Banner mobile');
  const desktopImage = createHeroImage('carosel-img carosel-img-desktop', 'Banner desktop');
  heroElements.media.append(mobileImage, desktopImage);

  return { mobileImage, desktopImage };
}

// Crea un pulsante del carosello hero.
function createHeroButton({ text, href, type }) {
  const isOutline = type === 'outline';
  const arrowColor = isOutline ? '#ffffff' : '#333333';

  const link = document.createElement('a');
  link.className = `carosel-button ${isOutline ? 'carosel-button--outline' : 'carosel-button--solid'}`;
  link.href = href;

  const label = document.createElement('span');
  label.textContent = text;

  const iconWrapper = document.createElement('div');
  iconWrapper.innerHTML = `<svg class="carosel-button-icon" xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none" aria-hidden="true"><g><path d="M1 4.5L4.8 8L1 11.5" stroke="${arrowColor}" stroke-linecap="round"/></g></svg>`;

  link.append(label, iconWrapper.firstElementChild);
  return link;
}

// Mostra la slide hero corrente.
function renderHeroSlide(heroImages) {
  const slide = HERO_SLIDES[heroIndex];

  if (!slide || !heroImages) return;

  heroImages.mobileImage.src = slide.mobile;
  heroImages.desktopImage.src = slide.desktop;
  heroImages.mobileImage.alt = slide.title;
  heroImages.desktopImage.alt = slide.title;

  heroElements.root?.classList.toggle('carosel--dark-text', slide.textColor !== '#ffffff');

  if (heroElements.eyebrow) {
    heroElements.eyebrow.textContent = slide.eyebrow;
    setVisible(heroElements.eyebrow, slide.eyebrow !== '');
  }

  if (heroElements.title) {
    heroElements.title.textContent = slide.title;
  }

  if (heroElements.subtitle) {
    heroElements.subtitle.textContent = slide.subtitle;
    setVisible(heroElements.subtitle, slide.subtitle !== '');
  }

  if (heroElements.buttonRow) {
    heroElements.buttonRow.innerHTML = '';
    slide.buttons.forEach((button) => heroElements.buttonRow.appendChild(createHeroButton(button)));
  }
}

// Avanza alla prossima slide hero.
function showNextHeroSlide(heroImages) {
  heroIndex = (heroIndex + 1) % HERO_SLIDES.length;
  renderHeroSlide(heroImages);
}

// Inizializza il carosello principale della homepage.
function initHeroCarousel() {
  ensureHeroSubtitle();
  const heroImages = setupHeroMedia();

  if (!heroImages) return;

  window.addEventListener('load', () => {
    renderHeroSlide(heroImages);
    setInterval(() => showNextHeroSlide(heroImages), 5000);
  });

  window.addEventListener('resize', () => renderHeroSlide(heroImages));
}

// Calcola l'indice massimo dello slider prodotti.
function getFeaturedMaxIndex() {
  return Math.max(0, featuredSlider.slides.length - 2);
}

// Aggiorna posizione dello slider prodotti.
function updateFeaturedSlider() {
  const firstSlide = featuredSlider.slides[0];

  if (!featuredSlider.track || !firstSlide) return;

  const slideWidth = firstSlide.offsetWidth;
  const maxIndex = getFeaturedMaxIndex();

  if (featuredSlider.index > maxIndex) featuredSlider.index = 0;
  if (featuredSlider.index < 0) featuredSlider.index = maxIndex;

  featuredSlider.track.style.transform = `translateX(-${featuredSlider.index * (slideWidth + featuredSlider.gap)}px)`;
}

// Avanza lo slider prodotti in evidenza.
function showNextFeaturedSlide() {
  const maxIndex = getFeaturedMaxIndex();
  featuredSlider.index = featuredSlider.index >= maxIndex ? 0 : featuredSlider.index + 1;
  updateFeaturedSlider();
}

// Inizializza lo slider dei prodotti in evidenza.
function initFeaturedProductsSlider() {
  featuredSlider.previousButton?.addEventListener('click', () => {
    featuredSlider.index -= 1;
    updateFeaturedSlider();
  });

  featuredSlider.nextButton?.addEventListener('click', () => {
    featuredSlider.index += 1;
    updateFeaturedSlider();
  });

  window.addEventListener('load', () => {
    updateFeaturedSlider();
    setInterval(showNextFeaturedSlide, 3000);
  });
}

initHeroCarousel();
initFeaturedProductsSlider();

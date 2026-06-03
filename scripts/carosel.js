// ─── Dati ───────────────────────────────────────────────────────────────────

const CAROSEL_SLIDES = [
  {
    eyebrow:   "",
    title:     "Eccellenza resa semplice.",
    subtitle:  "14 Aprile 2026, ore 16:00 CEST",
    textColor: "#ffffff",
    mobile:    "https://store.bblcdn.eu/s8/default/5bfa336a05e340ff8d761ddd299f88c1/X2D-EN.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    desktop:   "https://store.bblcdn.eu/s8/default/f4b73400f4824c63a973f4a92db9903b/X2D-EN.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    buttons:   [{ text: "Scopri di più", href: "https://bambulab.com/launch-0414", type: "solid" }]
  },
  {
    eyebrow:   "Bambu Lab P2S",
    title:     "L'Icona, Ridefinita.",
    subtitle:  "",
    textColor: "#1a1a1a",
    mobile:    "https://store.bblcdn.eu/s8/default/14cc20d466044712a4b8d1600d342b97/H2D-MO-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    desktop:   "https://store.bblcdn.eu/s8/default/fe995023db7440f8963309dc1a32bc65/H2D-PC-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    buttons:   [{ text: "Acquista ora", href: "/it/products/p2s?from=home_page_3dprinter", type: "solid" }]
  },
  {
    eyebrow:   "Bambu Lab H2C",
    title:     "Multi-Materiale senza compromessi.",
    subtitle:  "",
    textColor: "#ffffff",
    mobile:    "https://store.bblcdn.eu/s8/default/1bd724a38cd7494fad1fc0e326b3c6a2/MO-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    desktop:   "https://store.bblcdn.eu/s8/default/629e8d63b2d44d9f8f7bbde5caa01e77/PC-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    buttons:   [{ text: "Acquista ora", href: "/it/products/h2c?from=home_page_3dprinter", type: "solid" }]
  },
  {
    eyebrow:   "Bambu Lab A1",
    title:     "Stampante multicolore di dimensioni complete per principianti.",
    subtitle:  "",
    textColor: "#000000",
    mobile:    "https://store.bblcdn.com/s4/default/8fe39d801afe4c7aaecd6eaf874b2f6a/MO_A1_(5).png__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    desktop:   "https://store.bblcdn.com/s4/default/8a3c3b6625774e3b90e55b5cd5563cd0/PC_A1_(8)_(1).png__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    buttons:   [{ text: "Acquista ora", href: "/it/products/A1", type: "solid" }]
  },
  {
    eyebrow:   "Bambu Lab P1S",
    title:     "Chiusa per filamenti avanzati",
    subtitle:  "",
    textColor: "#ffffff",
    mobile:    "https://store.bblcdn.eu/s8/default/fa908e7293f041b596775a98ce49c744/MO_P1S.png__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    desktop:   "https://store.bblcdn.eu/s8/default/df9a54f19e074fb9975af7786510c453/PC_P1S.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    buttons:   [{ text: "Acquista ora", href: "/it/products/P1S", type: "solid" }]
  },
  {
    eyebrow:   "Bambu Lab H2S",
    title:     "Il Tuo Hub di Produzione Personale",
    subtitle:  "",
    textColor: "#ffffff",
    mobile:    "https://store.bblcdn.eu/s8/default/4ad0494c9e1d43c7921a7f7efc8748ec/H2S_MO.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    desktop:   "https://store.bblcdn.eu/s8/default/dc3ac3f014994c52843ffea70644224f/H2S_PC.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    buttons:   [{ text: "Acquista ora", href: "/it/products/h2s?from=home_page_3dprinter", type: "solid" }]
  },
  {
    eyebrow:   "",
    title:     "Maker's Supply",
    subtitle:  "Tutto ciò che serve per completare il tuo capolavoro, in un solo clic",
    textColor: "#ffffff",
    mobile:    "https://store.bblcdn.eu/s8/default/071c80f86500463f9bddcb62c4d572e1/MO_MW-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    desktop:   "https://store.bblcdn.eu/s8/default/6f26598f38d3475c87283c40c6fe2a52/PC_MW-tuya.jpg__op__resize,m_lfit,w_3840__op__format,f_auto__op__quality,q_95",
    buttons:   [
      { text: "Per saperne di più", href: "https://blog.bambulab.com/makers-supply-powering-up-your-3d-projects/", type: "solid" },
      { text: "Acquista ora",       href: "/it/maker-supply", type: "outline" }
    ]
  }
];

// ─── Setup DOM ──────────────────────────────────────────────────────────────

const carosel        = document.querySelector(".carosel");
const caroselEyebrow = document.querySelector(".carosel-eyebrow");
const caroselTitle   = document.querySelector(".carosel-title");
const caroselButtonRow = document.querySelector(".carosel-button-row");

let caroselSubtitle = document.querySelector(".carosel-subtitle");
if (!caroselSubtitle && caroselTitle) {
  caroselSubtitle = document.createElement("div");
  caroselSubtitle.className = "carosel-subtitle";
  caroselSubtitle.style.marginTop = "12px";
  caroselSubtitle.style.fontSize = "16px";
  caroselSubtitle.style.lineHeight = "1.4";
  caroselSubtitle.style.fontWeight = "400";

  caroselTitle.parentNode.appendChild(caroselSubtitle);
}

document.querySelector(".carosel-img-mobile")?.remove();
document.querySelector(".carosel-img-desktop")?.remove();

let caroselMedia = document.querySelector("#carosel-media");
if (!caroselMedia && carosel) {
  caroselMedia = document.createElement("div");
  caroselMedia.className = "carosel-media";
  caroselMedia.id = "carosel-media";
  carosel.appendChild(caroselMedia);
}

const caroselImgMobile  = document.createElement("img");
const caroselImgDesktop = document.createElement("img");
caroselImgMobile.className  = "carosel-img carosel-img-mobile";
caroselImgDesktop.className = "carosel-img carosel-img-desktop";
caroselImgMobile.alt  = "Banner mobile";
caroselImgDesktop.alt = "Banner desktop";
caroselMedia?.append(caroselImgMobile, caroselImgDesktop);

// ─── Logica carousel ────────────────────────────────────────────────────────

let caroselIndex = 0;

function setVisible(el, visible) {
  if (el) el.style.display = visible ? "block" : "none";
}

function creaBottone({ text, href, type }) {
  const isOutline  = type === "outline";
  const arrowColor = isOutline ? "#ffffff" : "#333333";

  const link = document.createElement("a");
  link.className = "carosel-button";
  link.href = href;
  if (isOutline) {
    link.style.backgroundColor = "transparent";
    link.style.borderColor = "#ffffff";
    link.style.color = "#ffffff";
  } else {
    link.style.backgroundColor = "#ffffff";
    link.style.borderColor = "transparent";
    link.style.color = "rgb(51, 51, 51)";
  }

  const span = document.createElement("span");
  span.textContent = text;

  const tmp = document.createElement("div");
  tmp.innerHTML = `<svg class="carosel-button-icon" xmlns="http://www.w3.org/2000/svg" width="6" height="16" viewBox="0 0 6 16" fill="none" aria-hidden="true"><g><path d="M1 4.5L4.8 8L1 11.5" stroke="${arrowColor}" stroke-linecap="round"/></g></svg>`;

  link.append(span, tmp.firstElementChild);
  return link;
}

function aggiornaCarosel() {
  const slide = CAROSEL_SLIDES[caroselIndex];
  if (!slide) return;

  caroselImgMobile.src  = slide.mobile;
  caroselImgDesktop.src = slide.desktop;
  caroselImgMobile.alt  = caroselImgDesktop.alt = slide.title;

  if (caroselEyebrow) {
    caroselEyebrow.textContent  = slide.eyebrow;
    caroselEyebrow.style.color  = slide.textColor;
    setVisible(caroselEyebrow, slide.eyebrow !== "");
  }

  if (caroselTitle) {
    caroselTitle.textContent = slide.title;
    caroselTitle.style.color = slide.textColor;
  }

  if (caroselSubtitle) {
    caroselSubtitle.textContent = slide.subtitle;
    caroselSubtitle.style.color = slide.textColor;
    setVisible(caroselSubtitle, slide.subtitle !== "");
  }

  if (caroselButtonRow) {
    caroselButtonRow.innerHTML = "";
    slide.buttons.forEach(btn => caroselButtonRow.appendChild(creaBottone(btn)));
    caroselButtonRow.style.justifyContent = window.innerWidth >= 1025 ? "flex-start" : "center";
  }
}

function slideSuccessiva() {
  caroselIndex = (caroselIndex + 1) % CAROSEL_SLIDES.length;
  aggiornaCarosel();
}

// ─── Event listeners ────────────────────────────────────────────────────────

window.addEventListener("load", () => {
  aggiornaCarosel();
  setInterval(slideSuccessiva, 4000);
});

window.addEventListener("resize", aggiornaCarosel);

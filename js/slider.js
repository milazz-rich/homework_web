// ─── DOM ────────────────────────────────────────────────────────────────────

const section2Track  = document.querySelector("#featured-products-track");
const section2Slides = document.querySelectorAll(".featured-products-slide");
const section2Prev   = document.querySelector("#featured-products-prev");
const section2Next   = document.querySelector("#featured-products-next");

// ─── Stato ──────────────────────────────────────────────────────────────────

const GAP = 16;
let section2Index = 0;

// ─── Logica slider ──────────────────────────────────────────────────────────

function updateSection2Slider() {
  if (!section2Track || !section2Slides[0]) return;

  const slideWidth = section2Slides[0].offsetWidth;
  const maxIndex   = Math.max(0, section2Slides.length - 2);

  if (section2Index > maxIndex) section2Index = 0;
  if (section2Index < 0) section2Index = maxIndex;
  section2Track.style.transform = `translateX(-${section2Index * (slideWidth + GAP)}px)`;
}

function advanceSection2Slider() {
  const maxIndex = Math.max(0, section2Slides.length - 2);
  section2Index = section2Index >= maxIndex ? 0 : section2Index + 1;
  updateSection2Slider();
}

// ─── Event listeners ────────────────────────────────────────────────────────

section2Prev?.addEventListener("click", () => { section2Index--; updateSection2Slider(); });
section2Next?.addEventListener("click", () => { section2Index++; updateSection2Slider(); });

window.addEventListener("load", () => {
  updateSection2Slider();
  setInterval(advanceSection2Slider, 3000);
});


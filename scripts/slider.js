// ─── DOM ────────────────────────────────────────────────────────────────────

const section2Track  = document.querySelector("#section2-track");
const section2Slides = document.querySelectorAll(".section2-slide");
const section2Prev   = document.querySelector("#section2-prev");
const section2Next   = document.querySelector("#section2-next");

// ─── Stato ──────────────────────────────────────────────────────────────────

const GAP = 16;
let section2Index = 0;

// ─── Logica slider ──────────────────────────────────────────────────────────

function updateSection2Slider() {
  if (!section2Track || !section2Slides[0]) return;

  const slideWidth = section2Slides[0].offsetWidth;
  const maxIndex   = Math.max(0, section2Slides.length - 2);

  section2Index = Math.max(0, Math.min(section2Index, maxIndex));
  section2Track.style.transform = `translateX(-${section2Index * (slideWidth + GAP)}px)`;

  if (section2Prev) section2Prev.disabled = section2Index === 0;
  if (section2Next) section2Next.disabled = section2Index === maxIndex;
}

// ─── Event listeners ────────────────────────────────────────────────────────

section2Prev?.addEventListener("click", () => { section2Index--; updateSection2Slider(); });
section2Next?.addEventListener("click", () => { section2Index++; updateSection2Slider(); });

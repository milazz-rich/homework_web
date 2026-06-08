const filamentSearchInput = document.querySelector('.catalog-search-input');
const filamentSearchWrap = document.querySelector('.catalog-search-wrap');
const filamentCards = Array.from(document.querySelectorAll('.catalog-card'));
const filamentSortButton = document.querySelector('.toolbar-sort-btn');
const filamentFilterLinks = Array.from(document.querySelectorAll('.filter-list a'));
const filamentViewButtons = Array.from(document.querySelectorAll('.toolbar-view-btn'));
const filamentGrid = document.querySelector('.catalog-grid');

let activeMaterialFilter = '';
let sortMode = 'default';
let viewMode = 'grid';

function extractMaterial(text) {
  const normalized = (text || '').toLowerCase();

  if (normalized.includes('pla')) return 'pla';
  if (normalized.includes('petg')) return 'petg';
  if (normalized.includes('abs') || normalized.includes('asa')) return 'abs-asa';
  if (normalized.includes('pc') || normalized.includes('tpu')) return 'pc-tpu';
  if (normalized.includes('pa') || normalized.includes('pet')) return 'pa-pet';
  if (normalized.includes('support')) return 'support';
  if (normalized.includes('fiber')) return 'fiber';

  return '';
}

function parsePrice(text) {
  const match = String(text || '').match(/([\d\.]+),?(\d{0,2})/);

  if (!match) return Number.POSITIVE_INFINITY;

  const whole = match[1].replace(/\./g, '');
  const decimals = (match[2] || '').padEnd(2, '0').slice(0, 2);
  return Number.parseFloat(`${whole}.${decimals}`);
}

function matchesFilters(card) {
  const query = (filamentSearchInput?.value || '').trim().toLowerCase();
  const name = card.querySelector('.catalog-card-name')?.textContent?.toLowerCase() || '';
  const subtitle = card.querySelector('.catalog-card-subtitle')?.textContent?.toLowerCase() || '';
  const price = card.querySelector('.catalog-card-price')?.textContent?.toLowerCase() || '';
  const material = extractMaterial(`${name} ${subtitle}`);

  const matchesQuery = query === '' || name.includes(query) || subtitle.includes(query) || price.includes(query);
  const matchesMaterial = activeMaterialFilter === '' || material === activeMaterialFilter;

  return matchesQuery && matchesMaterial;
}

function sortCards(cards) {
  const sorted = [...cards];

  if (sortMode === 'name-asc') {
    sorted.sort((a, b) => {
      const nameA = a.querySelector('.catalog-card-name')?.textContent || '';
      const nameB = b.querySelector('.catalog-card-name')?.textContent || '';
      return nameA.localeCompare(nameB, 'it', { sensitivity: 'base' });
    });
  }

  if (sortMode === 'price-asc') {
    sorted.sort((a, b) => parsePrice(a.querySelector('.catalog-card-price')?.textContent) - parsePrice(b.querySelector('.catalog-card-price')?.textContent));
  }

  if (sortMode === 'price-desc') {
    sorted.sort((a, b) => parsePrice(b.querySelector('.catalog-card-price')?.textContent) - parsePrice(a.querySelector('.catalog-card-price')?.textContent));
  }

  return sorted;
}

function applyViewMode() {
  if (!filamentGrid) return;

  filamentGrid.classList.toggle('catalog-grid--list', viewMode === 'list');
  filamentViewButtons.forEach((button) => {
    const mode = button.dataset.view;
    button.classList.toggle('active', mode === viewMode);
  });
}

function renderCards() {
  if (!filamentCards.length || !filamentGrid) return;

  const visibleCards = filamentCards.filter(matchesFilters);
  const sortedVisibleCards = sortCards(visibleCards);

  filamentCards.forEach((card) => {
    card.style.display = 'none';
  });

  sortedVisibleCards.forEach((card) => {
    card.style.display = '';
    filamentGrid.appendChild(card);
  });

  applyViewMode();
}

function updateSortLabel() {
  if (!filamentSortButton) return;

  const labels = {
    default: 'Ordina',
    'price-asc': 'Prezzo crescente',
    'price-desc': 'Prezzo decrescente',
    'name-asc': 'Nome A-Z',
  };

  const label = filamentSortButton.querySelector('span');
  if (label) label.textContent = labels[sortMode] || 'Ordina';
}

function clearFilters() {
  if (filamentSearchInput) filamentSearchInput.value = '';
  activeMaterialFilter = '';
  sortMode = 'default';

  filamentFilterLinks.forEach((link) => link.classList.remove('is-active'));
  updateSortLabel();
  renderCards();
}

if (filamentSearchInput && filamentSearchWrap) {
  const clearButton = document.createElement('button');
  clearButton.type = 'button';
  clearButton.textContent = 'X';
  clearButton.setAttribute('aria-label', 'Reset filtri');
  clearButton.style.border = '0';
  clearButton.style.background = 'transparent';
  clearButton.style.cursor = 'pointer';
  clearButton.style.fontWeight = '700';
  clearButton.style.width = '28px';
  clearButton.style.height = '28px';
  clearButton.style.borderRadius = '50%';
  clearButton.style.color = '#333';
  clearButton.style.position = 'absolute';
  clearButton.style.right = '42px';
  clearButton.style.top = '50%';
  clearButton.style.transform = 'translateY(-50%)';
  clearButton.style.flex = '0 0 auto';

  clearButton.addEventListener('click', clearFilters);
  filamentSearchWrap.appendChild(clearButton);

  filamentSearchInput.addEventListener('input', renderCards);
  filamentSearchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      clearFilters();
    }
  });
}

filamentFilterLinks.forEach((link) => {
  link.addEventListener('click', (event) => {
    event.preventDefault();

    const label = (link.textContent || '').trim().toLowerCase();
    const nextMaterial = label.includes('pla') ? 'pla'
      : label.includes('petg') ? 'petg'
        : label.includes('abs') || label.includes('asa') ? 'abs-asa'
          : label.includes('pc') || label.includes('tpu') ? 'pc-tpu'
            : label.includes('pa') || label.includes('pet') ? 'pa-pet'
              : label.includes('fiber') ? 'fiber'
                : label.includes('support') ? 'support'
                  : '';

    activeMaterialFilter = activeMaterialFilter === nextMaterial ? '' : nextMaterial;

    filamentFilterLinks.forEach((item) => item.classList.remove('is-active'));
    if (activeMaterialFilter) link.classList.add('is-active');

    renderCards();
  });
});

if (filamentSortButton) {
  filamentSortButton.addEventListener('click', () => {
    sortMode = sortMode === 'default'
      ? 'price-asc'
      : sortMode === 'price-asc'
        ? 'price-desc'
        : sortMode === 'price-desc'
          ? 'name-asc'
          : 'default';

    updateSortLabel();
    renderCards();
  });
}

filamentViewButtons.forEach((button) => {
  button.addEventListener('click', () => {
    viewMode = button.dataset.view === 'list' ? 'list' : 'grid';
    renderCards();
  });
});

updateSortLabel();
renderCards();

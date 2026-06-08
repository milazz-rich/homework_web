const makerSearchInput = document.querySelector('.catalog-search-input');
const makerSearchWrap = document.querySelector('.catalog-search-wrap');
const makerCards = Array.from(document.querySelectorAll('.catalog-card'));
const makerSortButton = document.querySelector('.toolbar-sort-btn');
const makerFilterLinks = Array.from(document.querySelectorAll('.filter-list a'));
const makerViewButtons = Array.from(document.querySelectorAll('.toolbar-view-btn'));
const makerGrid = document.querySelector('.catalog-grid');

let activeCategoryFilter = '';
let sortMode = 'default';
let viewMode = 'grid';

function extractCategory(text) {
  const normalized = (text || '').toLowerCase();

  if (normalized.includes('makerlab')) return 'makerlab';
  if (normalized.includes('modelli')) return 'modelli';
  if (normalized.includes('combo')) return 'combo';
  if (normalized.includes('hardware')) return 'hardware';
  if (normalized.includes('elettronica')) return 'elettronica';
  if (normalized.includes('strumenti')) return 'strumenti';

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
  const query = (makerSearchInput?.value || '').trim().toLowerCase();
  const name = card.querySelector('.catalog-card-name')?.textContent?.toLowerCase() || '';
  const subtitle = card.querySelector('.catalog-card-subtitle')?.textContent?.toLowerCase() || '';
  const price = card.querySelector('.catalog-card-price')?.textContent?.toLowerCase() || '';
  const category = extractCategory(`${name} ${subtitle}`);

  const matchesQuery = query === '' || name.includes(query) || subtitle.includes(query) || price.includes(query);
  const matchesCategory = activeCategoryFilter === '' || category === activeCategoryFilter;

  return matchesQuery && matchesCategory;
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
  if (!makerGrid) return;

  makerGrid.classList.toggle('catalog-grid--list', viewMode === 'list');
  makerViewButtons.forEach((button) => {
    const mode = button.dataset.view;
    button.classList.toggle('active', mode === viewMode);
  });
}

function renderCards() {
  if (!makerCards.length || !makerGrid) return;

  const visibleCards = makerCards.filter(matchesFilters);
  const sortedVisibleCards = sortCards(visibleCards);

  makerCards.forEach((card) => {
    card.style.display = 'none';
  });

  sortedVisibleCards.forEach((card) => {
    card.style.display = '';
    makerGrid.appendChild(card);
  });

  applyViewMode();
}

function updateSortLabel() {
  if (!makerSortButton) return;

  const labels = {
    default: 'Ordina',
    'price-asc': 'Prezzo crescente',
    'price-desc': 'Prezzo decrescente',
    'name-asc': 'Nome A-Z',
  };

  const label = makerSortButton.querySelector('span');
  if (label) label.textContent = labels[sortMode] || 'Ordina';
}

function clearFilters() {
  if (makerSearchInput) makerSearchInput.value = '';
  activeCategoryFilter = '';
  sortMode = 'default';

  makerFilterLinks.forEach((link) => link.classList.remove('is-active'));
  updateSortLabel();
  renderCards();
}

if (makerSearchInput && makerSearchWrap) {
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
  makerSearchWrap.appendChild(clearButton);

  makerSearchInput.addEventListener('input', renderCards);
  makerSearchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      clearFilters();
    }
  });
}

makerFilterLinks.forEach((link) => {
  link.addEventListener('click', (event) => {
    event.preventDefault();

    const label = (link.textContent || '').trim().toLowerCase();
    const nextCategory = label.includes('makerlab') ? 'makerlab'
      : label.includes('modelli') ? 'modelli'
        : label.includes('combo') ? 'combo'
          : label.includes('hardware') ? 'hardware'
            : label.includes('elettronica') ? 'elettronica'
              : label.includes('strumenti') ? 'strumenti'
                : '';

    activeCategoryFilter = activeCategoryFilter === nextCategory ? '' : nextCategory;

    makerFilterLinks.forEach((item) => item.classList.remove('is-active'));
    if (activeCategoryFilter) link.classList.add('is-active');

    renderCards();
  });
});

if (makerSortButton) {
  makerSortButton.addEventListener('click', () => {
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

makerViewButtons.forEach((button) => {
  button.addEventListener('click', () => {
    viewMode = button.dataset.view === 'list' ? 'list' : 'grid';
    renderCards();
  });
});

updateSortLabel();
renderCards();

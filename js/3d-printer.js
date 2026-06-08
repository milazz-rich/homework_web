const printerSearchInput = document.querySelector('.catalog-search-input');
const printerSearchWrap = document.querySelector('.catalog-search-wrap');
const printerCards = Array.from(document.querySelectorAll('.catalog-card'));
const sortButton = document.querySelector('.toolbar-sort-btn');
const filterLinks = Array.from(document.querySelectorAll('.filter-list a'));
const viewButtons = Array.from(document.querySelectorAll('.toolbar-view-btn'));
const catalogGrid = document.querySelector('.catalog-grid');

let activeSeriesFilter = '';
let sortMode = 'default';
let viewMode = 'grid';

function extractSeries(name) {
  const normalized = (name || '').toLowerCase();

  if (normalized.includes('h2')) return 'h';
  if (normalized.includes('p2') || normalized.includes('p1')) return 'p';
  if (normalized.includes('a1') || normalized.includes('a2')) return 'a';
  if (normalized.includes('x2')) return 'x';

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
  const query = (printerSearchInput?.value || '').trim().toLowerCase();
  const name = card.querySelector('.catalog-card-name')?.textContent?.toLowerCase() || '';
  const price = card.querySelector('.catalog-card-price')?.textContent?.toLowerCase() || '';
  const series = extractSeries(name);

  const matchesQuery = query === '' || name.includes(query) || price.includes(query);
  const matchesSeries = activeSeriesFilter === '' || series === activeSeriesFilter;

  return matchesQuery && matchesSeries;
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
  if (!catalogGrid) return;

  catalogGrid.classList.toggle('catalog-grid--list', viewMode === 'list');
  viewButtons.forEach((button) => {
    const mode = button.dataset.view;
    button.classList.toggle('active', mode === viewMode);
  });
}

function renderCards() {
  if (!printerCards.length || !catalogGrid) return;

  const visibleCards = printerCards.filter(matchesFilters);
  const sortedVisibleCards = sortCards(visibleCards);

  printerCards.forEach((card) => {
    card.style.display = 'none';
  });

  sortedVisibleCards.forEach((card) => {
    card.style.display = '';
    catalogGrid.appendChild(card);
  });

  applyViewMode();
}

function updateSortLabel() {
  if (!sortButton) return;

  const labels = {
    default: 'Ordina',
    'price-asc': 'Prezzo crescente',
    'price-desc': 'Prezzo decrescente',
    'name-asc': 'Nome A-Z',
  };

  const label = sortButton.querySelector('span');
  if (label) label.textContent = labels[sortMode] || 'Ordina';
}

function clearFilters() {
  if (printerSearchInput) printerSearchInput.value = '';
  activeSeriesFilter = '';
  sortMode = 'default';

  filterLinks.forEach((link) => link.classList.remove('is-active'));
  updateSortLabel();
  renderCards();
}

if (printerSearchInput && printerSearchWrap) {
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
  printerSearchWrap.appendChild(clearButton);

  printerSearchInput.addEventListener('input', renderCards);
  printerSearchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      clearFilters();
    }
  });
}

filterLinks.forEach((link) => {
  link.addEventListener('click', (event) => {
    event.preventDefault();

    const label = (link.textContent || '').trim().toLowerCase();
    const nextSeries = label.includes('serie h') ? 'h'
      : label.includes('serie x') ? 'x'
        : label.includes('serie p') ? 'p'
          : label.includes('serie a') ? 'a'
            : '';

    activeSeriesFilter = activeSeriesFilter === nextSeries ? '' : nextSeries;

    filterLinks.forEach((item) => item.classList.remove('is-active'));
    if (activeSeriesFilter) link.classList.add('is-active');

    renderCards();
  });
});

if (sortButton) {
  sortButton.addEventListener('click', () => {
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

viewButtons.forEach((button) => {
  button.addEventListener('click', () => {
    viewMode = button.dataset.view === 'list' ? 'list' : 'grid';
    renderCards();
  });
});

updateSortLabel();
renderCards();

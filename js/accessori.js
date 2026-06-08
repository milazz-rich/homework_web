const accessorySearchInput = document.querySelector('.catalog-search-input');
const accessorySearchWrap = document.querySelector('.catalog-search-wrap');
const accessoryCards = Array.from(document.querySelectorAll('.catalog-card'));
const accessorySortButton = document.querySelector('.toolbar-sort-btn');
const accessoryFilterLinks = Array.from(document.querySelectorAll('.filter-list a'));
const accessoryViewButtons = Array.from(document.querySelectorAll('.toolbar-view-btn'));
const accessoryGrid = document.querySelector('.catalog-grid');

let activeCategoryFilter = '';
let sortMode = 'default';
let viewMode = 'grid';

function extractCategory(text) {
  const normalized = (text || '').toLowerCase();

  if (normalized.includes('plate')) return 'piastre';
  if (normalized.includes('encoder')) return 'encoder';
  if (normalized.includes('purifier')) return 'purificatore';
  if (normalized.includes('laser')) return 'laser';
  if (normalized.includes('cutting')) return 'taglio';

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
  const query = (accessorySearchInput?.value || '').trim().toLowerCase();
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
  if (!accessoryGrid) return;

  accessoryGrid.classList.toggle('catalog-grid--list', viewMode === 'list');
  accessoryViewButtons.forEach((button) => {
    const mode = button.dataset.view;
    button.classList.toggle('active', mode === viewMode);
  });
}

function renderCards() {
  if (!accessoryCards.length || !accessoryGrid) return;

  const visibleCards = accessoryCards.filter(matchesFilters);
  const sortedVisibleCards = sortCards(visibleCards);

  accessoryCards.forEach((card) => {
    card.style.display = 'none';
  });

  sortedVisibleCards.forEach((card) => {
    card.style.display = '';
    accessoryGrid.appendChild(card);
  });

  applyViewMode();
}

function updateSortLabel() {
  if (!accessorySortButton) return;

  const labels = {
    default: 'Ordina',
    'price-asc': 'Prezzo crescente',
    'price-desc': 'Prezzo decrescente',
    'name-asc': 'Nome A-Z',
  };

  const label = accessorySortButton.querySelector('span');
  if (label) label.textContent = labels[sortMode] || 'Ordina';
}

function clearFilters() {
  if (accessorySearchInput) accessorySearchInput.value = '';
  activeCategoryFilter = '';
  sortMode = 'default';

  accessoryFilterLinks.forEach((link) => link.classList.remove('is-active'));
  updateSortLabel();
  renderCards();
}

if (accessorySearchInput && accessorySearchWrap) {
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
  accessorySearchWrap.appendChild(clearButton);

  accessorySearchInput.addEventListener('input', renderCards);
  accessorySearchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      clearFilters();
    }
  });
}

accessoryFilterLinks.forEach((link) => {
  link.addEventListener('click', (event) => {
    event.preventDefault();

    const label = (link.textContent || '').trim().toLowerCase();
    const nextCategory = label.includes('piastre') ? 'piastre'
      : label.includes('encoder') ? 'encoder'
        : label.includes('purificatore') ? 'purificatore'
          : label.includes('laser') ? 'laser'
            : label.includes('taglio') ? 'taglio'
              : '';

    activeCategoryFilter = activeCategoryFilter === nextCategory ? '' : nextCategory;

    accessoryFilterLinks.forEach((item) => item.classList.remove('is-active'));
    if (activeCategoryFilter) link.classList.add('is-active');

    renderCards();
  });
});

if (accessorySortButton) {
  accessorySortButton.addEventListener('click', () => {
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

accessoryViewButtons.forEach((button) => {
  button.addEventListener('click', () => {
    viewMode = button.dataset.view === 'list' ? 'list' : 'grid';
    renderCards();
  });
});

updateSortLabel();
renderCards();

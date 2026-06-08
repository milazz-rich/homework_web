const saldiSearchInput = document.querySelector('.catalog-search-input');
const saldiSearchWrap = document.querySelector('.catalog-search-wrap');
const saldiCards = Array.from(document.querySelectorAll('.catalog-card'));
const saldiSortButton = document.querySelector('.toolbar-sort-btn');
const saldiFilterLinks = Array.from(document.querySelectorAll('.filter-list a'));
const saldiViewButtons = Array.from(document.querySelectorAll('.toolbar-view-btn'));
const saldiGrid = document.querySelector('.catalog-grid');

let activeTypeFilter = '';
let sortMode = 'default';
let viewMode = 'grid';

function extractType(text) {
  const normalized = (text || '').toLowerCase();

  if (normalized.includes('stampanti')) return 'stampanti';
  if (normalized.includes('filamenti')) return 'filamenti';
  if (normalized.includes('accessori')) return 'accessori';
  if (normalized.includes('maker')) return 'makersupply';
  if (normalized.includes('material')) return 'materiali';
  if (normalized.includes('ams')) return 'ams';

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
  const query = (saldiSearchInput?.value || '').trim().toLowerCase();
  const name = card.querySelector('.catalog-card-name')?.textContent?.toLowerCase() || '';
  const subtitle = card.querySelector('.catalog-card-subtitle')?.textContent?.toLowerCase() || '';
  const price = card.querySelector('.catalog-card-price')?.textContent?.toLowerCase() || '';
  const type = extractType(`${name} ${subtitle}`);

  const matchesQuery = query === '' || name.includes(query) || subtitle.includes(query) || price.includes(query);
  const matchesType = activeTypeFilter === '' || type === activeTypeFilter;

  return matchesQuery && matchesType;
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
  if (!saldiGrid) return;

  saldiGrid.classList.toggle('catalog-grid--list', viewMode === 'list');
  saldiViewButtons.forEach((button) => {
    const mode = button.dataset.view;
    button.classList.toggle('active', mode === viewMode);
  });
}

function renderCards() {
  if (!saldiCards.length || !saldiGrid) return;

  const visibleCards = saldiCards.filter(matchesFilters);
  const sortedVisibleCards = sortCards(visibleCards);

  saldiCards.forEach((card) => {
    card.style.display = 'none';
  });

  sortedVisibleCards.forEach((card) => {
    card.style.display = '';
    saldiGrid.appendChild(card);
  });

  applyViewMode();
}

function updateSortLabel() {
  if (!saldiSortButton) return;

  const labels = {
    default: 'Ordina',
    'price-asc': 'Prezzo crescente',
    'price-desc': 'Prezzo decrescente',
    'name-asc': 'Nome A-Z',
  };

  const label = saldiSortButton.querySelector('span');
  if (label) label.textContent = labels[sortMode] || 'Ordina';
}

function clearFilters() {
  if (saldiSearchInput) saldiSearchInput.value = '';
  activeTypeFilter = '';
  sortMode = 'default';

  saldiFilterLinks.forEach((link) => link.classList.remove('is-active'));
  updateSortLabel();
  renderCards();
}

if (saldiSearchInput && saldiSearchWrap) {
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
  saldiSearchWrap.appendChild(clearButton);

  saldiSearchInput.addEventListener('input', renderCards);
  saldiSearchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      clearFilters();
    }
  });
}

saldiFilterLinks.forEach((link) => {
  link.addEventListener('click', (event) => {
    event.preventDefault();

    const label = (link.textContent || '').trim().toLowerCase();
    const nextType = label.includes('stampanti') ? 'stampanti'
      : label.includes('filamenti') ? 'filamenti'
        : label.includes('accessori') ? 'accessori'
          : label.includes('maker') ? 'makersupply'
            : label.includes('material') ? 'materiali'
              : label.includes('ams') ? 'ams'
                : '';

    activeTypeFilter = activeTypeFilter === nextType ? '' : nextType;

    saldiFilterLinks.forEach((item) => item.classList.remove('is-active'));
    if (activeTypeFilter) link.classList.add('is-active');

    renderCards();
  });
});

if (saldiSortButton) {
  saldiSortButton.addEventListener('click', () => {
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

saldiViewButtons.forEach((button) => {
  button.addEventListener('click', () => {
    viewMode = button.dataset.view === 'list' ? 'list' : 'grid';
    renderCards();
  });
});

updateSortLabel();
renderCards();

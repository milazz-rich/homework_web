function initCatalogPage(options) {
  const searchInput = document.querySelector('.catalog-search-input');
  const searchWrap = document.querySelector('.catalog-search-wrap');
  const cards = Array.from(document.querySelectorAll('.catalog-card'));
  const sortButton = document.querySelector('.toolbar-sort-btn');
  const filterLinks = Array.from(document.querySelectorAll('.filter-list a'));
  const viewButtons = Array.from(document.querySelectorAll('.toolbar-view-btn'));
  const grid = document.querySelector('.catalog-grid');
  const textFilters = options.textFilters || {};
  const labelFilters = options.labelFilters || {};
  const getFilterFromText = options.getFilterFromText || ((text) => getCatalogFilterFromMap(text, textFilters));
  const getFilterFromLabel = options.getFilterFromLabel || ((label) => getCatalogFilterFromMap(label, labelFilters));

  let activeFilter = '';
  let sortMode = 'default';
  let viewMode = 'grid';

  function parsePrice(text) {
    const match = String(text || '').match(/([\d\.]+),?(\d{0,2})/);

    if (!match) return Number.POSITIVE_INFINITY;

    const whole = match[1].replace(/\./g, '');
    const decimals = (match[2] || '').padEnd(2, '0').slice(0, 2);
    return Number.parseFloat(`${whole}.${decimals}`);
  }

  function getCardText(card) {
    const name = card.querySelector('.catalog-card-name')?.textContent?.toLowerCase() || '';
    const subtitle = card.querySelector('.catalog-card-subtitle')?.textContent?.toLowerCase() || '';
    const price = card.querySelector('.catalog-card-price')?.textContent?.toLowerCase() || '';

    return { name, subtitle, price, all: `${name} ${subtitle}` };
  }

  function matchesFilters(card) {
    const query = (searchInput?.value || '').trim().toLowerCase();
    const text = getCardText(card);
    const cardFilter = getFilterFromText(text.all);
    const matchesQuery = query === '' || text.name.includes(query) || text.subtitle.includes(query) || text.price.includes(query);
    const matchesActiveFilter = activeFilter === '' || cardFilter === activeFilter;

    return matchesQuery && matchesActiveFilter;
  }

  function sortCards(items) {
    const sorted = [...items];

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
    if (!grid) return;

    grid.classList.toggle('catalog-grid--list', viewMode === 'list');
    viewButtons.forEach((button) => {
      const mode = button.dataset.view;
      button.classList.toggle('active', mode === viewMode);
    });
  }

  function renderCards() {
    if (!cards.length || !grid) return;

    const visibleCards = sortCards(cards.filter(matchesFilters));

    cards.forEach((card) => {
      card.classList.add('hidden');
    });

    visibleCards.forEach((card) => {
      card.classList.remove('hidden');
      grid.appendChild(card);
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
    if (searchInput) searchInput.value = '';
    activeFilter = '';
    sortMode = 'default';

    filterLinks.forEach((link) => link.classList.remove('is-active'));
    updateSortLabel();
    renderCards();
  }

  function addClearButton() {
    if (!searchInput || !searchWrap) return;

    const clearButton = document.createElement('button');
    clearButton.type = 'button';
    clearButton.textContent = 'X';
    clearButton.className = 'catalog-clear-btn';
    clearButton.setAttribute('aria-label', 'Reset filtri');

    clearButton.addEventListener('click', clearFilters);
    searchWrap.appendChild(clearButton);

    searchInput.addEventListener('input', renderCards);
    searchInput.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        clearFilters();
      }
    });
  }

  filterLinks.forEach((link) => {
    link.addEventListener('click', (event) => {
      event.preventDefault();

      const label = (link.textContent || '').trim().toLowerCase();
      const nextFilter = getFilterFromLabel(label);
      activeFilter = activeFilter === nextFilter ? '' : nextFilter;

      filterLinks.forEach((item) => item.classList.remove('is-active'));
      if (activeFilter) link.classList.add('is-active');

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

  addClearButton();
  updateSortLabel();
  renderCards();
}

function getCatalogFilterFromMap(text, filterMap) {
  const normalized = (text || '').toLowerCase();

  for (const filterName in filterMap) {
    const keywords = filterMap[filterName];

    if (keywords.some((keyword) => normalized.includes(keyword))) {
      return filterName;
    }
  }

  return '';
}

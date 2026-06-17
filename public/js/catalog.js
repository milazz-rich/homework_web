// Funzioni comuni dei cataloghi: ricerca, filtri, ordinamento e vista griglia/lista.

let catalogSearchInput = null;
let catalogGrid = null;
let catalogCards = [];
let catalogFilterLinks = [];
let catalogViewButtons = [];
let catalogSortButton = null;
let catalogActiveFilter = '';
let catalogSortMode = 'default';
let catalogViewMode = 'grid';
let catalogTextFilters = {};
let catalogLabelFilters = {};

// Converte il prezzo testuale in numero.
function parseCatalogPrice(text) {
  const match = String(text || '').match(/([\d\.]+),?(\d{0,2})/);

  if (!match) return Number.POSITIVE_INFINITY;

  const whole = match[1].replace(/\./g, '');
  const decimals = (match[2] || '').padEnd(2, '0').slice(0, 2);
  return Number.parseFloat(whole + '.' + decimals);
}

// Legge i testi principali di una card.
function getCatalogCardText(card) {
  const name = card.querySelector('.catalog-card-name');
  const subtitle = card.querySelector('.catalog-card-subtitle');
  const price = card.querySelector('.catalog-card-price');
  const text = {
    name: name ? name.textContent.toLowerCase() : '',
    subtitle: subtitle ? subtitle.textContent.toLowerCase() : '',
    price: price ? price.textContent.toLowerCase() : '',
  };

  text.all = text.name + ' ' + text.subtitle;
  return text;
}

// Trova il filtro associato a un testo.
function getCatalogFilterFromMap(text, filterMap) {
  const normalized = String(text || '').toLowerCase();

  for (const filterName in filterMap) {
    const keywords = filterMap[filterName];

    for (const keyword of keywords) {
      if (normalized.includes(keyword)) {
        return filterName;
      }
    }
  }

  return '';
}

// Verifica se una card rispetta ricerca e filtro.
function cardMatchesCatalogFilters(card) {
  const query = catalogSearchInput ? catalogSearchInput.value.trim().toLowerCase() : '';
  const text = getCatalogCardText(card);
  const cardFilter = card.dataset.filter || getCatalogFilterFromMap(text.all, catalogTextFilters);
  const matchesQuery = query === ''
    || text.name.includes(query)
    || text.subtitle.includes(query)
    || text.price.includes(query);
  const matchesFilter = catalogActiveFilter === '' || cardFilter === catalogActiveFilter;

  return matchesQuery && matchesFilter;
}

// Ordina le card secondo la modalita selezionata.
function sortCatalogCards(cards) {
  const sorted = [];

  for (const card of cards) {
    sorted.push(card);
  }

  if (catalogSortMode === 'name-asc') {
    sorted.sort(function (a, b) {
      const nameA = a.querySelector('.catalog-card-name');
      const nameB = b.querySelector('.catalog-card-name');
      return (nameA ? nameA.textContent : '').localeCompare(nameB ? nameB.textContent : '', 'it', { sensitivity: 'base' });
    });
  }

  if (catalogSortMode === 'price-asc') {
    sorted.sort(function (a, b) {
      return parseCatalogPrice(a.querySelector('.catalog-card-price')?.textContent) - parseCatalogPrice(b.querySelector('.catalog-card-price')?.textContent);
    });
  }

  if (catalogSortMode === 'price-desc') {
    sorted.sort(function (a, b) {
      return parseCatalogPrice(b.querySelector('.catalog-card-price')?.textContent) - parseCatalogPrice(a.querySelector('.catalog-card-price')?.textContent);
    });
  }

  return sorted;
}

// Applica la vista griglia o lista.
function applyCatalogViewMode() {
  if (!catalogGrid) return;

  catalogGrid.classList.toggle('catalog-grid--list', catalogViewMode === 'list');

  for (const button of catalogViewButtons) {
    button.classList.toggle('active', button.dataset.view === catalogViewMode);
  }
}

// Ridisegna le card filtrate e ordinate.
function renderCatalogCards() {
  if (!catalogGrid) return;

  const visibleCards = [];

  for (const card of catalogCards) {
    card.classList.add('hidden');

    if (cardMatchesCatalogFilters(card)) {
      visibleCards.push(card);
    }
  }

  for (const card of sortCatalogCards(visibleCards)) {
    card.classList.remove('hidden');
    catalogGrid.appendChild(card);
  }

  applyCatalogViewMode();
}

// Aggiorna l'etichetta del pulsante ordine.
function updateCatalogSortLabel() {
  const label = catalogSortButton ? catalogSortButton.querySelector('span') : null;

  if (!label) return;

  const labels = {
    default: 'Ordina',
    'price-asc': 'Prezzo crescente',
    'price-desc': 'Prezzo decrescente',
    'name-asc': 'Nome A-Z',
  };

  label.textContent = labels[catalogSortMode] || labels.default;
}

// Resetta ricerca, filtri e ordinamento.
function clearCatalogFilters() {
  if (catalogSearchInput) catalogSearchInput.value = '';

  catalogActiveFilter = '';
  catalogSortMode = 'default';

  for (const link of catalogFilterLinks) {
    link.classList.remove('is-active');
  }

  updateCatalogSortLabel();
  renderCatalogCards();
}

// Gestisce il click sui filtri laterali.
function onCatalogFilterClick(event) {
  event.preventDefault();

  const link = event.currentTarget;
  const label = link.textContent.trim().toLowerCase();
  const nextFilter = getCatalogFilterFromMap(label, catalogLabelFilters);

  catalogActiveFilter = catalogActiveFilter === nextFilter ? '' : nextFilter;

  for (const item of catalogFilterLinks) {
    item.classList.remove('is-active');
  }

  if (catalogActiveFilter) {
    link.classList.add('is-active');
  }

  renderCatalogCards();
}

// Cambia il criterio di ordinamento.
function onCatalogSortClick() {
  if (catalogSortMode === 'default') catalogSortMode = 'price-asc';
  else if (catalogSortMode === 'price-asc') catalogSortMode = 'price-desc';
  else if (catalogSortMode === 'price-desc') catalogSortMode = 'name-asc';
  else catalogSortMode = 'default';

  updateCatalogSortLabel();
  renderCatalogCards();
}

// Cambia la visualizzazione del catalogo.
function onCatalogViewClick(event) {
  const button = event.currentTarget;
  catalogViewMode = button.dataset.view === 'list' ? 'list' : 'grid';
  renderCatalogCards();
}

// Gestisce Escape nel campo ricerca.
function onCatalogSearchKeydown(event) {
  if (event.key === 'Escape') {
    clearCatalogFilters();
  }
}

// Aggiunge il pulsante per azzerare i filtri.
function addCatalogClearButton() {
  const searchWrap = document.querySelector('.catalog-search-wrap');

  if (!catalogSearchInput || !searchWrap || searchWrap.querySelector('.catalog-clear-btn')) return;

  const clearButton = document.createElement('button');
  clearButton.type = 'button';
  clearButton.textContent = 'X';
  clearButton.className = 'catalog-clear-btn';
  clearButton.setAttribute('aria-label', 'Reset filtri');
  clearButton.addEventListener('click', clearCatalogFilters);
  searchWrap.appendChild(clearButton);
}

// Inizializza una pagina catalogo.
function initCatalogPage(options = {}) {
  catalogSearchInput = document.querySelector('.catalog-search-input');
  catalogGrid = document.querySelector('.catalog-grid');
  catalogCards = document.querySelectorAll('.catalog-card');
  catalogFilterLinks = document.querySelectorAll('.filter-list a');
  catalogViewButtons = document.querySelectorAll('.toolbar-view-btn');
  catalogSortButton = document.querySelector('.toolbar-sort-btn');
  catalogTextFilters = options.textFilters || {};
  catalogLabelFilters = options.labelFilters || {};

  addCatalogClearButton();

  if (catalogSearchInput) {
    catalogSearchInput.addEventListener('input', renderCatalogCards);
    catalogSearchInput.addEventListener('keydown', onCatalogSearchKeydown);
  }

  for (const link of catalogFilterLinks) {
    link.addEventListener('click', onCatalogFilterClick);
  }

  for (const button of catalogViewButtons) {
    button.addEventListener('click', onCatalogViewClick);
  }

  if (catalogSortButton) {
    catalogSortButton.addEventListener('click', onCatalogSortClick);
  }

  updateCatalogSortLabel();
  renderCatalogCards();
}

// Gestione header globale: dropdown, badge carrello e ricerca prodotti.

const DROPDOWN_CONFIG = {
  saldi: { trigger: '[data-dropdown-trigger="saldi"]', container: '[data-dropdown-menu="saldi"]', mode: 'full' },
  stampanti: { trigger: '[data-dropdown-trigger="stampanti"]', container: '[data-dropdown-menu="stampanti"]', mode: 'full' },
  ams: { trigger: '[data-dropdown-trigger="ams"]', container: '[data-dropdown-menu="ams"]', mode: 'full' },
  filamenti: { trigger: '[data-dropdown-trigger="filamenti"]', container: '[data-dropdown-menu="filamenti"]', mode: 'full' },
  accessori: { trigger: '[data-dropdown-trigger="accessori"]', container: '[data-dropdown-menu="accessori"]', mode: 'full' },
  materiali: { trigger: '[data-dropdown-trigger="materiali"]', container: '[data-dropdown-menu="materiali"]', mode: 'full' },
  makersupply: { trigger: '[data-dropdown-trigger="makersupply"]', container: '[data-dropdown-menu="makersupply"]', mode: 'full' },
  supporto: { trigger: '[data-dropdown-trigger="supporto"]', container: '[data-dropdown-menu="supporto"]', mode: 'simple' },
  user: { trigger: '[data-dropdown-trigger="user"]', container: '[data-dropdown-menu="user"]', mode: 'simple' },
};

const headerElements = {
  cartBadges: Array.from(document.querySelectorAll('.cart-badge')),
  searchModal: document.querySelector('#search-modal'),
  searchOpenButtons: Array.from(document.querySelectorAll('[data-search-open]')),
  searchCloseButtons: Array.from(document.querySelectorAll('[data-search-close]')),
};

const searchElements = {
  input: headerElements.searchModal?.querySelector('.search-modal-input'),
  results: headerElements.searchModal?.querySelector('[data-search-results]'),
  status: headerElements.searchModal?.querySelector('[data-search-status]'),
};

let searchProducts = [];
let searchProductsLoaded = false;

function escapeSearchHtml(value) {
  return String(value || '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}

// Dropdown: funzioni base apertura/chiusura.
function closeDropdown(dropdown) {
  dropdown.container.classList.add('hidden');
}

function openDropdown(dropdown) {
  if (dropdown.closeTimer) {
    clearTimeout(dropdown.closeTimer);
    dropdown.closeTimer = null;
  }

  dropdown.container.classList.remove('hidden');
}

function isInsideAnyTrigger(dropdown, relatedTarget) {
  return dropdown.triggers.some((trigger) => trigger.contains(relatedTarget));
}

function staysInsideDropdown(dropdown, relatedTarget) {
  return relatedTarget
    && (isInsideAnyTrigger(dropdown, relatedTarget) || dropdown.container.contains(relatedTarget));
}

// Dropdown simple: user/supporto.
function initSimpleDropdown(dropdown) {
  dropdown.trigger = dropdown.triggers[0];

  const parent = dropdown.trigger.parentElement;
  const root = document.createElement('div');
  root.className = 'dropdown-root dropdown-root--simple';

  parent.insertBefore(root, dropdown.trigger);
  root.appendChild(dropdown.trigger);
  root.appendChild(dropdown.container);

  dropdown.root = root;

  dropdown.root.addEventListener('mouseenter', function () { openDropdown(dropdown); });
  dropdown.root.addEventListener('mouseleave', function () {
    dropdown.closeTimer = setTimeout(() => closeDropdown(dropdown), 50);
  });

  dropdown.trigger.addEventListener('click', function (event) {
    event.preventDefault();
    dropdown.trigger.blur();
  });
}

// Dropdown full-width: categorie principali.
function initFullDropdown(dropdown) {
  for (const trigger of dropdown.triggers) {
    trigger.addEventListener('mouseenter', function () { openDropdown(dropdown); });
    trigger.addEventListener('mouseleave', function (event) {
      if (staysInsideDropdown(dropdown, event.relatedTarget)) return;
      closeDropdown(dropdown);
    });
  }

  dropdown.container.addEventListener('mouseenter', function () { openDropdown(dropdown); });
  dropdown.container.addEventListener('mouseleave', function (event) {
    if (staysInsideDropdown(dropdown, event.relatedTarget)) return;
    closeDropdown(dropdown);
  });
}

function initDropdowns() {
  const dropdowns = Object.values(DROPDOWN_CONFIG);

  for (const dropdown of dropdowns) {
    dropdown.triggers = Array.from(document.querySelectorAll(dropdown.trigger));
    dropdown.container = document.querySelector(dropdown.container);

    if (!dropdown.triggers.length || !dropdown.container) continue;

    dropdown.container.classList.add(`dropdown-menu--${dropdown.mode}`);
    for (const trigger of dropdown.triggers) {
      trigger.classList.add('dropdown-trigger');
    }

    if (dropdown.mode === 'simple') {
      initSimpleDropdown(dropdown);
    } else {
      initFullDropdown(dropdown);
    }
  }
}

// Badge carrello in header desktop/mobile.
function updateCartBadge(count) {
  for (const badge of headerElements.cartBadges) {
    if (count > 0) {
      badge.textContent = count > 99 ? '99+' : String(count);
      badge.classList.add('is-visible');
    } else {
      badge.textContent = '0';
      badge.classList.remove('is-visible');
    }
  }
}

function onCartBadgeResponse(response) {
  if (response.status === 401 || !response.ok) {
    return null;
  }

  return response.json();
}

function onCartBadgeJson(items) {
  if (!Array.isArray(items)) {
    updateCartBadge(0);
    return;
  }

  let count = 0;
  for (const item of items) {
    count += Number(item?.quantity || 0);
  }

  updateCartBadge(count);
}

function onCartBadgeError() {
  updateCartBadge(0);
  return null;
}

function loadCartBadge() {
  if (!headerElements.cartBadges.length) return;

  fetch('/api/cart', {
    headers: { Accept: 'application/json' },
  }).then(onCartBadgeResponse, onCartBadgeError).then(onCartBadgeJson);
}

// Ricerca prodotti nel modal dell'header.
function updateSearchButtons(expanded) {
  for (const button of headerElements.searchOpenButtons) {
    button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
  }
}

function onSearchProductsResponse(response) {
  if (!response.ok) {
    return null;
  }

  return response.json();
}

function onSearchProductsError() {
  return null;
}

function onSearchProductsJson(data) {
  if (data === null) {
    if (searchElements.status) {
      searchElements.status.textContent = 'Non riesco a caricare i prodotti.';
    }
    return;
  }

  searchProducts = Array.isArray(data) ? data : [];
  searchProductsLoaded = true;
  renderSearchResults();
}

function loadSearchProducts() {
  if (searchProductsLoaded) {
    renderSearchResults();
    return;
  }

  if (searchElements.status) {
    searchElements.status.textContent = 'Caricamento prodotti...';
  }

  fetch('/api/products', {
    headers: { Accept: 'application/json' },
  }).then(onSearchProductsResponse, onSearchProductsError).then(onSearchProductsJson);
}

function getSearchMatches(query) {
  return searchProducts
    .filter(function (product) {
      const name = String(product.name || '').toLowerCase();
      const subtitle = String(product.subtitle || '').toLowerCase();

      return name.includes(query) || subtitle.includes(query);
    })
    .slice(0, 8);
}

function renderSearchResult(product) {
  const image = product.image_path || 'img/stampanti3d.png';
  const price = Number(product.price || 0).toLocaleString('it-IT', {
    style: 'currency',
    currency: 'EUR',
  });

  return `
    <a class="search-modal-result" href="/product?id=${encodeURIComponent(product.id)}">
      <span class="search-modal-result-image">
        <img src="${escapeSearchHtml(image)}" alt="${escapeSearchHtml(product.name || '')}">
      </span>
      <span class="search-modal-result-body">
        <strong>${escapeSearchHtml(product.name || '')}</strong>
        <span>${escapeSearchHtml(product.subtitle || '')}</span>
      </span>
      <span class="search-modal-result-price">${price}</span>
    </a>
  `;
}

function renderSearchResults() {
  if (!searchElements.input || !searchElements.results || !searchElements.status) return;

  const query = searchElements.input.value.trim().toLowerCase();

  if (query.length < 2) {
    searchElements.results.innerHTML = '';
    searchElements.status.textContent = 'Inserisci almeno 2 caratteri per cercare.';
    return;
  }

  const matches = getSearchMatches(query);

  if (!matches.length) {
    searchElements.results.innerHTML = '';
    searchElements.status.textContent = 'Nessun prodotto trovato.';
    return;
  }

  searchElements.status.textContent = `${matches.length} risultato/i trovato/i`;
  searchElements.results.innerHTML = matches.map(renderSearchResult).join('');
}

function openSearchModal() {
  if (!headerElements.searchModal) return;

  headerElements.searchModal.classList.remove('hidden');
  document.body.classList.add('search-modal-open');
  updateSearchButtons(true);

  setTimeout(function () {
    if (searchElements.input) searchElements.input.focus();
  }, 0);

  loadSearchProducts();
}

function closeSearchModal() {
  if (!headerElements.searchModal) return;

  headerElements.searchModal.classList.add('hidden');
  document.body.classList.remove('search-modal-open');
  updateSearchButtons(false);
}

function initSearchModal() {
  for (const button of headerElements.searchOpenButtons) {
    button.addEventListener('click', openSearchModal);
  }

  for (const button of headerElements.searchCloseButtons) {
    button.addEventListener('click', closeSearchModal);
  }

  if (searchElements.input) {
    searchElements.input.addEventListener('input', renderSearchResults);
  }

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && headerElements.searchModal && !headerElements.searchModal.classList.contains('hidden')) {
      closeSearchModal();
    }
  });
}

initDropdowns();
initSearchModal();
window.refreshCartBadge = loadCartBadge;
loadCartBadge();

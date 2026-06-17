// Gestione pagina carrello: caricamento, quantità, rimozione e checkout.

const cartItemsList = document.querySelector('#cart-items-list');
const cartEmptyState = document.querySelector('#cart-empty-state');
const cartTotalLabel = document.querySelector('#cart-total-label');
const cartCheckoutBtn = document.querySelector('#cart-checkout-btn');
const recommendedButtons = Array.from(document.querySelectorAll('.rec-card-btn[data-product-id]'));

const cartMoney = new Intl.NumberFormat('it-IT', {
  style: 'currency',
  currency: 'EUR',
});

let cartItems = [];

// Legge il token CSRF della pagina.
function getCartCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

// Protegge testo dinamico da HTML indesiderato.
function escapeHtml(value) {
  return String(value || '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}

// Formatta un valore in euro.
function formatMoney(value) {
  return cartMoney.format(Number(value) || 0);
}

// Calcola il totale di una riga carrello.
function getLineTotal(item) {
  const price = Number(item?.product?.price || 0);
  const quantity = Number(item?.quantity || 0);
  return price * quantity;
}

// Aggiorna il badge carrello dalla copia locale.
function updateLocalCartBadge() {
  const totalQuantity = cartItems.reduce((sum, item) => sum + Number(item.quantity || 0), 0);
  const badges = document.querySelectorAll('.cart-badge');

  badges.forEach((badge) => {
    badge.textContent = totalQuantity > 99 ? '99+' : String(totalQuantity);
    badge.classList.toggle('is-visible', totalQuantity > 0);
  });
}

// Sincronizza i pulsanti dei prodotti consigliati.
function syncRecommendedButtons(items) {
  const cartProductIds = new Set(items.map((item) => String(item?.product?.id || '')));

  recommendedButtons.forEach((button) => {
    const productId = button.dataset.productId;
    const inCart = cartProductIds.has(productId);

    button.textContent = inCart ? 'Nel carrello' : 'Aggiungi al carrello';
    button.disabled = inCart;
    button.classList.toggle('is-in-cart', inCart);
  });
}

// Mostra un messaggio nel carrello.
function showCartMessage(message) {
  if (!cartEmptyState) return;

  cartEmptyState.textContent = message;
  cartEmptyState.classList.add('is-visible');
}

// Nasconde il messaggio del carrello.
function hideCartMessage() {
  cartEmptyState?.classList.remove('is-visible');
}

// Trova una riga nella copia locale del carrello.
function findLocalCartItem(cartId) {
  return cartItems.find((item) => String(item.id) === String(cartId));
}

// Aggiorna subito la quantità locale.
function updateLocalCartItemQuantity(cartId, quantity) {
  const item = findLocalCartItem(cartId);

  if (!item) return;

  item.quantity = quantity;
  renderCart(cartItems);
}

// Rimuove subito una riga locale.
function removeLocalCartItem(cartId) {
  cartItems = cartItems.filter((item) => String(item.id) !== String(cartId));
  renderCart(cartItems);
}

// Inserisce o sostituisce una riga nella copia locale.
function upsertLocalCartItem(cartItem) {
  const index = cartItems.findIndex((item) => String(item.id) === String(cartItem.id));

  if (index === -1) {
    cartItems.push(cartItem);
  } else {
    cartItems[index] = cartItem;
  }

  renderCart(cartItems);
}

// Disegna tutti gli elementi del carrello.
function renderCart(items) {
  if (!cartItemsList) return;

  const totalQuantity = items.reduce((sum, item) => sum + Number(item.quantity || 0), 0);
  const totalPrice = items.reduce((sum, item) => sum + getLineTotal(item), 0);

  if (cartTotalLabel) {
    cartTotalLabel.textContent = `Totale: ${formatMoney(totalPrice)}`;
  }

  if (cartCheckoutBtn) {
    cartCheckoutBtn.textContent = `Checkout ${totalQuantity} articolo(i)`;
    cartCheckoutBtn.disabled = items.length === 0;
  }

  updateLocalCartBadge();
  syncRecommendedButtons(items);

  if (!items.length) {
    cartItemsList.innerHTML = '';
    showCartMessage('Il carrello è vuoto.');
    return;
  }

  hideCartMessage();

  cartItemsList.innerHTML = items.map((item) => {
    const product = item.product || {};
    const price = getLineTotal(item);
    const productUrl = product.id ? `/product?id=${encodeURIComponent(product.id)}` : '#';

    return `
      <div class="cart-item" data-cart-id="${item.id}">
        <label class="cart-item-checkbox-wrap">
          <input type="checkbox" checked>
          <span class="cart-item-checkmark"></span>
        </label>
        <a href="${productUrl}" class="cart-item-img-wrap">
          <img src="${escapeHtml(product.image_path || 'img/stampanti3d.png')}" alt="${escapeHtml(product.name || '')}">
        </a>
        <div class="cart-item-info">
          <a href="${productUrl}" class="cart-item-name">${escapeHtml(product.name || '')}</a>
          <div class="cart-item-variant">${escapeHtml(product.subtitle || '')}</div>
          <a href="#" class="cart-item-remove" data-action="remove">Rimuovi</a>
        </div>
        <div class="cart-item-qty">
          <button class="qty-btn" data-action="decrease" aria-label="Diminuisci quantità">&#8722;</button>
          <span class="qty-value">${item.quantity}</span>
          <button class="qty-btn" data-action="increase" aria-label="Aumenta quantità">&#43;</button>
        </div>
        <div class="cart-item-price">${formatMoney(price)}</div>
      </div>
    `;
  }).join('');
}

// Carica il carrello dal server.
function loadCart() {
  if (!cartItemsList) return;

  return fetch('/api/cart', {
    headers: { Accept: 'application/json' },
  }).then(function (response) {
    return response.json().then(function (data) {
      return { response, data };
    });
  }).then(function (result) {
    const response = result.response;
    const data = result.data;

    if (response.status === 401) {
      cartItemsList.innerHTML = '';
      cartEmptyState?.classList.add('is-visible');
      return;
    }

    if (!response.ok) {
      throw new Error(data.message || 'Errore nel caricamento del carrello.');
    }

    cartItems = Array.isArray(data) ? data : [];
    renderCart(cartItems);
  }).catch(function (error) {
    cartItemsList.innerHTML = '';
    showCartMessage(error.message || 'Errore nel caricamento del carrello.');
  });
}

// Legge JSON e conserva la risposta originale.
function readCartJson(response) {
  return response.json().then(function (data) {
    return { response, data };
  });
}

// Conferma una modifica gia applicata localmente.
function refreshCartAfterChange() {
  updateLocalCartBadge();
}

// Aggiunge un prodotto consigliato al carrello.
function addRecommendedProduct(printerId) {
  const formData = new FormData();
  formData.append('product_id', String(printerId));
  formData.append('quantity', '1');
  formData.append('_token', getCartCsrfToken());

  return fetch('/api/cart', {
    method: 'POST',
    headers: { Accept: 'application/json' },
    body: formData,
  }).then(readCartJson).then(function (result) {
    if (!result.response.ok) {
      throw new Error(result.data.message || 'Errore aggiunta al carrello.');
    }

    upsertLocalCartItem(result.data);
    return refreshCartAfterChange();
  });
}

// Aggiorna la quantità di una riga carrello.
function updateItemQuantity(cartId, quantity) {
  const formData = new FormData();
  formData.append('cart_id', String(cartId));
  formData.append('quantity', String(quantity));
  formData.append('_token', getCartCsrfToken());

  return fetch('/api/cart', {
    method: 'POST',
    headers: { Accept: 'application/json' },
    body: formData,
  }).then(readCartJson).then(function (result) {
    if (!result.response.ok) {
      throw new Error(result.data.message || 'Errore aggiornamento carrello.');
    }

    return refreshCartAfterChange();
  });
}

// Rimuove una riga carrello.
function removeItem(cartId) {
  const body = new URLSearchParams({
    id: String(cartId),
    _token: getCartCsrfToken(),
  });

  return fetch('/api/cart', {
    method: 'DELETE',
    headers: { Accept: 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
    body,
  }).then(readCartJson).then(function (result) {
    if (!result.response.ok) {
      throw new Error(result.data.message || 'Errore rimozione elemento.');
    }

    return refreshCartAfterChange();
  });
}

// Handler: click su +, -, rimuovi.
cartItemsList?.addEventListener('click', function (event) {
  const target = event.target;
  const item = target.closest('.cart-item');

  if (!item) return;

  const cartId = item.getAttribute('data-cart-id');
  const action = target.getAttribute('data-action');

  if (!cartId || !action) return;

  event.preventDefault();

  const currentQty = Number(item.querySelector('.qty-value')?.textContent || 1);
  let request = null;

  if (action === 'increase') {
    const nextQty = currentQty + 1;
    updateLocalCartItemQuantity(cartId, nextQty);
    request = updateItemQuantity(cartId, nextQty);
  }

  if (action === 'decrease') {
    if (currentQty <= 1) {
      removeLocalCartItem(cartId);
      request = removeItem(cartId);
    } else {
      const nextQty = currentQty - 1;
      updateLocalCartItemQuantity(cartId, nextQty);
      request = updateItemQuantity(cartId, nextQty);
    }
  }

  if (action === 'remove') {
    removeLocalCartItem(cartId);
    request = removeItem(cartId);
  }

  if (request) {
    request.catch(function (error) {
      showCartMessage(error.message || 'Errore aggiornamento carrello.');
      loadCart();
    });
  }
});

// Handler: checkout carrello completo.
cartCheckoutBtn?.addEventListener('click', function () {
  cartCheckoutBtn.disabled = true;
  cartCheckoutBtn.textContent = 'Reindirizzamento...';

  fetch('/api/checkout', {
    method: 'POST',
    headers: { Accept: 'application/json', 'X-CSRF-TOKEN': getCartCsrfToken() },
  }).then(readCartJson).then(function (result) {
    const response = result.response;
    const data = result.data;

    if (!response.ok) {
      throw new Error(data.message || 'Errore durante il checkout.');
    }

    if (!data.url) {
      throw new Error('Stripe non ha restituito un URL valido.');
    }

    window.location.href = data.url;
  }).catch(function (error) {
    showCartMessage(error.message || 'Errore durante il checkout.');
    if (cartCheckoutBtn) {
      cartCheckoutBtn.disabled = false;
      cartCheckoutBtn.textContent = 'Checkout';
    }
  });
});

// Handler: prodotti consigliati.
recommendedButtons.forEach((button) => {
  button.addEventListener('click', function () {
    const productId = button.dataset.productId;

    if (!productId || button.disabled) return;

    const originalText = button.textContent;

    button.disabled = true;
    button.textContent = 'Nel carrello';
    button.classList.add('is-in-cart');

    addRecommendedProduct(productId).catch(function (error) {
      showCartMessage(error.message || 'Errore aggiunta al carrello.');
      button.disabled = false;
      button.textContent = originalText;
      button.classList.remove('is-in-cart');
      loadCart();
    });
  });
});

loadCart();

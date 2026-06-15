const cartItemsList = document.querySelector('#cart-items-list');
const cartEmptyState = document.querySelector('#cart-empty-state');
const cartTotalLabel = document.querySelector('#cart-total-label');
const cartCheckoutBtn = document.querySelector('#cart-checkout-btn');
const recommendedButtons = Array.from(document.querySelectorAll('.rec-card-btn[data-product-id]'));

const cartMoney = new Intl.NumberFormat('it-IT', {
  style: 'currency',
  currency: 'EUR',
});

function escapeHtml(value) {
  return String(value || '')
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}

function formatMoney(value) {
  return cartMoney.format(Number(value) || 0);
}

function getLineTotal(item) {
  const price = Number(item?.product?.price || 0);
  const quantity = Number(item?.quantity || 0);
  return price * quantity;
}

function syncRecommendedButtons(items) {
  const cartProductIds = new Set(items.map((item) => String(item?.product?.id || '')));

  recommendedButtons.forEach((button) => {
    const productId = button.dataset.productId;
    const inCart = cartProductIds.has(productId);

    button.textContent = inCart ? 'Nel carrello' : 'Aggiungi al carrello';
    button.disabled = inCart;
    button.style.opacity = inCart ? '0.7' : '1';
    button.style.cursor = inCart ? 'not-allowed' : 'pointer';
  });
}

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

  syncRecommendedButtons(items);

  if (!items.length) {
    cartItemsList.innerHTML = '';
    if (cartEmptyState) {
      cartEmptyState.textContent = 'Il carrello è vuoto.';
      cartEmptyState.style.display = 'block';
    }
    return;
  }

  if (cartEmptyState) cartEmptyState.style.display = 'none';

  cartItemsList.innerHTML = items.map((item) => {
    const product = item.product || {};
    const price = getLineTotal(item);
    const productUrl = product.id ? `product.php?id=${encodeURIComponent(product.id)}` : '#';

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

async function loadCart() {
  if (!cartItemsList) return;

  try {
    const response = await fetch('app/api/api_cart.php', {
      headers: { Accept: 'application/json' },
    });

    const data = await response.json();

    if (response.status === 401) {
      cartItemsList.innerHTML = '';
      if (cartEmptyState) {
        cartEmptyState.style.display = 'block';
      }
      return;
    }

    if (!response.ok) {
      throw new Error(data.message || 'Errore nel caricamento del carrello.');
    }

    renderCart(Array.isArray(data) ? data : []);
  } catch (error) {
    cartItemsList.innerHTML = '';
    if (cartEmptyState) {
      cartEmptyState.textContent = error.message || 'Errore nel caricamento del carrello.';
      cartEmptyState.style.display = 'block';
    }
  }
}

async function addRecommendedProduct(printerId) {
  const formData = new FormData();
  formData.append('product_id', String(printerId));
  formData.append('quantity', '1');

  const response = await fetch('app/api/api_cart.php', {
    method: 'POST',
    headers: { Accept: 'application/json' },
    body: formData,
  });

  const data = await response.json();

  if (!response.ok) {
    throw new Error(data.message || 'Errore aggiunta al carrello.');
  }

  if (typeof window.refreshCartBadge === 'function') {
    window.refreshCartBadge();
  }

  await loadCart();
}

async function updateItemQuantity(cartId, quantity) {
  const formData = new FormData();
  formData.append('cart_id', String(cartId));
  formData.append('quantity', String(quantity));

  const response = await fetch('app/api/api_cart.php', {
    method: 'POST',
    headers: { Accept: 'application/json' },
    body: formData,
  });

  if (!response.ok) {
    const data = await response.json();
    throw new Error(data.message || 'Errore aggiornamento carrello.');
  }

  if (typeof window.refreshCartBadge === 'function') {
    window.refreshCartBadge();
  }

  return loadCart();
}

async function removeItem(cartId) {
  const response = await fetch('app/api/api_cart.php', {
    method: 'DELETE',
    headers: { Accept: 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `id=${encodeURIComponent(cartId)}`,
  });

  if (!response.ok) {
    const data = await response.json();
    throw new Error(data.message || 'Errore rimozione elemento.');
  }

  if (typeof window.refreshCartBadge === 'function') {
    window.refreshCartBadge();
  }

  return loadCart();
}

cartItemsList?.addEventListener('click', async (event) => {
  const target = event.target;
  const item = target.closest('.cart-item');

  if (!item) return;

  const cartId = item.getAttribute('data-cart-id');
  const action = target.getAttribute('data-action');

  if (!cartId || !action) return;

  event.preventDefault();

  const currentQty = Number(item.querySelector('.qty-value')?.textContent || 1);

  try {
    if (action === 'increase') {
      await updateItemQuantity(cartId, currentQty + 1);
    }

    if (action === 'decrease') {
      if (currentQty <= 1) {
        await removeItem(cartId);
      } else {
        await updateItemQuantity(cartId, currentQty - 1);
      }
    }

    if (action === 'remove') {
      await removeItem(cartId);
    }
  } catch (error) {
    if (cartEmptyState) {
      cartEmptyState.textContent = error.message || 'Errore aggiornamento carrello.';
      cartEmptyState.style.display = 'block';
    }
  }
});

cartCheckoutBtn?.addEventListener('click', async () => {
  try {
    cartCheckoutBtn.disabled = true;
    cartCheckoutBtn.textContent = 'Reindirizzamento...';

    const response = await fetch('app/api/api_checkout.php', {
      method: 'POST',
      headers: { Accept: 'application/json' },
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Errore durante il checkout.');
    }

    if (!data.url) {
      throw new Error('Stripe non ha restituito un URL valido.');
    }

    window.location.href = data.url;
  } catch (error) {
    if (cartEmptyState) {
      cartEmptyState.textContent = error.message || 'Errore durante il checkout.';
      cartEmptyState.style.display = 'block';
    }
    if (cartCheckoutBtn) {
      cartCheckoutBtn.disabled = false;
      cartCheckoutBtn.textContent = 'Checkout';
    }
  }
});

recommendedButtons.forEach((button) => {
  button.addEventListener('click', async () => {
    const productId = button.dataset.productId;

    if (!productId || button.disabled) return;

    try {
      button.disabled = true;
      button.textContent = 'Aggiunta...';
      await addRecommendedProduct(productId);
    } catch (error) {
      if (cartEmptyState) {
        cartEmptyState.textContent = error.message || 'Errore aggiunta al carrello.';
        cartEmptyState.style.display = 'block';
      }
      button.disabled = false;
      button.textContent = 'Aggiungi al carrello';
    }
  });
});

loadCart();

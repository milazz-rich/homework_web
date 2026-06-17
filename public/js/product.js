// Gestione pagina prodotto: immagini, accordion, quantità, carrello e checkout.

// Gallery thumbnails.
document.querySelectorAll('.product-gallery-thumbs .thumb').forEach(thumb => {
  thumb.addEventListener('click', () => {
    const mainImg = document.getElementById('mainImage');
    if (!mainImg) return;

    const src = thumb.dataset.src;
    mainImg.src = src;
    if (thumb.dataset.fallback) {
      mainImg.onerror = () => { mainImg.src = thumb.dataset.fallback; };
    }
    document.querySelectorAll('.product-gallery-thumbs .thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
  });
});

// Accordion dettagli prodotto.
document.querySelectorAll('.product-accordion-trigger').forEach(trigger => {
  trigger.addEventListener('click', () => {
    const expanded = trigger.getAttribute('aria-expanded') === 'true';
    trigger.setAttribute('aria-expanded', String(!expanded));
    const body = trigger.nextElementSibling;
    if (expanded) body.setAttribute('hidden', '');
    else body.removeAttribute('hidden');
  });
});

// Quantità e prezzo dinamico.
const productPurchaseForm = document.getElementById('productPurchaseForm');
const qtyInput = document.getElementById('qtyInput');
const priceDisplay = document.querySelector('.product-price-display');
const purchaseFormData = productPurchaseForm ? new FormData(productPurchaseForm) : new FormData();
const BASE_PRICE = Number(purchaseFormData.get('unit_price') || 0);
const ADD_TO_CART_URL = '/api/cart';
const BUY_NOW_URL = '/api/checkout/buy-now';

productPurchaseForm?.addEventListener('submit', (event) => {
  event.preventDefault();
});

function normalizeQuantity(value) {
  return Math.min(99, Math.max(1, parseInt(value, 10) || 1));
}

function updatePrice() {
  if (!qtyInput || !priceDisplay) return;

  const qty = normalizeQuantity(qtyInput.value);
  qtyInput.value = qty;
  priceDisplay.textContent = '€' + (BASE_PRICE * qty).toLocaleString('it-IT', { minimumFractionDigits: 2 });
}

document.getElementById('qtyMinus')?.addEventListener('click', () => {
  if (!qtyInput) return;
  qtyInput.value = normalizeQuantity(parseInt(qtyInput.value, 10) - 1);
  updatePrice();
});

document.getElementById('qtyPlus')?.addEventListener('click', () => {
  if (!qtyInput) return;
  qtyInput.value = normalizeQuantity(parseInt(qtyInput.value, 10) + 1);
  updatePrice();
});

qtyInput?.addEventListener('input', updatePrice);

// Toggle varianti visuali, se presenti.
document.querySelectorAll('.variant-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  });
});

document.querySelectorAll('.color-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const colorLabel = btn.closest('.product-color')?.querySelector('.product-variant-label strong');
    if (colorLabel) colorLabel.textContent = btn.dataset.color;
  });
});

// Tab upsell, se presenti.
document.querySelectorAll('.product-upsell').forEach(upsell => {
  upsell.querySelectorAll('.upsell-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      upsell.querySelectorAll('.upsell-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
    });
  });
});

// Aggiunta al carrello: logica ripristinata al comportamento precedente.
document.querySelector('.btn-add-cart')?.addEventListener('click', () => {
  const btn = document.querySelector('.btn-add-cart');
  if (!btn) return;
  const qty = normalizeQuantity(qtyInput?.value || '1');

  btn.disabled = true;
  const original = btn.textContent;
  btn.textContent = 'Aggiunta...';

  const formData = productPurchaseForm ? new FormData(productPurchaseForm) : new FormData();
  formData.append('quantity', String(qty));

  fetch(ADD_TO_CART_URL, {
    method: 'POST',
    headers: { Accept: 'application/json' },
    body: formData,
  })
    .then(async (response) => {
      const data = await response.json();
      if (response.status === 401) {
        window.location.href = '/login';
        return;
      }
      if (!response.ok) {
        throw new Error(data.message || 'Errore durante l\'aggiunta al carrello.');
      }
      if (typeof window.refreshCartBadge === 'function') {
        window.refreshCartBadge();
      }
      btn.textContent = 'Aggiunto ✓';
      btn.classList.add('is-added');
      setTimeout(() => {
        btn.textContent = original;
        btn.classList.remove('is-added');
        btn.disabled = false;
      }, 1800);
    })
    .catch((error) => {
      alert(error.message || 'Errore durante l\'aggiunta al carrello.');
      btn.textContent = original;
      btn.disabled = false;
    });
});

// Checkout immediato: logica ripristinata al comportamento precedente.
document.querySelector('.btn-buy-now')?.addEventListener('click', () => {
  const btn = document.querySelector('.btn-buy-now');
  if (!btn) return;
  const qty = normalizeQuantity(qtyInput?.value || '1');

  btn.disabled = true;
  const original = btn.textContent;
  btn.textContent = 'Reindirizzamento...';

  const formData = productPurchaseForm ? new FormData(productPurchaseForm) : new FormData();
  formData.append('quantity', String(qty));

  fetch(BUY_NOW_URL, {
    method: 'POST',
    headers: { Accept: 'application/json' },
    body: formData,
  })
    .then(async (response) => {
      const data = await response.json();
      if (response.status === 401) {
        window.location.href = '/login';
        return;
      }
      if (!response.ok) {
        throw new Error(data.message || 'Errore durante il checkout.');
      }
      if (!data.url) {
        throw new Error('Stripe non ha restituito un URL valido.');
      }
      window.location.href = data.url;
    })
    .catch((error) => {
      alert(error.message || 'Errore durante il checkout.');
      btn.textContent = original;
      btn.disabled = false;
    });
});

// Pulsanti bundle dimostrativi, se presenti.
document.querySelectorAll('.bundle-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    if (btn.textContent === 'Aggiunto') {
      btn.textContent = 'Aggiungi';
      btn.classList.remove('is-added');
    } else {
      btn.textContent = 'Aggiunto';
      btn.classList.add('is-added');
    }
  });
});

updatePrice();

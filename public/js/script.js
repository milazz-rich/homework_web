// Newsletter e convertitore valuta della homepage.

function getCsrfToken() {
  const inputToken = document.querySelector('input[name="_token"]');
  const converterToken = document.querySelector('#fxCsrfToken');
  const metaToken = document.querySelector('meta[name="csrf-token"]');

  if (inputToken) return inputToken.value;
  if (converterToken) return converterToken.value;
  if (metaToken) return metaToken.content;
  return '';
}

function onJsonResponse(response) {
  if (response.ok) {
    return response.json();
  }

  return response.json().then(function (data) {
    return {
      success: false,
      message: data.message || 'Errore di rete o server non raggiungibile.',
    };
  }, function () {
    return {
      success: false,
      message: 'Errore di rete o server non raggiungibile.',
    };
  });
}

function onNetworkError() {
  return {
    success: false,
    message: 'Errore di rete o server non raggiungibile.',
  };
}

function setFormMessage(element, data, fallbackMessage) {
  if (!element) return;

  element.textContent = data.message || fallbackMessage;
  element.classList.toggle('is-success', data.success === true);
  element.classList.toggle('is-error', data.success !== true);
}

function setLoadingButton(button, isLoading, loadingText, originalText) {
  if (!button) return;

  button.disabled = isLoading;
  button.textContent = isLoading ? loadingText : originalText;
}

// Handler: iscrizione newsletter.
function onNewsletterSubmit(event) {
  event.preventDefault();

  const form = event.currentTarget;
  const message = document.querySelector('.newsletter-signup-message');
  const submitButton = form.querySelector('button[type="submit"]');
  const originalText = submitButton ? submitButton.textContent : '';

  setLoadingButton(submitButton, true, 'Invio...', originalText);

  fetch(form.action || '/api/newsletter', {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'X-CSRF-TOKEN': getCsrfToken(),
    },
    body: new FormData(form),
  }).then(onJsonResponse, onNetworkError).then(function (data) {
    setFormMessage(message, data, 'Errore di rete o server non raggiungibile.');

    if (data.success) {
      form.reset();
    }

    setLoadingButton(submitButton, false, '', originalText);
  });
}

function getCurrencyRequestBody() {
  const amountInput = document.querySelector('#fxAmount');
  const fromSelect = document.querySelector('#fxFrom');
  const toSelect = document.querySelector('#fxTo');
  const csrfToken = getCsrfToken();
  const body = new URLSearchParams({
    amount: amountInput ? amountInput.value : '',
    from: fromSelect ? fromSelect.value : '',
    to: toSelect ? toSelect.value : '',
  });

  if (csrfToken) {
    body.append('_token', csrfToken);
  }

  return body;
}

// Handler: conversione valuta.
function onCurrencyConvertClick() {
  const convertButton = document.querySelector('#fxConvertButton');
  const result = document.querySelector('#fxResult');
  const originalText = convertButton ? convertButton.textContent : '';
  const csrfToken = getCsrfToken();

  setLoadingButton(convertButton, true, 'Conversione...', originalText);

  fetch('/api/currency-converter', {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-CSRF-TOKEN': csrfToken,
    },
    body: getCurrencyRequestBody(),
  }).then(onJsonResponse, onNetworkError).then(function (data) {
    setFormMessage(result, data, 'Errore nel recupero del cambio valuta.');
    setLoadingButton(convertButton, false, '', originalText);
  });
}

// Handler: invio con Enter nei campi del convertitore.
function onCurrencyFieldKeydown(event) {
  if (event.key === 'Enter') {
    event.preventDefault();
    onCurrencyConvertClick();
  }
}

function initNewsletterSignup() {
  const form = document.querySelector('.newsletter-signup-form');

  if (form) {
    form.addEventListener('submit', onNewsletterSubmit);
  }
}

function initCurrencyConverter() {
  const convertButton = document.querySelector('#fxConvertButton');
  const fields = [
    document.querySelector('#fxAmount'),
    document.querySelector('#fxFrom'),
    document.querySelector('#fxTo'),
  ];

  if (convertButton) {
    convertButton.addEventListener('click', onCurrencyConvertClick);
  }

  for (const field of fields) {
    if (field) {
      field.addEventListener('keydown', onCurrencyFieldKeydown);
    }
  }
}

initNewsletterSignup();
initCurrencyConverter();

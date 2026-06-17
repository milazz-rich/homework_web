const newsletterForm = {
  form: document.querySelector('.newsletter-signup-form'),
  message: document.querySelector('.newsletter-signup-message'),
};

function getCsrfToken() {
  return document.querySelector('input[name="_token"]')?.value
    || document.querySelector('#fxCsrfToken')?.value
    || document.querySelector('meta[name="csrf-token"]')?.content
    || '';
}

async function readJsonResponse(response, fallbackMessage) {
  let data = null;

  try {
    data = await response.json();
  } catch (_error) {
    data = null;
  }

  if (!response.ok) {
    return {
      success: false,
      message: data?.message || fallbackMessage,
    };
  }

  return data || {
    success: false,
    message: fallbackMessage,
  };
}

function setFormMessage(element, data, fallbackMessage) {
  if (!element) return;

  element.textContent = data.message || fallbackMessage;
  element.classList.toggle('is-success', !!data.success);
  element.classList.toggle('is-error', !data.success);
}

if (newsletterForm.form) {
  newsletterForm.form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const submitButton = newsletterForm.form.querySelector('button[type="submit"]');
    const originalText = submitButton?.textContent || '';

    if (submitButton) {
      submitButton.disabled = true;
      submitButton.textContent = 'Invio...';
    }

    try {
      const response = await fetch(newsletterForm.form.action || '/api/newsletter', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'X-CSRF-TOKEN': getCsrfToken(),
        },
        body: new FormData(newsletterForm.form),
      });

      const data = await readJsonResponse(response, 'Errore di rete o server non raggiungibile.');
      setFormMessage(newsletterForm.message, data, 'Errore di rete o server non raggiungibile.');

      if (data.success) {
        newsletterForm.form.reset();
      }
    } catch (_error) {
      setFormMessage(newsletterForm.message, {
        success: false,
        message: 'Errore di rete o server non raggiungibile.',
      }, 'Errore di rete o server non raggiungibile.');
    } finally {
      if (submitButton) {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
      }
    }
  });
}

const currencyConverter = {
  amount: document.querySelector('#fxAmount'),
  from: document.querySelector('#fxFrom'),
  to: document.querySelector('#fxTo'),
  button: document.querySelector('#fxConvertButton'),
  result: document.querySelector('#fxResult')
};

if (currencyConverter.button) {
  currencyConverter.button.addEventListener('click', async () => {
    if (!currencyConverter.amount || !currencyConverter.from || !currencyConverter.to || !currencyConverter.result) return;

    const originalText = currencyConverter.button.textContent;
    currencyConverter.button.disabled = true;
    currencyConverter.button.textContent = 'Conversione...';

    const body = new URLSearchParams({
      amount: currencyConverter.amount.value,
      from: currencyConverter.from.value,
      to: currencyConverter.to.value,
    });

    const csrfToken = getCsrfToken();
    if (csrfToken) {
      body.append('_token', csrfToken);
    }

    try {
      const response = await fetch('/api/currency-converter', {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-CSRF-TOKEN': csrfToken,
        },
        body,
      });

      const data = await readJsonResponse(response, 'Errore nel recupero del cambio valuta.');
      setFormMessage(currencyConverter.result, data, 'Errore nel recupero del cambio valuta.');
    } catch (_error) {
      setFormMessage(currencyConverter.result, {
        success: false,
        message: 'Errore nel recupero del cambio valuta.',
      }, 'Errore nel recupero del cambio valuta.');
    } finally {
      currencyConverter.button.disabled = false;
      currencyConverter.button.textContent = originalText;
    }
  });

  [currencyConverter.amount, currencyConverter.from, currencyConverter.to].forEach((field) => {
    field?.addEventListener('keydown', (event) => {
      if (event.key === 'Enter') {
        event.preventDefault();
        currencyConverter.button.click();
      }
    });
  });
}

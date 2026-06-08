const newsletterForm = {
  form: document.querySelector('.newsletter-signup-form'),
  message: document.querySelector('.newsletter-signup-message'),
};

if (newsletterForm.form) {
  newsletterForm.form.addEventListener('submit', (event) => {
    event.preventDefault();

    fetch('app/api/api_newsletter.php', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
      },
      body: new FormData(newsletterForm.form),
    })
      .then((response) => response.json())
      .then((data) => {
        if (!newsletterForm.message) return;

        newsletterForm.message.textContent = data.message || 'Errore di rete o server non raggiungibile.';
        newsletterForm.message.classList.toggle('is-success', !!data.success);
        newsletterForm.message.classList.toggle('is-error', !data.success);
      })
      .catch(() => {
        if (!newsletterForm.message) return;

        newsletterForm.message.textContent = 'Errore di rete o server non raggiungibile.';
        newsletterForm.message.classList.remove('is-success');
        newsletterForm.message.classList.add('is-error');
      });
  });
}

const currencyConverter = {
  amount: document.querySelector("#fxAmount"),
  from: document.querySelector("#fxFrom"),
  to: document.querySelector("#fxTo"),
  button: document.querySelector("#fxConvertButton"),
  result: document.querySelector("#fxResult")
};

function setFxResult(text, ok) {
  if (!currencyConverter.result) return;
  currencyConverter.result.textContent = text;
  currencyConverter.result.style.color = ok ? "#1b7a35" : "#cc2b2b";
}

function onFxResponse(response) {
  if (response.ok) return response.json();
  return null;
}

function onFxNetworkError(error) {
  console.error(error);
  return null;
}

function onFxJson(data) {
  if (data == null || data.result !== "success") {
    setFxResult("Errore nel recupero del cambio valuta.", false);
    return;
  }

  const amount = Number(currencyConverter.amount.value);
  const fromCode = currencyConverter.from.value;
  const toCode = currencyConverter.to.value;
  const rate = data.rates[toCode];

  if (!rate) {
    setFxResult("Valuta di destinazione non disponibile.", false);
    return;
  }

  const converted = amount * rate;
  const text =
    amount.toFixed(2) +
    " " +
    fromCode +
    " = " +
    converted.toFixed(2) +
    " " +
    toCode +
    " (1 " +
    fromCode +
    " = " +
    rate.toFixed(4) +
    " " +
    toCode +
    ")";

  setFxResult(text, true);
}

function convertCurrency() {
  if (!currencyConverter.amount || !currencyConverter.from || !currencyConverter.to) return;

  const amount = Number(currencyConverter.amount.value);
  const fromCode = currencyConverter.from.value;
  const toCode = currencyConverter.to.value;

  if (!Number.isFinite(amount) || amount <= 0) {
    setFxResult("Inserisci un importo valido maggiore di zero.", false);
    return;
  }

  if (fromCode === toCode) {
    setFxResult(amount.toFixed(2) + " " + fromCode + " = " + amount.toFixed(2) + " " + toCode, true);
    return;
  }

  const url = "https://open.er-api.com/v6/latest/" + encodeURIComponent(fromCode);
  fetch(url).then(onFxResponse, onFxNetworkError).then(onFxJson);
}

function initCurrencyConverter() {
  if (!currencyConverter.button) return;
  currencyConverter.button.addEventListener("click", convertCurrency);
}

initCurrencyConverter();

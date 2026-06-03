const newsletterForm = {
  container: document.querySelector(".section9-form-wrap"),
  input: document.querySelector(".section9-form input[type='email']"),
  button: document.querySelector(".section9-form button"),
  consent: document.querySelector(".section9-consent input[type='checkbox']"),
  accessKey: "40cf218c52dffc7c28eaddf7943f110f"
};

function ensureMessageBox() {
  if (!newsletterForm.container) return null;

  let box = newsletterForm.container.querySelector(".section9-message");
  if (box) return box;

  box = document.createElement("p");
  box.className = "section9-message";
  box.style.marginTop = "10px";
  box.style.fontSize = "14px";
  box.style.lineHeight = "1.4";
  newsletterForm.container.appendChild(box);
  return box;
}

function setMessage(text, ok) {
  const box = ensureMessageBox();
  if (!box) return;

  box.textContent = text;
  box.style.color = ok ? "#1b7a35" : "#cc2b2b";
}

function onResponse(response) {
  if (response.ok) return response.json();
  return null;
}

function onNetworkError(error) {
  console.error(error);
  return null;
}

function onJson(data) {
  if (data == null) {
    setMessage("Errore di rete o server non raggiungibile.", false);
    return;
  }

  if (data.success === false) {
    setMessage("Errore API Mailboxlayer: richiesta non valida.", false);
    return;
  }

  if (data.format_valid && data.mx_found) {
    setMessage("Email valida. Iscrizione completata.", true);
    return;
  }

  setMessage("Email non valida. Controlla l'indirizzo inserito.", false);
}

function validateNewsletterEmail(email) {
  const url =
    "https://apilayer.net/api/check?access_key=" +
    newsletterForm.accessKey +
    "&email=" +
    encodeURIComponent(email) +
    "&smtp=1&format=1";

  fetch(url).then(onResponse, onNetworkError).then(onJson);
}

function onNewsletterSubmit(event) {
  event.preventDefault();

  if (!newsletterForm.input || !newsletterForm.consent) return;

  const email = newsletterForm.input.value.trim();
  if (email === "") {
    setMessage("Inserisci una email.", false);
    return;
  }

  if (!newsletterForm.consent.checked) {
    setMessage("Devi accettare il consenso marketing.", false);
    return;
  }

  validateNewsletterEmail(email);
}

function initSection9Form() {
  if (!newsletterForm.button) return;
  newsletterForm.button.addEventListener("click", onNewsletterSubmit);
}

initSection9Form();

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

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
  amount: document.querySelector('#fxAmount'),
  from: document.querySelector('#fxFrom'),
  to: document.querySelector('#fxTo'),
  button: document.querySelector('#fxConvertButton'),
  result: document.querySelector('#fxResult')
};

if (currencyConverter.button) {
  currencyConverter.button.addEventListener('click', () => {
    if (!currencyConverter.amount || !currencyConverter.from || !currencyConverter.to || !currencyConverter.result) return;

    fetch('app/api/api_currency_converter.php', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
      },
      body: new URLSearchParams({
        amount: currencyConverter.amount.value,
        from: currencyConverter.from.value,
        to: currencyConverter.to.value,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        currencyConverter.result.textContent = data.message || 'Errore nel recupero del cambio valuta.';
        currencyConverter.result.style.color = data.success ? '#1b7a35' : '#cc2b2b';
      })
      .catch(() => {
        currencyConverter.result.textContent = 'Errore nel recupero del cambio valuta.';
        currencyConverter.result.style.color = '#cc2b2b';
      });
  });
}

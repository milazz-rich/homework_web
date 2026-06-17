// Login, registrazione e invio codice di verifica.

function getAuthCsrfToken() {
  const metaToken = document.querySelector('meta[name="csrf-token"]');
  const inputToken = document.querySelector('input[name="_token"]');

  if (metaToken) return metaToken.content;
  if (inputToken) return inputToken.value;
  return '';
}

function onAuthResponse(response) {
  if (!response.ok) {
    return response.json().then(function (data) {
      return {
        success: false,
        message: data.message || 'Operazione fallita.',
      };
    }, function () {
      return {
        success: false,
        message: 'Operazione fallita.',
      };
    });
  }

  return response.json();
}

function onAuthNetworkError() {
  return {
    success: false,
    message: 'Errore di rete o server non raggiungibile.',
  };
}

function showAuthMessage(message, isError) {
  const authMessage = document.querySelector('[data-auth-message]');

  if (!authMessage) return;

  authMessage.textContent = message;
  authMessage.classList.remove('form-error--hidden');
  authMessage.classList.toggle('form-error--success', isError === false);
}

function setButtonLoading(button, isLoading, loadingText, originalText) {
  if (!button) return;

  button.disabled = isLoading;
  button.textContent = isLoading ? loadingText : originalText;
}

function setEyeIcon(icon, showPassword) {
  icon.innerHTML = showPassword
    ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
      d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`
    : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
      d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />`;
}

// Handler: mostra o testo della password.
function onPasswordToggleClick(event) {
  const button = event.currentTarget;
  const wrapper = button.closest('.password-wrapper');
  const input = wrapper ? wrapper.querySelector('input') : null;
  const icon = wrapper ? wrapper.querySelector('#eye-icon') : null;

  if (!input || !icon) return;

  const showPassword = input.type === 'password';
  input.type = showPassword ? 'text' : 'password';
  setEyeIcon(icon, showPassword);
}

function showVerifyMessage(message, isError) {
  const verifyMessage = document.querySelector('#verify-message');

  if (!verifyMessage) return;

  verifyMessage.textContent = message;
  verifyMessage.classList.remove('form-error--hidden');
  verifyMessage.classList.toggle('form-error--success', isError === false);
}

// Handler: invia il codice di verifica all'email inserita.
function onSendCodeClick(event) {
  const button = event.currentTarget;
  const emailInput = document.querySelector('input[name="email"]');
  const email = emailInput ? emailInput.value.trim() : '';
  const originalText = button.textContent;

  if (!email) {
    showVerifyMessage('Inserisci prima un indirizzo e-mail valido.', true);
    return;
  }

  const csrfToken = getAuthCsrfToken();
  const body = new URLSearchParams({ email: email, _token: csrfToken });

  setButtonLoading(button, true, 'Invio in corso...', originalText);

  fetch('/api/send-verification-code', {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-CSRF-TOKEN': csrfToken,
    },
    body: body,
  }).then(onAuthResponse, onAuthNetworkError).then(function (data) {
    if (data.success) {
      showVerifyMessage(data.message, false);
    } else {
      showVerifyMessage(data.message || 'Invio fallito.', true);
    }

    setButtonLoading(button, false, '', originalText);
  });
}

// Handler: submit AJAX dei form login/registrazione.
function onAuthFormSubmit(event) {
  event.preventDefault();

  const form = event.currentTarget;
  const submitButton = form.querySelector('button[type="submit"]');
  const originalText = submitButton ? submitButton.textContent : '';
  const csrfToken = getAuthCsrfToken();
  const formData = new FormData(form);

  if (!formData.has('_token')) {
    formData.append('_token', csrfToken);
  }

  setButtonLoading(submitButton, true, 'Invio in corso...', originalText);

  fetch(form.action, {
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'X-CSRF-TOKEN': csrfToken,
    },
    body: formData,
  }).then(onAuthResponse, onAuthNetworkError).then(function (data) {
    if (data.success) {
      window.location.href = '/';
      return;
    }

    showAuthMessage(data.message || 'Operazione fallita.', true);
    setButtonLoading(submitButton, false, '', originalText);
  });
}

function initPasswordToggles() {
  const buttons = document.querySelectorAll('.toggle-eye');

  for (const button of buttons) {
    button.addEventListener('click', onPasswordToggleClick);
  }
}

function initVerificationCodeSender() {
  const sendCodeButton = document.querySelector('#send-code-btn');

  if (sendCodeButton) {
    sendCodeButton.addEventListener('click', onSendCodeClick);
  }
}

function initAuthForms() {
  const forms = document.querySelectorAll('[data-auth-form]');

  for (const form of forms) {
    form.addEventListener('submit', onAuthFormSubmit);
  }
}

initPasswordToggles();
initVerificationCodeSender();
initAuthForms();

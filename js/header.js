const DROPDOWNS = {
  saldi: {
    trigger: '[data-dropdown-trigger="saldi"]',
    container: '[data-dropdown-menu="saldi"]',
    mode: "full"
  },
  // Dropdown full: occupa tutta la larghezza della navbar.
  stampanti: {
    trigger: '[data-dropdown-trigger="stampanti"]',
    container: '[data-dropdown-menu="stampanti"]',
    mode: "full"
  },
  ams: {
    trigger: '[data-dropdown-trigger="ams"]',
    container: '[data-dropdown-menu="ams"]',
    mode: "full"
  },
  filamenti: {
    trigger: '[data-dropdown-trigger="filamenti"]',
    container: '[data-dropdown-menu="filamenti"]',
    mode: "full"
  },
  accessori: {
    trigger: '[data-dropdown-trigger="accessori"]',
    container: '[data-dropdown-menu="accessori"]',
    mode: "full"
  },
  materiali: {
    trigger: '[data-dropdown-trigger="materiali"]',
    container: '[data-dropdown-menu="materiali"]',
    mode: "full"
  },
  makersupply: {
    trigger: '[data-dropdown-trigger="makersupply"]',
    container: '[data-dropdown-menu="makersupply"]',
    mode: "full"
  },
  // Dropdown simple: pannello piccolo sotto al trigger.
  supporto: {
    trigger: '[data-dropdown-trigger="supporto"]',
    container: '[data-dropdown-menu="supporto"]',
    mode: "simple"
  },
  user: {
    trigger: '[data-dropdown-trigger="user"]',
    container: '[data-dropdown-menu="user"]',
    mode: "simple"
  }
};

const cartBadges = Array.from(document.querySelectorAll('.cart-badge'));

function closeDropdown(dropdown) {
  dropdown.container.classList.add("hidden");
}

function openDropdown(dropdown) {
  if (dropdown.closeTimer) {
    clearTimeout(dropdown.closeTimer);
    dropdown.closeTimer = null;
  }

  dropdown.container.classList.remove("hidden");
}

function isInsideAnyTrigger(dropdown, relatedTarget) {
  return dropdown.triggers.some((trigger) => trigger.contains(relatedTarget));
}

// Evita la chiusura quando il mouse passa tra trigger e menu.
function staysInsideDropdown(dropdown, relatedTarget) {
  return (
    relatedTarget &&
    (isInsideAnyTrigger(dropdown, relatedTarget) || dropdown.container.contains(relatedTarget))
  );
}

Object.values(DROPDOWNS).forEach((dropdown) => {
  // Recupera trigger e container configurati nel markup.
  dropdown.triggers = Array.from(document.querySelectorAll(dropdown.trigger));
  dropdown.container = document.querySelector(dropdown.container);

  if (dropdown.triggers.length === 0 || !dropdown.container) return;

  dropdown.container.classList.add("dropdown-menu--" + dropdown.mode);
  dropdown.triggers.forEach((trigger) => trigger.classList.add("dropdown-trigger"));

  if (dropdown.mode === "simple") {
    // I dropdown simple usano un wrapper dedicato per il posizionamento.
    dropdown.trigger = dropdown.triggers[0];
    const parent = dropdown.trigger.parentElement;
    const root = document.createElement("div");
    root.className = "dropdown-root dropdown-root--simple";

    parent.insertBefore(root, dropdown.trigger);
    root.appendChild(dropdown.trigger);
    root.appendChild(dropdown.container);

    dropdown.root = root;

    dropdown.root.addEventListener("mouseenter", () => {
      openDropdown(dropdown);
    });

    dropdown.root.addEventListener("mouseleave", () => {
      dropdown.closeTimer = setTimeout(() => closeDropdown(dropdown), 50);
    });
  } else {
    // I dropdown full si aprono e si chiudono direttamente sul trigger e sul pannello.
    dropdown.triggers.forEach((trigger) => {
      trigger.addEventListener("mouseenter", () => {
        openDropdown(dropdown);
      });

      trigger.addEventListener("mouseleave", (event) => {
        if (staysInsideDropdown(dropdown, event.relatedTarget)) return;
        closeDropdown(dropdown);
      });
    });

    dropdown.container.addEventListener("mouseenter", () => {
      openDropdown(dropdown);
    });

    dropdown.container.addEventListener("mouseleave", (event) => {
      if (staysInsideDropdown(dropdown, event.relatedTarget)) return;
      closeDropdown(dropdown);
    });
  }

  if (dropdown.mode === "simple") {
    // Il click sui dropdown simple non deve navigare.
    dropdown.trigger.addEventListener("click", (event) => {
      event.preventDefault();
      dropdown.trigger.blur();
    });
  }
});

function updateCartBadge(count) {
  cartBadges.forEach((badge) => {
    if (!badge) return;

    if (count > 0) {
      badge.textContent = count > 99 ? '99+' : String(count);
      badge.style.display = 'inline-flex';
    } else {
      badge.textContent = '0';
      badge.style.display = 'none';
    }
  });
}

async function loadCartBadge() {
  if (!cartBadges.length) return;

  try {
    const response = await fetch('app/api/api_cart.php', {
      headers: { Accept: 'application/json' },
    });

    if (response.status === 401) {
      updateCartBadge(0);
      return;
    }

    if (!response.ok) {
      updateCartBadge(0);
      return;
    }

    const items = await response.json();
    const count = Array.isArray(items)
      ? items.reduce((sum, item) => sum + Number(item?.quantity || 0), 0)
      : 0;

    updateCartBadge(count);
  } catch (_error) {
    updateCartBadge(0);
  }
}

window.refreshCartBadge = loadCartBadge;
loadCartBadge();

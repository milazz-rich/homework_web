const DROPDOWNS = {
  // Dropdown full: occupa tutta la larghezza della navbar.
  saldi: {
    trigger: '[data-dropdown-trigger="saldi"]',
    container: '[data-dropdown-menu="saldi"]',
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

// Evita la chiusura quando il mouse passa tra trigger e menu.
function staysInsideDropdown(dropdown, relatedTarget) {
  return (
    relatedTarget &&
    (dropdown.trigger.contains(relatedTarget) || dropdown.container.contains(relatedTarget))
  );
}

Object.values(DROPDOWNS).forEach((dropdown) => {
  // Recupera trigger e container configurati nel markup.
  dropdown.trigger = document.querySelector(dropdown.trigger);
  dropdown.container = document.querySelector(dropdown.container);

  if (!dropdown.trigger || !dropdown.container) return;

  dropdown.container.classList.add("dropdown-menu--" + dropdown.mode);
  dropdown.trigger.classList.add("dropdown-trigger");

  if (dropdown.mode === "simple") {
    // I dropdown simple usano un wrapper dedicato per il posizionamento.
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
    dropdown.trigger.addEventListener("mouseenter", () => {
      openDropdown(dropdown);
    });

    dropdown.container.addEventListener("mouseenter", () => {
      openDropdown(dropdown);
    });

    dropdown.trigger.addEventListener("mouseleave", (event) => {
      if (staysInsideDropdown(dropdown, event.relatedTarget)) return;
      dropdown.closeTimer = setTimeout(() => closeDropdown(dropdownf), 50);
    });

    dropdown.container.addEventListener("mouseleave", (event) => {
      if (staysInsideDropdown(dropdown, event.relatedTarget)) return;
      dropdown.closeTimer = setTimeout(() => closeDropdown(dropdown), 50);
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

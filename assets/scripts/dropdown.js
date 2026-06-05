function createDropdown(triggerElement, dropdownHTML) {
  if (!triggerElement) return null;

  const dropdown = document.createElement("div");
  dropdown.className = "dropdown-menu";
  dropdown.innerHTML = dropdownHTML;
  dropdown.hidden = true;

  const parent = triggerElement.parentElement;
  if (!parent) return null;

  parent.appendChild(dropdown);

  triggerElement.addEventListener("click", (event) => {
    event.preventDefault();
    event.stopPropagation();
    dropdown.hidden = !dropdown.hidden;
  });

  document.addEventListener("click", (event) => {
    if (!dropdown.contains(event.target) && event.target !== triggerElement) {
      dropdown.hidden = true;
    }
  });

  return dropdown;
}

function initSupportDropdown() {
  const supportLinks = document.querySelectorAll('[data-menu="supporto"]');

  supportLinks.forEach((link) => {
    if (link.dataset.dropdownReady === "true") return;
    link.dataset.dropdownReady = "true";

    createDropdown(
      link,
      '<div class="dropdown-menu-title">Supporto</div>' +
        '<a href="#">FAQ</a>' +
        '<a href="#">Contattaci</a>' +
        '<a href="#">Stato ordine</a>'
    );
  });
}

initSupportDropdown();

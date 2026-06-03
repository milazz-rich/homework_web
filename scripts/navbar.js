const navbar = {
  elements: {
    root: document.querySelector(".navbar"),
    dropdown: document.querySelector("#navbarDropdown"),
    links: Array.from(document.querySelectorAll(".dropdown-link")),
    panels: Array.from(document.querySelectorAll(".dropdown-panel")),
    supportWrapper: document.querySelector(".supporto-dropdown"),
    supportTrigger: document.querySelector(".supporto-trigger"),
    supportMenu: document.querySelector(".supporto-menu")
  },
  state: {
    activeMenu: ""
  }
};

function showElement(element) {
  if (element) element.classList.remove("is-hidden");
}

function hideElement(element) {
  if (element) element.classList.add("is-hidden");
}

function closeAllPanels() {
  navbar.elements.panels.forEach(hideElement);
}

function closeDropdown() {
  hideElement(navbar.elements.dropdown);
  closeAllPanels();
  navbar.state.activeMenu = "";
}

function openDropdown(menuName) {
  const panel = document.querySelector(`.dropdown-panel[data-panel="${menuName}"]`);
  if (!navbar.elements.dropdown || !panel) return;

  closeAllPanels();
  showElement(panel);
  showElement(navbar.elements.dropdown);
  navbar.state.activeMenu = menuName;
}

function closeSupportMenu() {
  const { supportWrapper, supportMenu } = navbar.elements;
  if (!supportWrapper || !supportMenu) return;

  supportWrapper.classList.remove("open");
  hideElement(supportMenu);
}

function toggleSupportMenu() {
  const { supportWrapper, supportMenu } = navbar.elements;
  if (!supportWrapper || !supportMenu) return;

  const isOpen = !supportMenu.classList.contains("is-hidden");
  if (isOpen) {
    closeSupportMenu();
    return;
  }

  supportWrapper.classList.add("open");
  showElement(supportMenu);
}

function onDropdownClick(event, link) {
  if (!navbar.elements.dropdown) return;

  event.preventDefault();
  event.stopPropagation();

  const menuName = link.dataset.menu;
  const isSameMenuOpen =
    !navbar.elements.dropdown.classList.contains("is-hidden") &&
    navbar.state.activeMenu === menuName;

  closeSupportMenu();

  if (isSameMenuOpen) {
    closeDropdown();
    return;
  }

  openDropdown(menuName);
}

function onSupportClick(event) {
  event.preventDefault();
  event.stopPropagation();

  closeDropdown();
  toggleSupportMenu();
}

function onOutsideClick(event) {
  const insideNavbar = navbar.elements.root && navbar.elements.root.contains(event.target);
  if (insideNavbar) return;

  closeDropdown();
  closeSupportMenu();
}

function initNavbar() {
  navbar.elements.links.forEach(function (link) {
    link.addEventListener("click", function (event) {
      onDropdownClick(event, link);
    });
  });

  if (navbar.elements.supportTrigger) {
    navbar.elements.supportTrigger.addEventListener("click", onSupportClick);
  }

  document.addEventListener("click", onOutsideClick);
}

initNavbar();

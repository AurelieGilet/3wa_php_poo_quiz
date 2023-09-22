// Handle clicks outside of the menu dropdown (to close it)
function handleClickOutsideMenu(event) {
    const { target } = event;

    if (!target.matches('#options-menu, #nav-options')) {
        const optionsButton = document.getElementById('nav-options');

        toggleMobileMenu(optionsButton);
    }
}

// Open/close navigation dropdown
function toggleMobileMenu(optionsButton) {
    const expanded = optionsButton.getAttribute('aria-expanded') === 'true';

    optionsButton.setAttribute('aria-expanded', String(!expanded));

    /**
     * We add the handleClickOutsideMenu event listener only if the menu dropdown is open,
     * otherwise we remove it to avoid having unnecessary active event listener on the document
     */
    if (expanded) {
        optionsButton.classList.replace('icon-options-hover', 'icon-options');

        optionsMenu.classList.remove('show');

        document.removeEventListener('click', handleClickOutsideMenu);
    } else {
        optionsButton.classList.replace('icon-options', 'icon-options-hover');

        optionsMenu.classList.add('show');

        document.addEventListener('click', handleClickOutsideMenu);
    }
}

const optionsButton = document.getElementById('nav-options');
const optionsMenu = document.getElementById('options-menu');

if (optionsButton) {
    optionsButton.addEventListener('click', () => {
        toggleMobileMenu(optionsButton);
    })
}

window.addEventListener('resize', () => {
    optionsButton.classList.replace('icon-options-hover', 'icon-options');
    optionsButton.setAttribute('aria-expanded', 'false');
    optionsMenu.classList.remove('show');
    document.removeEventListener('click', handleClickOutsideMenu);
});
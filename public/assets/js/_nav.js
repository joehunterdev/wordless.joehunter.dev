/* ==========================================================================
   _nav.js — active link highlight + mobile menu toggle
   ========================================================================== */

// Mark the current page link as active
const currentPath = window.location.pathname.replace(/\/$/, '') || '/';

document.querySelectorAll('.site-nav a').forEach(link => {
    const linkPath = new URL(link.href).pathname.replace(/\/$/, '') || '/';
    if (linkPath === currentPath) {
        link.setAttribute('aria-current', 'page');
    }
});

// Mobile menu toggle — looks for a [data-nav-toggle] button in the markup
const toggle = document.querySelector('[data-nav-toggle]');
const nav    = document.querySelector('.site-nav');

if (toggle && nav) {
    toggle.addEventListener('click', () => {
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!expanded));
        nav.toggleAttribute('data-open', !expanded);
    });
}

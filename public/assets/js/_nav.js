/* ==========================================================================
   _nav.js — Navigation functionality
   ========================================================================== */

// Mobile menu toggle (called from HTML onclick)
function toggleMobileMenu() {
    const nav = document.querySelector('.site-nav');
    if (nav) {
        nav.classList.toggle('show');
    }
}

// Expose to global scope (required because app.js is type="module")
window.toggleMobileMenu = toggleMobileMenu;

// Tap-to-toggle submenus on mobile
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.dropdown > a').forEach(link => {
        link.addEventListener('click', e => {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const dropdown = link.parentElement;
                dropdown.classList.toggle('open');
            }
        });
    });
});

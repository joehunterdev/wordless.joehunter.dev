/* ==========================================================================
   _nav.js — Simple navigation functionality
   ========================================================================== */

// Mobile menu toggle function (called from HTML onclick)
function toggleMobileMenu() {
    const nav = document.querySelector('.site-nav');
    if (nav) {
        nav.classList.toggle('mobile-open');
    }
}

// Simple dropdown hover for desktop
document.addEventListener('DOMContentLoaded', () => {
    // No complex JS needed - CSS handles hover states
});

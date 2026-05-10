/* ==========================================================================
   _nav.js — Simple navigation functionality
   ========================================================================== */

// Mobile menu toggle function (called from HTML onclick)
function toggleMobileMenu() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        navbar.classList.toggle('show');
    }
}

// Simple dropdown hover for desktop
document.addEventListener('DOMContentLoaded', () => {
    // No complex JS needed - CSS handles hover states
});

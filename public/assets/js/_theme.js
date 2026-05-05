/* ==========================================================================
   _theme.js — dark / light mode toggle, persists to localStorage
   ========================================================================== */

const STORAGE_KEY = 'wordless-theme';
const root        = document.documentElement;

// Apply stored preference before first paint (script is deferred via module)
const stored = localStorage.getItem(STORAGE_KEY);
if (stored) {
    root.setAttribute('data-theme', stored);
}

// Wire up any [data-theme-toggle] button in the markup
const btn = document.querySelector('[data-theme-toggle]');

if (btn) {
    btn.addEventListener('click', () => {
        const current = root.getAttribute('data-theme');
        const next    = current === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        localStorage.setItem(STORAGE_KEY, next);
        btn.setAttribute('aria-label', `Switch to ${current === 'dark' ? 'light' : 'dark'} mode`);
    });
}

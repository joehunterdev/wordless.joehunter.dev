/* ==========================================================================
   _code.js — copy-to-clipboard button on every <pre><code> block
   ========================================================================== */

const LABEL_COPY    = 'Copy';
const LABEL_COPIED  = 'Copied!';
const RESET_DELAY   = 2000;

document.querySelectorAll('pre code').forEach(block => {
    const pre = block.parentElement;
    pre.style.position = 'relative';

    const btn = document.createElement('button');
    btn.className   = 'copy-btn';
    btn.textContent = LABEL_COPY;
    btn.setAttribute('aria-label', 'Copy code to clipboard');

    btn.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(block.textContent ?? '');
            btn.textContent = LABEL_COPIED;
            btn.disabled    = true;
            setTimeout(() => {
                btn.textContent = LABEL_COPY;
                btn.disabled    = false;
            }, RESET_DELAY);
        } catch {
            btn.textContent = 'Failed';
        }
    });

    pre.appendChild(btn);
});

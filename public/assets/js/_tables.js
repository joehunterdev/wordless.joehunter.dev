/* ==========================================================================
   _tables.js — sortable columns on tables with [data-sortable]
   ========================================================================== */

document.querySelectorAll('table[data-sortable]').forEach(table => {
    const headers = table.querySelectorAll('thead th');

    headers.forEach((th, colIndex) => {
        th.style.cursor = 'pointer';
        th.setAttribute('aria-sort', 'none');
        th.title = `Sort by ${th.textContent.trim()}`;
        th.addEventListener('click', () => {
            const ascending = th.getAttribute('aria-sort') !== 'ascending';
            sortTable(table, colIndex, ascending);

            headers.forEach(h => h.setAttribute('aria-sort', 'none'));
            th.setAttribute('aria-sort', ascending ? 'ascending' : 'descending');
        });
    });
});

/**
 * @param {HTMLTableElement} table
 * @param {number}           col
 * @param {boolean}          ascending
 */
function sortTable(table, col, ascending) {
    const tbody = table.querySelector('tbody');
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((a, b) => {
        const aText = a.cells[col]?.textContent.trim() ?? '';
        const bText = b.cells[col]?.textContent.trim() ?? '';
        return ascending
            ? aText.localeCompare(bText, undefined, { numeric: true })
            : bText.localeCompare(aText, undefined, { numeric: true });
    });

    rows.forEach(row => tbody.appendChild(row));
}

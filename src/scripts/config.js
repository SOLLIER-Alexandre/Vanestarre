/**
 * Script for the config page
 *
 * @author CHATEAUX Adrien
 */

(() => {
    window.addEventListener('load', () => {
        const arrowDownIcons = document.getElementsByClassName('arrow-down-icon');

        for (const arrowDownIcon of arrowDownIcons) {
            arrowDownIcon.addEventListener('click', () => {
                // Expand the parent table-line
                const tableLine = arrowDownIcon.parentElement.parentElement.parentElement;
                tableLine.classList.toggle('expanded');
            });
        }
    });
})();
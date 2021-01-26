/**
 * Script for the config page
 *
 * @author CHATEAUX Adrien
 */

(() => {
    window.addEventListener('load', () => {
        const arrowDownClass = document.getElementsByClassName('arrow-down');

        for (const arrowDown of arrowDownClass) {
            arrowDown.addEventListener('click', () => {
                const tableLine = arrowDown.parentElement.parentElement;
                const icon = arrowDown.children[0];
                tableLine.classList.toggle('expanded');
            });
        }
    });
})();
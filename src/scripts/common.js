/**
 * Common script present on every page of the website
 *
 * @author SOLLIER Alexandre
 */

(() => {
    const header = document.getElementById('header');
    const searchButton = document.getElementById('search-btn');
    const searchBox = document.getElementById('search-box');

    if (header !== null && searchButton !== null && searchBox !== null) {
        // Focus the search box when touching the search button (on mobile devices)
        searchButton.onclick = () => {
            header.classList.add('search-shown');
            searchBox.focus();
        };

        // Un-hide everything when the search box is unfocused
        searchBox.onblur = () => {
            header.classList.remove('search-shown');
        };
    }
})();
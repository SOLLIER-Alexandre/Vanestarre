/**
 * Script used on the account page
 *
 * @author CHATEAUX Adrien
 */

(() => {
    window.addEventListener('load', () => {
        document.getElementById('show_form_button').onclick = () => {
            document.getElementById('pwd_change_frame').style.display = 'block';
            document.getElementById('show_form_button').remove();
        };
    });
})();
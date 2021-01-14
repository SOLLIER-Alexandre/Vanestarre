/**
 * Script used on the account page
 *
 * @author CHATEAUX Adrien
 */

(() => {
    window.onload = () =>
    {
        document.getElementById('show_form_button').onclick = () =>
        {
            document.getElementById('form_modif_pwd').style.visibility = 'visible';
            document.getElementById('show_form_button').style.visibility = 'hidden';
        };
    };
})();
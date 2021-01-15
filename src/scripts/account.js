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
            document.getElementById('pwd_change_frame').style.visibility = 'visible';
            var pwd_change_frame = document.getElementById('pwd_change_frame');
            document.getElementById('pwd_change_frame').remove()
            document.getElementById('main_frame').appendChild(pwd_change_frame);
            document.getElementById('show_form_button').remove();
        };
    };
})();
<?php
    // Set the HTTP response code to 404
    http_response_code(404);

    echo <<<HTML
    <h1>Erreur 404</h1>
    <p>Vous avez essayé d'acceder a une page non autorisé de Vanéstarre, le meilleur site internet des interwebs.</p>
    <p>Vous êtes un monstre!</p>
    HTML;
?>
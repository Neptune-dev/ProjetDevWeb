<?php

////////////////////////////////////////////
// ROUTEUR, NE PAS TOUCHER POUR L'INSTANT //
////////////////////////////////////////////

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //récupération de l'URL de la requete HTTP du client

//supression des éléments non nécessaires
$uri = rtrim($uri, 'projet_paris_sportifs/'); //spécifique à l'utilisation de XAMPP, à adapter une fois en production

//routing
switch ($uri) {
    case '':
        require 'views/homepage.php';
        break;
    
    default:
        http_response_code(404);
        echo "404 - Not Found";
        break;
}

?>
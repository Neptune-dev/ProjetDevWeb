<?php

////////////////////////////////////////////
// ROUTEUR, NE PAS TOUCHER POUR L'INSTANT //
////////////////////////////////////////////

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); //récupération de l'URL de la requete HTTP du client

//supression des éléments non nécessaires
$uri = rtrim($uri, '/');

// recupération du dossier du projet (ex: /site_paris_sportifs)
$base = dirname($_SERVER['SCRIPT_NAME']);
$base = rtrim($base, '/');

// retire la base du chemin
if ($base !== '' && str_starts_with($uri, $base)) {
    $route = substr($uri, strlen($base));
    $route = $route ?: '/';
} else {
    $route = $uri;
}

//routing
switch ($route) {
    case '/':
        require 'views/homepage.php';
        break;
    
    case '/login':
        require 'routes/login.php';
        break;

    case '/signin':
        require 'routes/signin.php';
        break;

    case '/admin_panel':
        require 'routes/admin_panel.php';
        break;

    case '/401':
        require 'routes/401.php';
        break;

    default:
        require 'routes/404.php';
        break;
}

?>
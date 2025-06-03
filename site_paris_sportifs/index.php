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

    case '/mon_compte':
        require 'routes/mon_compte.php';
        break;
    
    case '/logout':
        require 'routes/logout.php';
        break;

    case '/reward_ad':
        require 'routes/reward_ad.php';
        break;

    // NE FONCTIONNE PAS ENCORE
    case preg_match('#^/game_view/(\d+)$#', $route, $matches):
        $_GET['game_id'] = $matches[1];
        require 'routes/game_view.php';
        break;

    // http status codes d'exception
    case '/401':
        require 'routes/401.php';
        break;
    
    default:
        require 'routes/404.php';
        break;
}

?>
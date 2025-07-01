<?php

////////////////////////////////////////////
//                ROUTEUR                 //
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

// On s'assure que $route ne contient pas de query string (sécurité supplémentaire)
$route = strtok($route, '?');

//routing
switch ($route) {
    case '/':
        require 'routes/homepage.php';
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

    case '/game_panel':
        require 'routes/game_panel.php';
        break;

    case '/mon_compte':
        require 'routes/mon_compte.php';
        break;

    case '/bet':
        require 'routes/bet.php';
        break;
    
    case '/logout':
        require 'routes/logout.php';
        break;

    case '/reward_ad':
        require 'routes/reward_ad.php';
        break;

    // http status codes d'exception
    case '/400':
        require 'routes/errors/400.php';
        break;
    
    case '/401':
        require 'routes/errors/401.php';
        break;

    case '/402':
        require 'routes/errors/402.php';
        break;

    case '/404':
        require 'routes/errors/404.php';
        break;
    
    default:
        require 'routes/errors/404.php';
        break;
}

?>
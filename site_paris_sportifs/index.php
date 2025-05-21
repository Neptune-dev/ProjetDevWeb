<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = rtrim($uri, 'projet_paris_sportifs/');

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
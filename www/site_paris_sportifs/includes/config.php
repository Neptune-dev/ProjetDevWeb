<?php

// c'est ici qu'on met les valeurs de configuration
// notamment pour les tests

$dbName = 'SiteParis';
$addr = getenv('DB_HOST') ?: 'localhost:3307'; //défaut = localhost:3307 | avec docker = variable d'environnement
$MySQLusername = 'root';
$MySQLpwd = '';

$baseMoney = 10000;

?>
<?php

    //fichier qui contient des fonctions php que l'on veut delocaliser
    //notamment quand elles utilisent des valeurs qui doivent etre configuer au moment du test
    //ça évite de devoir chercher dans le code où changer le port du serveur par exemple
    //ces valeurs sont stockées dans /includes/config.php

    //on va chercher la config
    require_once('includes/config.php');

    function openDB() {
        $pdo = new PDO('mysql:host='.$GLOBALS['addr'].';dbname='.$GLOBALS['dbName'], $GLOBALS['MySQLusername'], $GLOBALS['MySQLpwd']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    function checkAdmin () {
        if ($_SESSION["user"]["isAdmin"] != 1) {
        header("Location: /site_paris_sportifs/401");
        exit();
        }
    }

?>
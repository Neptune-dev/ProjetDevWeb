<?php
//page de l'admin
ob_start();
?>

<!--contenu de la page -->
<?php
session_start();
require_once('includes/helpers.php');

if (!isset($_SESSION['user'])) {
    header("Location: /site_paris_sportifs/login");
    exit();
}
$user = $_SESSION['user'];

$pdo = openDB();
?>

<h1 class="titre_orange">Coming soon...</h1>

<!--fin du contenu -->
<?php
$title = 'Classé'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
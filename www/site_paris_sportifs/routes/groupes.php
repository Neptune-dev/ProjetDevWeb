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


<!--fin du contenu -->
<?php
$title = 'Groupes Amis'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
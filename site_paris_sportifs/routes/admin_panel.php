<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<h1>Panneau de configuration admin</h1>

<?php
session_start();

// sécurité
if ($_SESSION["user"]["isAdmin"] != 1) {
    header("Location: /site_paris_sportifs/401");
    exit();
}



?>

<!--fin du contenu -->
<?php
$title = 'Admin Panel'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
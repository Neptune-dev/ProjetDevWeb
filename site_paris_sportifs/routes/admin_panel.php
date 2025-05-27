<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<?php
session_start();

// sécurité
require_once('includes/helpers.php');
checkAdmin();


?>

<h1>Panneau de configuration administrateur</h1>

<a href="/site_paris_sportifs/createGame">Créer un match</a>
<a href="/site_paris_sportifs/modifyGame">Modifier un match</a>


<!--fin du contenu -->
<?php
$title = 'Admin Panel'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
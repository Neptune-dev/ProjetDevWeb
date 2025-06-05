<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<h1>Votre Paris</h1>

<!--fin du contenu -->
<?php
$title = 'Bet'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
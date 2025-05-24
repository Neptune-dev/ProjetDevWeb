<?php
//page d'erreur 404
ob_start();
?>

<!--contenu de la page -->

<h1>404 - Not Found</h1>

<?php
$title = '404'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
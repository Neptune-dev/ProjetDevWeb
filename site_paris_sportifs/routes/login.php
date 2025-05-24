<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<h1>Login</h1>

<?php
$title = 'Login'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
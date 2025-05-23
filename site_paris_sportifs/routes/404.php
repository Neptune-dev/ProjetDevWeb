<?php
//page d'erreur 404
ob_start();
?>

<h1>404 - Not Found</h1>

<?php
$content = ob_get_clean();
require 'views/base.php';
?>
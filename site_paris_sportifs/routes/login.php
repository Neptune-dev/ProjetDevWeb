<?php
//page de login
ob_start();
?>

<h1>Login</h1>

<?php
$content = ob_get_clean();
require 'views/base.php';
?>
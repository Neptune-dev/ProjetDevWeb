<?php
//page d'erreur 404
ob_start();
?>

<!--contenu de la page -->
<?php http_response_code(401); ?>
<br><br><br>
<h1>401 - Unauthorized</h1>

<p>Une authentification est nécessaire pour accéder à la ressource.</p>

<!--fin du contenu -->
<?php
$title = '401'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
<?php
//page d'erreur 404
ob_start();
?>

<!--contenu de la page -->

<?php http_response_code(404); ?>

<h1>404 - Not Found</h1>

<p>L'URL suivante n'a pas été trouvée : <?= $route ?></p>

<!--fin du contenu -->
<?php
$title = '404'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
<?php
//page d'erreur 400
ob_start();
?>

<!--contenu de la page -->
<?php http_response_code(400); ?>
<br><br><br>
<div class="NotFound">
    <h1>400 - Bad Request</h1>
    <h2 id="message">Chargement du message...</h2>
    <p>La syntaxe de la requête est erronée.</p><br>
    <a href="/site_paris_sportifs/">Retour au terrain</a>
</div>

<script>
    const messages = [
        "Faudra peut-être des messages rigolos ici"
    ];

    const messageElement = document.getElementById("message");
    const randomIndex = Math.floor(Math.random() * messages.length);
    messageElement.textContent = messages[randomIndex];
  </script>

<!--fin du contenu -->
<?php
$title = '400'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
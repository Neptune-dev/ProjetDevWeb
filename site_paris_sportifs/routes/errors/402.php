<?php
//page d'erreur 402
ob_start();
?>

<!--contenu de la page -->
<?php http_response_code(402); ?>
<br><br><br>
<div class="NotFound">
    <h1>402 - Payment Required</h1>
    <h2 id="message">Chargement du message...</h2>
    <p>Paiement requis, ou fonds insuffisants pour accéder à la ressource.</p><br>
    <a href="/site_paris_sportifs/">Retour au terrain</a>
</div>

<script>
    const messages = [
        "Il faut des phrases sympas ici aussi"
    ];

    const messageElement = document.getElementById("message");
    const randomIndex = Math.floor(Math.random() * messages.length);
    messageElement.textContent = messages[randomIndex];
  </script>

<!--fin du contenu -->
<?php
$title = '402'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
<?php
//page d'erreur 401
ob_start();
?>

<!--contenu de la page -->
<?php http_response_code(401); ?>

<div class="NotFound">
    <h1>401 - Unauthorized</h1>
    <h2 id="message">Chargement du message...</h2>
    <p>Une authentification administrateur est nécessaire pour accéder à la ressource.</p><br>
    <a href="/site_paris_sportifs/">Retour au terrain</a>
</div>

<script>
    const messages = [
        "Le football il a changé... Mais pas notre sécurité.",
        "Coup de sifflet ! T’es hors-jeu sur cette page.",
        "Pas de carton rouge… mais tu n’as pas le brassard d’administrateur non plus.",
        "On t’a vu tenter un dribble dans les coulisses… mais sans mot de passe, tu restes sur le banc.",
        "Cette zone est réservée aux coachs. Les supporters restent en tribune.",
        "Tentative de tir depuis l’extérieur de la zone autorisée. Résultat : 401.",
        "Penalty refusé. Il faut plus qu’une simple feinte pour accéder ici.",
        "Tu bluffes comme Neymar, mais l’arbitre n’est pas dupe.",
        "Oops ! Tu n’as pas signé le contrat pro pour accéder à ces pages.",
        "La VAR a parlé : accès refusé.",
        "Les vestiaires des admins sont interdits aux visiteurs. Va t’échauffer ailleurs.",
        "Cette page est comme un but refusé : hors-jeu !",
        "L'arbitre est formel : vous n'entrez pas dans le terrain sans autorisation.",
        "T'as pas le bon maillot, tu dois être sur le mauvais terrain...",
        "T'as demandé au coach ? Il m'a dit de t'empêcher de passer. Désolé !",
        "Hors limites ! Cette zone est réservée au staff technique.",
        "Coup de sifflet final pour vous sur cette page. Vous ne pouvez pas entrer.",
        "Carton jaune : vous approchez d'une zone sensible. Faites demi-tour.",
        "On tond la pelouse du terrain. Accès interdit au public.",
        "La direction a statué : vous n'êtes pas sur la liste pour cette page.",
        "Le vestiaire est privé. Le public ne peut pas y entrer.",
        "Faute de main ! Tu n'as pas les autorisations nécessaires.",
        "Changement de stratégie : cette page ne t'est pas ouverte."
    ];

    const messageElement = document.getElementById("message");
    const randomIndex = Math.floor(Math.random() * messages.length);
    messageElement.textContent = messages[randomIndex];
  </script>

<!--fin du contenu -->
<?php
$title = '401'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
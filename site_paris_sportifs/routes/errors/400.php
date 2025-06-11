<?php
//page d'erreur 400
ob_start();
?>

<!--contenu de la page -->
<?php http_response_code(400); ?>

<div class="NotFound">
    <h1>400 - Bad Request</h1>
    <h2 id="message">Chargement du message...</h2>
    <p>La syntaxe de la requête est erronée.</p><br>
    <a href="/site_paris_sportifs/">Retour au terrain</a>
</div>

<script>
    const messages = [
        "Vous avez tenté un coup tactique... mais vous êtes hors-jeu dès l’URL.",
        "Stratégie risquée : modifier l’URL ne fait pas grimper les cotes.",
        "Vous avez essayé de bluffer le serveur, il a checké… et vous a vu.",
        "Cette combinaison d'URL n'existe pas, même pas dans Football Manager.",
        "Erreur 400 : Vous tentez un dribble dans un couloir sans issue.",
        "Le bookmaker n'aime pas les URL bricolées à la main.",
        "Manipuler l’URL ? C’est comme tirer un penalty les yeux fermés.",
        "Votre navigateur a tenté une percée... droit dans le mur.",
        "On ne gagne pas un pari en essayant de pirater la page.",
        "Coup tactique raté : ce lien n’est pas dans le plan de jeu.",
        "Votre demande est aussi bancale qu’un tacle par derrière.",
        "On dirait que vous avez tenté une feinte… sur le serveur.",
        "Vous n’êtes pas un hacker, juste un mauvais passeur d’URL.",
        "Ce lien est plus inventé qu’un but refusé par la VAR.",
        "Il fallait parier, pas programmer un raccourci HTML.",
        "Aucune cote ne couvre ce genre de tentative hasardeuse.",
        "Votre requête est en faute technique : ballon perdu.",
        "Pas de triche ici, on joue selon les règles (et les routes).",
        "Cette page n’a pas été validée par l’arbitre du protocole HTTP.",
        "Tentative de corner direct… vers nulle part.",
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
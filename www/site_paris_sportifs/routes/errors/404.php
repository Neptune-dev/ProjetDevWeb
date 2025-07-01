<?php
//page d'erreur 404
ob_start();
?>

<!--contenu de la page -->
<?php http_response_code(404); ?>

<div class="NotFound">
    <h1>404 - Not Found</h1>
    <h2 id="message">Chargement du message...</h2>
    <p>La ressource suivante n'a pas été trouvée :
        <?php
        // si la ressource manquante est spécifiée en query parameter, celle-ci est affichée,
        // sinon c'est l'URI de la requete qui est affichée
        if (isset($_GET["ressource"])) {
            echo $_GET["ressource"];
        } else {
            echo $route;
        }
        ?>
    </p><br>
    <a href="/site_paris_sportifs/">Retour au terrain</a>
</div>

<script>
    const messages = [
        "Ma chérie tu es à contre-sens... Reviens dans le match.",
        "Vous êtes hors-jeu ! Cette page n'existe pas.",
        "Page inexistante... comme vos gains.",
        "Oups, ce pari n'était pas gagnant.",
        "Pas de bol ! Cette page est hors-cote.",
        "Page introuvable… comme la VAR en Ligue 2.",
        "Cette page est aussi perdue que vos paris combinés.",
        "Mauvais pari... Cette page ne rapporte rien.",
        "Vous avez misé sur la mauvaise URL.",
        "Carton rouge ! Cette page est exclue du site.",
        "C'est le moment de cash out, cette page n'existe pas.",
        "On a vérifié à la VAR... il n'y a vraiment rien ici.",
        "Cette page est suspendue pour simulation.",
        "Pas de cote pour cette page, elle est introuvable.",
        "But refusé ! Vous êtes hors de la zone de jeu.",
        "C'était presque ça... mais vous avez raté la page gagnante.",
        "Même la VAR n'a pas retrouvé cette page.",
        "Votre navigateur tente une passe en profondeur... vers nulle part.",
        "Cette cote était trop belle pour être vraie.",
        "Page introuvable… mais on vous félicite pour l’audace.",
        "La page que vous cherchez est en position de hors-jeu.",
        "Cette page a été transférée au mercato. On ne sait pas où.",
        "Pas de page ici. Comme d’hab, vous avez tenté un truc risqué.",
        "La page que vous cherchez est dans le vestiaire, on dirait.",
        "Cette page est aussi fiable qu’un combiné à 9 matchs.",
        "Erreur 404 : comme votre dernier ticket, elle n’a mené nulle part.",
        "Cette page est introuvable, comme la défense de votre équipe préférée.",
        "Cette page est aussi introuvable que le dernier but de votre attaquant.",
        "Erreur 404 : comme votre dernier ticket, elle n’a mené nulle part.",
        "Page 404 : même l’arbitre ne l’a pas vue venir.",
    ];

    const messageElement = document.getElementById("message");
    const randomIndex = Math.floor(Math.random() * messages.length);
    messageElement.textContent = messages[randomIndex];
  </script>



<!--fin du contenu -->
<?php
$title = '404'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
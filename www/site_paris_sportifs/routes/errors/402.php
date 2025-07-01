<?php
//page d'erreur 402
ob_start();
?>

<!--contenu de la page -->
<?php http_response_code(402); ?>

<div class="NotFound">
    <h3>402 - Payment Required</h3>
    <h2 id="message">Chargement du message...</h2>
    <p>Paiement requis, ou fonds insuffisants pour accéder à la ressource.</p><br>
    <a href="/site_paris_sportifs/">Retour au terrain</a>
</div>

<script>
    const messages = [
        "Pas assez de fonds pour parier, même sur un match de Ligue 2.",
        "Vous avez misé plus que votre solde, c'est un carton rouge direct !",
        "Pas de thunes, pas de paris. C'est la règle du jeu.",
        "Vous avez tenté un tir au but sans ballon, échec total.",
        "Votre compte est à sec, comme les filets après un match nul.",
        "Pas de paiement, pas de jeu. C'est la loi du sport.",
        "Vous avez oublié de recharger votre compte avant le coup d'envoi.",
        "C'est le moment de faire un dépôt, sinon c'est la fin du match.",
        "Votre solde est aussi bas que les côtes d'un match sans enjeu.",
        "Pas de fonds, pas de victoire. C'est aussi simple que ça.",
        "Votre compte est vide, comme les rêves de ceux qui ne parient pas.",
        "Vous avez tenté un pari… mais votre compte est à sec.",
        "Votre solde est aussi vide qu’un stade sans supporters.",
        "Pas de fonds, pas de fun. Retournez à la case départ.",
        "Votre compte est à sec, comme un terrain en plein été.",
        "Votre portefeuille fait grève, il doit être français.",
        "Cagnotte à sec ! Il est temps de faire un virement… ou une prière.",
        "Vous êtes à sec… même le croupier a eu pitié.",
        "Balance insuffisante… mais votre optimisme est admirable.",
        "On ne peut pas miser l’espoir, désolé.",
        "Votre banquier vous regarde avec désespoir.",
        "Pas d’argent, pas de pari. Pas de pari, pas de souci.",
        "Même la VAR confirme : vous êtes fauché.",
        "On ne prend pas les chèques en bois.",
        "C’est bien d’y croire… mais pas sans argent.",
        "Cash out ? Il n’y a même pas de cash in.",
        "Vous jouez à découvert… mais pas chez nous.",
        "Il faut plus que de la foi pour miser ici.",
        "Votre mise est partie... avec vos économies.",
        "Le bookmaker vous envoie ses condoléances financières.",
        "Pas assez pour miser ? Allez tenter votre chance au Monopoly.",
        "Besoin d'argent ? Faites un crédit !",
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
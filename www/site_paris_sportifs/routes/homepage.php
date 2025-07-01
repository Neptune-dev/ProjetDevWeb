<?php
//page d'acceuil
ob_start();
?>

<!--contenu de la page -->

<?php
session_start();
require_once('includes/helpers.php');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    $pdo = openDB();

    // Récupération du solde
    $stmt = $pdo->prepare("SELECT Balance FROM Wallets WHERE UserID = ?");
    $stmt->execute([$user["ID"]]);
    $wallet = $stmt->fetch();

    $balance = $wallet ? $wallet["Balance"] : 0;
}

?>

<section class="TopPari">
    <h1>Matchs de la semaine</h1>
    <?php

    require_once 'includes/helpers.php';
    calcOdds(); // mise à jour des dernières cotes
    $pdo = openDB();
    $stmt = $pdo->prepare("SELECT * FROM Games");
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($games as $game) {
        if (!isset($game['H2H'])) {
            $_GET["gameID"] = $game['ID'];
            require ('views/game_view.php');
        }
    }
    ?>
</section>


<div class="contact-wrapper">
    <section class="Contact">
        <h2>Contactez-nous</h2>
        <form class="contactForm" action="https://formspree.io/f/xgvkgzoq" method="POST">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" required>

            <label for="email">Email :</label>
            <input type="email" name="email" required>

            <label for="message">Message :</label>
            <textarea name="message" rows="5" required></textarea>

            <button type="submit">Envoyer</button>
            <p class="msg"></p>
        </form>
    </section>
</div>
<script src="/site_paris_sportifs/public/js/script.js"></script>

<!--fin du contenu -->
<?php
$title = 'Bet Glory'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
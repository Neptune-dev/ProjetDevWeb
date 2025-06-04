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

<br>
<!-- Faudra le mettre lorsqu'on valide le paris, c'est drôle.
<h3 id="message" class="Prévention">Chargement du message...</h3><br>
-->

<section class="TopPari">
    <h1>Les Matchs</h1>
    <?php

    require_once 'includes/helpers.php';
    $pdo = openDB();
    $stmt = $pdo->prepare("SELECT * FROM Games");
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($games as $game) {
        if (!isset($game['H2H']) || $game['H2H'] == 0) {
            $_GET["gameID"] = $game['ID'];
            require ('views/game_view.php');
        }
    }
    ?>
</section>

<br>
<br>
<br>
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

<footer>
    <a href="https://www.conseil-constitutionnel.fr/le-bloc-de-constitutionnalite/declaration-des-droits-de-l-homme-et-du-citoyen-de-1789" target="_blank">Mentions légales</a>
    <div class="socials">
        <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
    </div>
    <!--Le <p> ajoute automatiquement un margin, mais j'aime pas celui du bas.-->
    &copy; <span id="year"></span> Groupe_des_Wapitis
</footer>
<script>document.getElementById("year").textContent = new Date().getFullYear();</script>



<!--fin du contenu -->
<?php
$title = 'Bet Glory'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
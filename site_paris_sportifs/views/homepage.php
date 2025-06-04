<?php
session_start();
require_once('includes/helpers.php');
?>

<?php
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/images/favicon.png">
    <title>Bet Glory</title>
    <link rel="stylesheet" href="public/css/DA.css">
    <link rel="stylesheet" href="public/css/homepage_style.css">
    <link rel="stylesheet" href="public/css/header.css">
    <link rel="stylesheet" href="public/css/footer.css">
    <link rel="stylesheet" href="public/css/paris.css">
    <link rel="stylesheet" href="public/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--Le dernier c'est pour les favicons de entreprises pour le footer-->
</head>
<body>
    <a href="https://www.joueurs-info-service.fr/" target="_blank"><div style="background: url('public/images/prevention.webp') center center no-repeat rgb(0, 0, 0); height: 60px; cursor: pointer; z-index: 120; display: block;"></div></a>
    <header>
        <div class="header-left">
            <div class="logo">
                <a href="/site_paris_sportifs"><img src="public/images/logosansfond.png" alt="Logo du site"></a>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="balance">
                    Solde : <strong id="balance"><?= htmlspecialchars($balance) ?></strong> 💰
                </div>
            <?php endif; ?>
        </div>
        <nav class="header-right">
            <ul>
                <li><a href="/site_paris_sportifs/">Accueil</a></li>

                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="/site_paris_sportifs/mon_compte">Mon compte</a></li>
                <?php else: ?>
                    <li><a href="/site_paris_sportifs/login">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
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
                require ('game_view.php');
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
</body>
</html>
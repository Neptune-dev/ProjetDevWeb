<?php
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/images/favicon3.png">
    <title><?= $title ?></title>
    <!--Cela ne marchait pas, je suis remonté plus loin dans l'arborescence-->
    <link rel="stylesheet" href="/site_paris_sportifs/public/css/DA.css">
    <link rel="stylesheet" href="public/css/header.css">
    <link rel="stylesheet" href="public/css/footer.css">
    <link rel="stylesheet" href="public/css/paris.css">
    <link rel="stylesheet" href="public/css/contact.css">
    <link rel="stylesheet" href="public/css/mon_compte.css">
    <link rel="stylesheet" href="public/css/erreur.css">
    <link rel="stylesheet" href="public/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--Le dernier c'est pour les favicons de entreprises pour le footer-->
</head>

<!-- C'est un fichier template qui sert
de base structurelle commune à toutes les pages qui se ressembleront-->

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
    <!-- Le script est pour la couleur de la page actuelle.-->
    <script src="/site_paris_sportifs/public/js/script.js"></script>

    <main>
        <?= $content ?> 
    </main>

    <footer>
        <div>
            <a href="https://www.conseil-constitutionnel.fr/le-bloc-de-constitutionnalite/declaration-des-droits-de-l-homme-et-du-citoyen-de-1789" target="_blank">Mentions légales</a>
            <div class="socials">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
            <!--Le <p> ajoute automatiquement un margin, mais j'aime pas celui du bas.-->
            <p>&copy; <span id="year"></span> Groupe_des_Wapitis</p>
        </div>
    </footer>
    <script>document.getElementById("year").textContent = new Date().getFullYear();</script>
</body>
</html>
<?php
session_start();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--Le dernier c'est pour les favicons de entreprises pour le footer-->
</head>
<body>
    <header>
        <div class="logo">
            <img src="public/images/logosansfond.png" alt="Logo du site">
        </div>
        <nav>
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
    
    <section class="TopPari">
        <h2>Les Matches De La Semaine</h2>
        <?php require ('game_view.php'); ?>
    </section>

    <br>
    <br>
    <br>
    <section class="Contact">
        <hr>
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
    <script src="/site_paris_sportifs/public/js/script.js"></script>

    <footer>
        <div>
            <a href="https://www.conseil-constitutionnel.fr/le-bloc-de-constitutionnalite/declaration-des-droits-de-l-homme-et-du-citoyen-de-1789" target="_blank">Mentions légales</a>
            <div class="socials">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
            <!--Le <p> ajoute automatiquement un margin, mais j'aime pas celui du bas.-->
            &copy; <span id="year"></span> Groupe_des_Wapitis
        </div>
    </footer>
    <script>document.getElementById("year").textContent = new Date().getFullYear();</script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/images/favicon.png">
    <title>Home page</title>
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
                <li><a href="/site_paris_sportifs/login">Login</a></li>
                <li><a href="/site_paris_sportifs/signin">Sign in</a></li>
            </ul>
        </nav>
    </header>
    <button onclick="toggleTheme()">Dark Mode 🌓</button>
    <section id="Contact">
        <hr>
        <h2>Contactez-moi</h2>
        <form id="contactForm">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
        <p id="msg"></p>
    </section>
    <footer>
        <div>
            <p><a href="https://www.conseil-constitutionnel.fr/le-bloc-de-constitutionnalite/declaration-des-droits-de-l-homme-et-du-citoyen-de-1789" target="_blank">Mentions légales</a></p>
            <div class="socials">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
            <p>&copy; <span id="year"></span> Groupe_des_Wapitis</p>
        </div>
    </footer>
    <script>document.getElementById("year").textContent = new Date().getFullYear();</script>

    <?php
    session_start();
    ?>
</body>
</html>
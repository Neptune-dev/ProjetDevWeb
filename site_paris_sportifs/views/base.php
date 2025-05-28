<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/images/favicon.png">
    <title><?= $title ?></title>
    <!--Cela ne marchait pas, je suis remonté plus loin dans l'arborescence-->
    <link rel="stylesheet" href="/site_paris_sportifs/public/css/DA.css">
    <link rel="stylesheet" href="/site_paris_sportifs/public/css/base_style.css">
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
    <!-- Le script est pour la couleur de la page actuelle.-->
    <script src="/site_paris_sportifs/views/script.js"></script>


    <!-- C'est un fichier template qui sert
    de base structurelle commune à toutes les pages qui se ressembleront-->
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
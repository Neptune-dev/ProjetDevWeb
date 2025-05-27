<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/images/placeholderIcon.png">
    <title>Home page</title>
    <link rel="stylesheet" href="public/css/homepage_style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="public/images/logo.png" alt="Logo du site">
        </div>
        <nav>
            <ul>
                <li><a href="/site_paris_sportifs/">Accueil</a></li>
                <li><a href="/site_paris_sportifs/login">Login</a></li>
                <li><a href="/site_paris_sportifs/signin">Sign in</a></li>
            </ul>
        </nav>
    </header>
    <?php
    session_start();
    ?>
</body>
</html>
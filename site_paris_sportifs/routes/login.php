<?php
//page de login
ob_start();
?>

<!--contenu de la page -->
<div class="contact-wrapper">
    <section class="Contact">
        <h2>Connexion</h2>
        <form class="contactForm" action="login" method="POST">
            Nom d'utilisateur : <input type="text" name="username" required><br>
            Mot de passe : <input type="password" name="pwd" required>
            <h5><a href="#" id="forgot-password">Mot de passe oublié ?</a></h5>
            <div id="forgot-msg" class="hidden">Cheh ! Fallait pas l'oublier.</div>
            <!--Flemme de faire le reset de mot de passe, mais c'est pas compliqué à faire-->
            <button type="submit">Se connecter</button>
        </form>
        <h5 style="text-align: center;"><a href="/site_paris_sportifs/signin">Pas encore de compte ?<br>Incris-toi</a></h5>
    </section>
</div>
<script src="/site_paris_sportifs/public/js/script.js"></script>

<?php
    session_start();
    require_once('includes/helpers.php');

    /*Un peu facultatif, en soit ça sert à rien de log si t'es connecté*/
    if (isset($_SESSION['user'])) {
    header("Location: /site_paris_sportifs/mon_compte");
    exit();
    }

    $pdo = openDB();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];

        $stmt = $pdo->prepare("SELECT * FROM Users WHERE Username=?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();


        if ($user && password_verify($pwd, $user["Pwd"])) {
            $_SESSION["user"] = $user;
            if ($user["isAdmin"] == 1) {
                header("Location: /site_paris_sportifs/admin_panel");
            } else {
                header("Location: /site_paris_sportifs/");
            }
            exit();
        } else {
            echo "<p> Identifiants incorrects.</p>";
        }
    }
?>

<!--fin du contenu -->
<?php
$title = 'Login'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
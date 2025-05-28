<?php
//page de login
ob_start();
?>

<!--contenu de la page -->
<br>
<br>
<br>
<section class="Contact">
    <h2>Veuillez vous identifier.</h2>
    <form class="contactForm" action="login" method="POST">
        Nom d'utilisateur : <input type="text" name="username" required><br>
        Mot de passe : <input type="password" name="pwd" required><br>
        <button type="submit">Se connecter</button>
    </form>
    <a href="/site_paris_sportifs/signin">Vous n'avez pas de compte ? Cliquez ici.</a>
</section>

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
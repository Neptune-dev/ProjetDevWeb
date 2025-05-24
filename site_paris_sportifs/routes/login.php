<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<h1>Login</h1>

<form action="login" method="POST">
    Nom d'utilisateur : <input type="text" name="username" required><br>
    Mot de passe : <input type="password" name="pwd" required><br>
    <input type="submit" value="Se connecter">
</form>

<?php
    session_start();
    require_once('includes/helpers.php');
    $pdo = openDB();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];

        $stmt = $pdo->prepare("SELECT * FROM Users WHERE Username=?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();


        if ($user && password_verify($pwd, $user["Pwd"])) {
            $_SESSION["user"] = $user;
            header("Location: /site_paris_sportifs/");
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
<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<h1>Signin</h1>

<form action="signin" method="POST">
    Nom d'utilisateur : <input type="text" name="username" required><br>
    mot de passe : <input type="password" name="pwd" required><br>
    <input type="submit" value="Se connecter">
</form>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username =$_POST['username'];
        $pwd =$_POST['pwd'];

        $hashed = password_hash($pwd, PASSWORD_DEFAULT);
        echo $hashed;
    }
?>

<!--fin du contenu -->
<?php
$title = 'Signin'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
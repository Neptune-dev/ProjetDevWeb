<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<h1>Signin</h1>

<form action="signin" method="POST">
    Prénom : <input type="text" name="firstName" required><br>
    Nom de famille : <input type="text" name="lastNamme" required><br>
    Date de naissance : <input type="date" name="birthdate" required><br>
    Nom d'utilisateur : <input type="text" name="username" required><br>
    Mot de passe : <input type="password" name="pwd" required><br>
    Confirmer le mot de passe : <input type="password" name="pwdConfirm" required><br>
    <input type="submit" value="Créer un compte">
</form>

<?php
    session_start();
    require_once('includes/helpers.php');
    $pdo = openDB();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastNamme'];
        $birthdate = $_POST['birthdate'];
        $username = $_POST['username'];
        $pwd = $_POST['pwd'];
        $pwdConfirm = $_POST['pwdConfirm'];

        $stmt = $pdo->prepare("SELECT * FROM Users WHERE Username=?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($pwd == $pwdConfirm) {
            if (!$user) {
                $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO Users (FirstName, LastName, Username, Birthdate, Pwd) VALUES (?,?,?,?,?)");
                $stmt->execute([$firstName, $lastName, $username, $birthdate, $hashedPassword]);
                header("Location: /site_paris_sportifs/");
                exit();
            } else {
            echo "<p>L'utilisateur existe déjà</p>";
            }
        } else {
            echo "<p>Les mots de passe ne sont pas les mêmes.</p>";
        }
    }
?>

<!--fin du contenu -->
<?php
$title = 'Signin'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
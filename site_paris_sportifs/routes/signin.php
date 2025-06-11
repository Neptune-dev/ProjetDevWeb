<?php
//page de login
ob_start();
?>

<!--contenu de la page -->
<<div class="contact-wrapper">
    <section class="Contact">
        <h2>Créer un compte.</h2>
        <!--On peut garder que Nom d'utilisateur, date de naissance et les deux mots de passe. -->
        <form class="contactForm" action="signin" method="POST">
            Prénom : <input type="text" name="firstName" required><br>
            Nom de famille : <input type="text" name="lastNamme" required><br>
            Date de naissance : <input type="date" name="birthdate" required><br>
            Nom d'utilisateur : <input type="text" name="username" required><br>
            Mot de passe : <input type="password" name="pwd" required><br>
            Confirmer le mot de passe : <input type="password" name="pwdConfirm" required><br>
            <button type="submit">Créer un compte</button>
        </form>
    </section>
</div>

<?php
    session_start();
    require_once('includes/helpers.php');
    $pdo = openDB();

    /*Un peu facultatif, en soit ça sert à rien de signIn si t'es connecté*/
    if (isset($_SESSION['user'])) {
    header("Location: /site_paris_sportifs/mon_compte");
    exit();
    }

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
                // ajoute l'utilisateur à la DB
                $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO Users (FirstName, LastName, Username, Birthdate, Pwd, isAdmin) VALUES (?,?,?,?,?,?)");
                $stmt->execute([$firstName, $lastName, $username, $birthdate, $hashedPassword, 0]);
                
                // créé un porte monnaie pour cet utilisateur
                require_once('includes/config.php');
                $stmt = $pdo->prepare("INSERT INTO Wallets (UserID, Balance) SELECT ID, ? FROM Users WHERE Username=?");
                $stmt->execute([$baseMoney, $username]);
                
                header("Location: /site_paris_sportifs/");
                exit();
            } else {
            echo "<p style='color:black;'>L'utilisateur existe déjà</p>";
            }
        } else {
            echo "<p style='color:black;'>Les mots de passe ne sont pas les mêmes.</p>";
        }
    }
?>

<!--fin du contenu -->
<?php
$title = 'Signin'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<?php

session_start();

// vérif que l'utilisateur est connecté
if(!isset($_SESSION["user"])) {
    header("Location: /site_paris_sportifs/login");
    exit();
}
// vérif que la requete est bonne
if (!isset($_GET['id']) || !isset($_GET['bet'])) {
    header("Location: /site_paris_sportifs/400");
    exit();
}

// traitement du formulaire de validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $value = $_POST['value'];
    $userID = $_SESSION['user']['ID'];
    
    require_once('includes/helpers.php');
    $pdo = openDB();

    // récupération du solde de l'utilisateur
    $stmt = $pdo->prepare('SELECT Balance FROM Wallets WHERE UserID = ?');
    $stmt->execute([$userID]);
    $wallet = $stmt->fetch();
    $userBalance = $wallet ? $wallet["Balance"] : 0;

    // vérif de si l'utilisateur à assez de thunes
    if ($value <= $userBalance) {
        //mise à jour du solde
        $stmt = $pdo->prepare('UPDATE Wallets SET Balance = Balance - ? WHERE UserID = ?');
        $stmt->execute([$value, $userID]);

        //enregistrement du paris
        $stmt = $pdo->prepare('INSERT INTO Bets (UserID, GameID, H2H, Amount) VALUES (?,?,?,?)');
        $stmt->execute([$userID, $_GET['id'], $_GET['bet'], $value]);

        //mise à jour des côtes
        calcOdds();

        header("Location: /site_paris_sportifs/mon_compte");
        exit();
    } else {
        header("Location: /site_paris_sportifs/402");
        exit();
    }
}
?>

<h1>Votre Paris</h1>

<?php 
$_GET['nobets'] = 1;
$_GET['gameID'] = $_GET['id'];
require('views/game_view.php');
?>

<!-- Validation du paris -->
<section class="Contact">
    <form action="bet?id=<?=$_GET['id']?>&bet=<?=$_GET['bet']?>" method="POST">
        <p>Mise :</p>
        <input type="number" name="value" required>
        <button type="submit">Valider le Paris</button>
    </form>
</section>

<!--fin du contenu -->
<?php
$title = 'Bet'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
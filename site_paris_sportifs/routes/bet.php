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
<div class="TopPari">
    <h1>Votre Paris</h1>
    <h3 id="message" class="Prévention">Chargement du message...</h3>
    <?php 
        $_GET['H2H'] = $_GET['bet'];
        $_GET['gameID'] = $_GET['id'];
        require('views/game_view.php');
    ?>

    <!-- Validation du paris -->
    <section class="Contact">
        <form action="bet?id=<?=$_GET['id']?>&bet=<?=$_GET['bet']?>" method="POST">
            <p>Mise :</p>
            <input type="number" name="value" min=0 oninput="validity.valid||(value='');" required>
            <button type="submit">Parier</button>
        </form>
    </section>
</div>

<script>
    const messages = [
        "🔞 Parier comporte des risques… la pauvreté en comporte davantage !",
        "🔞 Parier comporte des risques… mais s'arrêter c'est accepter sa défaite.",
        "🔞 Parier comporte des risques… mais qui ne tente rien n’a rien",
        "🔞 Parier comporte des risques… mais la vie sans risque est ennuyeuse !",
        "🔞 Parier comporte des risques… mais vous êtes peut-être à un pari de vous refaire.",
        "🔞 Votre banquier n'aime pas ce site. Nous si.",
        "🔞 Si vous perdez, ce n’est pas de la malchance. C’est la faute de l’arbitre.",
        "🔞 Ne rêvez pas votre vie, pariez-la.",
        "🔞 Le jeu ne fait pas le bonheur… sauf quand ça passe à la 95e.",
        "🔞 Misez. Vibrez. Recommencez.",
        "🔞 Parier ne résout pas les problèmes. Mais ça les rend plus excitants.",
        "🔞 La chance ne sourit qu'aux audacieux et aux parieurs.",
        "🔞 La vie est un pari. Faites-en un gagnant.",
        "🔞 Parier, c’est comme l’amour : parfois on gagne, parfois on perd, mais on ne s’ennuie jamais.",
    ];

    const messageElement = document.getElementById("message");
    const randomIndex = Math.floor(Math.random() * messages.length);
    messageElement.textContent = messages[randomIndex];
</script>

<!--fin du contenu -->
<?php
$title = 'Bet'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
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
        $stmt = $pdo->prepare('INSERT INTO Bets (UserID, GameID, H2H, Amount, Finished) VALUES (?,?,?,?,?)');
        $stmt->execute([$userID, $_GET['id'], $_GET['bet'], $value,0]);

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
    <h1 style="padding-bottom: 0;">Votre Paris</h1>
    <?php 
        $_GET['H2H'] = $_GET['bet'];
        $_GET['gameID'] = $_GET['id'];
        require('views/game_view.php');
    ?>

    <!-- Validation du paris -->
    <section class="Contact">
        <form action="bet?id=<?=$_GET['id']?>&bet=<?=$_GET['bet']?>" method="POST">
            <p>Mise :</p>
            <input type="number" name="value" min=1 oninput="validity.valid||(value='');" required>
            <button type="submit">Parier</button>
        </form>
    </section>
</div>
<h4>Information :</h4>
<h3 id="message" class="Prévention">Chargement du message...</h3>

<script>
    const messages = [
        "🔞 Parier comporte des risques… la pauvreté en comporte davantage !",
        "🔞 Parier comporte des risques… mais s'arrêter c'est accepter sa défaite.",
        "🔞 Parier comporte des risques… mais qui ne tente rien n’a rien.",
        "🔞 Parier comporte des risques… mais la vie sans risque est ennuyeuse !",
        "🔞 Parier comporte des risques… mais vous êtes peut-être à un pari de vous refaire.",
        "🔞 Parier comporte des risques… mais c’est moins cher qu’un psy.",
        "🔞 Parier comporte des risques… surtout quand vous écoutez votre instinct.",
        "🔞 Parier comporte des risques… mais c’est quand même plus fun que l’épargne logement.",
        "🔞 Parier comporte des risques… mais c’est légal, alors profitons-en.",
        "🔞 Parier comporte des risques… surtout quand c’est votre dernier billet.",
        "🔞 Parier comporte des risques… et parfois des miracles.",
        "🔞 Parier comporte des risques… mais les regrets, c’est pire.",
        "🔞 Parier comporte des risques… comme ignorer cette cote à 17 qui sentait la remontada.",
        "🔞 Parier comporte des risques… mais les paris perdus font les meilleures anecdotes.",
        "🔞 Parier comporte des risques… mais c’est moins risqué que de croire aux licornes.",
        "🔞 Si vous perdez, ce n’est pas de la malchance. C’est la faute de l’arbitre.",
        "🔞 Ne rêvez pas votre vie, pariez-la.",
        "🔞 Votre banquier n'aime pas ce site. Nous si.",
        "🔞 Le jeu ne fait pas le bonheur… sauf quand ça passe à la 95e.",
        "🔞 Parier ne résout pas les problèmes. Mais ça les rend plus excitants.",
        "🔞 La chance ne sourit qu'aux audacieux et aux parieurs.",
        "🔞 La vie est un pari. Faites-en un gagnant.",
        "🔞 Parier, c’est comme l’amour : parfois on gagne, parfois on perd, mais on ne s’ennuie jamais.",
        "🔞 Vous perdez plus souvent que vous ne l’admettez… et c’est normal.",
        "🔞 Il paraît qu’il faut savoir perdre. Vous, vous êtes un expert.",
        "🔞 Si la chance vous tourne le dos, arrêtez de parier en moonwalk.",
        "🔞 Vos paris perdants méritent un musée.",
        "🔞 Ce n’est pas vous qui perdez… c’est le karma qui vous teste.",
        "🔞 Parfois on gagne. Parfois on apprend. Souvent, on recharge.",
        "🔞 La prochaine, c’est la bonne… comme d’habitude.",
        "🔞 Un pari bien placé vaut mille regrets. Ou l’inverse.",
        "🔞 C’est pas de la dépendance, c’est de la passion (non ?)",
        "🔞 Si vous deviez être payé à chaque défaite, vous seriez riche.",
        "🔞 Le football, il a changé... comme votre compte en banque.",
        "🔞 Vous avez plus de flair que de chance.",
        "🔞 Tout miser sur une intuition ? On adore votre courage.",
        "🔞 Vous dites toujours ‘dernier pari’... on a arrêté de compter.",
        "🔞 L’adrénaline ne rembourse pas vos pertes.",
        "🔞 Si perdre était un sport, vous seriez champion.",
        "🔞 Chaque pari est une promesse… rarement tenue.",
        "🔞 Vous avez cru au miracle. On respecte l’audace.",
        "🔞 Vos paris s’accumulent… comme vos erreurs de jugement.",
        "🔞 Vos paris sont comme vos évaluations, vous y allez au talent.",
        "🔞 Votre instinct est formé à l’aveugle.",
        "🔞 Le problème ce n’est pas les paris. C’est que vous y croyez trop.",
        "🔞 L’espoir fait vivre. Mais il fait surtout parier.",
        "🔞 Vous vous dites ‘je maîtrise’ ? On vous croit. Promis.",
        "🔞 Vous aviez un plan. C’était de perdre avec style.",
        "🔞 Une victoire sur dix, c’est un ratio… respectable ?",
        "🔞 Chaque pari est une aventure. Parfois une tragédie.",
        "🔞 Vous êtes peut-être à un pari de faire faillite. Faites le bon.",
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
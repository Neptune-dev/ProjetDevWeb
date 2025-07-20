<?php
ob_start();
?>



<?php
session_start();
?>

<h3>Stats</h3>
<?php
require_once('includes/helpers.php');       
$pdo = openDB();

$userId = $_GET['id'];
$stmt = $pdo->prepare("SELECT COUNT(*) AS nb_paris FROM Bets WHERE UserID = ?");
$stmt->execute([$userId]);
$result = $stmt->fetch();
$nb_paris = $result['nb_paris'];

$stmt = $pdo->prepare("SELECT SUM(Amount) AS total_gains FROM Bets WHERE UserID = ? AND Finished = 1");
$stmt->execute([$userId]);  
$total_gains = $stmt->fetchColumn();
$stmt = $pdo->prepare("SELECT SUM(Amount) AS total_losses FROM Bets WHERE UserID = ? AND Finished = 0");
$stmt->execute([$userId]);  
$total_losses = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT AVG(Amount) AS mise_moyenne FROM Bets WHERE UserID = ?");
$stmt->execute([$userId]);
$mise_moyenne = $stmt->fetchColumn();
if ($mise_moyenne === null) $mise_moyenne = 0; 

$stmt = $pdo->prepare("SELECT COUNT(*) FROM Bets WHERE UserID = ? AND Finished = 1");
$stmt->execute([$userId]);
$nb_gagnes = $stmt->fetchColumn();
if ($nb_paris === null) $nb_paris = 0;
if ($nb_gagnes === null) $nb_gagnes = 0;
if ($total_gains === null) $total_gains = 0;
if ($total_losses === null) $total_losses = 0;
if ($mise_moyenne === null) $mise_moyenne = 0;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM Bets WHERE UserID = ? AND Finished = 0");
$stmt->execute([$userId]);
$nb_perdus = $stmt->fetchColumn();
if ($nb_perdus === null) $nb_perdus = 0;


if ($nb_paris > 0) {
    $pourcentage_gagnes = round(($nb_gagnes / $nb_paris) * 100, 2);
} else {
    $pourcentage_gagnes = 0;
}

$solde_net = $total_gains - $total_losses;

$stmt = $pdo->prepare("SELECT SUM(Amount) FROM Bets WHERE UserID = ?");
$stmt->execute([$userId]);
$total_mises = $stmt->fetchColumn();
if ($total_mises === null || $total_mises == 0) {
    $roi = 0;
} else {
    $roi = round((($solde_net) / $total_mises) * 100, 2);
}

$stmt = $pdo->prepare("
    SELECT Games.League, COUNT(*) AS nb
    FROM Bets
    JOIN Games ON Bets.GameID = Games.ID
    WHERE Bets.UserID = ?
    GROUP BY Games.League
    ORDER BY nb DESC
    LIMIT 1
");
$stmt->execute([$userId]);
$most_played_league = $stmt->fetch();
$league_name = $most_played_league ? $most_played_league['League'] : "Aucune";

$stmt = $pdo->prepare("SELECT Finished FROM Bets WHERE UserID = ? ORDER BY ID DESC");
$stmt->execute([$userId]);
$results = $stmt->fetchAll(PDO::FETCH_COLUMN);

$serie_type = null; // "victoires" ou "défaites"
$serie_count = 0;

if (!empty($results)) {
    $first = $results[0];
    $serie_type = ($first == 1) ? "W" : "L";
    foreach ($results as $res) {
        if ($res === $first) {
            $serie_count++;
        } else {
            break;
        }
    }
}

?>

<div class="text">
    <p class="text">
        Série en cours : 
        <?php
        if ($serie_count > 0) {
            echo $serie_count . " " . $serie_type;
        } else {
            echo "Aucune série en cours";
        }
        ?>
    </p>
    <p class="text">Nombre de paris effectués : <?php echo $nb_paris; ?></p>
    <p class="text">Nombre de paris gagnés/perdus : <?php echo $nb_gagnes; ?>/<?php echo $nb_perdus; ?></p>
    <p class="text">Pourcentage de paris gagnés : <?php echo $pourcentage_gagnes; ?>%</p>
    <p class="text">Total des gains : <?php echo $total_gains; ?> <img src="public/images/monnaie.png" alt="💰" class="monnaie"></p>
    <p class="text">Total des pertes : <?php echo $total_losses; ?> <img src="public/images/monnaie.png" alt="💰" class="monnaie"></p>
    <p class="text">Solde net : <?php echo $solde_net; ?> <img src="public/images/monnaie.png" alt="💰" class="monnaie"></p>
    <p class="text">Retour sur investissement (ROI) : <?php echo $roi; ?>%</p>
    <p class="text">Ligue la plus jouée : <?php echo htmlspecialchars($league_name); ?></p>
    <p class="text">Mise moyenne par pari : <?php echo $mise_moyenne; ?> <img src="public/images/monnaie.png" alt="💰" class="monnaie"></p>
</div>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["historique"]) && isset ($_GET["id"])) {
        header("Location: /site_paris_sportifs/historique?id=".$_GET['id']);
        exit();
    } 
}
echo '<form action="mes_stats?historique&id='.$userId.'" method="POST"><button type="submit">Historique</button></form>';
?>
<!--fin du contenu -->
<?php
$title = 'Mes Stats'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
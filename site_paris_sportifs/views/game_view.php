<?php

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(400);
    exit();
}

require_once('includes/helpers.php');
$pdo = openDB();

$stmt = $pdo->prepare("SELECT * FROM Games WHERE ID=?");
$stmt->execute([$_GET["gameID"]]);
$game = $stmt->fetch();

$league = $game["League"];
$gameDate = $game["GameDate"];
$gameTime = $game["GameTime"];
$homeOdd = $game["HomeOdd"];
$awayOdd = $game["AwayOdd"];


$stmt = $pdo->prepare("SELECT * FROM Teams WHERE ID=?");
$stmt->execute([$game["Home"]]);
$home = $stmt->fetch();
$homeLogo = $home["TeamLogo"];
$home = $home["TeamName"];

$stmt = $pdo->prepare("SELECT * FROM Teams WHERE ID=?");
$stmt->execute([$game["Away"]]);
$away = $stmt->fetch();
$awayLogo = $away["TeamLogo"];
$away = $away["TeamName"];



ob_start();
?>

<div class="match-bubble">
    <div class="teams">
        <div class="team">
            <img src="<?=$homeLogo?>" alt="Home team Logo">
            <span class="team-name"><?= $home ?></span>
            <span class="team-name"><?= $homeOdd ?></span>
        </div>
        <span class="vs">VS</span>
        <div class="team">
            <img src="<?=$awayLogo?>" alt="Away team Logo">
            <span class="team-name"><?= $away ?></span>
            <span class="team-name"><?= $awayOdd ?></span>
        </div>
    </div>
    <div class="odds">
        <div class="odd"><?= 50 ?></div>
        <div class="odd"><?= 50 ?></div>
    </div>
    <div class="match-info">
        <?= $league ?> - <?= $gameTime ?> - <?= $gameDate ?>
    </div>
</div>

<?php
echo ob_get_clean();
?>

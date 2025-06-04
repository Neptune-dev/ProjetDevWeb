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

<div class="match-card">
    <div class="teams">
        <div class="team">
            <img src="<?= $homeLogo ?>" alt="Logo <?= $home ?>">
            <div class="team-name"><?= $home ?></div>
            <div class="team-name"><?= $homeOdd ?></div>
        </div>

        <div class="vs">VS</div>

        <div class="team">
            <img src="<?= $awayLogo ?>" alt="Logo <?= $away ?>">
            <div class="team-name"><?= $away ?></div>
            <div class="team-name"><?= $awayOdd ?></div>
        </div>
    </div>

    <div class="odds">
        <div class="odd">1</div>
        <div class="odd">N</div>
        <div class="odd">2</div>
    </div>

    <div class="match-info">
        <?= $league ?> — <?= $gameTime ?> — <?= $gameDate ?>
    </div>
</div>


<?php
echo ob_get_clean();
?>

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
$home = $game["Home"];
$away = $game["Away"];
$gameDate = $game["GameDate"];
$gameTime = $game["GameTime"];
$homeOdd = $game["HomeOdd"];
$awayOdd = $game["AwayOdd"];


ob_start();
?>

<div class="match-bubble">
    <div class="teams">
        <div class="team">
            <img src="public/images/psg.webp" alt="PSG">
            <span class="team-name"><?= $home ?></span>
            <span class="team-name"><?= $homeOdd ?></span>
        </div>
        <span class="vs">VS</span>
        <div class="team">
            <img src="public/images/om.png" alt="OM">
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

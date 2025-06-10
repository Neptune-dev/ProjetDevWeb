<?php

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(400);
    exit();
}

require_once('includes/helpers.php');
$pdo = openDB();

$stmt = $pdo->prepare("SELECT * FROM Games WHERE ID=?");
$stmt->execute([$_GET["bet"]["GameID"]]);
$game = $stmt->fetch();

$league = $game["League"];
$gameDate = $game["GameDate"];
$gameTime = $game["GameTime"];


$homeDynaOdd = $game["HomeDynaOdd"];
$drawDynaOdd = $game["DrawDynaOdd"];
$awayDynaOdd = $game["AwayDynaOdd"];
$odds = array($drawDynaOdd, $homeDynaOdd, $awayDynaOdd);

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

$result = array('Nul', $home, $away);

$jours = [
    'Monday' => 'Lundi',
    'Tuesday' => 'Mardi',
    'Wednesday' => 'Mercredi',
    'Thursday' => 'Jeudi',
    'Friday' => 'Vendredi',
    'Saturday' => 'Samedi',
    'Sunday' => 'Dimanche',
];

$matchDateTime = new DateTime($gameDate . ' ' . $gameTime);
$now = new DateTime();

$dayLabel = '';
if ($matchDateTime->format('Y-m-d') === $now->format('Y-m-d')) {
    $dayLabel = 'Aujourd’hui';
} elseif ($matchDateTime->format('Y-m-d') === $now->modify('+1 day')->format('Y-m-d')) {
    $dayLabel = 'Demain';
} else {
    $dayEn = $matchDateTime->format('l');
    $dayLabel = $jours[$dayEn] ?? $dayEn;
}

$hour = (int)$matchDateTime->format('H');
$minute = (int)$matchDateTime->format('i');
$formattedTime = sprintf('%02dh%02d', $hour, $minute);


ob_start();
?>

<div class="match-card">
    <div class="teams">
        <div class="team">
            <img src="<?= $homeLogo ?>" alt="Logo <?= $home ?>">
            <div class="team-name"><?= $home ?></div>
            <!--<div class="team-name"><?= $homeOdd ?></div> -->
        </div>

        <div class="vs">VS</div>

        <div class="team">
            <img src="<?= $awayLogo ?>" alt="Logo <?= $away ?>">
            <div class="team-name"><?= $away ?></div>
            <!--<div class="team-name"><?= $awayOdd ?></div> -->
        </div>
    </div>

    <div>
        Resultat :
        <?= $result[$_GET["bet"]["H2H"]] ?><br>
        Montant :
        <?= $_GET["bet"]["Amount"] ?>
        <img src="public/images/monnaie.png" alt="💰" class="monnaie"><br>
        Cote :
        <?= round($odds[$_GET["bet"]["H2H"]], 2) ?><br>
        Gain Potentiel :
        <?= round($_GET["bet"]["Amount"] * $odds[$_GET["bet"]["H2H"]]) ?>
        <img src="public/images/monnaie.png" alt="💰" class="monnaie"><br>
    </div>

    <div class="match-info">
        <?= $league ?> — <?= $dayLabel ?> — <?= $formattedTime ?>
    </div>
</div>


<?php
echo ob_get_clean();
?>

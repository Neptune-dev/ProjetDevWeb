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


$homeDynaOdd = $game["HomeDynaOdd"];
$drawDynaOdd = $game["DrawDynaOdd"];
$awayDynaOdd = $game["AwayDynaOdd"];

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

    <?php 
    if (isset($_GET['H2H'])){
        // H2H = 0 pour nul || 1 pour home || 2 pour away
        switch ($_GET['H2H']) {
            case 0:
                echo '
                    Resultat : Nul<br>
                    Cote : '.round($drawDynaOdd, 2);
                break;

            case 1:
                echo '
                    Resultat : '.$home.'<br>
                    Cote : '.round($homeDynaOdd, 2);
                break;
            
            case 2:
                echo '
                    <p>Resultat :'.$away.'<br>
                    Cote : '.round($awayDynaOdd, 2);
                break;
            
            default:
                break;
        }
    } else {
        echo '
            <div class="odds">
                <a href="/site_paris_sportifs/bet?id='.$game['ID'].'&bet=1">
                    <div class="odd">
                        <div>'.$home.'</div>
                        <div>'.round($homeDynaOdd, 2).'</div>
                    </div></a>
                <a href="/site_paris_sportifs/bet?id='.$game['ID'].'&bet=0">
                    <div class="odd">
                        <div>Nul</div>
                        <div>'.round($drawDynaOdd, 2).'</div>
                    </div></a>
                <a href="/site_paris_sportifs/bet?id='.$game['ID'].'&bet=2">
                    <div class="odd">
                        <div>'.$away.'</div>
                        <div>'.round($awayDynaOdd, 2).'</div>
                    </div></a>
            </div>';
    }
    ?>

    <div class="match-info">
        <?= $league ?> — <?= $dayLabel ?> — <?= $formattedTime ?>
    </div>
    
    
    
    
</div>


<?php
echo ob_get_clean();
?>

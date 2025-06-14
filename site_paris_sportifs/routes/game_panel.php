<?php
//page de modification de matchs
ob_start();
?>

<!--contenu de la page -->
<?php
session_start();

// sécurité
require_once('includes/helpers.php');
checkAdmin();

//vérif syntaxe requete
if (!isset($_GET["id"])) {
    header('Location: /site_paris_sportifs/400?');
    exit();
} else { //on vérifie si ce match existe
    $pdo = openDB();
    $stmt = $pdo->prepare("SELECT * FROM Games WHERE ID=?");
    $stmt->execute([$_GET["id"]]);
    $game = $stmt->fetch();
    if (!$game) {
        header('Location: /site_paris_sportifs/404?ressource=matchID:'.$_GET["id"]);
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //suppression du match
    if (isset($_GET["delete"])) {
        $stmt = $pdo->prepare("DELETE FROM Games WHERE ID=?");
        $stmt->execute([$_GET['id']]);
        header("Location: /site_paris_sportifs/admin_panel");
        exit();
    }

    //modification du match
    if (isset($_GET["modify"])) {
        $gameDate = $_POST['gameDate'];
        $gameTime = $_POST['gameTime'];
        $isLive = $_POST['isLive'];
        $homeScore = $_POST['homeScore'];
        $awayScore = $_POST['awayScore'];
        $homeOdd = $_POST['homeOdd'];
        $awayOdd = $_POST['awayOdd'];

        if ($isLive == 'on') {
            $isLive = 1;
        } else {
            $isLive = 0;
        }
        $stmt = $pdo->prepare("UPDATE Games SET GameDate=?, GameTime=?, isLive=?, HomeScore=?, AwayScore=?, HomeOdd=?, AwayOdd=? WHERE ID=?");
        $stmt->execute([$gameDate, $gameTime, $isLive, $homeScore, $awayScore, $homeOdd, $awayOdd, $game["ID"]]);
        header("Location: /site_paris_sportifs/admin_panel");
        exit();
    }

    //validation des résultat
    if (isset($_GET["result"])) {
        $stmt = $pdo->prepare("UPDATE Games SET H2H=? WHERE ID=?");
        $stmt->execute([$_POST['H2H'], $_GET["id"]]);
        procWinnings($_GET["id"]); // distribution des gains
        header("Location: /site_paris_sportifs/admin_panel");
        exit();
    }
}


?>

<h1>Match Actuel</h1>

<table>
    <tr>
        <th>Game ID</th>
        <th>League</th>
        <th>Home</th>
        <th>Away</th>
        <th>Game Date</th>
        <th>Game Time</th>
        <th>Is Live</th>
        <th>Home Score</th>
        <th>Away Score</th>
        <th>Home Odd</th>
        <th>Away Odd</th>
        <th>Home Dynamic Odd</th>
        <th>Draw Dynamic Odd</th>
        <th>Away Dynamic Odd</th>
    </tr>
    <?php
    require_once('includes/helpers.php');
    $pdo = openDB();
        
    $stmt = $pdo->prepare("SELECT * FROM Games WHERE ID=?");
    $stmt->execute([$_GET['id']]);
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($games as $game) {
        echo "<tr>";
        echo "<td>".$game["ID"]."</td>";
        echo "<td>".$game["League"]."</td>";
        echo "<td>".$game["Home"]."</td>";
        echo "<td>".$game["Away"]."</td>";
        echo "<td>".$game["GameDate"]."</td>";
        echo "<td>".$game["GameTime"]."</td>";
        echo "<td>".$game["isLive"]."</td>";
        echo "<td>".$game["HomeScore"]."</td>";
        echo "<td>".$game["AwayScore"]."</td>";
        echo "<td>".$game["HomeOdd"]."</td>";
        echo "<td>".$game["AwayOdd"]."</td>";
        echo "<td>".$game["HomeDynaOdd"]."</td>";
        echo "<td>".$game["DrawDynaOdd"]."</td>";
        echo "<td>".$game["AwayDynaOdd"]."</td>";
        echo "</tr>";
    }
    ?>
</table>


<!-- Modification du match -->
<?php
function dropDownTeams($name) {
    require_once('includes/helpers.php');
    $pdo = openDB();
    $stmt = $pdo->prepare("SELECT * FROM Teams");
    $stmt->execute();
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<select name="'.$name.'">';
    foreach ($teams as $team) {
        echo '<option value="'.$team["ID"].'">'.$team["TeamName"]."</option>";
    }
    echo "</select><br>";
}

?>

<section class="Contact">
    <h2>Modifier le match</h2>
    <form class="contactForm" action="game_panel?id=<?=$game["ID"]?>&modify" method="POST">
        Date : <input type="date" name="gameDate"><br>
        Time : <input type="time" name="gameTime"><br>
        Is Live : <input type="checkbox" name="isLive"><br>
        Home Score : <input type="number" name="homeScore"><br>
        Away Score : <input type="number" name="awayScore"><br>
        Home Odd : <input type="number" step="0.1" name="homeOdd"><br>
        Away Odd : <input type="number" step="0.1" name="awayOdd"><br>
        <button type="submit">Modifier le match</button>
    </form>
</section>

<section class="Contact">
    <h2>Valider le resultat</h2>
    <form class="contactForm" action="game_panel?id=<?=$game["ID"]?>&result" method="POST">
            Gagnant* :
            <select name="H2H">
                <option value="1">Home</option>
                <option value="0">Draw</option>
                <option value="2">Away</option>
            </select>
            <button type="submit">Valider</button>
    </form>
</section>

<!-- Suppression du match -->
<form action="game_panel?id=<?=$game["ID"]?>&delete" method="POST">
    <button type="submit">Supprimer</button>
</form>

<!--fin du contenu -->
<?php
$title = 'Game Panel'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
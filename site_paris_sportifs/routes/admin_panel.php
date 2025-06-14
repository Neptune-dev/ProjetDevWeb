<?php
//page de l'admin
ob_start();
?>

<!--contenu de la page -->

<?php
session_start();

// sécurité
require_once('includes/helpers.php');
checkAdmin();

?>

<h1 class="titre_orange">Panneau de configuration administrateur</h1>

<!-- Tableau des matchs disponibles -->
<button type="button" class="collapsible"><h2>Modifier un match</h2></button>
<div class="collapsible-content">
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
            <th>Modify</th>
        </tr>
        <?php
        require_once('includes/helpers.php');
        $pdo = openDB();
        
        $stmt = $pdo->prepare("SELECT * FROM Games");
        $stmt->execute();
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($games as $game) {
            if (!isset($game['H2H'])) {
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
                //bouton de modification
                echo '<td><form action="admin_panel?modifyGame&id='.$game["ID"].'" method="POST"><button type="submit">Modifier</button></form></td>';
                echo "</tr>";
            }
        }
        ?>
    </table>
</div>

<!-- Tableau des équipes disponibles -->

<button type="button" class="collapsible"><h2>Les équipes</h2></button>
<div class="collapsible-content">
    <table>
        <tr>
            <th>Team ID</th>
            <th>Team Name</th>
            <th>Team Logo</th>
            <!--<th>Delete</th> -->
        </tr>
        <?php
        require_once('includes/helpers.php');
        $pdo = openDB();
        
        $stmt = $pdo->prepare("SELECT * FROM Teams");
        $stmt->execute();
        $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($teams as $team) {
            echo "<tr>";
            echo "<td>".$team["ID"]."</td>";
            echo "<td>".$team["TeamName"]."</td>";
            echo '<td><img src="'.$team["TeamLogo"].'" alt="Team Logo" style="width: 10vh;"></td>';
            //bouton de suppression : à faire fonctionner
            //echo '<td><form action="admin_panel?deleteTeam&id='.$team["ID"].'" method="POST"><button type="submit">Supprimer</button></form></td>';
            echo "</tr>";
        }

        ?>
    </table>
</div>


<!-- Formulaire de création de nouveau matchs -->

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
<button type="button" class="collapsible"><h2>Ajouter un match</h2></button>
<div class="collapsible-content">
    <section class="Contact">
        <h2>Créer un match</h2>
        <form class="contactForm" action="admin_panel?addGame" method="POST">
            Date : <input type="date" name="gameDate" required><br>
            Time : <input type="time" name="gameTime" required><br>
            League : <input type="text" name="league" required><br>
            Home : <?php dropDownTeams('home') ?><br>
            Away : <?php dropDownTeams('away') ?><br>
            Home Odd : <input type="number" step="0.1" name="homeOdd"><br>
            Away Odd : <input type="number" step="0.1" name="awayOdd"><br>
            <button type="submit">Créer le match</button>
        </form>
    </section>
</div>

<button type="button" class="collapsible"><h2>Ajouter une équipe</h2></button>
<div class="collapsible-content">
    <section class="Contact">
        <h2>Créer une équipe</h2>
        <form class="contactForm" action="admin_panel?addTeam" method="POST">
            Nom* : <input type="text" name="teamName" required><br>
            Logo url* : <input type="text" name="logo" required><br>
            <button type="submit">Créer l'équipe</button>
        </form>
    </section>
</div>


<!-- GESTION DE REQUETE POST (formulaires) -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["addGame"])) {
        $league = $_POST['league'];
        $home = $_POST['home'];
        $away = $_POST['away'];
        $gameDate = $_POST['gameDate'];
        $gameTime = $_POST['gameTime'];
        $homeOdd = $_POST['homeOdd'];
        $awayOdd = $_POST['awayOdd'];

        if ($isLive == 'on') {
            $isLive = 1;
        } else {
            $isLive = 0;
        }

        // cotes dynamiques par defaut
        $homeDynaOdd = 1;
        $drawDynaOdd = 1;
        $awayDynaOdd = 1;


        $stmt = $pdo->prepare("INSERT INTO Games (League, Home, Away, GameDate, GameTime, HomeOdd, AwayOdd, HomeDynaOdd, DrawDynaOdd, AwayDynaOdd) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$league, $home, $away, $gameDate, $gameTime, $homeOdd, $awayOdd, $homeDynaOdd, $drawDynaOdd, $awayDynaOdd]);
        header("Refresh:0");
        exit();
    }
    if (isset($_GET["addTeam"])) {
        $teamName = $_POST['teamName'];
        $logo = $_POST['logo'];


        $stmt = $pdo->prepare("INSERT INTO Teams (TeamName, TeamLogo) VALUES (?,?)");
        $stmt->execute([$teamName, $logo]);
        header("Refresh:0");
        exit();
    }
    if (isset($_GET["modifyGame"])) {
        header("Location: /site_paris_sportifs/game_panel?id=".$_GET['id']);
        exit();
    }
    if (isset($_GET["deleteTeam"])) {
        $stmt = $pdo->prepare("DELETE FROM Teams WHERE ID=?");
        $stmt->execute([$_GET['id']]);
        header("Refresh:0");
        exit();
    }
}
?>

<script src="/site_paris_sportifs/public/js/collapse.js"></script>

<!--fin du contenu -->
<?php
$title = 'Admin Panel'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
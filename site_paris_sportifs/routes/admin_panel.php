<?php
//page de login
ob_start();
?>

<!--contenu de la page -->

<?php
session_start();

// sécurité
require_once('includes/helpers.php');
checkAdmin();

?>

<h1>Panneau de configuration administrateur</h1>


<!-- Tableau des matchs disponibles -->

<h2>Modifier un match</h2>

<table>
    <tr>
        <th>Game ID</th>
        <th>Home</th>
        <th>Away</th>
        <th>Game Date</th>
        <th>Is Live</th>
        <th>H2H</th>
        <th>Home Score</th>
        <th>Away Score</th>
        <th>Modify</th>
        <th>Delete</th>
    </tr>
    <?php
    require_once('includes/helpers.php');
    $pdo = openDB();
    
    $stmt = $pdo->prepare("SELECT * FROM Games");
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($games as $game) {
        echo "<tr>";
        echo "<td>".$game["ID"]."</td>";
        echo "<td>".$game["Home"]."</td>";
        echo "<td>".$game["Away"]."</td>";
        echo "<td>".$game["GameDate"]."</td>";
        echo "<td>".$game["isLive"]."</td>";
        echo "<td>".$game["H2H"]."</td>";
        echo "<td>".$game["HomeScore"]."</td>";
        echo "<td>".$game["AwayScore"]."</td>";
        echo '<td><a type="button" href="/site_paris_sportifs/modify">Modifier</a></td>';
        echo '<td><a type="button" href="/site_paris_sportifs/delete">Supprimer</a></td>';
        echo "</tr>";
    }

    ?>
</table>


<!-- Formulaire de création de nouveau matchs -->
<section class="Contact">
    <h2>Créer un match</h2>
    <form class="contactForm" action="admin_panel" method="POST">
        Date : <input type="date" name="gameDate" required><br>
        Home : <input type="text" name="home" required><br>
        Away : <input type="text" name="away" required><br>
        Is Live : <input type="checkbox" name="isLive"><br>
        H2H : <input type="number" name="H2H"><br>
        Home Score : <input type="number" name="homeScore"><br>
        Away Score : <input type="number" name="awayScore"><br>
        <button type="submit">Créer le match</button>
    </form>
</section>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $home = $_POST['home'];
        $away = $_POST['away'];
        $gameDate = $_POST['gameDate'];
        $isLive = $_POST['isLive'];
        $H2H = $_POST['H2H'];
        $homeScore = $_POST['homeScore'];
        $awayScore = $_POST['awayScore'];

        if ($isLive == 'on') {
            $isLive = 1;
        } else {
            $isLive = 0;
        }

        $stmt = $pdo->prepare("INSERT INTO Games (Home, Away, GameDate, isLive, H2H, HomeScore, AwayScore) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$home, $away, $gameDate, $isLive, $H2H, $homeScore, $awayScore]);
        header("Refresh:0");
        exit();
    }
?>

<!--fin du contenu -->
<?php
$title = 'Admin Panel'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
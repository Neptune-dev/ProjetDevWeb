<?php
//page "Mon compte"
ob_start();
?>

<!--contenu de la page -->
<?php
session_start();
require_once('includes/helpers.php');

if (!isset($_SESSION['user'])) {
    header("Location: /site_paris_sportifs/login");
    exit();
}
$user = $_SESSION['user'];

$pdo = openDB();

// Récupération du solde
$stmt = $pdo->prepare("SELECT Balance FROM Wallets WHERE UserID = ?");
$stmt->execute([$user["ID"]]);
$wallet = $stmt->fetch();

$balance = $wallet ? $wallet["Balance"] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // mise à jour de la bio
    $bio = $_POST["bio"];
    if ($bio != '') {
        $stmt = $pdo->prepare("UPDATE Users SET Bio = ? WHERE ID = ?");
        $stmt->execute([$bio, $user["ID"]]);
    }
    
    //mise à jour de la photo de profil
    $teamID = $_POST["profilePicture"];
    $stmt = $pdo->prepare("SELECT TeamLogo FROM Teams WHERE ID=?");
    $stmt->execute([$teamID]);
    $teamLogo = $stmt->fetchColumn();
    $stmt = $pdo->prepare("UPDATE Users SET Picture = ? WHERE ID = ?");
    $stmt->execute([$teamLogo, $user["ID"]]);

    header('Refresh:0');
    exit();
}

// récupération de la bio
$stmt = $pdo->prepare("SELECT Bio FROM Users WHERE ID = ?");
$stmt->execute([$user["ID"]]);
$user["Bio"] = $stmt->fetchColumn();

// récupération de la photo de profil
$stmt = $pdo->prepare("SELECT Picture FROM Users WHERE ID = ?");
$stmt->execute([$user["ID"]]);
$user["Picture"] = $stmt->fetchColumn();

//vérif de si il n'y a pas de logo choisi par default
if ($user['Picture'] == '' || $user["Picture"] == null) {
    $user['Picture'] = 'public/images/favicon3.png';
}

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

<section class="account">

    <div class="profile-container">
        <div class="user-info">
            <img src="<?= $user["Picture"] ?>" alt="Avatar" class="avatar">
            <div class="user-details">
                <h1 class="username">Bienvenue, <?= htmlspecialchars($user['Username']) ?> !</h1>
                <p class="bio">
                    <?php
                    if (isset($user["Bio"])) {
                        echo $user["Bio"];
                    } else {
                        echo 'Aucune bio renseignée.';
                    }  
                    ?>
                </p>
            </div>
        </div>
        <button class="edit-profile" id="edit-profile" onclick="toggleEditForm()">Modifier le profil</button>

        <form id="edit-form" action="mon_compte" method="POST" style="display: none;">
            <p>Logo de profil :</p>
            <?php dropDownTeams('profilePicture') ?><br>
            <textarea name="bio" maxlength="255" placeholder="Votre nouvelle bio (max 255 caractères)"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
            <button type="submit">Enregistrer</button>
        </form>
    </div>

    <!-- amis -->
    
    <h2>Mes amis</h2>
    <table>
        <tr>
            <th>Pseudo</th>
            <th>Pofil</th>
            <th>Gains Hebdo</th>
            <th>Historique</th>
            <th>Supprimer</th>
        </tr>
        <?php
        require_once('includes/helpers.php');
        $pdo = openDB();
        
        $stmt = $pdo->prepare("SELECT * FROM Friends JOIN Users AS UserA ON Friends.A = UserA.ID JOIN Users AS UserB ON Friends.B = UserB.ID WHERE Friends.A = ? OR Friends.B = ? ");
        $stmt->execute();
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($friends as $friends) {
            if (!isset($game['H2H'])) {
                echo "<tr>";
                echo "<td>".$friens["Username"]."</td>";
                echo "<td>".$friens["Picture"]."</td>";
                echo "<td>".$friens["Username"]."</td>";
                echo "<td>".$friens["Username"]."</td>";
                //bouton de modification
                echo '<td><form action="admin_panel?modifyGame&id='.$friend["ID"].'" method="POST"><button type="submit">Supprimer</button></form></td>';
                echo "</tr>";
            }
        }
        ?>
    </table>

    <script>
    function toggleEditForm() {
        const btn = document.getElementById("edit-profile");
        btn.innerText = btn.innerText == "Annuler" ? "Modifier le profil" : "Annuler";
        const form = document.getElementById("edit-form");
        form.style.display = form.style.display === "none" ? "block" : "none";
    }
    </script>

    <div class="text">
        <p>Heureux de vous revoir sur notre site de paris sportifs 🎯</p>
    </div>

    <div class="TopPari">
        <?php if (empty($user['isAdmin'])): ?>
            <h1>Vos Paris</h1>
        <?php endif; ?>
        <?php
            require_once('includes/helpers.php');
            $pdo = openDB();
            $stmt = $pdo->prepare('SELECT * FROM Bets WHERE UserID=?');
            $stmt->execute([$user['ID']]);
            $bets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($bets)) {
                echo '<p class="text" style="color:black;">Vous n'."'avez pas encore fait de paris</p>";
            } else {
                foreach ($bets as $bet) {
                    $_GET['bet'] = $bet;
                    require ('views/bet_view.php');
                }
            }
        ?>
    </div>
    
    <div class ="centre">
    <?php if (isset($user['isAdmin']) && $user['isAdmin']): ?>
        <button><a href="/site_paris_sportifs/admin_panel">Accéder au panneau d'administration</a></button>
    <?php else: ?>
        
        <button id="adButton">Regarder une publicité (+200 unités)</button>

        <div class="video-container" id="videoContainer"></div>
        
        <p id="rewardMsg"></p>

    <?php endif; ?>
    <script src="/site_paris_sportifs/public/js/script.js"></script>
    <button><a href="/site_paris_sportifs/logout">Se déconnecter</a></button>
    </div>
</section>

<!--fin du contenu -->
<?php
$title = 'Mon Compte'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
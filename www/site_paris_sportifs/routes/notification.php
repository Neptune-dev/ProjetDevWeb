<?php
//page de l'admin
ob_start();
?>

<!--contenu de la page -->

<h1 class="titre_orange">Mes Notifications</h1>

<?php
session_start();
require_once('includes/helpers.php');

if (!isset($_SESSION['user'])) {
    header("Location: /site_paris_sportifs/login");
    exit();
}
$user = $_SESSION['user'];

?>
    <?php
        $user = $_SESSION['user'];
        
        require_once('includes/helpers.php');
        $pdo = openDB();
        
        $stmt = $pdo->prepare("SELECT FriendRequests.ID AS ID, Sender.Username AS pseudo, Sender.Picture AS Profil, Sender.ID AS senderId FROM FriendRequests JOIN Users AS Sender ON FriendRequests.Sender = Sender.ID 
                                WHERE Receiver = ?"); 
        $stmt->execute([$user['ID']]);
        $notifs= $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //suppression du match
            if (isset($_GET["delete"]) && isset ($_GET["id"])) {
                $stmt = $pdo->prepare("DELETE FROM Friends WHERE ID=?");
                $stmt->execute([$_GET['id']]);
                header("Location: /site_paris_sportifs/friends");
                exit();
            }
            if (isset($_GET["stats"]) && isset ($_GET["id"])) {
                header("Location: /site_paris_sportifs/mes_stats?id=".$_GET['id']);
                exit();
            } 
        }      

        if (sizeof($notifs) != 0) {
            foreach ($notifs as $notif) {

                //vérif de si il n'y a pas de logo choisi par default
                if ($notif['Profil'] == '' || $notif["Profil"] == null) {
                    $notif['Profil'] = 'public/images/favicon3.png';
                }

                echo "<table>
                        <tr>
                            <th>Pseudo</th>
                            <th>Pofil</th>
                            <th>Gains Hebdo</th>
                            <th>Stats</th>
                            <th>Accepter</th>
                            <th>Refuser</th>
                        </tr>";
                echo "<tr>";
                echo "<td>".$notif["pseudo"]."</td>";
                echo '<td><img src="'.$notif["Profil"].'" alt="Team Logo" style="width: 10vh;"></td>';
                echo "<td>".$notif["ID"]."</td>";
                //bouton statistiques
                echo '<td><form action="notificationss?stats&id='.$notif["senderId"].'" method="POST"><button type="submit">Stats</button></form></td>';
                //bouton de suppression de l'ami
                echo '<td><form action="notificationss?accepte&id='.$notifs["ID"].'" method="POST"><button type="submit">Accepter</button></form></td>';
                echo '<td><form action="notificationss?delete&id='.$notifs["ID"].'" method="POST"><button type="submit">Refuser</button></form></td>';
                echo "</tr></table>";
            }
        } else {
            echo '<div class="text">'."<p>Vous n'avez pas encore de notifications.</p></div>";
        }
    ?>

<!--fin du contenu -->
<?php
$title = 'Notifications'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
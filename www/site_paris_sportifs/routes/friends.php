<?php
ob_start();
?>

<!--contenu de la page -->

<?php

session_start();

?>

<h3>Mes amis</h3>

    <?php
        $user = $_SESSION['user'];
        
        require_once('includes/helpers.php');
        $pdo = openDB();
        
        $stmt = $pdo->prepare("SELECT Friends.ID AS ID,If (Friends.A= ?, UserB.ID,UserA.ID) AS Friend,If (Friends.A= ?, UserB.Username,UserA.Username) AS Pseudo,If (Friends.A= ?, UserB.Picture,UserA.Picture) AS Profil  FROM Friends JOIN Users AS UserA ON Friends.A = UserA.ID
                                JOIN Users AS UserB ON Friends.B = UserB.ID
                                WHERE ((UserA.ID = ? OR UserB.ID = ?) AND (IF(Friends.A = ?, UserB.ID, UserA.ID) != ?))"); 
        $stmt->execute([$user['ID'], $user['ID'],$user['ID'], $user['ID'], $user['ID'], $user['ID'], $user['ID']]);
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //suppression du match
            if (isset($_GET["delete"]) && isset ($_GET["id"])) {
                $stmt = $pdo->prepare("DELETE FROM Friends WHERE ID=?");
                $stmt->execute([$_GET['id']]);
                header("Location: /site_paris_sportifs/friends");
                exit();
            }
        }       

        if (sizeof($friends) != 0) {
            foreach ($friends as $friend) {

                //vérif de si il n'y a pas de logo choisi par default
                if ($friend['Profil'] == '' || $friend["Profil"] == null) {
                    $friend['Profil'] = 'public/images/favicon3.png';
                }

                echo "<table>
                        <tr>
                            <th>Pseudo</th>
                            <th>Pofil</th>
                            <th>Gains Hebdo</th>
                            <th>Historique</th>
                            <th>Supprimer</th>
                        </tr>";
                echo "<tr>";
                echo "<td>".$friend["Pseudo"]."</td>";
                echo '<td><img src="'.$friend["Profil"].'" alt="Team Logo" style="width: 10vh;"></td>';
                echo "<td>".$friend["ID"]."</td>";
                //bouton d'historique
                echo '<td><form action="admin_panel?modifyGame&id='.$friend["ID"].'" method="POST"><button type="submit">Historique</button></form></td>';
                //bouton de suppression de l'ami
                echo '<td><form action="friends?delete&id='.$friend["ID"].'" method="POST"><button type="submit">Supprimer</button></form></td>';
                echo "</tr></table>";
            }
        } else {
            echo '<div class="text">'."<p>Vous n'avez pas encore d'amis.</p></div>";
        }
    ?>
    




<!--fin du contenu -->
<?php
$title = 'Mes Amis'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
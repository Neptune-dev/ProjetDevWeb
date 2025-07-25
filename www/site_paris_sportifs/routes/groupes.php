<?php
//page de l'admin
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
?>

<button type="button" class="collapsible"><h2>Créer un groupe</h2></button>        
<div class="collapsible-content">
    <section class="Contact">
        <h2>Créer votre Groupe</h2>
        <form class="contactForm" action="groupes?creer" method="POST">
            Nom du groupe* :<input type="text" name="nom_groupe" required><br>
            Limite d'investissement* :<input type="number" name="limite" required><br>
            <button type="submit">Créer</button>
        </form>
    </section>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["creer"])) {
        $nom_groupe = $_POST['nom_groupe'];
        $limite = $_POST['limite'];

        $stmt = $pdo->prepare("INSERT INTO Groupes(GroupName, Limitation, CreatorID) VALUES (?, ?,?)");
        $stmt->execute([$nom_groupe, $limite, $user['ID']]);

        header("Location: /site_paris_sportifs/groupes");
        exit();
    }
}
?>

<h1 class="titre_orange">Mes Groupes</h1>
    <table>
        <tr>
            <th>Nom</th>
            <th>Limite</th>
            <th>Entrer</th>
        </tr>
        <?php
        require_once('includes/helpers.php');
        $pdo = openDB();
        
        $stmt = $pdo->prepare("SELECT * FROM Groupes");
        $stmt->execute();
        $groupes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($groupes as $groupe) {
                echo "<tr>";
                echo "<td>".$groupe["GroupName"]."</td>";
                echo "<td>".$groupe["Limitation"]."</td>";
                echo '<td><form action="groupes?modifyGame&id='.$groupe["ID"].'" method="POST"><button type="submit">Entrer</button></form></td>';
                echo "</tr>";
        }
        ?>
    </table>

<script src="/site_paris_sportifs/public/js/collapse.js"></script>

<!--fin du contenu -->
<?php
$title = 'Groupes Amis'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
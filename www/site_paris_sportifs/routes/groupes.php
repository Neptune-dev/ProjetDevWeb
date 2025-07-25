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

        $stmt = $pdo->prepare("INSERT INTO Groupes(GroupName, Limitation) VALUES (?, ?)");
        $stmt->execute([$nom_groupe, $limite]);

        header("Location: /site_paris_sportifs/groupes");
        exit();
    }
}
?>



<script src="/site_paris_sportifs/public/js/collapse.js"></script>

<!--fin du contenu -->
<?php
$title = 'Groupes Amis'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
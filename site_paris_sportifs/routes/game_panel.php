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
}


?>

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
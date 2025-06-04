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
    $stmt = $pdo->prepare("SELECT * FROM Games");
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $check = 0;
    foreach ($games as $game) {
        if ($game['id'] == $_GET["id"]) {
            $check = 1;
        }
    }
    if ($check == 0) {
        header('Location: /site_paris_sportifs/404?ressource=matchID:'.$_GET["id"]);
        exit();
    } else {
        $pdo = openDB();
        $stmt = $pdo->prepare("SELECT * FROM Games WHERE ID=?");
        $stmt->execute([$_GET["id"]]);
        $game = $stmt->fetch();
    }
}




echo $game['League'];


?>

<!--fin du contenu -->
<?php
$title = 'Game Panel'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
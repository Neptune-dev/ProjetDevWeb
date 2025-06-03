<?php
session_start();
require_once('includes/helpers.php');

//Il faudra faire avec la bio des utilisateurs en base de données !

/*

$pdo = openDB(); //Il faudra faire avec la bio des utilisateurs en base de données !

// Traitement de la mise à jour du profil
if (isset($_SESSION['user'], $_POST['bio'])) {
    $bio = trim($_POST['bio']);
    if (strlen($bio) <= 256) {
        $stmt = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
        $stmt->execute([$bio, $_SESSION['user']['id']]);

        // Mets à jour la session si nécessaire
        $_SESSION['user']['bio'] = $bio;
    }
    header("Location: /site_paris_sportifs/mon_compte");
    exit;
    }
?>

*/
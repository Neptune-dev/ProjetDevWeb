<?php
ob_start();
?>

<!--contenu de la page -->

<?php

session_start();

?>


<h3>Historique des paris</h3>

<?php
require_once('includes/helpers.php');
$pdo = openDB();
?>

<section class="TopPari">
    <?php
    if (!isset($_GET['id'])) {
        echo "Aucun utilisateur sélectionné.";
    } else {
        $userId = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM Bets WHERE UserID=? and Finished=1");
        $stmt->execute([$userId]);
        $bets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($bets)) {
            echo '<p class="text" style="color:black;">Aucun paris effectué</p>';
        } else {
            foreach ($bets as $bet) {
                $_GET['bet'] = $bet;
                require ('views/bet_view.php');
            }
        }
    }
    ?>
</div>



<!--fin du contenu -->
<?php
$title = 'historique'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
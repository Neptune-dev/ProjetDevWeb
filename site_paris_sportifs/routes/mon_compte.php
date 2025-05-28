<?php
//page "Mon compte"
ob_start();
?>

<!--contenu de la page -->
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /site_paris_sportifs/login");
    exit();
}
$user = $_SESSION['user'];
?>

<br>
<br>
<br>
<section class="account">
    <h1>Bienvenue, <?= htmlspecialchars($user['Username']) ?> !</h1>
    <p>Heureux de vous revoir sur notre site de paris sportifs 🎯</p>

    <?php if (isset($user['isAdmin']) && $user['isAdmin']): ?>
        <p><a href="/site_paris_sportifs/admin_panel">Accéder au panneau d'administration</a></p>
    <?php endif; ?>

    <a href="/site_paris_sportifs/logout" class="logout-btn">Se déconnecter</a>
</section>

<!--fin du contenu -->
<?php
$title = 'Mon Compte'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
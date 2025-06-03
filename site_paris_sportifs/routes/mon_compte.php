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
?>

<br>
<br>
<br>
<section class="account">
    <div class="profile-container">
        <div class="user-info">
            <img src="public/images/psg.webp" alt="Avatar" class="avatar">
            <div class="user-details">
                <h1 class="username">Bienvenue, <?= htmlspecialchars($user['Username']) ?> !</h1>
                <p class="bio"><?= htmlspecialchars($user['bio'] ?? 'Aucune bio renseignée.') ?></p>
            </div>
        </div>
        <button class="edit-profile">Modifier le profil</button>
    </div>

    <p>Heureux de vous revoir sur notre site de paris sportifs 🎯</p>

    <?php if (isset($user['isAdmin']) && $user['isAdmin']): ?>
        <a href="/site_paris_sportifs/admin_panel">Accéder au panneau d'administration</a>
    <?php else: ?>
        
        
        
        <p>💰 Solde actuel : <strong id="balance"><?= $balance ?></strong> unités</p>

        <button id="adButton">Regarder une publicité (+200 unités)</button>

        <div class="video-container" id="videoContainer"></div>
        
        <p id="rewardMsg"></p>






    <?php endif; ?>
    <script src="/site_paris_sportifs/public/js/script.js"></script>
    <a href="/site_paris_sportifs/logout" class="logout-btn">Se déconnecter</a>
</section>

<!--fin du contenu -->
<?php
$title = 'Mon Compte'; //titre de la page
$content = ob_get_clean();
require 'views/base.php';
?>
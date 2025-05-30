<?php
ob_start();
?>

<div class="match-bubble">
    <div class="teams">
        <div class="team">
            <img src="public/images/psg.webp" alt="PSG">
            <span class="team-name">PSG</span>
            <span class="team-name">1.75</span>
        </div>
        <span class="vs">VS</span>
        <div class="team">
            <img src="public/images/om.png" alt="OM">
            <span class="team-name">OM</span>
            <span class="team-name">4.20</span>
        </div>
    </div>
    <div class="odds">
        <div class="odd">1.75</div>
        <div class="odd">4.20</div>
    </div>
    <div class="match-info">
        Ligue 1 - 20h45 - 15/05/2023
    </div>
</div>

<?php
echo ob_get_clean();
?>

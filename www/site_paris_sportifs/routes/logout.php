<?php
session_start();
session_destroy();
header("Location: /site_paris_sportifs/");
exit();
?>
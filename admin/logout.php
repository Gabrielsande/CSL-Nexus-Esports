<?php
// admin/logout.php — Nexus Esports
session_start();
session_destroy();
header('Location: ../public/index.php');
exit;

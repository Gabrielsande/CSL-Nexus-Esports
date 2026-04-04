<?php
// admin/logout.php — FragZone
session_start();
session_destroy();
header('Location: ../public/index.php');
exit;

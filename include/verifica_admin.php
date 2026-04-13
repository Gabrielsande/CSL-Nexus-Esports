<?php
// include/verifica_admin.php — Nexus Esports
// Inclua DEPOIS de verifica_login.php (já faz session_start)
require_once __DIR__ . '/funcoes.php';
if (!is_admin()) redirecionar('../admin/dashboard.php');

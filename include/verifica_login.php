<?php
// include/verifica_login.php — Nexus Esports
session_start();
require_once __DIR__ . '/funcoes.php';
if (!usuario_logado()) redirecionar('../public/login.php');

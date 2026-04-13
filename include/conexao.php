<?php
// include/conexao.php — Nexus Esports
$host   = 'localhost';
$dbname = 'noticiasge';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user, $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die('<p style="font-family:monospace;color:#c0392b">Erro de conexão: '
        . htmlspecialchars($e->getMessage()) . '</p>');
}

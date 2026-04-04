<?php
// include/header.php — FragZone
// Requer: session_start() e require_once 'funcoes.php' antes de incluir

// Detecta raiz relativa dependendo de onde está o arquivo chamador
$depth = substr_count(str_replace('\\','/',__DIR__), '/');
// Caminho para assets a partir de qualquer pasta do projeto
$asset_root = '../assets';
?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? sanitizar($page_title) . ' — ' : '' ?>FragZone</title>
    <link rel="stylesheet" href="<?= $asset_root ?>/css/style.css">
    <script>
        (function(){
            var t = localStorage.getItem('fragzone-theme') || 'dark';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>

<?php
$atual = basename($_SERVER['PHP_SELF'], '.php');
function nav_active(string $page): string {
    global $atual;
    return $atual === $page ? ' active' : '';
}

// Define prefixos de link conforme pasta do arquivo atual
$is_admin_page  = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$public_prefix  = $is_admin_page ? '../public/' : '';
$admin_prefix   = $is_admin_page ? '' : '../admin/';
?>

<header>
    <!-- Topbar -->
    <div class="topbar">
        <span>🎮 Portal de Games &amp; E-Sports do Brasil</span>
        <div class="topbar-right">
            <span><?= date('d/m/Y') ?></span>
            <?php if (usuario_logado()): ?>
                <span>Olá, <strong><?= sanitizar($_SESSION['usuario_nome']) ?></strong>
                <?php if (is_admin()): ?>
                    <span class="badge-admin">ADMIN</span>
                <?php endif; ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Logo + Search + Actions -->
    <div class="header-brand">
        <div class="header-brand-inner">
            <a href="<?= $public_prefix ?>index.php" class="logo">
                <span class="logo-name">FRAG<em>ZONE</em></span>
                <span class="logo-sub">Games &amp; E-Sports News</span>
            </a>

            <form class="search-form" action="<?= $public_prefix ?>index.php" method="GET" role="search">
                <input class="search-input" type="search" name="q"
                       placeholder="Buscar notícias, jogos, campeonatos..."
                       value="<?= isset($_GET['q']) ? sanitizar($_GET['q']) : '' ?>"
                       autocomplete="off" aria-label="Buscar">
                <button class="search-btn" type="submit" aria-label="Pesquisar">🔍</button>
            </form>

            <div class="header-actions">
                <button class="btn-theme" id="theme-btn" onclick="toggleTheme()" title="Alternar tema">☀️</button>
                <?php if (!usuario_logado()): ?>
                    <a href="<?= $public_prefix ?>cadastro.php" class="btn btn-primary btn-sm">Cadastrar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" aria-label="Navegação principal">
        <div class="navbar-inner">
            <ul class="navbar-links">
                <li><a href="<?= $public_prefix ?>index.php" class="<?= nav_active('index') ?>">Início</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=esports">E-Sports <span class="live-badge">Ao vivo</span></a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=games">Games</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=campeonatos">Campeonatos</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=lancamentos">Lançamentos</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=analises">Análises</a></li>
            </ul>

            <div class="navbar-auth">
                <?php if (usuario_logado()): ?>
                    <a href="<?= $admin_prefix ?>dashboard.php">Painel</a>
                    <?php if (is_admin()): ?>
                        <a href="<?= $admin_prefix ?>gerenciar_usuarios.php" style="color:#f39c12; font-weight:700">👥 Usuários</a>
                    <?php endif; ?>
                    <a href="<?= $admin_prefix ?>nova_noticia.php" style="color:var(--red); font-weight:900">+ Notícia</a>
                    <a href="<?= $admin_prefix ?>logout.php">Sair</a>
                <?php else: ?>
                    <a href="<?= $public_prefix ?>login.php">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Ticker -->
    <div class="ticker">
        <span class="ticker-label">Destaques</span>
        <div class="ticker-track">
            <span class="ticker-scroll">
                CBLOL 2026: LOUD encerra fase de grupos invicta com 9 vitórias
                <span class="ticker-sep">|</span>
                CS2 Major de Paris: premiação recorde de US$ 2 milhões confirmada
                <span class="ticker-sep">|</span>
                Free Fire World Series: Brasil é tricampeão mundial em Bangkok
                <span class="ticker-sep">|</span>
                GTA VI chega em setembro de 2026 para PS5 e Xbox Series
                <span class="ticker-sep">|</span>
                Valorant Champions Tour: Brasil garante 3 vagas internacionais
                <span class="ticker-sep">|</span>
                Nintendo anuncia novo Direct com novidades para o Switch 2
                <span class="ticker-sep">|</span>
                League of Legends: nova temporada traz mudanças radicais no mapa
            </span>
        </div>
    </div>
</header>

<script>
function toggleTheme() {
    var html = document.documentElement;
    var cur  = html.getAttribute('data-theme');
    var next = cur === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('fragzone-theme', next);
    document.getElementById('theme-btn').textContent = next === 'dark' ? '☀️' : '🌙';
}
(function(){
    var t   = localStorage.getItem('fragzone-theme') || 'dark';
    var btn = document.getElementById('theme-btn');
    document.documentElement.setAttribute('data-theme', t);
    if (btn) btn.textContent = t === 'dark' ? '☀️' : '🌙';
})();
</script>

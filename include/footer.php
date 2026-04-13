<?php
// include/footer.php — Nexus Esports
$is_admin_page = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$public_prefix = $is_admin_page ? '../public/' : '';
$admin_prefix  = $is_admin_page ? '' : '../admin/';
?>
<footer>
    <div class="footer-inner">
        <div class="footer-brand">
            <a href="<?= $public_prefix ?>index.php" class="logo" style="text-decoration:none">
                <span class="logo-name">NEXUS<em>ESPORTS</em></span>
            </a>
            <p>O portal de referência em notícias de Games e E-Sports do Brasil. Cobertura completa de campeonatos, lançamentos e tudo que acontece no universo gamer.</p>
            <span class="footer-badge">🎮 PHP · MySQL · NoticiasGE</span>
        </div>

        <div class="footer-col">
            <h4>Navegação</h4>
            <ul>
                <li><a href="<?= $public_prefix ?>index.php">🏠 Início</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=games">🎮 E-Sports &amp; Games</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=lancamentos">🚀 Lançamentos</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=mundo_gamer">🌐 Mundo Gamer</a></li>
                <li><a href="<?= $public_prefix ?>index.php?cat=guias">📖 Guias</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Portal</h4>
            <ul>
                <?php if (usuario_logado()): ?>
                    <li><a href="<?= $admin_prefix ?>dashboard.php">📊 Dashboard</a></li>
                    <li><a href="<?= $admin_prefix ?>nova_noticia.php">📝 Nova Notícia</a></li>
                    <?php if (is_admin()): ?>
                        <li><a href="<?= $admin_prefix ?>gerenciar_usuarios.php">👥 Gerenciar Usuários</a></li>
                    <?php endif; ?>
                    <li><a href="<?= $admin_prefix ?>logout.php">🚪 Sair</a></li>
                <?php else: ?>
                    <li><a href="<?= $public_prefix ?>login.php">🔑 Login</a></li>
                    <li><a href="<?= $public_prefix ?>cadastro.php">📋 Cadastro</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p class="footer-copy">&copy; <?= date('Y') ?> <strong>Nexus Esports</strong> — Todos os direitos reservados.</p>
        <span class="footer-tech">
            💻 <strong>Dev Sandes</strong> ·
            <a href="https://github.com/Gabrielsande" target="_blank" rel="noopener" style="color:var(--red);text-decoration:none;">
                GitHub
            </a>
        </span>
    </div>
</footer>
</body>
</html>

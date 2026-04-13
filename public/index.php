<?php
// public/index.php — Nexus Esports
session_start();
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

$busca = trim($_GET['q']   ?? '');
$cat   = trim($_GET['cat'] ?? '');

if ($busca !== '') {
    $stmt = $pdo->prepare("
        SELECT n.*, u.nome AS autor_nome
        FROM noticias n JOIN usuarios u ON n.autor = u.id
        WHERE n.titulo LIKE ? OR n.noticia LIKE ?
        ORDER BY n.data DESC
    ");
    $like = '%' . $busca . '%';
    $stmt->execute([$like, $like]);
} elseif ($cat !== '') {
    $stmt = $pdo->prepare("
        SELECT n.*, u.nome AS autor_nome
        FROM noticias n JOIN usuarios u ON n.autor = u.id
        WHERE n.categoria = ?
        ORDER BY n.data DESC
    ");
    $stmt->execute([$cat]);
} else {
    $stmt = $pdo->query("
        SELECT n.*, u.nome AS autor_nome
        FROM noticias n JOIN usuarios u ON n.autor = u.id
        ORDER BY n.data DESC
    ");
}
$noticias = $stmt->fetchAll();

$page_title = $busca ? 'Busca: ' . $busca : ($cat ? label_categoria($cat) : 'Início');
include '../include/header.php';
?>

<?php if (!$busca && !$cat): ?>
<section class="hero-fullscreen" id="hero">
    <div class="hero-bg-grid"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="hero-inner">
        <div class="hero-eyebrow">
            <span class="hero-live-dot"></span>
            Portal Oficial · Games &amp; E-Sports
        </div>
        <h1 class="hero-title">
            <span class="ht-nexus">NEXUS</span>
            <span class="ht-esports">ESPORTS</span>
        </h1>
        <p class="hero-sub">As melhores notícias do universo gamer em um só lugar.<br>Cobertura completa de campeonatos, lançamentos e e-sports.</p>

        <div class="hero-actions">
            <?php if (usuario_logado()): ?>
                <a href="../admin/dashboard.php" class="hero-btn hero-btn-primary">
                    📊 Dashboard
                </a>
                <a href="../admin/nova_noticia.php" class="hero-btn hero-btn-ghost">
                    ✏️ Publicar Notícia
                </a>
            <?php else: ?>
                <a href="login.php" class="hero-btn hero-btn-primary">
                    🔑 Fazer Login
                </a>
                <a href="cadastro.php" class="hero-btn hero-btn-ghost">
                    📋 Cadastrar-se
                </a>
            <?php endif; ?>
        </div>




        
        <a href="#noticias" class="hero-scroll-hint">
            <span class="scroll-arrow">↓</span>
            <span>Ver notícias</span>
        </a>
    </div>
</section>
<?php endif; ?>

<div class="container container-pad" id="noticias">

    <?php if ($busca || $cat): ?>
    <div class="cat-filter-bar">
        <a href="index.php" class="cat-pill">📰 Todas</a>
        <a href="index.php?cat=games"       class="cat-pill<?= $cat==='games'       ?' active':'' ?>">🎮 E-Sports &amp; Games</a>
        <a href="index.php?cat=lancamentos" class="cat-pill<?= $cat==='lancamentos' ?' active':'' ?>">🚀 Lançamentos</a>
        <a href="index.php?cat=mundo_gamer" class="cat-pill<?= $cat==='mundo_gamer' ?' active':'' ?>">🌐 Mundo Gamer</a>
        <a href="index.php?cat=guias"       class="cat-pill<?= $cat==='guias'       ?' active':'' ?>">📖 Guias</a>
    </div>
    <?php endif; ?>

    <div class="section-head">
        <div class="section-head-left">
            <div class="section-head-bar"></div>
            <h2>
                <?php if ($busca): ?>Resultados para "<?= sanitizar($busca) ?>"
                <?php elseif ($cat): ?><?= label_categoria($cat) ?>
                <?php else: ?>Últimas Notícias
                <?php endif; ?>
            </h2>
        </div>
        <?php if (usuario_logado()): ?>
            <a href="../admin/nova_noticia.php" class="btn btn-primary btn-sm">+ Publicar</a>
        <?php endif; ?>
    </div>

    <?php if (empty($noticias)): ?>
        <div class="empty-state">
            <span class="ei"><?= $busca ? '🔍' : '📭' ?></span>
            <h3><?= $busca ? 'Nenhum resultado' : 'Nenhuma notícia nesta categoria' ?></h3>
            <p><?= $busca ? 'Tente outros termos.' : 'Seja o primeiro a publicar!' ?></p>
            <?php if ($cat || $busca): ?>
                <a href="index.php" class="btn btn-ghost mt-2">← Voltar ao início</a>
            <?php elseif (usuario_logado()): ?>
                <a href="../admin/nova_noticia.php" class="btn btn-primary mt-2">+ Nova Notícia</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="news-grid">
            <?php foreach ($noticias as $i => $n):
                if (!$busca) {
                    if ($i === 0)          $cardClass = 'card-pos-0';
                    elseif ($i === 1)      $cardClass = 'card-pos-1';
                    elseif ($i === 2)      $cardClass = 'card-pos-2';
                    elseif ($i === 3)      $cardClass = 'card-pos-3';
                    elseif ($i === 4)      $cardClass = 'card-pos-4';
                    elseif ($i === 5)      $cardClass = 'card-pos-5';
                    elseif ($i === 6)      $cardClass = 'card-pos-6';
                    elseif ($i === 7)      $cardClass = 'card-pos-7';
                    else                   $cardClass = 'card-pos-rest';
                } else {
                    $cardClass = 'card-pos-rest';
                }
                $excerptLen = match($cardClass) {
                    'card-pos-0' => 260,
                    'card-pos-7' => 200,
                    default      => 150,
                };
            ?>
            <article class="card <?= $cardClass ?>">
                <div class="card-img">
                    <?php if ($n['imagem']): ?>
                        <img src="../assets/img/<?= sanitizar($n['imagem']) ?>"
                             alt="<?= sanitizar($n['titulo']) ?>"
                             loading="<?= $i<3?'eager':'lazy' ?>">
                    <?php else: ?>
                        <div class="card-img-placeholder">🎮</div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if ($n['categoria']): ?>
                        <a href="index.php?cat=<?= urlencode($n['categoria']) ?>" class="card-tag">
                            <?= label_categoria($n['categoria']) ?>
                        </a>
                    <?php else: ?>
                        <span class="card-tag">📰 Geral</span>
                    <?php endif; ?>
                    <h2><a href="noticia.php?id=<?= $n['id'] ?>"><?= sanitizar($n['titulo']) ?></a></h2>
                    <p class="card-excerpt"><?= sanitizar(resumo($n['noticia'], $excerptLen)) ?></p>
                    <div class="card-meta">
                        <span class="card-meta-author">✍ <?= sanitizar($n['autor_nome']) ?></span>
                        <span><?= formatar_data_curta($n['data']) ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
// ── Partículas ────────────────────────────────────────────────────────
(function(){
    const c = document.getElementById('particles');
    if (!c) return;
    for (let i = 0; i < 30; i++) {
        const p = document.createElement('span');
        p.className = 'particle';
        p.style.cssText = `left:${Math.random()*100}%;top:${Math.random()*100}%;width:${2+Math.random()*3}px;height:${2+Math.random()*3}px;animation-delay:${Math.random()*8}s;animation-duration:${5+Math.random()*8}s`;
        c.appendChild(p);
    }
})();
</script>

<?php include '../include/footer.php'; ?>

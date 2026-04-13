<?php
// admin/nova_noticia.php — Nexus Esports
require_once __DIR__ . '/../include/verifica_login.php';
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

$erro = ''; $sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = sanitizar($_POST['titulo']    ?? '');
    $conteudo  = trim($_POST['noticia']        ?? '');
    $categoria = sanitizar($_POST['categoria'] ?? '');
    $autor     = $_SESSION['usuario_id'];
    $imagemNome = null;

    $cats_validas = cats_validas();
    $admin_only   = cats_admin_only();

    if (!$titulo || !$conteudo || !$categoria) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } elseif (!in_array($categoria, $cats_validas)) {
        $erro = 'Categoria inválida.';
    } elseif (in_array($categoria, $admin_only) && !is_admin()) {
        $erro = '🔒 Apenas administradores podem publicar em Mundo Gamer e Guias.';
    } else {
        // Upload de imagem
        if (!empty($_FILES['imagem']['name'])) {
            $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $erro = 'Formato de imagem inválido. Use JPG, PNG, GIF ou WEBP.';
            } elseif ($_FILES['imagem']['size'] > 5 * 1024 * 1024) {
                $erro = 'Imagem muito grande (máx 5 MB).';
            } else {
                $pasta = __DIR__ . '/../assets/img/';
                if (!is_dir($pasta)) mkdir($pasta, 0755, true);
                $nome_arq = uniqid('img_') . '.' . $ext;
                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $pasta . $nome_arq)) {
                    $imagemNome = $nome_arq;
                } else {
                    $erro = 'Erro ao fazer upload da imagem.';
                }
            }
        }

        if (!$erro) {
            $stmt = $pdo->prepare("
                INSERT INTO noticias (titulo, noticia, autor, data, imagem, categoria)
                VALUES (?, ?, ?, NOW(), ?, ?)
            ");
            $stmt->execute([$titulo, $conteudo, $autor, $imagemNome, $categoria]);
            $sucesso = 'Notícia publicada com sucesso!';
        }
    }
}

$page_title = 'Nova Notícia';
include '../include/header.php';
?>

<div class="container container-pad">
    <div class="form-card wide">
        <div class="form-card-header">
            <h2>📰 Nova Notícia</h2>
            <p>Preencha os campos abaixo para publicar uma nova notícia no portal</p>
        </div>

        <?php if ($erro): ?>
            <div class="alert alert-error">⚠ <?= $erro ?></div>
        <?php endif; ?>
        <?php if ($sucesso): ?>
            <div class="alert alert-success">
                ✔ <?= $sucesso ?>
                <a href="../public/index.php" style="margin-left:1rem">Ver no portal →</a>
                <a href="nova_noticia.php" style="margin-left:.5rem">+ Outra notícia</a>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label class="form-label">Título *</label>
                <input class="form-control" type="text" name="titulo" required
                       placeholder="Título da notícia"
                       value="<?= isset($_POST['titulo']) ? sanitizar($_POST['titulo']) : '' ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Categoria *</label>
                <select class="form-control" name="categoria" required>
                    <option value="">— Selecione uma categoria —</option>
                    <option value="games"       <?= (($_POST['categoria'] ?? '') === 'games')       ? 'selected' : '' ?>>🎮 E-Sports &amp; Games</option>
                    <option value="lancamentos" <?= (($_POST['categoria'] ?? '') === 'lancamentos') ? 'selected' : '' ?>>🚀 Lançamentos</option>
                    <?php if (is_admin()): ?>
                    <optgroup label="━━ Exclusivo Admin ━━">
                        <option value="mundo_gamer" <?= (($_POST['categoria'] ?? '') === 'mundo_gamer') ? 'selected' : '' ?>>🌐 Mundo Gamer</option>
                        <option value="guias"       <?= (($_POST['categoria'] ?? '') === 'guias')       ? 'selected' : '' ?>>📖 Guias</option>
                    </optgroup>
                    <?php endif; ?>
                </select>
                <p class="form-hint">
                    A notícia aparecerá na aba "Início" e na aba da categoria escolhida.
                    <?php if (is_admin()): ?>
                        <strong style="color:var(--red)">🔒 Mundo Gamer e Guias são exclusivos de admin.</strong>
                    <?php endif; ?>
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">Conteúdo *</label>
                <textarea class="form-control" name="noticia" required
                          style="min-height:280px"
                          placeholder="Escreva o conteúdo completo da notícia aqui..."><?= isset($_POST['noticia']) ? sanitizar($_POST['noticia']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Imagem de capa</label>
                <input class="form-control" type="file" name="imagem" accept="image/*">
                <p class="form-hint">JPG, PNG, GIF ou WEBP · Máximo 5 MB</p>
            </div>

            <div class="flex gap-2 flex-wrap mt-2">
                <button type="submit" class="btn btn-primary">🚀 Publicar Notícia</button>
                <a href="dashboard.php" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include '../include/footer.php'; ?>

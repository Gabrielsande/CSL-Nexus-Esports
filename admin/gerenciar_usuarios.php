<?php
// admin/gerenciar_usuarios.php — FragZone (somente admin)
require_once __DIR__ . '/../include/verifica_login.php';
require_once __DIR__ . '/../include/verifica_admin.php';
require_once __DIR__ . '/../include/conexao.php';
require_once __DIR__ . '/../include/funcoes.php';

$erro = ''; $sucesso = '';
$acao = $_GET['acao'] ?? '';
$uid  = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;

// ── Ações via GET ──────────────────────────────────────────────────────────

// Aprovar acesso
if ($acao === 'aprovar' && $uid) {
    $pdo->prepare("UPDATE usuarios SET ativo = 1 WHERE id = ? AND tipo != 'admin'")
        ->execute([$uid]);
    $sucesso = 'Usuário aprovado com sucesso!';
}

// Revogar acesso
if ($acao === 'revogar' && $uid) {
    $pdo->prepare("UPDATE usuarios SET ativo = 0 WHERE id = ? AND tipo != 'admin'")
        ->execute([$uid]);
    $sucesso = 'Acesso do usuário revogado.';
}

// Promover a admin
if ($acao === 'promover' && $uid) {
    $pdo->prepare("UPDATE usuarios SET tipo = 'admin', ativo = 1 WHERE id = ?")
        ->execute([$uid]);
    $sucesso = 'Usuário promovido a administrador!';
}

// Rebaixar para jornalista
if ($acao === 'rebaixar' && $uid) {
    if ($uid === (int)$_SESSION['usuario_id']) {
        $erro = 'Você não pode rebaixar a si mesmo.';
    } else {
        $pdo->prepare("UPDATE usuarios SET tipo = 'jornalista' WHERE id = ?")
            ->execute([$uid]);
        $sucesso = 'Usuário rebaixado para jornalista.';
    }
}

// Excluir usuário
if ($acao === 'excluir' && $uid) {
    if ($uid === (int)$_SESSION['usuario_id']) {
        $erro = 'Você não pode excluir a si mesmo aqui.';
    } else {
        // Remove imagens das notícias do usuário
        $pasta = __DIR__ . '/../assets/img/';
        $imgs = $pdo->prepare("SELECT imagem FROM noticias WHERE autor = ? AND imagem IS NOT NULL");
        $imgs->execute([$uid]);
        foreach ($imgs->fetchAll() as $row) {
            if (file_exists($pasta . $row['imagem'])) unlink($pasta . $row['imagem']);
        }
        $pdo->prepare("DELETE FROM usuarios WHERE id = ?")->execute([$uid]);
        $sucesso = 'Usuário excluído com sucesso.';
    }
}

// ── Criar usuário (POST) ───────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'criar') {
    $nome  = sanitizar($_POST['nome']  ?? '');
    $email = sanitizar($_POST['email'] ?? '');
    $senha = $_POST['senha']           ?? '';
    $tipo  = in_array($_POST['tipo'] ?? '', ['admin','jornalista']) ? $_POST['tipo'] : 'jornalista';
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if (!$nome || !$email || !$senha) {
        $erro = 'Nome, e-mail e senha são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'Senha deve ter pelo menos 6 caracteres.';
    } else {
        $chk = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $chk->execute([$email]);
        if ($chk->fetch()) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo, ativo) VALUES (?,?,?,?,?)")
                ->execute([$nome, $email, $hash, $tipo, $ativo]);
            $sucesso = "Usuário \"$nome\" criado com sucesso!";
        }
    }
}

// ── Editar usuário (POST) ──────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'editar') {
    $edit_uid = (int)($_POST['uid'] ?? 0);
    $nome     = sanitizar($_POST['nome']  ?? '');
    $email    = sanitizar($_POST['email'] ?? '');
    $senha    = $_POST['senha']           ?? '';
    $tipo     = in_array($_POST['tipo'] ?? '', ['admin','jornalista']) ? $_POST['tipo'] : 'jornalista';
    $ativo    = isset($_POST['ativo']) ? 1 : 0;

    // Não permite rebaixar ou desativar a si mesmo
    if ($edit_uid === (int)$_SESSION['usuario_id']) {
        $tipo  = 'admin';
        $ativo = 1;
    }

    if (!$nome || !$email) {
        $erro = 'Nome e e-mail são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif ($senha && strlen($senha) < 6) {
        $erro = 'Nova senha deve ter pelo menos 6 caracteres.';
    } else {
        $chk = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
        $chk->execute([$email, $edit_uid]);
        if ($chk->fetch()) {
            $erro = 'Este e-mail já pertence a outra conta.';
        } else {
            if ($senha) {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $pdo->prepare("UPDATE usuarios SET nome=?, email=?, senha=?, tipo=?, ativo=? WHERE id=?")
                    ->execute([$nome, $email, $hash, $tipo, $ativo, $edit_uid]);
            } else {
                $pdo->prepare("UPDATE usuarios SET nome=?, email=?, tipo=?, ativo=? WHERE id=?")
                    ->execute([$nome, $email, $tipo, $ativo, $edit_uid]);
            }
            $sucesso = "Usuário \"$nome\" atualizado com sucesso!";
        }
    }
}

// ── Listar usuários ────────────────────────────────────────────────────────
$usuarios = $pdo->query("
    SELECT u.*,
           (SELECT COUNT(*) FROM noticias WHERE autor = u.id) AS total_noticias
    FROM usuarios u
    ORDER BY u.criado_em DESC
")->fetchAll();

// Usuário sendo editado (para modal)
$editando = null;
if (isset($_GET['editar']) && (int)$_GET['editar'] > 0) {
    $stmtEdit = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmtEdit->execute([(int)$_GET['editar']]);
    $editando = $stmtEdit->fetch();
}

$page_title = 'Gerenciar Usuários';
include '../include/header.php';
?>

<div class="dash-page">
<div class="container">

    <div class="dash-stats">
        <?php
        $total_users    = count($usuarios);
        $pendentes      = count(array_filter($usuarios, fn($u) => !$u['ativo'] && $u['tipo'] !== 'admin'));
        $total_admins   = count(array_filter($usuarios, fn($u) => $u['tipo'] === 'admin'));
        ?>
        <div class="stat-card">
            <span class="stat-number"><?= $total_users ?></span>
            <span class="stat-label">Total de Usuários</span>
        </div>
        <div class="stat-card">
            <span class="stat-number" style="color:<?= $pendentes > 0 ? '#e74c3c' : 'var(--text)' ?>">
                <?= $pendentes ?>
            </span>
            <span class="stat-label">Aguardando Aprovação</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $total_admins ?></span>
            <span class="stat-label">Administradores</span>
        </div>
    </div>

    <div class="dash-layout">
        <!-- Sidebar -->
        <aside class="dash-sidebar">
            <div class="dash-profile-box">
                <div class="dash-avatar">👑</div>
                <div class="dash-profile-name"><?= sanitizar($_SESSION['usuario_nome']) ?></div>
                <div class="dash-profile-role">Administrador</div>
            </div>
            <nav class="dash-nav">
                <a href="dashboard.php" class="dash-nav-item">📊 Meu Painel</a>
                <a href="gerenciar_usuarios.php" class="dash-nav-item active">👥 Usuários</a>
                <a href="nova_noticia.php" class="dash-nav-item">✏️ Nova Notícia</a>
                <a href="../public/index.php" class="dash-nav-item">🏠 Ver Portal</a>
                <div class="dash-nav-sep"></div>
                <a href="logout.php" class="dash-nav-item danger">🚪 Sair</a>
            </nav>
        </aside>

        <!-- Main -->
        <main>

            <?php if ($erro): ?>
                <div class="alert alert-error" style="margin-bottom:1.25rem">⚠ <?= $erro ?></div>
            <?php endif; ?>
            <?php if ($sucesso): ?>
                <div class="alert alert-success" style="margin-bottom:1.25rem">✔ <?= $sucesso ?></div>
            <?php endif; ?>

            <!-- ── Card: Criar novo usuário ── -->
            <div class="dash-main-card" style="margin-bottom:1.5rem">
                <div class="dash-main-header">
                    <h2>➕ Criar Novo Usuário</h2>
                    <button class="btn btn-primary btn-sm" onclick="toggleForm('form-criar')">
                        + Criar usuário
                    </button>
                </div>
                <div class="dash-main-body" id="form-criar" style="display:none">
                    <form method="POST">
                        <input type="hidden" name="acao" value="criar">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nome completo *</label>
                                <input class="form-control" type="text" name="nome" required placeholder="Nome do usuário">
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-mail *</label>
                                <input class="form-control" type="email" name="email" required placeholder="email@exemplo.com">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Senha *</label>
                                <input class="form-control" type="password" name="senha" required placeholder="Mínimo 6 caracteres">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tipo de conta</label>
                                <select class="form-control" name="tipo">
                                    <option value="jornalista">🖊️ Jornalista</option>
                                    <option value="admin">👑 Administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display:flex;align-items:center;gap:.5rem">
                            <input type="checkbox" name="ativo" id="ativo_criar" value="1" checked
                                   style="width:auto;accent-color:var(--red)">
                            <label for="ativo_criar" class="form-label" style="margin:0;cursor:pointer">
                                Conta já ativada (pode fazer login imediatamente)
                            </label>
                        </div>
                        <div class="flex gap-2 flex-wrap mt-2">
                            <button type="submit" class="btn btn-primary">Criar usuário</button>
                            <button type="button" class="btn btn-ghost" onclick="toggleForm('form-criar')">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ── Card: Editar usuário (se selecionado) ── -->
            <?php if ($editando): ?>
            <div class="dash-main-card" style="margin-bottom:1.5rem;border:2px solid var(--red)">
                <div class="dash-main-header">
                    <h2>✏️ Editando: <?= sanitizar($editando['nome']) ?></h2>
                    <a href="gerenciar_usuarios.php" class="btn btn-ghost btn-sm">Cancelar</a>
                </div>
                <div class="dash-main-body">
                    <form method="POST">
                        <input type="hidden" name="acao" value="editar">
                        <input type="hidden" name="uid" value="<?= $editando['id'] ?>">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nome completo *</label>
                                <input class="form-control" type="text" name="nome" required
                                       value="<?= sanitizar($editando['nome']) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">E-mail *</label>
                                <input class="form-control" type="email" name="email" required
                                       value="<?= sanitizar($editando['email']) ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nova senha</label>
                                <input class="form-control" type="password" name="senha"
                                       placeholder="Deixe vazio para não alterar">
                                <p class="form-hint">Mínimo 6 caracteres</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tipo de conta</label>
                                <select class="form-control" name="tipo"
                                    <?= $editando['id'] === (int)$_SESSION['usuario_id'] ? 'disabled' : '' ?>>
                                    <option value="jornalista" <?= $editando['tipo'] === 'jornalista' ? 'selected' : '' ?>>🖊️ Jornalista</option>
                                    <option value="admin"      <?= $editando['tipo'] === 'admin'      ? 'selected' : '' ?>>👑 Administrador</option>
                                </select>
                                <?php if ($editando['id'] === (int)$_SESSION['usuario_id']): ?>
                                    <input type="hidden" name="tipo" value="admin">
                                    <p class="form-hint">Você não pode alterar o próprio tipo.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group" style="display:flex;align-items:center;gap:.5rem">
                            <input type="checkbox" name="ativo" id="ativo_edit" value="1"
                                   <?= $editando['ativo'] ? 'checked' : '' ?>
                                   <?= $editando['id'] === (int)$_SESSION['usuario_id'] ? 'disabled' : '' ?>
                                   style="width:auto;accent-color:var(--red)">
                            <label for="ativo_edit" class="form-label" style="margin:0;cursor:pointer">
                                Conta ativa (permite login)
                            </label>
                        </div>
                        <div class="flex gap-2 flex-wrap mt-2">
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                            <a href="gerenciar_usuarios.php" class="btn btn-ghost">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- ── Card: Lista de usuários ── -->
            <div class="dash-main-card">
                <div class="dash-main-header">
                    <h2>👥 Todos os Usuários</h2>
                </div>
                <div class="dash-main-body">
                    <?php if (empty($usuarios)): ?>
                        <div class="empty-state">
                            <span class="empty-icon">👤</span>
                            <h3>Nenhum usuário cadastrado</h3>
                        </div>
                    <?php else: ?>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Tipo</th>
                                    <th>Status</th>
                                    <th>Notícias</th>
                                    <th>Desde</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $u): ?>
                                <tr class="<?= !$u['ativo'] && $u['tipo'] !== 'admin' ? 'row-pending' : '' ?>">
                                    <td style="color:var(--text-3);font-size:.75rem"><?= $u['id'] ?></td>
                                    <td>
                                        <strong><?= sanitizar($u['nome']) ?></strong>
                                        <?php if ($u['id'] === (int)$_SESSION['usuario_id']): ?>
                                            <span class="badge-you">você</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color:var(--text-3);font-size:.85rem"><?= sanitizar($u['email']) ?></td>
                                    <td>
                                        <?php if ($u['tipo'] === 'admin'): ?>
                                            <span class="badge-tipo admin">👑 Admin</span>
                                        <?php else: ?>
                                            <span class="badge-tipo jornalista">🖊️ Jornalista</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($u['tipo'] === 'admin'): ?>
                                            <span class="badge-status ativo">✔ Ativo</span>
                                        <?php elseif ($u['ativo']): ?>
                                            <span class="badge-status ativo">✔ Aprovado</span>
                                        <?php else: ?>
                                            <span class="badge-status pendente">⏳ Pendente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align:center"><?= $u['total_noticias'] ?></td>
                                    <td style="white-space:nowrap;color:var(--text-3);font-size:.8rem">
                                        <?= formatar_data_curta($u['criado_em']) ?>
                                    </td>
                                    <td>
                                        <?php if ($u['id'] !== (int)$_SESSION['usuario_id']): ?>
                                        <div class="td-actions" style="flex-wrap:wrap;gap:.3rem">

                                            <!-- Editar -->
                                            <a href="gerenciar_usuarios.php?editar=<?= $u['id'] ?>"
                                               class="btn btn-ghost btn-sm">✏️</a>

                                            <!-- Aprovar / Revogar (só jornalistas) -->
                                            <?php if ($u['tipo'] !== 'admin'): ?>
                                                <?php if (!$u['ativo']): ?>
                                                    <a href="gerenciar_usuarios.php?acao=aprovar&uid=<?= $u['id'] ?>"
                                                       class="btn btn-sm"
                                                       style="background:#27ae60;color:#fff"
                                                       onclick="return confirm('Aprovar acesso de <?= sanitizar($u['nome']) ?>?')">
                                                       ✔ Aprovar
                                                    </a>
                                                <?php else: ?>
                                                    <a href="gerenciar_usuarios.php?acao=revogar&uid=<?= $u['id'] ?>"
                                                       class="btn btn-sm btn-ghost"
                                                       onclick="return confirm('Revogar acesso de <?= sanitizar($u['nome']) ?>?')">
                                                       🚫 Revogar
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <!-- Promover / Rebaixar -->
                                            <?php if ($u['tipo'] !== 'admin'): ?>
                                                <a href="gerenciar_usuarios.php?acao=promover&uid=<?= $u['id'] ?>"
                                                   class="btn btn-sm"
                                                   style="background:#f39c12;color:#fff"
                                                   onclick="return confirm('Promover <?= sanitizar($u['nome']) ?> a administrador?')">
                                                   👑 Promover
                                                </a>
                                            <?php else: ?>
                                                <a href="gerenciar_usuarios.php?acao=rebaixar&uid=<?= $u['id'] ?>"
                                                   class="btn btn-sm btn-ghost"
                                                   onclick="return confirm('Rebaixar <?= sanitizar($u['nome']) ?> para jornalista?')">
                                                   🖊️ Rebaixar
                                                </a>
                                            <?php endif; ?>

                                            <!-- Excluir -->
                                            <a href="gerenciar_usuarios.php?acao=excluir&uid=<?= $u['id'] ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Excluir permanentemente <?= sanitizar($u['nome']) ?> e todas as suas notícias?')">
                                               🗑️
                                            </a>
                                        </div>
                                        <?php else: ?>
                                            <span style="color:var(--text-3);font-size:.8rem">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </main>
    </div>
</div>
</div>

<script>
function toggleForm(id) {
    var el = document.getElementById(id);
    if (el) {
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
}
// Abre form automaticamente se houve erro de criação
<?php if ($erro && ($_POST['acao'] ?? '') === 'criar'): ?>
document.addEventListener('DOMContentLoaded', function(){ toggleForm('form-criar'); });
<?php endif; ?>
</script>

<style>
.row-pending { background: rgba(231,76,60,.06); }
.badge-you {
    display:inline-block;
    background: var(--red);
    color:#fff;
    font-size:.65rem;
    padding:.1rem .4rem;
    border-radius:999px;
    margin-left:.4rem;
    vertical-align:middle;
    font-weight:700;
    text-transform:uppercase;
}
.badge-tipo {
    display:inline-block;
    padding:.2rem .55rem;
    border-radius:999px;
    font-size:.75rem;
    font-weight:700;
}
.badge-tipo.admin      { background:rgba(243,156,18,.18); color:#f39c12; }
.badge-tipo.jornalista { background:rgba(52,152,219,.15); color:#3498db; }
.badge-status {
    display:inline-block;
    padding:.2rem .55rem;
    border-radius:999px;
    font-size:.75rem;
    font-weight:700;
}
.badge-status.ativo    { background:rgba(39,174,96,.15); color:#27ae60; }
.badge-status.pendente { background:rgba(231,76,60,.15);  color:#e74c3c; }
</style>

<?php include '../include/footer.php'; ?>

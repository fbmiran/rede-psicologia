<?php include __DIR__ . '/../partials/menu.php'; ?>

<div class="card shadow-sm p-4">
    <div class="text-center mb-4">
        <?php if (!empty($dados['foto_perfil'])): ?>
            <img src="/Uploads/PerfilPicture/<?= htmlspecialchars($dados['foto_perfil']) ?>" width="150" class="rounded-circle mb-2">
        <?php else: ?>
            <img src="/img/avatar_padrao.png" width="150" class="rounded-circle mb-2">
        <?php endif; ?>

        <h2><?= htmlspecialchars($dados['nome']) ?></h2>
    </div>

    <div class="mb-3">
        <strong>Abordagem:</strong><br>
        <?= nl2br(htmlspecialchars($dados['especialidades'])) ?>
    </div>

    <div class="mb-3">
        <strong>Sobre:</strong><br>
        <?= nl2br(htmlspecialchars($dados['bio'])) ?>
    </div>

    <!-- Aqui futuramente: lista de posts -->
</div>
<?php if ($_SESSION['usuario']['id'] !== $dados['usuario_id']): ?>
    <?php
        $stmtSeguindo = $this->pdo->prepare("SELECT 1 FROM seguidores WHERE seguidor_id = ? AND seguido_id = ?");
        $stmtSeguindo->execute([$_SESSION['usuario']['id'], $dados['usuario_id']]);
        $jaSeguindo = $stmtSeguindo->fetchColumn();
    ?>
    <?php if ($jaSeguindo): ?>
        <a href="/?rota=deixar_de_seguir&id=<?= $dados['usuario_id'] ?>">Deixar de seguir</a>
    <?php else: ?>
        <a href="/?rota=seguir&id=<?= $dados['usuario_id'] ?>">Seguir</a>
    <?php endif; ?>
<?php endif; ?>

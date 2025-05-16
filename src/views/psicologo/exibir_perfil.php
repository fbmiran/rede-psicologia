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
</div>

<?php if (!empty($usuarioLogado) && $usuarioLogado['id'] !== $dados['usuario_id']): ?>
    <?php if ($jaSeguindo): ?>
        <a href="/deixarDeSeguir?id=<?= $dados['usuario_id'] ?>" class="btn btn-danger mt-3">Deixar de seguir</a>
    <?php else: ?>
        <a href="/seguir?id=<?= $dados['usuario_id'] ?>" class="btn btn-primary mt-3">Seguir</a>
    <?php endif; ?>
<?php endif; ?>
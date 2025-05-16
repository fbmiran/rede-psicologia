<?php include __DIR__ . '/../partials/menu.php'; ?>

<h2>Mural</h2>

<?php if (!empty($_SESSION['mensagem'])): ?>
    <div class="alert alert-success"><?= $_SESSION['mensagem'] ?></div>
    <?php unset($_SESSION['mensagem']); ?>
<?php endif; ?>

<form method="POST" action="/novo_post" class="mb-4">
    <textarea name="conteudo" class="form-control mb-2" placeholder="Escreva algo..." required></textarea>
    <button type="submit" class="btn btn-primary">Publicar</button>
</form>

<?php foreach ($posts as $post): ?>
    <div class="card mb-3 p-3">
        <strong><?= htmlspecialchars($post['nome']) ?></strong><br>
        <small><?= date('d/m/Y H:i', strtotime($post['data_postagem'])) ?></small>
        <p><?= nl2br(htmlspecialchars($post['conteudo'])) ?></p>
    </div>
<?php endforeach; ?>

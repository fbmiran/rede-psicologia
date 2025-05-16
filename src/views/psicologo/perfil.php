<?php include __DIR__ . '/../partials/menu.php'; ?>

<?php if (!empty($_SESSION['mensagem'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['mensagem'] ?>
        <?php unset($_SESSION['mensagem']); ?>
    </div>
<?php endif; ?>

<h2>Perfil do Psicólogo</h2>
<form method="POST" action="/atualizar_perfil" enctype="multipart/form-data" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label>CRP:</label>
        <input type="text" name="crp" class="form-control" value="<?= $dados['crp'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label>CPF:</label>
        <input type="text" name="cpf" class="form-control" value="<?= $dados['cpf'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label>Telefone:</label>
        <input type="text" name="telefone" class="form-control" value="<?= $dados['telefone'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label>Endereço:</label>
        <input type="text" name="endereco" class="form-control" value="<?= $dados['endereco'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label>Complemento:</label>
        <input type="text" name="complemento" class="form-control" value="<?= $dados['complemento'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label>CEP:</label>
        <input type="text" name="cep" class="form-control" value="<?= $dados['cep'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label>Cidade:</label>
        <input type="text" name="cidade" class="form-control" value="<?= $dados['cidade'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label>Estado:</label>
        <input type="text" name="estado" class="form-control" value="<?= $dados['estado'] ?? '' ?>">
    </div>


    <div class="mb-3">
        <label>Especialidades:</label>
        <textarea name="especialidades" class="form-control"><?= $dados['especialidades'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label>Bio:</label>
        <textarea name="bio" class="form-control"><?= $dados['bio'] ?? '' ?></textarea>
    </div>

    <div class="mb-3">
        <label>Foto de perfil:</label>
        <?php if (!empty($dados['foto_perfil'])): ?>
            <div><img src="/Uploads/PerfilPicture/<?= $dados['foto_perfil'] ?>" width="120" class="rounded-circle mb-2"></div>
        <?php endif; ?>
        <input type="file" name="foto" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

<script>
document.querySelector('input[name="cep"]').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, '');

    if (cep.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
                document.querySelector('input[name="endereco"]').value = data.logradouro || '';
                document.querySelector('input[name="cidade"]').value = data.localidade || '';
                document.querySelector('input[name="estado"]').value = data.uf || '';
                document.querySelector('input[name="complemento"]').value = data.complemento || '';
            } else {
                alert('CEP não encontrado.');
            }
        })
        .catch(() => alert('Erro ao consultar o CEP.'));
});
</script>

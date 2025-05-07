<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rede Psicologia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">

<h2 class="mb-4">Cadastro</h2>
<form method="POST" action="/?rota=register" class="card p-4 shadow-sm">
    <div class="mb-3">
        <input type="text" name="nome" class="form-control" placeholder="Nome" required>
    </div>
    <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="E-mail" required>
    </div>
    <div class="mb-3">
        <input type="password" name="senha" class="form-control" placeholder="Senha" required>
    </div>
    <div class="mb-3">
        <select name="tipo" class="form-select" required onchange="document.getElementById('psico').style.display = this.value == 'paciente' ? 'block' : 'none';">
            <option value="">Tipo de usuário</option>
            <option value="psicologo">Psicólogo</option>
            <option value="paciente">Paciente</option>
        </select>
    </div>
    <div id="psico" class="mb-3" style="display:none;">
        <input type="number" name="psicologo_id" class="form-control" placeholder="ID do psicólogo responsável">
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>
<div class="mt-3">
    <a href="/?rota=login">Já tem conta? Login</a>
</div>

</body>
</html>

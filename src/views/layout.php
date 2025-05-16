<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'Rede de Psicologia' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <?php include __DIR__ . '/partials/menu.php'; ?>
    </header>

    <main>
        <?php if (!empty($_SESSION['mensagem'])): ?>
            <div class="mensagem-sucesso"><?= $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></div>
        <?php endif; ?>

        <?= $conteudo ?? '' ?>
    </main>
</body>
</html>

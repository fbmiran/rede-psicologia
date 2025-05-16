<h2>Psicólogos</h2>
<ul>
<?php foreach ($psicologos as $p): ?>
    <li>
        <a href="/perfil/publico/<?= $p['id'] ?>">
            <?= htmlspecialchars($p['nome']) ?>
            <?php if (!empty($p['foto_perfil'])): ?>
                <img src="/Uploads/PerfilPicture/<?= htmlspecialchars($p['foto_perfil']) ?>" width="30" />
            <?php endif; ?>
        </a>
    </li>
<?php endforeach; ?>
</ul>

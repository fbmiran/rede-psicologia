
<style>
nav.menu {
    background: #f2f2f2;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}
nav.menu a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    padding: 8px 12px;
    background: #ddd;
    border-radius: 8px;
    transition: background 0.3s;
}
nav.menu a:hover {
    background: #bbb;
}
</style>
<nav class="menu">
    <a href="/perfil">Meu Perfil</a> |
    <a href="/ver_perfil&id=<?= $_SESSION['usuario']['id'] ?>">Ver como público</a> |
    <a href="/perfil/editar">Editar Perfil</a> |
    <a href="/mural">Mural</a> |
    <a href="/psicologos">Psicólogos</a> |
    <a href="/logout">Sair</a>
</nav>

<?php

class PostController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function mural()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $usuario_id = $_SESSION['usuario']['id'];

        $sql = "
            SELECT posts.*, usuarios.nome 
            FROM posts 
            JOIN usuarios ON posts.usuario_id = usuarios.id 
            WHERE posts.usuario_id = :usuario_id
            OR posts.usuario_id IN (
                    SELECT seguido_id FROM seguidores WHERE seguidor_id = :usuario_id
            )
            ORDER BY posts.data_postagem DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/post/mural.php';
    }


    public function novoPost()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /login');
            exit;
        }

        $usuario_id = $_SESSION['usuario']['id'];
        $conteudo = trim($_POST['conteudo']);

        if ($conteudo !== '') {
            $stmt = $this->pdo->prepare("INSERT INTO posts (usuario_id, conteudo) VALUES (?, ?)");
            $stmt->execute([$usuario_id, $conteudo]);
            $_SESSION['mensagem'] = 'Post publicado com sucesso!';
        }

        header('Location: /?rota=mural');
    }

    public function seguir()
    {
        $seguidor_id = $_SESSION['usuario']['id'];
        $seguido_id = $_GET['id'] ?? null;

        if ($seguido_id && $seguidor_id !== $seguido_id) {
            $stmt = $this->pdo->prepare("INSERT IGNORE INTO seguidores (seguidor_id, seguido_id) VALUES (?, ?)");
            $stmt->execute([$seguidor_id, $seguido_id]);
        }

        header('Location: /perfil&id=' . $seguido_id);
    }

    public function deixarDeSeguir()
    {
        $seguidor_id = $_SESSION['usuario']['id'];
        $seguido_id = $_GET['id'] ?? null;

        if ($seguido_id) {
            $stmt = $this->pdo->prepare("DELETE FROM seguidores WHERE seguidor_id = ? AND seguido_id = ?");
            $stmt->execute([$seguidor_id, $seguido_id]);
        }

        header('Location: /perfil&id=' . $seguido_id);
    }

}
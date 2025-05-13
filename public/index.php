<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';
require_once __DIR__ . '/../src/controllers/PsicologoController.php';
require_once __DIR__ . '/../src/controllers/PostController.php';



$rota = $_GET['rota'] ?? 'login';
$auth = new AuthController($pdo);
$psicologo = new PsicologoController($pdo); // Passando $pdo se necessário


switch ($rota) {
    case 'login':
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $auth->login() : $auth->showLogin();
        break;
    case 'register':
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $auth->register() : $auth->showRegister();
        break;
    case 'logout':
        $auth->logout();
        break;
    case 'dashboard':
        $auth->dashboard();
        break;
    case 'perfil':
        $_SERVER['REQUEST_METHOD'] === 'POST' ? $psicologo->atualizarPerfil() : $psicologo->perfil();
        break;
    case 'atualizar_perfil': // ✅ rota para salvar o formulário
        $psicologo->atualizarPerfil();
        break;
    case 'ver_perfil':
        $controller = new PsicologoController($pdo);
        $controller->verPerfil($_GET['id']);
        break;
    case 'mural':
        (new PostController($pdo))->mural();
        break;
    case 'novo_post':
        (new PostController($pdo))->novoPost();
        break;
            
    default:
        echo "Rota inválida.";
}

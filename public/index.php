<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';
require_once __DIR__ . '/../src/controllers/PsicologoController.php';
require_once __DIR__ . '/../src/controllers/PostController.php';

// Captura e limpa a URL amigável
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$rota = trim($uri, '/');

// Instância dos controllers
$auth = new AuthController($pdo);
$psicologo = new PsicologoController($pdo);
$postController = new PostController($pdo);

error_log("Rota acessada: $rota");

// Roteamento
switch ($rota) {
    case '':
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

    case 'perfil/editar':
        $psicologo->editarPerfil(); // Certifique-se que existe este método
        break;

    case (preg_match('/^perfil\/publico\/(\d+)$/', $rota, $matches) ? true : false):
        $psicologo->verPerfil($matches[1]);
        break;
        

    case 'mural':
        $postController->mural();
        break;

    case 'novo_post':
        $postController->novoPost();
        break;

    case 'seguir':
        $postController->seguir();
        break;

    case 'deixarDeSeguir':
        $postController->deixarDeSeguir();
        break;

    case 'psicologos':
        $psicologo->listarPsicologos();
        break;

    default:
        http_response_code(404);
        echo "Rota inválida: <code>$rota</code>";
        break;
}

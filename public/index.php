<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

$rota = $_GET['rota'] ?? 'login';
$auth = new AuthController($pdo);

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
    default:
        echo "Rota inválida.";
}

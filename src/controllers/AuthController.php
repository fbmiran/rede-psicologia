<?php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    private $usuario;

    public function __construct($pdo) {
        $this->usuario = new Usuario($pdo);
        session_start();
    }

    public function showLogin() {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister() {
        include __DIR__ . '/../views/auth/register.php';
    }

    public function register() {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $tipo = $_POST['tipo'];
        $psicologo_id = $tipo === 'paciente' ? $_POST['psicologo_id'] : null;

        if ($this->usuario->cadastrar($nome, $email, $senha, $tipo, $psicologo_id)) {
            header('Location: /?rota=login');
            exit;
        } else {
            echo "Erro ao cadastrar.";
        }
    }

    public function login() {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $usuario = $this->usuario->autenticar($email, $senha);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario;
            header('Location: /?rota=dashboard');
            exit;
        } else {
            echo "E-mail ou senha inválidos.";
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /?rota=login');
    }

    public function dashboard() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: /?rota=login');
            exit;
        }
    
        $usuario = $_SESSION['usuario'];
    
        if ($usuario['tipo'] === 'psicologo') {
            include __DIR__ . '/../views/psicologo/dashboard.php';
        } elseif ($usuario['tipo'] === 'paciente') {
            include __DIR__ . '/../views/paciente/dashboard.php';
        } else {
            echo "Tipo de usuário inválido.";
        }
    }
    
}

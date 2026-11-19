<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Controller.php';
require_once APP_PATH . 'models' . DIRECTORY_SEPARATOR . 'Usuario.php';

class AuthController extends Controller {

    public function showLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "index.php?route=dashboard");
            exit;
        }

        require_once APP_PATH . "views" . DIRECTORY_SEPARATOR . "auth" . DIRECTORY_SEPARATOR . "login.php";
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "index.php?route=login");
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuarioModel = new Usuario();
        $user = $usuarioModel->login($email, $password);

        if ($user) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            $this->logActivity($user['id'], 'login', 'El usuario inició sesión en el sistema');
            
            header("Location: " . BASE_URL . "index.php?route=dashboard");
            exit;
        } else {
            header("Location: " . BASE_URL . "index.php?route=login&error=1");
            exit;
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            $this->logActivity($_SESSION['user']['id'], 'logout', 'El usuario cerró sesión');
        }

        session_destroy();
        header("Location: " . BASE_URL . "index.php?route=login");
        exit;
    }
}
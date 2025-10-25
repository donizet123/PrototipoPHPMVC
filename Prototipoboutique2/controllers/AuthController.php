<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../helpers/Session.php';

class AuthController {
    private $db;
    private $usuario;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->usuario = new Usuario($this->db);
    }

    public function login() {
        // Si ya está logueado, redirigir al dashboard
        if (Session::isLoggedIn()) {
            header('Location: ' . BASE_URL . 'dashboard/index');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($usuario) || empty($password)) {
                $error = 'Por favor, completa todos los campos';
            } else {
                $user = $this->usuario->login($usuario, $password);
                
                if ($user) {
                    // Guardar datos en sesión
                    Session::set('user_id', $user['id']);
                    Session::set('user_logged_in', true);
                    Session::set('usuario', $user['usuario']);
                    Session::set('nombre', $user['nombre']);
                    Session::set('rol', $user['rol']);
                    
                    // Redirigir al dashboard
                    header('Location: ' . BASE_URL . 'dashboard/index');
                    exit;
                } else {
                    $error = 'Usuario o contraseña incorrectos';
                }
            }
        }

        // Cargar vista de login
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        Session::destroy();
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
}
?>
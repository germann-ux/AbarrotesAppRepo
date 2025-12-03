<?php
require_once __DIR__ . '/../Models/User.php';

class AuthController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = new User();
            if ($user->login($email, $password)) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user->id;
                $_SESSION['nombre'] = $user->nombre;
                $_SESSION['role'] = $user->role;
                
                if ($user->role === 'client') {
                    header("Location: index.php?view=client_dashboard");
                } else {
                    header("Location: index.php?view=dashboard");
                }
                exit;
            } else {
                $error = "Invalid email or password";
                require_once __DIR__ . '/../Views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../Views/auth/login.php';
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->nombre = $_POST['nombre'] ?? $_POST['username'] ?? '';
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->role = 'client'; // Default role for registration
            
            if ($user->emailExists()) {
                $error = "Email already exists";
                require_once __DIR__ . '/../Views/auth/register.php';
            } elseif ($user->register()) {
                header("Location: index.php?view=login&registered=true");
                exit;
            } else {
                $error = "Registration failed";
                require_once __DIR__ . '/../Views/auth/register.php';
            }
        } else {
            require_once __DIR__ . '/../Views/auth/register.php';
        }
    }
    
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header("Location: index.php?view=login");
        exit;
    }
}
?>

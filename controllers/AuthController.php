<?php

/**
 * Authentication Controller
 */

class AuthController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    /**
     * Login page
     */
    public function login() {
        if (isLoggedIn()) {
            redirect('/');
        }

        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$email || !$password) {
                $error = 'Please fill in all fields';
            } else {
                $userData = $this->user->getByEmail($email);

                if ($userData && $this->user->verifyPassword($password, $userData['password'])) {
                    // Set session
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['user'] = $userData;
                    
                    redirect('/');
                } else {
                    $error = 'Invalid email or password';
                }
            }
        }

        include VIEWS_PATH . '/login.php';
    }

    /**
     * Logout
     */
    public function logout() {
        logout();
    }

    /**
     * Change password
     */
    public function changePassword() {
        checkAuth();

        $message = '';
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($newPassword !== $confirmPassword) {
                $error = 'New passwords do not match';
            } elseif (strlen($newPassword) < 6) {
                $error = 'Password must be at least 6 characters';
            } else {
                if ($this->user->changePassword($_SESSION['user_id'], $oldPassword, $newPassword)) {
                    $message = 'Password changed successfully';
                } else {
                    $error = 'Current password is incorrect';
                }
            }
        }

        include VIEWS_PATH . '/change-password.php';
    }
}

?>
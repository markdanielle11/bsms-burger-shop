<?php

/**
 * Authentication Middleware
 */

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . '/index.php?action=login');
        exit;
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return $_SESSION['user'] ?? null;
}

function getUserRole() {
    $user = getCurrentUser();
    return $user['role_id'] ?? null;
}

function logout() {
    session_destroy();
    header('Location: ' . BASE_URL . '/index.php?action=login');
    exit;
}

?>
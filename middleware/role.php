<?php

/**
 * Role-based Authorization Middleware
 */

function checkRole($allowedRoles) {
    checkAuth();
    
    $userRole = getUserRole();
    
    if (!is_array($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }
    
    if (!in_array($userRole, $allowedRoles)) {
        http_response_code(403);
        die('Access Denied: You do not have permission to access this page.');
    }
}

function hasPermission($permission) {
    checkAuth();
    
    $user = getCurrentUser();
    $userRole = getUserRole();
    
    // Admin has all permissions
    if ($userRole === ROLE_ADMIN) {
        return true;
    }
    
    // Check user permissions from session
    $permissions = $_SESSION['permissions'] ?? [];
    return in_array($permission, $permissions);
}

?>
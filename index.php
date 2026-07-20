<?php

/**
 * BSMS - Main Entry Point
 */

// Start session
session_start();

// Load configuration
require_once 'config/database.php';
require_once 'config/constants.php';

// Load classes
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Product.php';
require_once 'classes/Inventory.php';

// Load middleware
require_once 'middleware/auth.php';
require_once 'middleware/role.php';
require_once 'middleware/csrf.php';

// Load utilities
require_once 'utils/helpers.php';

// Load controllers
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';

// Route requests
$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'login':
        $auth = new AuthController();
        $auth->login();
        break;
    
    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;
    
    case 'dashboard':
    default:
        $dashboard = new DashboardController();
        $dashboard->index();
        break;
}

?>
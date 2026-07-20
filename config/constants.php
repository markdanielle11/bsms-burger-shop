<?php

/**
 * PrimeBurger - Application Constants
 */

// Application
define('APP_NAME', 'PrimeBurger - Burger Shop Management System');
define('APP_VERSION', '1.0.0');
define('APP_ENV', getenv('APP_ENV') ?: 'development');

// Paths
define('ROOT_PATH', dirname(dirname(__FILE__)));
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CLASSES_PATH', ROOT_PATH . '/classes');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');

// URLs
define('BASE_URL', getenv('APP_URL') ?: 'http://localhost/primeburger');
define('PUBLIC_URL', BASE_URL . '/public');
define('API_URL', BASE_URL . '/api');

// User Roles
define('ROLE_ADMIN', 1);
define('ROLE_MANAGER', 2);
define('ROLE_CASHIER', 3);
define('ROLE_KITCHEN', 4);
define('ROLE_INVENTORY', 5);

// Role Names
define('ROLE_NAMES', [
    ROLE_ADMIN => 'Administrator',
    ROLE_MANAGER => 'Manager',
    ROLE_CASHIER => 'Cashier',
    ROLE_KITCHEN => 'Kitchen Staff',
    ROLE_INVENTORY => 'Inventory Staff'
]);

// Permissions
define('PERM_DASHBOARD', 'view_dashboard');
define('PERM_POS', 'use_pos');
define('PERM_INVENTORY', 'manage_inventory');
define('PERM_REPORTS', 'view_reports');
define('PERM_ADMIN', 'system_admin');

// Session
define('SESSION_TIMEOUT', intval(getenv('SESSION_TIMEOUT') ?: 86400));
define('SESSION_COOKIE_NAME', 'primeburger_session');

// Currency
define('CURRENCY_CODE', getenv('CURRENCY_CODE') ?: 'PHP');
define('CURRENCY_SYMBOL', getenv('CURRENCY_SYMBOL') ?: '₱');
define('DECIMAL_PLACES', intval(getenv('DECIMAL_PLACES') ?: 2));

// File Upload
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_UPLOAD_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Date Format
define('DATE_FORMAT', 'Y-m-d');
define('TIME_FORMAT', 'H:i:s');
define('DATETIME_FORMAT', 'Y-m-d H:i:s');

// Pagination
define('ITEMS_PER_PAGE', 20);

// Status Codes
define('STATUS_SUCCESS', 1);
define('STATUS_PENDING', 2);
define('STATUS_FAILED', 3);
define('STATUS_CANCELLED', 4);

// Inventory
define('STOCK_STATUS_OK', 'ok');
define('STOCK_STATUS_LOW', 'low');
define('STOCK_STATUS_CRITICAL', 'critical');
define('STOCK_STATUS_OUT', 'out');

// Expiration
define('EXPIRY_DAYS_CRITICAL', 3);
define('EXPIRY_DAYS_WARNING', 7);

// Messages
define('MSG_SUCCESS', 'Operation completed successfully');
define('MSG_ERROR', 'An error occurred');
define('MSG_INVALID_INPUT', 'Invalid input provided');
define('MSG_UNAUTHORIZED', 'You do not have permission to access this');
define('MSG_NOT_FOUND', 'Resource not found');

?>

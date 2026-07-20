<?php

/**
 * Helper Functions
 */

/**
 * Sanitize input
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Format currency
 */
function formatCurrency($amount) {
    return CURRENCY_SYMBOL . number_format($amount, DECIMAL_PLACES);
}

/**
 * Format date
 */
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}

/**
 * Format datetime
 */
function formatDateTime($datetime) {
    return date('M d, Y H:i', strtotime($datetime));
}

/**
 * Format percentage
 */
function formatPercent($value, $decimals = 1) {
    return number_format($value, $decimals) . '%';
}

/**
 * Check if today
 */
function isToday($date) {
    return date('Y-m-d') === date('Y-m-d', strtotime($date));
}

/**
 * Get days ago
 */
function daysAgo($date) {
    $days = floor((time() - strtotime($date)) / 86400);
    return $days;
}

/**
 * Redirect
 */
function redirect($path) {
    header('Location: ' . BASE_URL . $path);
    exit;
}

/**
 * JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

/**
 * Generate random string
 */
function randomString($length = 10) {
    return substr(bin2hex(random_bytes($length)), 0, $length);
}

/**
 * Validate email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Get stock status
 */
function getStockStatus($quantity, $reorderPoint) {
    if ($quantity <= 0) {
        return STOCK_STATUS_OUT;
    } elseif ($quantity <= $reorderPoint) {
        return STOCK_STATUS_CRITICAL;
    } elseif ($quantity <= $reorderPoint * 1.5) {
        return STOCK_STATUS_LOW;
    }
    return STOCK_STATUS_OK;
}

?>
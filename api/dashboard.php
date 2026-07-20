<?php

/**
 * Dashboard API
 */

require_once '../config/database.php';
require_once '../config/constants.php';
require_once '../classes/Database.php';
require_once '../utils/helpers.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    jsonResponse(['error' => 'Unauthorized'], 401);
}

$db = Database::getInstance();
today = date('Y-m-d');

// Get today's sales
$todaysSales = $db->getRow(
    "SELECT COUNT(*) as orders, SUM(total) as revenue FROM sales WHERE DATE(created_at) = ?",
    [$today]
) ?? ['orders' => 0, 'revenue' => 0];

// Get total expenses
$expenses = $db->getRow(
    "SELECT SUM(amount) as total FROM expenses WHERE DATE(created_at) = ?",
    [$today]
) ?? ['total' => 0];

// Get low stock
$lowStock = $db->getRows(
    "SELECT COUNT(*) as count FROM inventory WHERE quantity <= reorder_point"
);

// Get expiring soon
$expiringSoon = $db->getRows(
    "SELECT COUNT(*) as count FROM expiration_batches 
     WHERE expiration_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)"
);

jsonResponse([
    'today' => [
        'orders' => $todaysSales['orders'] ?? 0,
        'revenue' => $todaysSales['revenue'] ?? 0,
        'expenses' => $expenses['total'] ?? 0,
        'profit' => ($todaysSales['revenue'] ?? 0) - ($expenses['total'] ?? 0)
    ],
    'alerts' => [
        'low_stock' => $lowStock[0]['count'] ?? 0,
        'expiring_soon' => $expiringSoon[0]['count'] ?? 0
    ]
]);

?>
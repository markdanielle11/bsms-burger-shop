<?php

/**
 * Dashboard Controller
 */

class DashboardController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Main dashboard
     */
    public function index() {
        checkAuth();

        // Get today's sales
        $today = date('Y-m-d');
        $todaysSales = $this->db->getRow(
            "SELECT COUNT(*) as count, SUM(total) as total FROM sales WHERE DATE(created_at) = ?",
            [$today]
        );

        // Get weekly sales
        $weekAgo = date('Y-m-d', strtotime('-7 days'));
        $weeklySales = $this->db->getRow(
            "SELECT SUM(total) as total FROM sales WHERE created_at >= ?",
            [$weekAgo]
        );

        // Get low stock items
        $lowStock = $this->db->getRows(
            "SELECT p.name, i.quantity, i.reorder_point FROM inventory i 
             JOIN products p ON i.product_id = p.id 
             WHERE i.quantity <= i.reorder_point 
             ORDER BY i.quantity ASC LIMIT 10"
        );

        // Get recent sales
        $recentSales = $this->db->getRows(
            "SELECT s.*, u.name as cashier FROM sales s 
             LEFT JOIN users u ON s.user_id = u.id 
             ORDER BY s.created_at DESC LIMIT 10"
        );

        include VIEWS_PATH . '/dashboard.php';
    }
}

?>
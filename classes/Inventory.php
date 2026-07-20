<?php

/**
 * Inventory Management Class
 */

class Inventory {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get current stock
     */
    public function getStock($productId) {
        return $this->db->getRow(
            "SELECT * FROM inventory WHERE product_id = ?",
            [$productId]
        );
    }

    /**
     * Get all inventory
     */
    public function getAll() {
        return $this->db->getRows(
            "SELECT i.*, p.name, p.barcode, c.name as category FROM inventory i 
             JOIN products p ON i.product_id = p.id 
             LEFT JOIN categories c ON p.category_id = c.id 
             ORDER BY p.name ASC"
        );
    }

    /**
     * Get low stock items
     */
    public function getLowStock() {
        return $this->db->getRows(
            "SELECT i.*, p.name, p.barcode, c.name as category FROM inventory i 
             JOIN products p ON i.product_id = p.id 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE i.quantity <= i.reorder_point 
             ORDER BY i.quantity ASC"
        );
    }

    /**
     * Update stock
     */
    public function updateStock($productId, $quantity) {
        $stock = $this->getStock($productId);
        
        if (!$stock) {
            // Create new inventory record
            return $this->db->insert('inventory', [
                'product_id' => $productId,
                'quantity' => $quantity,
                'reorder_point' => 10,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        return $this->db->update(
            'inventory',
            [
                'quantity' => $quantity,
                'updated_at' => date('Y-m-d H:i:s')
            ],
            'product_id = ?',
            [$productId]
        );
    }

    /**
     * Increase stock
     */
    public function increaseStock($productId, $quantity, $batchId = null) {
        $stock = $this->getStock($productId);
        $newQuantity = ($stock ? $stock['quantity'] : 0) + $quantity;
        
        $this->updateStock($productId, $newQuantity);
        $this->recordTransaction($productId, 'in', $quantity, $batchId);
        
        return $newQuantity;
    }

    /**
     * Decrease stock
     */
    public function decreaseStock($productId, $quantity, $reason = 'sale') {
        $stock = $this->getStock($productId);
        
        if (!$stock || $stock['quantity'] < $quantity) {
            return false;
        }
        
        $newQuantity = $stock['quantity'] - $quantity;
        $this->updateStock($productId, $newQuantity);
        $this->recordTransaction($productId, 'out', $quantity, null, $reason);
        
        return $newQuantity;
    }

    /**
     * Record transaction
     */
    public function recordTransaction($productId, $type, $quantity, $batchId = null, $reason = null) {
        return $this->db->insert('inventory_transactions', [
            'product_id' => $productId,
            'type' => $type,
            'quantity' => $quantity,
            'batch_id' => $batchId,
            'reason' => $reason,
            'user_id' => $_SESSION['user_id'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get transaction history
     */
    public function getTransactionHistory($productId = null, $limit = 100) {
        $query = "SELECT it.*, p.name as product_name FROM inventory_transactions it 
                  JOIN products p ON it.product_id = p.id";
        $params = [];
        
        if ($productId) {
            $query .= " WHERE it.product_id = ?";
            $params[] = $productId;
        }
        
        $query .= " ORDER BY it.created_at DESC LIMIT ?";
        $params[] = $limit;
        
        return $this->db->getRows($query, $params);
    }

    /**
     * Get total inventory value
     */
    public function getTotalValue() {
        $result = $this->db->getRow(
            "SELECT SUM(i.quantity * p.cost) as total_value FROM inventory i 
             JOIN products p ON i.product_id = p.id"
        );
        
        return $result['total_value'] ?? 0;
    }
}

?>
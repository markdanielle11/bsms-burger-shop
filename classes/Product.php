<?php

/**
 * Product Management Class
 */

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get product by ID
     */
    public function getById($id) {
        return $this->db->getRow(
            "SELECT p.*, c.name as category_name FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.id = ?",
            [$id]
        );
    }

    /**
     * Get product by barcode
     */
    public function getByBarcode($barcode) {
        return $this->db->getRow(
            "SELECT p.*, c.name as category_name FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.barcode = ?",
            [$barcode]
        );
    }

    /**
     * Search products
     */
    public function search($term, $limit = 20) {
        return $this->db->getRows(
            "SELECT p.*, c.name as category_name FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             WHERE p.name LIKE ? OR p.barcode LIKE ? 
             LIMIT ?",
            ["%$term%", "%$term%", $limit]
        );
    }

    /**
     * Get all products
     */
    public function getAll() {
        return $this->db->getRows(
            "SELECT p.*, c.name as category_name FROM products p 
             LEFT JOIN categories c ON p.category_id = c.id 
             ORDER BY p.name ASC"
        );
    }

    /**
     * Get products by category
     */
    public function getByCategory($categoryId) {
        return $this->db->getRows(
            "SELECT * FROM products WHERE category_id = ? ORDER BY name ASC",
            [$categoryId]
        );
    }

    /**
     * Create product
     */
    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('products', $data);
    }

    /**
     * Update product
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->update('products', $data, 'id = ?', [$id]);
    }

    /**
     * Delete product
     */
    public function delete($id) {
        return $this->db->delete('products', 'id = ?', [$id]);
    }

    /**
     * Get categories
     */
    public function getCategories() {
        return $this->db->getRows(
            "SELECT * FROM categories ORDER BY name ASC"
        );
    }
}

?>
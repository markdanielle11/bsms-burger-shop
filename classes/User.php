<?php

/**
 * User Management Class
 */

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get user by email
     */
    public function getByEmail($email) {
        return $this->db->getRow(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );
    }

    /**
     * Get user by ID
     */
    public function getById($id) {
        return $this->db->getRow(
            "SELECT u.*, r.name as role_name FROM users u 
             LEFT JOIN roles r ON u.role_id = r.id 
             WHERE u.id = ?",
            [$id]
        );
    }

    /**
     * Verify password
     */
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    /**
     * Hash password
     */
    public function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Create user
     */
    public function create($data) {
        $data['password'] = $this->hashPassword($data['password']);
        $data['created_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert('users', $data);
    }

    /**
     * Update user
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->db->update(
            'users',
            $data,
            'id = ?',
            [$id]
        );
    }

    /**
     * Get all users
     */
    public function getAll() {
        return $this->db->getRows(
            "SELECT u.*, r.name as role_name FROM users u 
             LEFT JOIN roles r ON u.role_id = r.id 
             ORDER BY u.created_at DESC"
        );
    }

    /**
     * Delete user
     */
    public function delete($id) {
        return $this->db->delete('users', 'id = ?', [$id]);
    }

    /**
     * Change password
     */
    public function changePassword($id, $oldPassword, $newPassword) {
        $user = $this->getById($id);
        
        if (!$user || !$this->verifyPassword($oldPassword, $user['password'])) {
            return false;
        }
        
        return $this->db->update(
            'users',
            ['password' => $this->hashPassword($newPassword)],
            'id = ?',
            [$id]
        );
    }
}

?>
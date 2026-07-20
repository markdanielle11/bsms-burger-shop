<?php

/**
 * BSMS - Password Reset & Troubleshooting Script
 * 
 * This script helps diagnose and fix login issues
 * Access at: http://localhost/bsms-burger-shop/reset-password.php
 * 
 * DELETE THIS FILE AFTER USE FOR SECURITY!
 */

// Load configuration
require_once 'config/database.php';
require_once 'config/constants.php';
require_once 'classes/Database.php';
require_once 'utils/helpers.php';

$message = '';
$error = '';
$action = $_GET['action'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSMS - Password Reset & Troubleshooting</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        h2 {
            color: #34495e;
            margin-top: 25px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-left: 4px solid #3498db;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #2c3e50;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-family: Arial, sans-serif;
        }
        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        button {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        button:hover {
            background: #2980b9;
        }
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d5f4e6;
            color: #27ae60;
            border-left: 4px solid #27ae60;
        }
        .alert-danger {
            background: #fadbd8;
            color: #c0392b;
            border-left: 4px solid #e74c3c;
        }
        .alert-info {
            background: #d6eaf8;
            color: #2980b9;
            border-left: 4px solid #3498db;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            font-family: monospace;
        }
        .status-ok {
            background: #d5f4e6;
            color: #27ae60;
        }
        .status-error {
            background: #fadbd8;
            color: #c0392b;
        }
        .info-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
        }
        code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #bdc3c7;
        }
        th {
            background: #ecf0f1;
            font-weight: bold;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .btn-secondary {
            background: #95a5a6;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .btn-danger {
            background: #e74c3c;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 BSMS - Password Reset & Troubleshooting</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Database Connection Test -->
        <div class="section">
            <h2>🗄️ Database Connection Test</h2>
            <p>Testing connection to your MySQL database...</p>
            <?php
                try {
                    $db = Database::getInstance();
                    $result = $db->getRow("SELECT VERSION() as version");
                    if ($result) {
                        echo '<div class="status status-ok">✅ Database connected successfully!</div>';
                        echo '<p><strong>MySQL Version:</strong> ' . htmlspecialchars($result['version']) . '</p>';
                        
                        // Check if users table exists and has data
                        $users = $db->getRows("SELECT id, email FROM users LIMIT 5");
                        echo '<p><strong>Users in database:</strong> ' . count($users) . '</p>';
                        
                        if (count($users) > 0) {
                            echo '<table>';
                            echo '<tr><th>ID</th><th>Email</th></tr>';
                            foreach ($users as $user) {
                                echo '<tr><td>' . $user['id'] . '</td><td>' . htmlspecialchars($user['email']) . '</td></tr>';
                            }
                            echo '</table>';
                        }
                    } else {
                        echo '<div class="status status-error">❌ Database connected but query failed</div>';
                    }
                } catch (Exception $e) {
                    echo '<div class="status status-error">❌ Database Connection Failed!</div>';
                    echo '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
                    echo '<p><strong>Check your .env file settings:</strong></p>';
                    echo '<pre>DB_HOST=' . getenv('DB_HOST') . '
DB_USER=' . getenv('DB_USER') . '
DB_NAME=' . getenv('DB_NAME') . '
DB_PORT=' . getenv('DB_PORT') . '</pre>';
                }
            ?>
        </div>

        <!-- Reset Admin Password -->
        <div class="section">
            <h2>🔐 Reset Admin Password</h2>
            <p>Reset the admin password to a new value</p>
            
            <form method="POST">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required placeholder="Enter new password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm password">
                </div>
                <button type="submit" name="action" value="reset_password">Reset Password</button>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'reset_password') {
                    $newPassword = $_POST['new_password'] ?? '';
                    $confirmPassword = $_POST['confirm_password'] ?? '';
                    
                    if (strlen($newPassword) < 6) {
                        $error = 'Password must be at least 6 characters';
                    } elseif ($newPassword !== $confirmPassword) {
                        $error = 'Passwords do not match';
                    } else {
                        try {
                            $db = Database::getInstance();
                            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                            
                            $db->update(
                                'users',
                                ['password' => $hashedPassword],
                                'email = ?',
                                ['admin@bsms.local']
                            );
                            
                            $message = '✅ Admin password has been reset successfully!<br>';
                            $message .= '<strong>Email:</strong> admin@bsms.local<br>';
                            $message .= '<strong>New Password:</strong> ' . htmlspecialchars($newPassword) . '<br>';
                            $message .= 'You can now login with these credentials.';
                        } catch (Exception $e) {
                            $error = 'Failed to reset password: ' . $e->getMessage();
                        }
                    }
                }
            ?>
        </div>

        <!-- Check Admin User -->
        <div class="section">
            <h2>👤 Check Admin User</h2>
            <p>Verify admin account exists and check details</p>
            <?php
                try {
                    $db = Database::getInstance();
                    $adminUser = $db->getRow("SELECT id, name, email, role_id, password FROM users WHERE email = 'admin@bsms.local'");
                    
                    if ($adminUser) {
                        echo '<div class="status status-ok">✅ Admin user found!</div>';
                        echo '<table>';
                        echo '<tr><th>Field</th><th>Value</th></tr>';
                        echo '<tr><td>ID</td><td>' . $adminUser['id'] . '</td></tr>';
                        echo '<tr><td>Name</td><td>' . htmlspecialchars($adminUser['name']) . '</td></tr>';
                        echo '<tr><td>Email</td><td>' . htmlspecialchars($adminUser['email']) . '</td></tr>';
                        echo '<tr><td>Role ID</td><td>' . $adminUser['role_id'] . '</td></tr>';
                        echo '<tr><td>Password Hash</td><td><code>' . substr($adminUser['password'], 0, 20) . '...</code></td></tr>';
                        echo '</table>';
                        
                        // Test password verification
                        if (password_verify('admin123', $adminUser['password'])) {
                            echo '<div class="status status-ok">✅ Password hash is valid for "admin123"</div>';
                        } else {
                            echo '<div class="status status-error">❌ Password hash does NOT match "admin123"</div>';
                            echo '<p>You need to reset the password above.</p>';
                        }
                    } else {
                        echo '<div class="status status-error">❌ Admin user NOT found!</div>';
                        echo '<p>The admin account was not created. Try re-importing the database schema.</p>';
                    }
                } catch (Exception $e) {
                    echo '<div class="status status-error">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
                }
            ?>
        </div>

        <!-- Configuration Check -->
        <div class="section">
            <h2>⚙️ Configuration Check</h2>
            <table>
                <tr>
                    <th>Setting</th>
                    <th>Value</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>PHP Version</td>
                    <td><?php echo phpversion(); ?></td>
                    <td>
                        <?php
                            if (version_compare(phpversion(), '7.4', '>=')) {
                                echo '<span style="color: green;">✅ OK</span>';
                            } else {
                                echo '<span style="color: red;">❌ Too Old</span>';
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Session Started</td>
                    <td><?php echo session_status() === PHP_SESSION_ACTIVE ? 'Yes' : 'No'; ?></td>
                    <td><?php echo session_status() === PHP_SESSION_ACTIVE ? '✅ OK' : '❌ Error'; ?></td>
                </tr>
                <tr>
                    <td>DB_HOST</td>
                    <td><?php echo getenv('DB_HOST') ?: 'localhost'; ?></td>
                    <td>ℹ️ Info</td>
                </tr>
                <tr>
                    <td>DB_PORT</td>
                    <td><?php echo getenv('DB_PORT') ?: '3306'; ?></td>
                    <td>ℹ️ Info</td>
                </tr>
                <tr>
                    <td>DB_USER</td>
                    <td><?php echo getenv('DB_USER') ?: 'root'; ?></td>
                    <td>ℹ️ Info</td>
                </tr>
                <tr>
                    <td>DB_NAME</td>
                    <td><?php echo getenv('DB_NAME') ?: 'bsms_db'; ?></td>
                    <td>ℹ️ Info</td>
                </tr>
            </table>
        </div>

        <!-- Quick Test Login -->
        <div class="section">
            <h2>🔑 Test Login Credentials</h2>
            <p>Use these credentials to test login:</p>
            <div class="info-box">
                <strong>Email:</strong> admin@bsms.local<br>
                <strong>Password:</strong> admin123 (or whatever you reset it to)
            </div>
            <button onclick="window.location.href='http://localhost/bsms-burger-shop'">🌐 Go to Login Page</button>
        </div>

        <!-- Delete This File -->
        <div class="section" style="background: #fadbd8; border-left-color: #e74c3c;">
            <h2>⚠️ Security Warning</h2>
            <p><strong>IMPORTANT:</strong> Delete this file after you're done troubleshooting!</p>
            <p>This file contains sensitive information and should not be left on the server.</p>
            <div class="button-group">
                <button class="btn-danger" onclick="if(confirm('Delete reset-password.php?')) { window.location.href='?action=delete'; }">🗑️ Delete This File</button>
                <button class="btn-secondary" onclick="window.location.href='http://localhost/bsms-burger-shop'">✅ Back to Login</button>
            </div>
        </div>

        <?php
            // Handle file deletion
            if ($action === 'delete') {
                if (unlink(__FILE__)) {
                    echo '<div class="alert alert-success">✅ File deleted successfully!</div>';
                } else {
                    echo '<div class="alert alert-danger">❌ Could not delete file. Please delete manually: reset-password.php</div>';
                }
            }
        ?>

        <hr style="margin-top: 30px; border: none; border-top: 1px solid #bdc3c7;">
        <p style="text-align: center; color: #7f8c8d; margin-top: 20px; font-size: 12px;">
            BSMS Password Reset & Troubleshooting Tool | Created for debugging purposes
        </p>
    </div>
</body>
</html>

?>

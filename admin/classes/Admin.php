<?php
class Admin {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function login($username, $password) {
        try {
            $stmt = $this->conn->prepare("
                SELECT id, username, password, full_name, role 
                FROM admin_users 
                WHERE username = ? AND status = 'active'
            ");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password'])) {
                // Log successful login
                $this->logLogin($admin['id'], 'success');
                
                // Update last login
                $stmt = $this->conn->prepare("
                    UPDATE admin_users SET last_login = NOW() 
                    WHERE id = ?
                ");
                $stmt->execute([$admin['id']]);
                
                return $admin;
            }
            
            // Log failed login attempt
            $this->logLogin(null, 'failed');
            return false;
        } catch(PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }
    
    private function logLogin($adminId, $status) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO admin_login_logs (admin_id, login_time, ip_address, user_agent, status)
                VALUES (?, NOW(), ?, ?, ?)
            ");
            $stmt->execute([
                $adminId,
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT'],
                $status
            ]);
        } catch(PDOException $e) {
            error_log("Login log error: " . $e->getMessage());
        }
    }
    
    public function getAdminList() {
        try {
            $stmt = $this->conn->query("
                SELECT id, username, email, full_name, role, status, 
                       last_login, created_at 
                FROM admin_users 
                ORDER BY created_at DESC
            ");
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Get admin list error: " . $e->getMessage());
            return [];
        }
    }
}
?> 
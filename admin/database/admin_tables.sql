-- Create admin_users table
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('super_admin', 'admin', 'moderator') NOT NULL DEFAULT 'admin',
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create admin_login_logs table for security
CREATE TABLE admin_login_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT,
    login_time DATETIME NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT,
    status ENUM('success', 'failed') NOT NULL,
    FOREIGN KEY (admin_id) REFERENCES admin_users(id)
); 
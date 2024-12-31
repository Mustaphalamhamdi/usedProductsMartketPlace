<?php
class Database {
    private $host = "localhost";
    private $db_name = "souqcycle";
    private $username = "root";
    private $password = "";
    
    public function getConnection() {
        try {
            // Try connecting without database first
            $conn = new PDO(
                "mysql:host=" . $this->host,
                $this->username,
                $this->password
            );
            
            // Create database if not exists
            $conn->exec("CREATE DATABASE IF NOT EXISTS $this->db_name");
            
            // Connect to the database
            $conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            error_log("Connection Error: " . $e->getMessage());
            echo "Connection Error: " . $e->getMessage();
            return null;
        }
    }
}
?>
<?php
class Database {
    private $host = "u200606317_souqcycle";
    private $db_name = "souqcycle";
    private $username = "mustapha";
    private $password = "Mustapha1211@@";
    
    public function getConnection() {
        try {
            $conn = new PDO(
                "mysql:host=" . $this->host,
                $this->username,
                $this->password
            );
            $conn->exec("CREATE DATABASE IF NOT EXISTS $this->db_name");
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
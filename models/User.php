<?php
class User {
    private $conn;
    private $table_name = "users";
    public $id;
    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $is_admin;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table_name . " 
                 (username, email, password, phone_number) 
                 VALUES 
                 (:username, :email, :password, :phone_number)";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":phone_number", $this->phone_number);
            return $stmt->execute();
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function login($email, $password) {
        $query = "SELECT id, username, email, password, is_admin FROM " . $this->table_name . 
                 " WHERE email = :email";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['is_admin'] = $row['is_admin'];
                    return true;
                }
            }
            
            return false;
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
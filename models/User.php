<?php
class User {
    // Database connection and table name
    private $conn;
    private $table_name = "users";

    // Object properties
    public $id;
    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $is_admin;

    // Constructor with database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to create a new user (registration)
    public function create() {
        // Sanitize user input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        
        // Hash the password for security
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Insert query
        $query = "INSERT INTO " . $this->table_name . " 
                 (username, email, password, phone_number) 
                 VALUES 
                 (:username, :email, :password, :phone_number)";

        try {
            $stmt = $this->conn->prepare($query);

            // Bind the values
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":phone_number", $this->phone_number);

            // Execute the query
            return $stmt->execute();
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function login($email, $password) {
        // Query to read user data
        $query = "SELECT id, username, email, password, is_admin FROM " . $this->table_name . 
                 " WHERE email = :email";
        
        try {
            $stmt = $this->conn->prepare($query);
            
            // Bind email parameter
            $stmt->bindParam(":email", $email);
            
            // Execute the query
            $stmt->execute();
            
            // Check if user exists
            if($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verify the password
                if(password_verify($password, $row['password'])) {
                    // Password is correct, set up session variables
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
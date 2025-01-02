<?php
class Category {
    private $conn;
    private $table = 'categories';
    public $id;
    public $name;
    public $description;
    public $created_by;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                (name, description, created_by) 
                VALUES 
                (:name, :description, :created_by)";

        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':created_by', $this->created_by);

        return $stmt->execute();
    }    
    public function getAllCategories() {
        try {
            $query = "SELECT * FROM categories ORDER BY name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error getting categories: " . $e->getMessage());
            return false;
        }
    }
}
?>
<?php
class Product {
   private $conn;
   private $table_name = "products";
   private $items_per_page = 9;
   public $id;
   public $title;
   public $description;
   public $price;
   public $user_id;
   public $category_id;
   public $status;
   public $creation_date;

   public function __construct($db) {
       $this->conn = $db;
   }
   public function create() {
       $this->title = htmlspecialchars(strip_tags($this->title));
       $this->description = htmlspecialchars(strip_tags($this->description));
       $this->price = floatval($this->price);
       $this->category_id = intval($this->category_id);
       $query = "INSERT INTO " . $this->table_name . "
               (title, description, price, user_id, category_id, status)
               VALUES
               (:title, :description, :price, :user_id, :category_id, 'available')";
       try {
           $stmt = $this->conn->prepare($query);
           $stmt->bindParam(":title", $this->title);
           $stmt->bindParam(":description", $this->description);
           $stmt->bindParam(":price", $this->price);
           $stmt->bindParam(":user_id", $this->user_id);
           $stmt->bindParam(":category_id", $this->category_id);
           return $stmt->execute();
       } catch(PDOException $e) {
           error_log("Create product error: " . $e->getMessage());
           return false;
       }
   }
   public function getAllProducts($status = null) {
       $query = "SELECT p.*, u.username, u.phone_number, c.name as category_name 
                FROM " . $this->table_name . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id";
       
       if ($status) {
           $query .= " WHERE p.status = :status";
       }
       
       $query .= " ORDER BY p.creation_date DESC";

       try {
           $stmt = $this->conn->prepare($query);
           
           if ($status) {
               $stmt->bindParam(":status", $status);
           }
           
           $stmt->execute();
           return $stmt->fetchAll(PDO::FETCH_ASSOC);
           
       } catch(PDOException $e) {
           error_log("Get all products error: " . $e->getMessage());
           return false;
       }
   }
   public function getProductById($id) {
       $query = "SELECT p.*, u.username, u.phone_number, c.name as category_name 
                FROM " . $this->table_name . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id";

       try {
           $stmt = $this->conn->prepare($query);
           $stmt->bindParam(":id", $id);
           $stmt->execute();
           
           return $stmt->fetch(PDO::FETCH_ASSOC);
           
       } catch(PDOException $e) {
           error_log("Get product by ID error: " . $e->getMessage());
           return false;
       }
   }

   public function searchProducts($searchTerm = '', $sortBy = '', $categoryId = null) {
       $query = "SELECT DISTINCT p.*, u.username, u.phone_number, c.name as category_name
                FROM " . $this->table_name . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id";
       
       $conditions = ["p.status = 'available'"];
       $params = [];
       
       if (!empty($searchTerm)) {
           $conditions[] = "(p.title LIKE :search OR p.description LIKE :search)";
           $params[':search'] = "%{$searchTerm}%";
       }
       
       if ($categoryId) {
           $conditions[] = "p.category_id = :category_id";
           $params[':category_id'] = $categoryId;
       }
       
       if (!empty($conditions)) {
           $query .= " WHERE " . implode(" AND ", $conditions);
       }
       
       switch ($sortBy) {
           case 'price_low':
               $query .= " ORDER BY p.price ASC";
               break;
           case 'price_high':
               $query .= " ORDER BY p.price DESC";
               break;
           case 'oldest':
               $query .= " ORDER BY p.creation_date ASC";
               break;
           default:
               $query .= " ORDER BY p.creation_date DESC";
       }

       try {
           $stmt = $this->conn->prepare($query);
           
           foreach ($params as $key => $value) {
               $stmt->bindValue($key, $value);
           }
           
           $stmt->execute();
           return $stmt->fetchAll(PDO::FETCH_ASSOC);
           
       } catch(PDOException $e) {
           error_log("Search error: " . $e->getMessage());
           return false;
       }
   }

   public function getProductsWithPagination($page = 1, $searchTerm = '', $sortBy = '', $categoryId = null) {
       $start = ($page - 1) * $this->items_per_page;
       
       $query = "SELECT DISTINCT p.*, u.username, u.phone_number, c.name as category_name
                FROM " . $this->table_name . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id";
       
       $conditions = ["p.status = 'available'"];
       $params = [];
       
       if (!empty($searchTerm)) {
           $conditions[] = "(p.title LIKE :search OR p.description LIKE :search)";
           $params[':search'] = "%{$searchTerm}%";
       }
       
       if ($categoryId) {
           $conditions[] = "p.category_id = :category_id";
           $params[':category_id'] = $categoryId;
       }
       
       if (!empty($conditions)) {
           $query .= " WHERE " . implode(" AND ", $conditions);
       }
       
       switch ($sortBy) {
           case 'price_low':
               $query .= " ORDER BY p.price ASC";
               break;
           case 'price_high':
               $query .= " ORDER BY p.price DESC";
               break;
           case 'oldest':
               $query .= " ORDER BY p.creation_date ASC";
               break;
           default:
               $query .= " ORDER BY p.creation_date DESC";
       }
       
       $countQuery = str_replace("DISTINCT p.*, u.username, u.phone_number, c.name as category_name", "COUNT(DISTINCT p.id) as total", $query);
       $countQuery = preg_replace("/ORDER BY.*$/", "", $countQuery);
       
       try {
           $countStmt = $this->conn->prepare($countQuery);
           foreach ($params as $key => $value) {
               $countStmt->bindValue($key, $value);
           }
           $countStmt->execute();
           $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
           
           $query .= " LIMIT :start, :items_per_page";
           $stmt = $this->conn->prepare($query);
           
           foreach ($params as $key => $value) {
               $stmt->bindValue($key, $value);
           }
           $stmt->bindValue(':start', $start, PDO::PARAM_INT);
           $stmt->bindValue(':items_per_page', $this->items_per_page, PDO::PARAM_INT);
           $stmt->execute();
           
           return [
               'products' => $stmt->fetchAll(PDO::FETCH_ASSOC),
               'total_items' => $totalCount,
               'items_per_page' => $this->items_per_page,
               'current_page' => $page,
               'total_pages' => ceil($totalCount / $this->items_per_page)
           ];
           
       } catch(PDOException $e) {
           error_log("Pagination error: " . $e->getMessage());
           return false;
       }
   }

   public function getProductsByCategory($categoryId = null) {
       $query = "SELECT p.*, u.username, u.phone_number, c.name as category_name
                FROM " . $this->table_name . " p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.status = 'available'";
       
       if ($categoryId) {
           $query .= " AND p.category_id = :category_id";
       }
       
       $query .= " ORDER BY p.creation_date DESC";

       try {
           $stmt = $this->conn->prepare($query);
           
           if ($categoryId) {
               $stmt->bindParam(":category_id", $categoryId);
           }
           
           $stmt->execute();
           return $stmt->fetchAll(PDO::FETCH_ASSOC);
           
       } catch(PDOException $e) {
           error_log("Get products by category error: " . $e->getMessage());
           return false;
       }
   }

   public function updateStatus($id, $status) {
       $query = "UPDATE " . $this->table_name . "
                 SET status = :status
                 WHERE id = :id";
   
       try {
           $stmt = $this->conn->prepare($query);
           $stmt->bindParam(":status", $status);
           $stmt->bindParam(":id", $id);
           return $stmt->execute();
       } catch(PDOException $e) {
           error_log("Update status error: " . $e->getMessage());
           return false;
       }
   }
   
   public function delete($id) {
       $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
   
       try {
           $stmt = $this->conn->prepare($query);
           $stmt->bindParam(":id", $id);
           return $stmt->execute();
       } catch(PDOException $e) {
           error_log("Delete error: " . $e->getMessage());
           return false;
       }
   }
}
?>
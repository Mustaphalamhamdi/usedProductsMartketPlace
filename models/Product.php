<?php
class Product {
    private $conn;
    private $table_name = "products";
    private $items_per_page = 9; // Show 9 products per page (3x3 grid)


    // Product properties
    public $id;
    public $title;
    public $description;
    public $price;
    public $user_id;
    public $status;
    public $creation_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new product listing
    public function create() {
        // Sanitize input to prevent SQL injection and remove any harmful HTML
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = floatval($this->price);

        // Our SQL query to insert a new product
        $query = "INSERT INTO " . $this->table_name . "
                (title, description, price, user_id, status)
                VALUES
                (:title, :description, :price, :user_id, 'available')";

        try {
            // Prepare the query
            $stmt = $this->conn->prepare($query);

            // Bind the values to prevent SQL injection
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":user_id", $this->user_id);

            // Execute the query and return the result
            return $stmt->execute();
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get all products with optional filter for status
    public function getAllProducts($status = null) {
        $query = "SELECT p.*, u.username, u.phone_number 
                 FROM " . $this->table_name . " p
                 LEFT JOIN users u ON p.user_id = u.id";
        
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
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get a single product by ID
    public function getProductById($id) {
        $query = "SELECT p.*, u.username, u.phone_number 
                 FROM " . $this->table_name . " p
                 LEFT JOIN users u ON p.user_id = u.id
                 WHERE p.id = :id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

public function searchProducts($searchTerm = '', $sortBy = '', $categoryId = null) {
    // Start with the base query including joins
    $query = "SELECT DISTINCT p.*, u.username, u.phone_number 
             FROM " . $this->table_name . " p
             LEFT JOIN users u ON p.user_id = u.id
             LEFT JOIN product_categories pc ON p.id = pc.product_id";
    
    // Build the WHERE clause
    $conditions = ["p.status = 'available'"];
    $params = [];
    
    // Add search condition if search term is provided
    if (!empty($searchTerm)) {
        $conditions[] = "(p.title LIKE :search OR p.description LIKE :search)";
        $params[':search'] = "%{$searchTerm}%";
    }
    
    // Add category filter if provided
    if ($categoryId) {
        $conditions[] = "pc.category_id = :category_id";
        $params[':category_id'] = $categoryId;
    }
    
    // Combine all conditions
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    // Add sorting
    switch ($sortBy) {
        case 'price_low':
            $query .= " ORDER BY p.price ASC";
            break;
        case 'price_high':
            $query .= " ORDER BY p.price DESC";
            break;
        case 'newest':
            $query .= " ORDER BY p.creation_date DESC";
            break;
        case 'oldest':
            $query .= " ORDER BY p.creation_date ASC";
            break;
        default:
            $query .= " ORDER BY p.creation_date DESC";
    }

    try {
        $stmt = $this->conn->prepare($query);
        
        // Bind all parameters
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
    // Calculate the starting point for this page
    $start = ($page - 1) * $this->items_per_page;
    
    // Start building our main query for products
    $query = "SELECT DISTINCT p.*, u.username, u.phone_number 
             FROM " . $this->table_name . " p
             LEFT JOIN users u ON p.user_id = u.id
             LEFT JOIN product_categories pc ON p.id = pc.product_id";
    
    // Build the WHERE clause
    $conditions = ["p.status = 'available'"];
    $params = [];
    
    // Add search condition if provided
    if (!empty($searchTerm)) {
        $conditions[] = "(p.title LIKE :search OR p.description LIKE :search)";
        $params[':search'] = "%{$searchTerm}%";
    }
    
    // Add category filter if provided
    if ($categoryId) {
        $conditions[] = "pc.category_id = :category_id";
        $params[':category_id'] = $categoryId;
    }
    
    // Combine all conditions
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    // Add sorting
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
    
    // First, get total count for pagination
    $countQuery = "SELECT COUNT(DISTINCT p.id) as total FROM " . $this->table_name . " p
                  LEFT JOIN product_categories pc ON p.id = pc.product_id";
    if (!empty($conditions)) {
        $countQuery .= " WHERE " . implode(" AND ", $conditions);
    }
    
    try {
        // Get total count
        $countStmt = $this->conn->prepare($countQuery);
        foreach ($params as $key => $value) {
            $countStmt->bindValue($key, $value);
        }
        $countStmt->execute();
        $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Add pagination to main query
        $query .= " LIMIT :start, :items_per_page";
        
        // Prepare and execute main query
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
        // Base query that joins with users table for seller information
        $query = "SELECT p.*, u.username, u.phone_number 
                 FROM " . $this->table_name . " p
                 LEFT JOIN users u ON p.user_id = u.id
                 LEFT JOIN product_categories pc ON p.id = pc.product_id";
        
        // If a category is specified, add the WHERE clause
        if ($categoryId) {
            $query .= " WHERE pc.category_id = :category_id AND p.status = 'available'";
        } else {
            $query .= " WHERE p.status = 'available'";
        }
        
        $query .= " ORDER BY p.creation_date DESC";
    
        try {
            $stmt = $this->conn->prepare($query);
            
            // If we're filtering by category, bind the parameter
            if ($categoryId) {
                $stmt->bindParam(":category_id", $categoryId);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
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
            echo "Error: " . $e->getMessage();
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
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
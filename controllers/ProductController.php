<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Product.php";
require_once __DIR__ . "/../models/ProductImage.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        if ($this->db === null) {
            die("Database connection failed");
        }
        $this->product = new Product($this->db);
    }
    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
            switch($_POST['action']) {
                case 'create':
                    $this->createProduct($_POST, $_FILES);
                    break;
                case 'admin_update_status':
                    if($this->adminUpdateStatus($_POST['product_id'], $_POST['status'])) {
                        $_SESSION['success'] = "Product status updated successfully";
                    } else {
                        $_SESSION['error'] = "Failed to update product status";
                    }
                    break;
                default:
                    break;
            }
        }
    }
    // Handle product creation
    public function createProduct($data, $files) {
        if (!isset($_SESSION['is_logged_in'])) {
            $_SESSION['error'] = "You must be logged in to create a listing";
            header("Location: ../views/user/login.php");
            exit();
        }
     
        if (empty($data['title']) || empty($data['description']) || empty($data['price'])) {
            $_SESSION['error'] = "Please fill in all required fields";
            header("Location: ../views/product/create.php");
            exit();
        }
     
        $this->product->title = $data['title'];
    $this->product->description = $data['description'];
    $this->product->price = $data['price'];
    $this->product->category_id = $data['category_id']; // Added this line
    $this->product->user_id = $_SESSION['user_id'];
     
        if ($this->product->create()) {
            $productId = $this->db->lastInsertId();
            
            if (!empty($_FILES['images'])) {
                $imageHandler = new ProductImage($this->db);
                $imageHandler->uploadImages($productId, $_FILES['images']);
            }
            
            $_SESSION['success'] = "Product created successfully!";
            header("Location: ../views/product/list.php");
            exit();
        } 
     
        $_SESSION['error'] = "Failed to create listing. Please try again.";
        header("Location: ../views/product/create.php");
        exit();
     }

    // Handle product listing display
    public function listProducts() {
        return $this->product->getAllProducts('available');
    }
    public function getAllProductsForAdmin() {
        $query = "SELECT p.*, u.username 
                  FROM products p 
                  LEFT JOIN users u ON p.user_id = u.id 
                  ORDER BY p.creation_date DESC";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function adminUpdateStatus($productId, $status) {
        if (!in_array($status, ['available', 'sold'])) {
            return false;
        }
    
        $query = "UPDATE products SET status = :status WHERE id = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":id", $productId);
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    public function adminDeleteProduct($productId) {
        $query = "DELETE FROM products WHERE id = :id";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $productId);
            return $stmt->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    // Handle single product display
    public function showProduct($id) {
        return $this->product->getProductById($id);
    }
    public function updateProductStatus($productId, $status) {
        // Make sure the user owns this product
        $product = $this->product->getProductById($productId);
        if (!$product || $product['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "You don't have permission to modify this listing";
            header("Location: ../views/product/view.php?id=" . $productId);
            return;
        }
    
        if ($this->product->updateStatus($productId, $status)) {
            $_SESSION['success'] = "Product status updated successfully";
        } else {
            $_SESSION['error'] = "Failed to update product status";
        }
        header("Location: ../views/product/view.php?id=" . $productId);
    }

    public function deleteProduct($productId) {
        try {
            // First delete associated images
            $imageHandler = new ProductImage($this->db);
            $imageHandler->deleteProductImages($productId);
            
            // Then delete the product
            if ($this->product->delete($productId)) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log("Delete product error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getUserProducts($userId) {
        // Create query to get all products for a specific user
        $query = "SELECT * FROM products 
                  WHERE user_id = :user_id 
                  ORDER BY creation_date DESC";
                  
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $_SESSION['error'] = "Error retrieving user products";
            return false;
        }
    }
    public function getTotalProducts() {
        $query = "SELECT COUNT(*) as total FROM products WHERE status = 'available'";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }
    
    public function getRecentProducts($limit = 5) {
        $query = "SELECT p.*, u.username 
                  FROM products p 
                  LEFT JOIN users u ON p.user_id = u.id 
                  ORDER BY p.creation_date DESC 
                  LIMIT :limit";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return [];
        }
    }
    public function getProductCountByCategory($categoryId) {
        try {
            $query = "SELECT COUNT(*) as count 
                      FROM products 
                      WHERE category_id = :category_id 
                      AND status = 'available'";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":category_id", $categoryId);
            $stmt->execute();
            
            error_log("Category ID: " . $categoryId); // Debug
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("Count result: " . print_r($result, true)); // Debug
            
            return $result['count'] ?? 0;
        } catch(PDOException $e) {
            error_log("Error getting product count: " . $e->getMessage());
            return 0;
        }
    }
    public function getPagedProducts($page = 1, $searchTerm = '', $sortBy = '', $categoryId = null) {
        return $this->product->getProductsWithPagination($page, $searchTerm, $sortBy, $categoryId);
    }
    public function searchAndFilterProducts($searchTerm = '', $sortBy = '', $categoryId = null) {
        return $this->product->searchProducts($searchTerm, $sortBy, $categoryId);
    }
    public function listProductsByCategory($categoryId = null) {
        return $this->product->getProductsByCategory($categoryId);
    }
}

// Handle form submissions and requests
// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new ProductController();
    
    switch($_POST['action']) {
        case 'create':
            $controller->createProduct($_POST, $_FILES);
            break;
        // Add the delete case here
        case 'delete':
            $controller = new ProductController();
            
            if (!isset($_POST['product_id'])) {
                $_SESSION['error'] = "Product ID not specified";
                header("Location: ../views/product/list.php");
                exit();
            }
            
            $productId = $_POST['product_id'];
            $product = $controller->showProduct($productId);
            
            if (!isset($_SESSION['user_id']) || (!isset($_SESSION['is_admin']) && $_SESSION['user_id'] != $product['user_id'])) {
                $_SESSION['error'] = "Unauthorized access";
                header("Location: ../views/product/list.php");
                exit();
            }
            
            if ($controller->deleteProduct($productId)) {
                $_SESSION['success'] = "Product deleted successfully";
                header("Location: ../views/product/list.php");
            } else {
                $_SESSION['error'] = "Failed to delete product";
                header("Location: ../views/product/list.php");
            }
            exit();
            case 'mark_sold':
                if (!isset($_POST['product_id'])) {
                    $_SESSION['error'] = "Product ID not specified";
                    header("Location: ../views/product/list.php");
                    exit();
                }
                
                $productId = $_POST['product_id'];
                $product = $controller->showProduct($productId);
                
                // Check if user owns this product
                if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $product['user_id']) {
                    $_SESSION['error'] = "You don't have permission to modify this listing";
                    header("Location: ../views/product/list.php");
                    exit();
                }
                
                if ($controller->updateProductStatus($productId, 'sold')) {
                    $_SESSION['success'] = "Product marked as sold";
                    header("Location: ../views/product/view.php?id=" . $productId);
                } else {
                    $_SESSION['error'] = "Failed to update product status";
                    header("Location: ../views/product/view.php?id=" . $productId);
                }
                exit();
                break;
    }
}
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';  // or set default action
}
if (!isset($_GET['action'])) {
    $_GET['action'] = 'default';
}

?>
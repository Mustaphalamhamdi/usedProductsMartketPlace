<?php
require_once __DIR__ . "/../config/database.php";  // Fix the path using __DIR__
require_once __DIR__ . "/../models/Category.php";

class CategoryController {
    private $db;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
    }

    // Create new category (admin only)
    public function createCategory($data) {
        $this->category->name = $data['name'];
        $this->category->description = $data['description'] ?? '';
        $this->category->created_by = $_SESSION['user_id'];

        if ($this->category->create()) {
            $_SESSION['success'] = "Category created successfully";
            header("Location: ../views/admin/categories/list.php");
        } else {
            $_SESSION['error'] = "Failed to create category";
            header("Location: ../views/admin/categories/create.php");
        }
        exit();
    }
    public function getAllCategories() {
        $query = "SELECT c.*, COUNT(pc.product_id) as product_count 
                 FROM categories c 
                 LEFT JOIN product_categories pc ON c.id = pc.category_id 
                 GROUP BY c.id 
                 ORDER BY c.name ASC";
        
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $_SESSION['error'] = "Error retrieving categories";
            return false;
        }
    }
    public function getTotalCategories() {
        $query = "SELECT COUNT(*) as total FROM categories";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch(PDOException $e) {
            return 0;
        }
    }
    // Get all categories
    public function listCategories() {
        return $this->category->getAllCategories();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_log("POST request received with data: " . print_r($_POST, true));
    
    $controller = new CategoryController();
    
    if (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'create':
                error_log("Creating category from POST");
                $controller->createCategory($_POST);
                break;
            default:
                error_log("Unknown action: " . $_POST['action']);
                $_SESSION['error'] = "Invalid action";
                header("Location: ../views/admin/categories/list.php");
                exit();
        }
    }
}
?>
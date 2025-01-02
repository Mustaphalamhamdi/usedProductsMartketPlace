<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Category.php";

class CategoryController {
    private $db;
    private $category;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category = new Category($this->db);
    }
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
public function updateCategory($id, $data) {
    try {
        $query = "UPDATE categories 
                 SET name = :name, description = :description 
                 WHERE id = :id";
                 
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $id);
        
        if($stmt->execute()) {
            $_SESSION['success'] = "Category updated successfully";
            return true;
        }
        return false;
    } catch(PDOException $e) {
        error_log("Update category error: " . $e->getMessage());
        return false;
    }
}
    public function deleteCategory($categoryId) {
        try {
            $this->db->beginTransaction();
            if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
                throw new Exception("Unauthorized access");
            }
            $query = "DELETE FROM categories WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $categoryId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $this->db->commit();
                $_SESSION['success'] = "Category deleted successfully";
                error_log("Category deleted successfully: " . $categoryId);
            } else {
                throw new Exception("Failed to delete category");
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Delete category error: " . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
        }
        header("Location: /../categories/list.php");
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
    public function getCategoryWithCount($categoryId) {
        try {
            $query = "SELECT COUNT(*) as count 
                      FROM products 
                      WHERE category_id = :category_id 
                      AND status = 'available'";
                      
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch(PDOException $e) {
            error_log("Error getting category count: " . $e->getMessage());
            return 0;
        }
    }
    
    public function getAllCategoriesWithCount() {
        try {
            $query = "SELECT c.*, COUNT(p.id) as product_count 
                      FROM categories c 
                      LEFT JOIN products p ON c.id = p.category_id AND p.status = 'available'
                      GROUP BY c.id";
                      
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error getting categories with count: " . $e->getMessage());
            return [];
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
    public function getProductsByCategory($categoryId) {
        try {
            $query = "SELECT p.*, u.username 
                      FROM products p 
                      LEFT JOIN users u ON p.user_id = u.id 
                      WHERE p.category_id = :category_id AND p.status = 'available' 
                      ORDER BY p.creation_date DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":category_id", $categoryId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error getting products by category: " . $e->getMessage());
            return [];
        }
    }
    public function listCategories() {
        return $this->category->getAllCategories();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $action = $_POST['action'] ?? '';    
    $controller = new CategoryController();
    
    if (isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'create':
                error_log("Creating category from POST");
                $controller->createCategory($_POST);
                break;
                case 'delete':
                    $categoryId = $_POST['category_id'] ?? 0;
                    if ($categoryId) {
                        $controller->deleteCategory($categoryId);
                    }
                    break;
                    case 'update':
                        if (!isset($_POST['category_id'])) {
                            $_SESSION['error'] = "Category ID not specified";
                            header("Location: ../views/admin/categories/list.php");
                            exit();
                        }
                        
                        $categoryId = $_POST['category_id'];
                        $data = [
                            'name' => $_POST['name'],
                            'description' => $_POST['description']
                        ];
                        
                        if ($controller->updateCategory($categoryId, $data)) {
                            $_SESSION['success'] = "Category updated successfully";
                        } else {
                            $_SESSION['error'] = "Failed to update category";
                        }
                        header("Location: ../views/admin/categories/list.php");
                        exit();
                        break;
            default:
                error_log("Unknown action: " . $_POST['action']);
                $_SESSION['error'] = "Invalid action";
                header("Location: /SouqCycle/views/admin/categories/list.php");
                exit();
        }
    }
}
?>
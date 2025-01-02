<?php
class ProductImage {
    private $conn;
    private $table_name = "product_images";
    private $upload_path;
    private $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    private $max_size = 5242880;

    public function __construct($db) {
        $this->conn = $db;
        $this->upload_path = $_SERVER['DOCUMENT_ROOT'] . "/SouqCycle/uploads/products/";
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0777, true);
        }
    }

    public function uploadImages($productId, $files) {
        $results = ['success' => true, 'errors' => []];
        
        foreach ($files['name'] as $key => $name) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid() . '.' . $ext;
                $destination = $this->upload_path . $newName;
                
                if (move_uploaded_file($files['tmp_name'][$key], $destination)) {
                    $stmt = $this->conn->prepare(
                        "INSERT INTO {$this->table_name} (product_id, image_path) VALUES (?, ?)"
                    );
                    if (!$stmt->execute([$productId, $newName])) {
                        $results['errors'][] = "Database error for {$name}";
                        $results['success'] = false;
                    }
                }
            }
        }
        return $results;
    }
    public function getProductImages($productId) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table_name} WHERE product_id = ? ORDER BY id ASC"
        );
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteProductImages($productId) {
        try {
            $images = $this->getProductImages($productId);
            foreach ($images as $image) {
                $filepath = $this->upload_path . $image['image_path'];
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            $query = "DELETE FROM " . $this->table_name . " WHERE product_id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':product_id', $productId);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Delete product images error: " . $e->getMessage());
            return false;
        }
    }
}
?>
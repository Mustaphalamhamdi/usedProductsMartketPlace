<?php
class ProductImage {
    private $conn;
    private $table_name = "product_images";
    private $upload_path = "../uploads/products/";
    private $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    private $max_size = 5242880; // 5MB in bytes

    public function __construct($db) {
        $this->conn = $db;
        // Create uploads directory if it doesn't exist
        if (!file_exists($this->upload_path)) {
            mkdir($this->upload_path, 0755, true);
        }
    }

    public function uploadImages($productId, $images) {
        error_log("Starting image upload for product ID: " . $productId);
        error_log("Image data received: " . print_r($images, true));
        // ... rest of your upload code
    }

    private function validateFile($file) {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Check file type
        if (!in_array($file['type'], $this->allowed_types)) {
            return false;
        }

        // Check file size
        if ($file['size'] > $this->max_size) {
            return false;
        }

        return true;
    }

    private function restructureFilesArray($files) {
        return [
            'name' => [$files['name']],
            'type' => [$files['type']],
            'tmp_name' => [$files['tmp_name']],
            'error' => [$files['error']],
            'size' => [$files['size']]
        ];
    }

    public function getProductImages($productId) {
        $query = "SELECT * FROM " . $this->table_name . "
                 WHERE product_id = :product_id
                 ORDER BY is_primary DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":product_id", $productId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            return false;
        }
    }
}
?>
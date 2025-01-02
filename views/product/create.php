<?php
require_once "../includes/header.php";
require_once "../includes/auth_check.php";
require_once "../../controllers/CategoryController.php";
$categoryController = new CategoryController();
$categories = $categoryController->listCategories();
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Create New Listing</h3>
                </div>
                <div class="card-body">
                    <form action="../../../controllers/ProductController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-4">
                            <label for="images" class="form-label">
                                <i class="bi bi-images me-2"></i>Product Images
                            </label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                You can upload up to 5 images (max 5MB each). First image will be the primary image.
                            </small>
                            <div id="imagePreview" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="form-label">
                                <i class="bi bi-tag me-2"></i>Product Title
                            </label>
                            <input type="text" class="form-control" id="title" name="title" required
                                   placeholder="Enter product title">
                        </div>
                        <div class="mb-4">
                            <label for="category_id" class="form-label">
                                <i class="bi bi-folder me-2"></i>Category
                            </label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="form-label">
                                <i class="bi bi-currency-dollar me-2"></i>Price
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price" name="price" 
                                       step="0.01" required placeholder="Enter price">
                                <span class="input-group-text">MAD</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="bi bi-text-paragraph me-2"></i>Description
                            </label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="4" required placeholder="Describe your product"></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Create Listing
                            </button>
                            <a href="list.php" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (this.files.length > 5) {
        alert('You can only upload up to 5 images');
        this.value = '';
        return;
    }

    for (let i = 0; i < this.files.length; i++) {
        const file = this.files[i];
        if (file) {
            if (file.size > 5242880) {
                alert('File ' + file.name + ' is too large. Maximum size is 5MB');
                continue;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'position-relative';
                div.innerHTML = `
                    <div class="card" style="width: 150px;">
                        <img src="${e.target.result}" class="card-img-top" 
                             style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2 text-center">
                            <small class="text-muted">Image ${i + 1}</small>
                        </div>
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        }
    }
});
</script>

<?php require_once "../includes/footer.php"; ?>
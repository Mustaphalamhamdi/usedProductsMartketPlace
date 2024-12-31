<?php
require_once "../includes/header.php";
require_once "../includes/auth_check.php";
require_once "../../controllers/CategoryController.php";
$categoryController = new CategoryController();
$categories = $categoryController->listCategories();
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Create New Listing</h3>
            </div>
            <div class="card-body">
                <form action="../../../controllers/ProductController.php" method="POST">
                    <input type="hidden" name="action" value="create">
                    
    <div class="mb-3">
        <label for="images" class="form-label">Product Images</label>
        <input type="file" class="form-control" id="images" name="images[]" 
               accept="image/jpeg,image/png,image/jpg" multiple required>
        <small class="text-muted">
            You can upload up to 5 images (max 5MB each). First image will be the primary image.
        </small>
    </div>

    <!-- Preview area for selected images -->
    <div id="imagePreview" class="mb-3 d-flex flex-wrap gap-2"></div>

    <!-- Add this JavaScript for image preview -->
    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.style.width = '150px';
                        div.style.height = '150px';
                        div.style.overflow = 'hidden';
                        div.style.position = 'relative';
                        div.className = 'border rounded';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';

                        div.appendChild(img);
                        preview.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
                    <div class="mb-3">
                        <label for="title" class="form-label">Product Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (in MAD)</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>

                    <div class="mb-3">
    <label for="category" class="form-label">Category</label>
    <select class="form-control" id="category" name="category_id" required>
        <option value="">Select a category</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>">
                <?php echo htmlspecialchars($category['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

                    <button type="submit" class="btn btn-primary">Create Listing</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>
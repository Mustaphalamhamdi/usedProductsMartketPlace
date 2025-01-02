<?php
require_once "../../includes/header.php";
require_once "../../includes/auth_check.php";
requireAdmin();
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Create New Category</h3>
                </div>
                <div class="card-body">
                <form method="POST" action="../../../controllers/CategoryController.php" onsubmit="console.log('Form submitted')">
    <input type="hidden" name="action" value="create">
    
    <div class="mb-3">
        <label for="name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Create Category</button>
</form>
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    console.log('Form data:', new FormData(this));
});
</script>
                    <div class="mt-3">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../../includes/footer.php"; ?>
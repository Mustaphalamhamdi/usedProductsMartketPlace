<?php
require_once "../includes/header.php";
require_once "../includes/auth_check.php";
require_once "../../controllers/UserController.php";
require_once "../../controllers/ProductController.php";
require_once "../../controllers/CategoryController.php";

// Make sure only admin can access this page
requireAdmin();

// Get summary data
$userController = new UserController();
$productController = new ProductController();
$categoryController = new CategoryController();

$stats = [
    'total_users' => $userController->getTotalUsers(),
    'total_products' => $productController->getTotalProducts(),
    'total_categories' => $categoryController->getTotalCategories(),
    'recent_products' => $productController->getRecentProducts(5) // Get 5 most recent products
];
?>

<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2><?php echo $stats['total_users']; ?></h2>
                    <a href="users/list.php" class="text-white">Manage Users →</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Products</h5>
                    <h2><?php echo $stats['total_products']; ?></h2>
                    <a href="products/list.php" class="text-white">Manage Products →</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <h2><?php echo $stats['total_categories']; ?></h2>
                    <a href="categories/list.php" class="text-white">Manage Categories →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Recent Products</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Seller</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Posted Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['recent_products'] as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['title']); ?></td>
                                <td><?php echo htmlspecialchars($product['username']); ?></td>
                                <td><?php echo number_format($product['price'], 2); ?> MAD</td>
                                <td>
                                    <span class="badge bg-<?php echo $product['status'] === 'available' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($product['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('Y-m-d', strtotime($product['creation_date'])); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="products/view.php?id=<?php echo $product['id']; ?>" 
                                           class="btn btn-info">View</a>
                                        <button type="button" 
                                                class="btn btn-danger"
                                                onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="categories/create.php" class="btn btn-primary">Add New Category</a>
                        <a href="users/list.php" class="btn btn-info">View All Users</a>
                        <a href="products/list.php" class="btn btn-success">View All Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../../controllers/ProductController.php';

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'delete_product';

        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;

        form.appendChild(actionInput);
        form.appendChild(productInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php require_once "../includes/footer.php"; ?>
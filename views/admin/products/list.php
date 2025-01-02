<?php
require_once "../../includes/header.php";
require_once "../../includes/auth_check.php";
require_once "../../../controllers/ProductController.php";

requireAdmin();

$productController = new ProductController();
$products = $productController->getAllProductsForAdmin();

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Product Management</h2>
        <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="me-2">Filter by Status:</label>
                <select id="statusFilter" class="form-select d-inline-block w-auto" onchange="filterProducts()">
                    <option value="all">All Products</option>
                    <option value="available">Available</option>
                    <option value="sold">Sold</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
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
                        <?php if ($products): ?>
                            <?php foreach ($products as $product): ?>
                                <tr class="product-row" data-status="<?php echo $product['status']; ?>">
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
                                            <a href="../../product/view.php?id=<?php echo $product['id']; ?>" 
                                               class="btn btn-info">View</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No products found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function filterProducts() {
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.product-row');
    
    rows.forEach(row => {
        if (status === 'all' || row.getAttribute('data-status') === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

<?php require_once "../../includes/footer.php"; ?>
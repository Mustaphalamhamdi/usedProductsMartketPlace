<?php
require_once "../../includes/header.php";
require_once "../../includes/auth_check.php";
require_once "../../../controllers/ProductController.php";

// Ensure user is admin
requireAdmin();

// Get all products
$productController = new ProductController();
$products = $productController->getAllProductsForAdmin();

// Display messages
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
            <!-- Status Filter -->
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
                                            <?php if ($product['status'] === 'available'): ?>
                                                <button class="btn btn-warning" 
                                                        onclick="changeStatus(<?php echo $product['id']; ?>, 'sold')">
                                                    Mark Sold
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-success" 
                                                        onclick="changeStatus(<?php echo $product['id']; ?>, 'available')">
                                                    Mark Available
                                                </button>
                                            <?php endif; ?>
                                            <button class="btn btn-danger" 
                                                    onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                                Delete
                                            </button>
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

function changeStatus(productId, newStatus) {
    if (confirm('Are you sure you want to change this product\'s status?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../../../controllers/ProductController.php';

        const inputs = {
            'action': 'admin_update_status',
            'product_id': productId,
            'status': newStatus
        };

        Object.entries(inputs).forEach(([name, value]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
}

function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../../../controllers/ProductController.php';

        const inputs = {
            'action': 'admin_delete_product',
            'product_id': productId
        };

        Object.entries(inputs).forEach(([name, value]) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php require_once "../../includes/footer.php"; ?>
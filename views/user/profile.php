<?php
require_once "../includes/header.php";
require_once "../includes/auth_check.php";
require_once "../../controllers/UserController.php";
require_once "../../controllers/ProductController.php";

// Ensure user is logged in
requireLogin();

// Initialize controllers
$userController = new UserController();
$productController = new ProductController();

// Get user profile and their listings
$profile = $userController->getUserProfile($_SESSION['user_id']);
$userListings = $productController->getUserProducts($_SESSION['user_id']);
?>

<div class="container">
    <div class="row">
        <!-- User Profile Section -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>My Profile</h4>
                </div>
                <div class="card-body">
                    <form action="../../controllers/UserController.php" method="POST">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" 
                                   value="<?php echo htmlspecialchars($profile['username']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" 
                                   value="<?php echo htmlspecialchars($profile['email']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone_number" 
                                   value="<?php echo htmlspecialchars($profile['phone_number']); ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="new_password" 
                                   placeholder="Leave blank to keep current password">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Listings Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>My Listings</h4>
                    <a href="../product/create.php" class="btn btn-primary btn-sm">Create New Listing</a>
                </div>
                <div class="card-body">
                    <?php if ($userListings && count($userListings) > 0): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Posted Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($userListings as $listing): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($listing['title']); ?></td>
                                            <td><?php echo number_format($listing['price'], 2); ?> MAD</td>
                                            <td>
                                                <span class="badge bg-<?php echo $listing['status'] === 'available' ? 'success' : 'secondary'; ?>">
                                                    <?php echo ucfirst($listing['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('Y-m-d', strtotime($listing['creation_date'])); ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="../product/view.php?id=<?php echo $listing['id']; ?>" 
                                                       class="btn btn-info">View</a>
                                                    <a href="../product/edit.php?id=<?php echo $listing['id']; ?>" 
                                                       class="btn btn-warning">Edit</a>
                                                    <?php if ($listing['status'] === 'available'): ?>
                                                        <button type="button" 
                                                                class="btn btn-success"
                                                                onclick="markAsSold(<?php echo $listing['id']; ?>)">
                                                            Mark Sold
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            You haven't created any listings yet. 
                            <a href="../product/create.php">Create your first listing</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function markAsSold(productId) {
    if (confirm('Are you sure you want to mark this item as sold?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../../controllers/ProductController.php';

        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = 'update_status';

        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = 'sold';

        form.appendChild(actionInput);
        form.appendChild(productInput);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php require_once "../includes/footer.php"; ?>
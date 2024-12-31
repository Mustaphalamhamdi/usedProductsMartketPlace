<?php
require_once "../includes/header.php";
require_once "../../controllers/ProductController.php";

// Make sure we have a product ID
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No product specified";
    header("Location: list.php");
    exit();
}

// Get the product details
$productController = new ProductController();
$product = $productController->showProduct($_GET['id']);

// Check if product exists
if (!$product) {
    $_SESSION['error'] = "Product not found";
    header("Location: list.php");
    exit();
}
?>

<div class="container">
    <!-- Back button -->
    <div class="mb-4">
        <a href="list.php" class="btn btn-secondary">← Back to Listings</a>
    </div>

    <!-- Product details card -->
    <div class="card">
        <div class="card-header">
            <h2><?php echo htmlspecialchars($product['title']); ?></h2>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Product information -->
                <div class="col-md-8">
                    <h4 class="text-primary mb-4"><?php echo number_format($product['price'], 2); ?> MAD</h4>
                    
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="lead"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                    </div>

                    <div class="mb-4">
                        <h5>Product Details</h5>
                        <ul class="list-unstyled">
                            <li><strong>Listed on:</strong> <?php echo date('F j, Y', strtotime($product['creation_date'])); ?></li>
                            <li><strong>Status:</strong> 
                                <span class="badge bg-<?php echo $product['status'] === 'available' ? 'success' : 'secondary'; ?>">
                                    <?php echo ucfirst($product['status']); ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Seller information -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Seller Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Seller:</strong> <?php echo htmlspecialchars($product['username']); ?></p>
                            
                            <?php if ($product['status'] === 'available'): ?>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($product['phone_number']); ?></p>
                                    <a href="tel:<?php echo $product['phone_number']; ?>" class="btn btn-success w-100 mb-2">
                                        Call Seller
                                    </a>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        Please <a href="../user/login.php">login</a> to see seller contact information.
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-secondary">
                                    This item is no longer available.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $product['user_id']): ?>
            <!-- Product management buttons for the seller -->
            <div class="mt-4 border-top pt-4">
                <h5>Manage Your Listing</h5>
                <form action="../../controllers/ProductController.php" method="POST" class="d-inline">
                    <input type="hidden" name="action" value="update_status">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <?php if ($product['status'] === 'available'): ?>
                        <button type="submit" name="status" value="sold" class="btn btn-warning">
                            Mark as Sold
                        </button>
                    <?php endif; ?>
                    
                    <button type="submit" name="action" value="delete" class="btn btn-danger" 
                            onclick="return confirm('Are you sure you want to delete this listing?')">
                        Delete Listing
                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>
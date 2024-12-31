<?php
require_once "views/includes/header.php";
require_once "controllers/ProductController.php";
require_once "controllers/CategoryController.php";


// Get latest products
$productController = new ProductController();
$latestProducts = $productController->getRecentProducts(6); // Get 6 latest products

// Get categories
$categoryController = new CategoryController();
$categories = $categoryController->getAllCategories();
?>

<div class="container">
    <!-- Hero Section -->
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Welcome to SouqCycle</h1>
            <p class="col-md-8 fs-4">Buy and sell used products in your local community. Find great deals or give your items a second life!</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="views/user/register.php" class="btn btn-primary btn-lg">Get Started</a>
                <a href="views/user/login.php" class="btn btn-outline-secondary btn-lg ms-2">Login</a>
            <?php else: ?>
                <a href="views/product/create.php" class="btn btn-primary btn-lg">List an Item</a>
                <a href="views/product/list.php" class="btn btn-outline-secondary btn-lg ms-2">Browse Items</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-5">
        <h2 class="mb-4">Browse Categories</h2>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($categories as $category): ?>
                <div class="col">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <p class="card-text text-muted"><?php echo $category['product_count']; ?> items</p>
                            <a href="views/product/list.php?category=<?php echo $category['id']; ?>" 
                               class="btn btn-outline-primary">View Items</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Latest Products Section -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Latest Products</h2>
            <a href="views/product/list.php" class="btn btn-outline-primary">View All</a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if ($latestProducts): ?>
                <?php foreach ($latestProducts as $product): ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                                <p class="card-text"><?php echo substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?></p>
                                <p class="card-text">
                                    <strong>Price: </strong><?php echo number_format($product['price'], 2); ?> MAD
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <a href="views/product/view.php?id=<?php echo $product['id']; ?>" 
                                   class="btn btn-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">No products available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="mb-5">
        <h2 class="text-center mb-4">How It Works</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="fs-1 text-primary mb-2">1</div>
                    <h4>Create an Account</h4>
                    <p>Sign up for free and join our community</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="fs-1 text-primary mb-2">2</div>
                    <h4>List or Browse</h4>
                    <p>Post items for sale or browse available products</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="fs-1 text-primary mb-2">3</div>
                    <h4>Connect & Trade</h4>
                    <p>Contact sellers and make deals in person</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "views/includes/footer.php"; ?>
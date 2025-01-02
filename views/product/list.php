<?php
require_once "../includes/header.php";
require_once "../../controllers/ProductController.php";
require_once "../../controllers/CategoryController.php";
require_once "../../models/ProductImage.php";

$db = (new Database())->getConnection();
$productController = new ProductController();
$categoryController = new CategoryController();
$categories = $categoryController->listCategories();
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;
$products = $selectedCategory ? 
    $productController->listProductsByCategory($selectedCategory) : 
    $productController->listProducts();
?>

<link rel="stylesheet" href="/../assets/css/productsList.css">

<div class="product-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-3">Available Products</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-white">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="col-md-6 text-md-end">
                    <a href="create.php" class="btn-create-listing">
                        <i class="bi bi-plus-circle me-2"></i>Create New Listing
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-md-3">
            <div class="filter-sidebar">
                <h5 class="mb-4">Categories</h5>
                <div class="category-filter">
                    <a href="list.php" class="<?php echo !$selectedCategory ? 'active' : ''; ?>">
                        <i class="bi bi-grid me-2"></i>All Categories
                    </a>
                    <?php foreach ($categories as $category): ?>
                        <a href="?category=<?php echo $category['id']; ?>" 
                           class="<?php echo $selectedCategory == $category['id'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <?php if ($products && count($products) > 0): ?>
                <div class="product-grid">
                    <?php foreach ($products as $product): 
                        $productImage = new ProductImage($db);
                        $images = $productImage->getProductImages($product['id']);
                        $imagePath = !empty($images) ? "/SouqCycle/uploads/products/" . $images[0]['image_path'] : "/SouqCycle/assets/images/no-image.jpg";
                    ?>
                        <div class="product-card">
                            <div class="position-relative">
                                <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                                     class="product-image"
                                     alt="<?php echo htmlspecialchars($product['title']); ?>">
                                <span class="price-badge">
                                    <?php echo number_format($product['price'], 2); ?> MAD
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-2">
                                    <?php echo htmlspecialchars($product['title']); ?>
                                </h5>
                                <p class="card-text text-muted">
                                    <?php echo substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?>
                                </p>
                                <div class="seller-info">
                                    <div class="seller-avatar">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo htmlspecialchars($product['username']); ?>
                                    </small>
                                </div>
                                <a href="view.php?id=<?php echo $product['id']; ?>" 
                                   class="view-details-btn d-block text-center mt-3">
                                    View Details
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    No products available in this category at the moment.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>
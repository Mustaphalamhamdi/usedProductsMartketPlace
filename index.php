<?php
require_once "views/includes/header.php";
require_once "controllers/ProductController.php";
require_once "controllers/CategoryController.php";
require_once "config/database.php";
require_once "models/Product.php";

$db = (new Database())->getConnection();
$productController = new ProductController();
$latestProducts = $productController->getRecentProducts(6);
?>

<!-- Custom CSS -->
<link rel="stylesheet" href="./assets/css/index.css">

<!-- Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="hero-title">Welcome to SouqCycle</h1>
                <p class="hero-subtitle">Buy and sell used products in your local area</p>
                <?php if(!isset($_SESSION['is_logged_in'])): ?>
                    <div class="d-flex gap-3">
                        <a href="views/user/register.php" class="btn btn-gradient btn-lg">Get Started</a>
                        <a href="views/user/login.php" class="btn btn-outline-light btn-lg">Sign In</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Browse Categories</h2>
        <div class="owl-carousel owl-theme">
            <?php
            $categoryController = new CategoryController();
            $categories = $categoryController->getAllCategoriesWithCount();
            
            foreach($categories as $category):
                $icon = 'bi-tag';
                switch(strtolower($category['name'])) {
                    case 'cars': $icon = 'bi-car-front'; break;
                    case 'electronics': $icon = 'bi-laptop'; break;
                    case 'houses': $icon = 'bi-house'; break;
                    case 'motos': $icon = 'bi-bicycle'; break;
                }
            ?>
                <div class="item">
                    <div class="category-card card text-center p-4">
                        <div class="category-icon">
                            <i class="bi <?php echo $icon; ?>"></i>
                        </div>
                        <h5 class="mb-3"><?php echo htmlspecialchars($category['name']); ?></h5>
                        <span class="text-muted mb-3"><?php echo $category['product_count']; ?> items</span>
                        <a href="views/product/list.php?category=<?php echo $category['id']; ?>" 
                           class="btn btn-gradient">View Items</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Latest Products -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">Latest Products</h2>
            <a href="views/product/list.php" class="btn btn-gradient">View All</a>
        </div>
        <div class="row g-4">
            <?php foreach ($latestProducts as $product): 
                $productImage = new ProductImage($db);
                $images = $productImage->getProductImages($product['id']);
                $imagePath = !empty($images) ? "/SouqCycle/uploads/products/" . $images[0]['image_path'] : "/SouqCycle/assets/images/no-image.jpg";
            ?>
                <div class="col-md-4">
                    <div class="product-card card h-100">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                             class="product-image"
                             alt="<?php echo htmlspecialchars($product['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                            <p class="card-text text-muted">
                                <?php echo substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?>
                            </p>
                            <p class="card-text">
                                <strong class="text-primary"><?php echo number_format($product['price'], 2); ?> MAD</strong>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="views/product/view.php?id=<?php echo $product['id']; ?>" 
                               class="btn btn-gradient w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works">
    <div class="container">
        <h2 class="section-title text-center">How It Works</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card text-center">
                    <i class="bi bi-person-plus-fill step-icon"></i>
                    <h3>Step 1</h3>
                    <h4 class="mb-3">Create an Account</h4>
                    <p class="text-muted">Sign up for free and join our community</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card text-center">
                    <i class="bi bi-list-ul step-icon"></i>
                    <h3>Step 2</h3>
                    <h4 class="mb-3">List or Browse</h4>
                    <p class="text-muted">Post items for sale or browse available products</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card text-center">
                    <i class="bi bi-chat-dots step-icon"></i>
                    <h3>Step 3</h3>
                    <h4 class="mb-3">Connect & Trade</h4>
                    <p class="text-muted">Contact sellers and make deals in person</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 4 }
        }
    });
});
</script>

<?php require_once "views/includes/footer.php"; ?>
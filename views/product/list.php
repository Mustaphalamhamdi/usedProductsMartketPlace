<?php
require_once "../includes/header.php";
require_once "../../controllers/ProductController.php";
require_once "../../controllers/CategoryController.php";

// Initialize variables
$searchTerm = $_GET['search'] ?? '';
$sortBy = $_GET['sort'] ?? 'newest';
$selectedCategory = isset($_GET['category']) ? (int)$_GET['category'] : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// Initialize the controller and get all products
$productController = new ProductController();
$categoryController = new CategoryController();
// Get data
$categories = $categoryController->getAllCategories();
$result = $productController->getPagedProducts($page, $searchTerm, $sortBy, $selectedCategory);

$products = $result['products'];
$products = $productController->listProducts();
$categories = $categoryController->listCategories();
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, $currentPage); // Ensure page is at least 1

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;
$result = $productController->getPagedProducts(
    $currentPage,
    $searchTerm,
    $sortBy,
    $selectedCategory
);

$products = $result['products'];
$totalPages = $result['total_pages'];

$products = $selectedCategory ? 
    $productController->listProductsByCategory($selectedCategory) :
    $productController->listProducts();

// Display any messages
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
?>

<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Available Products</h1>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="col-md-4 text-end">
                <a href="create.php" class="btn btn-primary">Create New Listing</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Category Filter Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filter by Category</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="list.php" class="btn <?php echo !$selectedCategory ? 'btn-primary' : 'btn-outline-primary'; ?>">
                            All Categories
                        </a>
                        <?php foreach ($categories as $category): ?>
                            <a href="?category=<?php echo $category['id']; ?>" 
                               class="btn <?php echo $selectedCategory == $category['id'] ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
    <div class="col">
        <p class="text-muted">
            Showing <?php echo count($products); ?> of <?php echo $result['total_items']; ?> products
            <?php if ($searchTerm || $selectedCategory): ?>
                matching your criteria
            <?php endif; ?>
        </p>
    </div>
</div>
    <!-- Products Grid -->
    <div class="row">
        <?php if ($products && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['title']); ?></h5>
                            <p class="card-text">
                                <?php echo substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?>
                            </p>
                            <p class="card-text">
                                <strong>Price: </strong><?php echo number_format($product['price'], 2); ?> MAD
                            </p>
                            <p class="card-text">
                                <small class="text-muted">Posted by: <?php echo htmlspecialchars($product['username']); ?></small>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="view.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    No products available in this category at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($totalPages > 1): ?>
    <div class="row">
        <div class="col-12">
            <nav aria-label="Product pagination">
                <ul class="pagination justify-content-center">
                    <!-- Previous page link -->
                    <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $currentPage - 1])); ?>">
                            Previous
                        </a>
                    </li>
                    
                    <!-- Page numbers -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <!-- Next page link -->
                    <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $currentPage + 1])); ?>">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php endif; ?>
</div>

<?php require_once "../includes/footer.php"; ?>
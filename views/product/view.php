<?php
require_once "../includes/header.php";
require_once "../../controllers/ProductController.php";
require_once "../../models/ProductImage.php";

// Initialize database connection
$db = (new Database())->getConnection();

// Check for product ID
if (!isset($_GET['id'])) {
   $_SESSION['error'] = "No product specified";
   header("Location: list.php");
   exit();
}

// Get product details
$productController = new ProductController();
$product = $productController->showProduct($_GET['id']);

// Check if product exists
if (!$product) {
   $_SESSION['error'] = "Product not found";
   header("Location: list.php");
   exit();
}

// Get product images
$productImage = new ProductImage($db);
$images = $productImage->getProductImages($product['id']);
$imagePath = !empty($images) ? "/SouqCycle/uploads/products/" . $images[0]['image_path'] : "/SouqCycle/assets/images/no-image.jpg";
?>

<div class="container py-4">
   <!-- Back button -->
   <div class="mb-4">
       <a href="list.php" class="btn btn-outline-primary">
           <i class="bi bi-arrow-left"></i> Back to Listings
       </a>
   </div>

   <div class="row">
       <!-- Product Images Section -->
       <div class="col-md-6 mb-4">
           <div class="card shadow-sm">
               <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                    class="card-img-top" 
                    id="mainImage"
                    style="height: 400px; object-fit: contain;"
                    alt="<?php echo htmlspecialchars($product['title']); ?>">
               
               <?php if (count($images) > 1): ?>
               <div class="card-body">
                   <div class="row g-2">
                       <?php foreach($images as $img): ?>
                       <div class="col-3">
                           <img src="/SouqCycle/uploads/products/<?php echo htmlspecialchars($img['image_path']); ?>"
                                class="img-thumbnail"
                                style="height: 80px; object-fit: cover; cursor: pointer;"
                                onclick="updateMainImage(this.src)"
                                alt="Product thumbnail">
                       </div>
                       <?php endforeach; ?>
                   </div>
               </div>
               <?php endif; ?>
           </div>
       </div>

       <!-- Product Details Section -->
       <div class="col-md-6">
           <div class="card shadow-sm h-100">
               <div class="card-body">
                   <h1 class="card-title h2 mb-4"><?php echo htmlspecialchars($product['title']); ?></h1>
                   
                   <div class="mb-4">
                       <h3 class="text-primary"><?php echo number_format($product['price'], 2); ?> MAD</h3>
                       <p class="text-muted mb-2">
                           <i class="bi bi-person-circle me-2"></i>Listed by: <?php echo htmlspecialchars($product['username']); ?>
                       </p>
                       <p class="text-muted">
                           <i class="bi bi-calendar me-2"></i>Posted on: <?php echo date('F j, Y', strtotime($product['creation_date'])); ?>
                       </p>
                       <span class="badge bg-<?php echo $product['status'] === 'available' ? 'success' : 'secondary'; ?>">
                           <?php echo ucfirst($product['status']); ?>
                       </span>
                   </div>

                   <div class="mb-4">
                       <h5 class="mb-3">Description</h5>
                       <p class="text-muted"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                   </div>

                   <?php if ($product['status'] === 'available'): ?>
                       <?php if (isset($_SESSION['user_id'])): ?>
                           <div class="card bg-light mb-4">
                               <div class="card-body">
                                   <h5>Contact Information</h5>
                                   <p class="mb-2"><i class="bi bi-telephone me-2"></i><?php echo htmlspecialchars($product['phone_number']); ?></p>
                                   <a href="tel:<?php echo $product['phone_number']; ?>" class="btn btn-success w-100">
                                       <i class="bi bi-telephone-fill me-2"></i>Call Seller
                                   </a>
                               </div>
                           </div>
                       <?php else: ?>
                           <div class="alert alert-info">
                               <i class="bi bi-info-circle me-2"></i>Please <a href="../user/login.php">login</a> to see seller contact information.
                           </div>
                       <?php endif; ?>
                   <?php else: ?>
                       <div class="alert alert-secondary">
                           <i class="bi bi-exclamation-circle me-2"></i>This item is no longer available.
                       </div>
                   <?php endif; ?>

                   <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $product['user_id']): ?>
    <div class="mt-4 pt-4 border-top">
        <h5>Manage Your Listing</h5>
        <div class="d-grid gap-2">
            <?php if ($product['status'] === 'available'): ?>
                <form action="../../controllers/ProductController.php" method="POST">
                    <input type="hidden" name="action" value="mark_sold">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="bi bi-check-circle me-2"></i>Mark as Sold
                    </button>
                </form>
            <?php endif; ?>
            
            <form action="../../controllers/ProductController.php" method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this listing?')">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-trash me-2"></i>Delete Listing
                </button>
            </form>
        </div>
    </div>
<?php endif; ?>
               </div>
           </div>
       </div>
   </div>
</div>

<script>
function updateMainImage(src) {
   document.getElementById('mainImage').src = src;
}
</script>

<?php require_once "../includes/footer.php"; ?>
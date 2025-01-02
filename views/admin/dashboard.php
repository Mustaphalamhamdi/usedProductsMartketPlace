<?php
require_once "../includes/header.php";
require_once "../includes/auth_check.php";
require_once "../../controllers/UserController.php";
require_once "../../controllers/ProductController.php";

// Ensure user is admin
requireAdmin();

$userController = new UserController();
$productController = new ProductController();

// Get statistics
$totalUsers = $userController->getTotalUsers();
$totalProducts = $productController->getTotalProducts();
?>

<link rel="stylesheet" href="   /assets/css/adminDashboard.css">

<div class="admin-dashboard">
    <div class="row g-0">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="sidebar">
                <div class="sidebar-header">
                    <h4>Admin Dashboard</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="users/list.php">
                        <i class="bi bi-people"></i> Users
                    </a>
                    <a class="nav-link" href="products/list.php">
                        <i class="bi bi-grid"></i> Products
                    </a>
                    <a class="nav-link" href="categories/list.php">
                        <i class="bi bi-tags"></i> Categories
                    </a>
                    <a class="nav-link" href="../../views/product/list.php">
                        <i class="bi bi-shop"></i> View Site
                    </a>
                    <a class="nav-link text-danger" href="../../controllers/UserController.php?action=logout">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="content">
                <!-- Welcome Message -->
                <div class="dashboard-card">
                    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
                    <p class="text-muted">Here's what's happening with your marketplace today.</p>
                </div>

                <!-- Statistics -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-people stat-icon"></i>
                            <div class="stat-number"><?php echo $totalUsers; ?></div>
                            <div class="stat-label">Total Users</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <i class="bi bi-grid stat-icon"></i>
                            <div class="stat-number"><?php echo $totalProducts; ?></div>
                            <div class="stat-label">Total Products</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="recent-activity">
                    <h4 class="mb-4">Recent Activity</h4>
                    <div class="dashboard-card">
                        <!-- Recent Users -->
                        <h5>Latest Users</h5>
                        <?php 
                        $recentUsers = $userController->getAllUsers();
                        foreach(array_slice($recentUsers, 0, 5) as $user): 
                        ?>
                            <div class="activity-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-person-circle me-2"></i>
                                        <?php echo htmlspecialchars($user['username']); ?>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo date('M d, Y', strtotime($user['registration_date'])); ?>
                                    </small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <h5>Quick Actions</h5>
                            <div class="d-grid gap-2">
                                <a href="users/list.php" class="btn btn-primary">
                                    <i class="bi bi-people me-2"></i>Manage Users
                                </a>
                                <a href="products/list.php" class="btn btn-primary">
                                    <i class="bi bi-grid me-2"></i>Manage Products
                                </a>
                                <a href="categories/list.php" class="btn btn-primary">
                                    <i class="bi bi-tags me-2"></i>Manage Categories
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <h5>System Status</h5>
                            <div class="mb-3">
                                <label class="text-muted">Server Status</label>
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle me-2" style="width: 10px; height: 10px;"></div>
                                    Operational
                                </div>
                            </div>
                            <div>
                                <label class="text-muted">Last Backup</label>
                                <div><?php echo date('M d, Y H:i'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SouqCycle - Buy and Sell Used Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/SouqCycle">SouqCycle</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/SouqCycle">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/product/list.php">Products</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/views/product/create.php">Sell Item</a>
                        </li>
                        <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/views/admin/dashboard.php">Admin Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/views/user/profile.php">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/controllers/UserController.php?action=logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/views/user/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/views/user/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
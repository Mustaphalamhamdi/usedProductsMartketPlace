<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>SouqCycle - Buy and Sell Used Products</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
   <style>
       .navbar {
           background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
           padding: 1rem 0;
           box-shadow: 0 2px 15px rgba(0,0,0,0.1);
       }
       
       .navbar-brand {
           font-size: 1.8rem;
           font-weight: 700;
           color: #fff !important;
           transition: all 0.3s ease;
       }
       
       .navbar-brand:hover {
           transform: scale(1.05);
       }
       
       .nav-link {
           color: rgba(255,255,255,0.9) !important;
           font-weight: 500;
           padding: 0.5rem 1rem;
           border-radius: 5px;
           transition: all 0.3s ease;
       }
       
       .nav-link:hover {
           background: rgba(255,255,255,0.1);
           transform: translateY(-2px);
       }
       
       .btn-sell {
           background: #00d2ff;
           color: #fff !important;
           padding: 0.5rem 1.2rem;
           border-radius: 25px;
           font-weight: 600;
           transition: all 0.3s ease;
       }
       
       .btn-sell:hover {
           background: #00b4db;
           transform: translateY(-2px);
       }
       
       .navbar-toggler {
           border: none;
           padding: 0.5rem;
       }
       
       .navbar-toggler:focus {
           box-shadow: none;
       }
       
       .user-profile {
           display: flex;
           align-items: center;
           gap: 0.5rem;
       }
       
       .user-avatar {
           width: 35px;
           height: 35px;
           border-radius: 50%;
           background: rgba(255,255,255,0.2);
           display: flex;
           align-items: center;
           justify-content: center;
       }
   </style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
        <a class="navbar-brand" href="/views">
            <i class="bi bi-bicycle me-2"></i>SouqCycle
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">
                        <i class="bi bi-house-door me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="views/product/list.php">
                        <i class="bi bi-grid me-1"></i>Products
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION['is_logged_in'])): ?>
                    <li class="nav-item">
                        <a class="nav-link btn-sell" href="views/product/create.php">
                            <i class="bi bi-plus-circle me-1"></i>Sell Item
                        </a>
                    </li>
                    <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="views/admin/dashboard.php">
                                <i class="bi bi-speedometer me-1"></i>Admin
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="user-profile">
                                <div class="user-avatar">
                                    <i class="bi bi-person"></i>
                                </div>
                                <?php echo htmlspecialchars($_SESSION['username']); ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="views/user/profile.php">
                                <i class="bi bi-person-circle me-2"></i>My Profile</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="controllers/UserController.php?action=logout">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="views/user/login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="views/user/register.php">
                            <i class="bi bi-person-plus me-1"></i>Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
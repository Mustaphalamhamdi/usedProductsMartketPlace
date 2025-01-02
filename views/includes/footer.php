<link rel="stylesheet" href="/../assets/css/footer.css">

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="footer-heading">About SouqCycle</h5>
                <p class="text-white-50 mb-4">
                    Your trusted marketplace for buying and selling used products. Join our community and start trading today.
                </p>
                <div class="footer-social">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h5 class="footer-heading">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="/index.php"><i class="bi bi-chevron-right"></i>Home</a></li>
                    <li><a href="/views/product/list.php"><i class="bi bi-chevron-right"></i>Products</a></li>
                    <li><a href="/views/product/list.php"><i class="bi bi-chevron-right"></i>Categories</a></li>
                    <?php if(!isset($_SESSION['is_logged_in'])): ?>
                        <li><a href="/SouqCycle/views/user/login.php"><i class="bi bi-chevron-right"></i>Login</a></li>
                        <li><a href="/SouqCycle/views/user/register.php"><i class="bi bi-chevron-right"></i>Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                <h5 class="footer-heading">Categories</h5>
                <ul class="footer-links">
                    <li><a href="/views/product/list.php"><i class="bi bi-chevron-right"></i>Cars</a></li>
                    <li><a href="/views/product/list.php"><i class="bi bi-chevron-right"></i>Electronics</a></li>
                    <li><a href="/views/product/list.php"><i class="bi bi-chevron-right"></i>Houses</a></li>
                    <li><a href="/views/product/list.php"><i class="bi bi-chevron-right"></i>Motos</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-4">
                <h5 class="footer-heading">Contact Us</h5>
                <ul class="footer-links">
                    <li>
                        <i class="bi bi-geo-alt me-2"></i>
                        Ismagi, Rabat, Morocco
                    </li>
                    <li>
                        <i class="bi bi-envelope me-2"></i>
                        <a href="mailto:info@souqcycle.com">info@souqcycle.ma</a>
                    </li>
                    <li>
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:+1234567890">+212 669 745 922</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> SouqCycle. All rights reserved. 
               Designed by <a href="https://github.com/Mustaphalamhamdi" class="text-white">Mustapha Lamhamdi Alaoui</a></p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>About Themeur</h4>
                    <p>Your premier destination for high-quality WordPress themes, plugins, and HTML templates. Join
                        thousands of satisfied customers building amazing websites.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="#">WordPress Themes</a></li>
                        <li><a href="#">HTML Templates</a></li>
                        <li><a href="#">WordPress Plugins</a></li>
                        <li><a href="#">E-commerce</a></li>
                        <li><a href="#">Blog Templates</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Refund Policy</a></li>
                        <li><a href="#">Licensing</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Newsletter</h4>
                    <p>Subscribe to get updates on new products and special offers</p>
                    <form action="#" method="POST" class="newsletter-form">
                        @csrf
                        <div class="input-group">
                            <input type="email" name="email" placeholder="Your email address" required>
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                    <div class="payment-methods">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-paypal"></i>
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p>&copy; {{ date('Y') }} Themeur. All rights reserved. Lifetime downloads for all purchases.</p>
                <div class="footer-links">
                    <a href="#">Sitemap</a>
                    <a href="#">Contact</a>
                    <a href="#">Support</a>
                </div>
            </div>
        </div>
    </div>
</footer>

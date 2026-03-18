@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Digital Marketplace for <span class="highlight">WordPress Themes</span> & Templates</h1>
                <p>Discover thousands of premium WordPress themes, plugins, and HTML templates. Lifetime downloads with
                    every purchase.</p>

                <div class="hero-cta">
                    <a href="#" class="btn btn-primary">Browse Products</a>
                    <a href="#" class="btn btn-outline">How It Works</a>
                </div>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">10,000+</span>
                        <span class="stat-label">Products</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">50,000+</span>
                        <span class="stat-label">Happy Customers</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">Lifetime</span>
                        <span class="stat-label">Downloads</span>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <img src="{{ asset('images/hero-illustration.svg') }}" alt="Digital Marketplace">
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header">
                <h2>Browse by <span class="highlight">Categories</span></h2>
                <p>Find exactly what you need from our extensive collection</p>
            </div>

            <div class="categories-grid">
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fab fa-wordpress"></i>
                    </div>
                    <h3>WordPress Themes</h3>
                    <p>Professional themes for every niche</p>
                    <span class="category-count">2,500+ products</span>
                </a>

                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fab fa-html5"></i>
                    </div>
                    <h3>HTML Templates</h3>
                    <p>Responsive and modern templates</p>
                    <span class="category-count">1,800+ products</span>
                </a>

                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h3>WordPress Plugins</h3>
                    <p>Extend functionality with plugins</p>
                    <span class="category-count">950+ products</span>
                </a>

                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>E-commerce</h3>
                    <p>Build your online store</p>
                    <span class="category-count">1,200+ products</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-section">
        <div class="container">
            <div class="section-header">
                <h2>Featured <span class="highlight">Products</span></h2>
                <p>Hand-picked premium products for you</p>
            </div>

            <div class="products-grid">
                @foreach ($featuredProducts ?? [] as $product)
                    <div class="product-card">
                        <div class="product-badge">Featured</div>
                        <div class="product-image">
                            <img src="{{ $product->image ?? asset('images/product-placeholder.jpg') }}"
                                alt="{{ $product->name ?? 'Product' }}">
                            <div class="product-actions">
                                <button class="action-btn wishlist-btn" data-id="{{ $product->id ?? '' }}">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="action-btn quick-view-btn" data-id="{{ $product->id ?? '' }}">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3><a href="#">{{ $product->name ?? 'Product Name' }}</a>
                            </h3>
                            <div class="product-meta">
                                <span class="product-category">{{ $product->category ?? 'Category' }}</span>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <span>4.8 (120)</span>
                                </div>
                            </div>
                            <div class="product-footer">
                                <span class="product-price">${{ $product->price ?? '49.00' }}</span>
                                <button class="btn-add-to-cart" data-id="{{ $product->id ?? '' }}">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Example static products for demo -->
                <div class="product-card">
                    <div class="product-badge">Popular</div>
                    <div class="product-image">
                        <img src="https://via.placeholder.com/300x200" alt="Product">
                        <div class="product-actions">
                            <button class="action-btn"><i class="far fa-heart"></i></button>
                            <button class="action-btn"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3><a href="#">Modern Business Pro</a></h3>
                        <div class="product-meta">
                            <span>WordPress</span>
                            <div class="product-rating">
                                <i class="fas fa-star"></i> 4.9 (234)
                            </div>
                        </div>
                        <div class="product-footer">
                            <span class="product-price">$59.00</span>
                            <button class="btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Add</button>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <img src="https://via.placeholder.com/300x200" alt="Product">
                        <div class="product-actions">
                            <button class="action-btn"><i class="far fa-heart"></i></button>
                            <button class="action-btn"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3><a href="#">E-Commerce Store</a></h3>
                        <div class="product-meta">
                            <span>HTML</span>
                            <div class="product-rating">
                                <i class="fas fa-star"></i> 4.7 (156)
                            </div>
                        </div>
                        <div class="product-footer">
                            <span class="product-price">$49.00</span>
                            <button class="btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Add</button>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-badge">New</div>
                    <div class="product-image">
                        <img src="https://via.placeholder.com/300x200" alt="Product">
                        <div class="product-actions">
                            <button class="action-btn"><i class="far fa-heart"></i></button>
                            <button class="action-btn"><i class="far fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3><a href="#">SEO Optimizer Pro</a></h3>
                        <div class="product-meta">
                            <span>Plugin</span>
                            <div class="product-rating">
                                <i class="fas fa-star"></i> 5.0 (89)
                            </div>
                        </div>
                        <div class="product-footer">
                            <span class="product-price">$39.00</span>
                            <button class="btn-add-to-cart"><i class="fas fa-shopping-cart"></i> Add</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-footer">
                <a href="#" class="btn btn-secondary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose <span class="highlight">Themeur</span></h2>
                <p>Experience the best digital marketplace platform</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h3>Lifetime Downloads</h3>
                    <p>Download your purchased items anytime, forever. No subscriptions or recurring fees.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure Payments</h3>
                    <p>Secure transactions powered by Razorpay with encryption and fraud protection.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Free Updates</h3>
                    <p>Get free updates for all purchased items to keep your website current.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Round-the-clock customer support to help you with any issues.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>Quality Code</h3>
                    <p>All products are reviewed for code quality and best practices.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Money Back Guarantee</h3>
                    <p>30-day money-back guarantee on all purchases.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2>What Our <span class="highlight">Customers</span> Say</h2>
                <p>Join thousands of satisfied customers</p>
            </div>

            <div class="testimonials-slider">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>Themeur has the best collection of WordPress themes. The quality is exceptional and the support
                            team is always helpful.</p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/60x60" alt="John Doe">
                        <div class="author-info">
                            <h4>John Doe</h4>
                            <p>Web Developer</p>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <i class="fas fa-quote-left"></i>
                        <p>I've purchased multiple templates from Themeur. The lifetime downloads feature is a game-changer!
                        </p>
                    </div>
                    <div class="testimonial-author">
                        <img src="https://via.placeholder.com/60x60" alt="Jane Smith">
                        <div class="author-info">
                            <h4>Jane Smith</h4>
                            <p>Designer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2>Stay Updated with Latest Products</h2>
                <p>Subscribe to our newsletter and get 10% off your first purchase</p>

                <form action="#" method="POST" class="newsletter-form">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Enter your email address" required>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Page specific styles if needed */
    </style>
@endpush

@push('scripts')
    <script>
        // Page specific scripts
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize any page-specific JavaScript here
        });
    </script>
@endpush

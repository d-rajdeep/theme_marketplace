@extends('layouts.app')

@section('title', 'Digital Marketplace - Themeour')

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Digital Marketplace for <span class="highlight">WordPress Themes</span> & Templates</h1>
                <p>Discover thousands of premium WordPress themes, plugins, and HTML templates. Lifetime downloads with
                    every purchase.</p>

                <div class="hero-cta">
                    <a href="{{ route('products.all') }}" class="btn btn-primary">Browse Products</a>
                    <a href="#categories" class="btn btn-outline">Explore Categories</a>
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
                <img src="{{ asset('images/hero-illustration.svg') }}" alt="Digital Marketplace"
                    onerror="this.src='https://via.placeholder.com/600x400?text=Hero+Image'">
            </div>
        </div>
    </section>

    <section id="categories" class="categories-section">
        <div class="container">
            <div class="section-header">
                <h2>Browse by <span class="highlight">Categories</span></h2>
                <p>Find exactly what you need from our extensive collection</p>
            </div>

            <div class="categories-grid">
                <a href="{{ route('products.all', ['type' => 'theme']) }}" class="category-card">
                    <div class="category-icon">
                        <i class="fab fa-wordpress"></i>
                    </div>
                    <h3>WordPress Themes</h3>
                    <p>Professional themes for every niche</p>
                    <span class="category-count">Explore &rarr;</span>
                </a>

                <a href="{{ route('products.all', ['type' => 'template']) }}" class="category-card">
                    <div class="category-icon">
                        <i class="fab fa-html5"></i>
                    </div>
                    <h3>HTML Templates</h3>
                    <p>Responsive and modern templates</p>
                    <span class="category-count">Explore &rarr;</span>
                </a>

                <a href="{{ route('products.all', ['type' => 'plugin']) }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-plug"></i>
                    </div>
                    <h3>WordPress Plugins</h3>
                    <p>Extend functionality with plugins</p>
                    <span class="category-count">Explore &rarr;</span>
                </a>

                <a href="{{ route('products.all') }}" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3>E-commerce</h3>
                    <p>Build your online store</p>
                    <span class="category-count">Explore &rarr;</span>
                </a>
            </div>
        </div>
    </section>

    <section class="featured-section">
        <div class="container">
            <div class="section-header">
                <h2>Featured <span class="highlight">Products</span></h2>
                <p>Hand-picked premium products for you</p>
            </div>

            <div class="products-grid">
                @forelse ($featuredProducts as $product)
                    <div class="product-card">
                        <div class="product-badge">{{ ucfirst($product->type) }}</div>

                        <div class="product-image">
                            <a
                                href="{{ route('product.show', ['category_slug' => $product->category->slug ?? 'uncategorized', 'product_slug' => $product->slug ?? $product->id]) }}">
                                <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                    alt="{{ $product->name }}">
                            </a>

                            <div class="product-actions">
                                <button class="action-btn wishlist-btn" data-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="action-btn quick-view-btn"
                                    data-image="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/800x600?text=No+Image' }}"
                                    data-title="{{ $product->name }}">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="product-info">
                            <h3>
                                <a
                                    href="{{ route('product.show', ['category_slug' => $product->category->slug ?? 'uncategorized', 'product_slug' => $product->slug ?? $product->id]) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="product-meta">
                                <span class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <span>{{ number_format($product->reviews()->avg('rating') ?? 0, 1) }}</span>
                                </div>
                            </div>

                            <div class="product-footer">
                                <span class="product-price">
                                    {{ $product->price > 0 ? '₹' . number_format($product->price, 2) : 'Free' }}
                                </span>

                                <button class="btn-add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-500" style="grid-column: 1 / -1;">
                        <p>No featured products available at the moment. Check back soon!</p>
                    </div>
                @endforelse
            </div>

            <div id="quickViewModal" class="quick-view-modal">
                <div class="quick-view-content">
                    <span class="close-quick-view"><i class="fas fa-times"></i></span>
                    <img id="quickViewImage" src="" alt="Product Preview">
                    <h3 id="quickViewTitle"></h3>
                </div>
            </div>

            <div class="section-footer" style="margin-top: 40px;">
                <a href="{{ route('products.all') }}" class="btn btn-secondary">View All Products</a>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose <span class="highlight">Themeur</span></h2>
                <p>Experience the best digital marketplace platform</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-download"></i></div>
                    <h3>Lifetime Downloads</h3>
                    <p>Download your purchased items anytime, forever. No subscriptions or recurring fees.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Secure Payments</h3>
                    <p>Secure transactions powered by Razorpay with encryption and fraud protection.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-sync-alt"></i></div>
                    <h3>Free Updates</h3>
                    <p>Get free updates for all purchased items to keep your website current.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-headset"></i></div>
                    <h3>24/7 Support</h3>
                    <p>Round-the-clock customer support to help you with any issues.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-code"></i></div>
                    <h3>Quality Code</h3>
                    <p>All products are reviewed for code quality and best practices.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <h3>Money Back Guarantee</h3>
                    <p>30-day money-back guarantee on all purchases.</p>
                </div>
            </div>
        </div>
    </section>

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
                        <div
                            style="width: 50px; height: 50px; background: #6366f1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">
                            J</div>
                        <div class="author-info" style="margin-left: 15px;">
                            <h4 style="margin:0;">John Doe</h4>
                            <p style="margin:0;">Web Developer</p>
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
                        <div
                            style="width: 50px; height: 50px; background: #10b981; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">
                            S</div>
                        <div class="author-info" style="margin-left: 15px;">
                            <h4 style="margin:0;">Sarah Smith</h4>
                            <p style="margin:0;">Designer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Quick View Modal Styles (Unchanged) */
        .quick-view-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.85);
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .quick-view-content {
            position: relative;
            background: #ffffff;
            padding: 20px;
            border-radius: 16px;
            max-width: 900px;
            width: 90%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            text-align: center;
            animation: modalFadeIn 0.3s ease-out forwards;
        }

        .quick-view-content img {
            max-width: 100%;
            max-height: 70vh;
            border-radius: 8px;
            object-fit: contain;
        }

        .quick-view-content h3 {
            margin-top: 20px;
            font-size: 20px;
            color: #1e293b;
            font-weight: 700;
        }

        .close-quick-view {
            position: absolute;
            top: -15px;
            right: -15px;
            background: #ef4444;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, background 0.2s;
        }

        .close-quick-view:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Quick View Modal Logic
            const modal = document.getElementById('quickViewModal');
            const modalImg = document.getElementById('quickViewImage');
            const modalTitle = document.getElementById('quickViewTitle');
            const closeBtn = document.querySelector('.close-quick-view');
            const quickViewBtns = document.querySelectorAll('.quick-view-btn');

            quickViewBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    modalImg.src = this.getAttribute('data-image');
                    modalTitle.textContent = this.getAttribute('data-title');
                    modal.style.display = 'flex';
                });
            });

            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // 2. NEW: AJAX Add to Cart Logic for Homepage
            const addToCartBtns = document.querySelectorAll('.btn-add-to-cart');

            addToCartBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.id;
                    const originalText = this.innerHTML;

                    // Show loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                    this.disabled = true;

                    // Send AJAX request to Laravel Cart Route
                    fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: 1 // Default to 1 item from homepage
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.innerHTML = '<i class="fas fa-check"></i> Added!';
                                // Optional: Update cart counter in navbar dynamically here
                                const cartCounter = document.getElementById('nav-cart-count');
                                if (cartCounter) cartCounter.innerText = data.cartCount;

                                setTimeout(() => {
                                    this.innerHTML = originalText;
                                    this.disabled = false;
                                }, 2000);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.innerHTML = originalText;
                            this.disabled = false;
                            alert('Something went wrong. Please try again.');
                        });
                });
            });
        });
    </script>
@endpush

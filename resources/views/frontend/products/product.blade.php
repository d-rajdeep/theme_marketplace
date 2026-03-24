@extends('layouts.app')

@section('title', $product->name . ' - Themeour')
@section('content')

    <section class="product-detail-section">
        <div class="container">

            {{-- Display Success Message for Reviews/Cart --}}
            @if (session('success'))
                <div
                    style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="product-detail-layout">
                <div class="product-gallery">
                    <div class="main-image">
                        @if ($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                                id="mainProductImage">
                        @else
                            <img src="{{ asset('images/product-placeholder.jpg') }}" alt="{{ $product->name }}"
                                id="mainProductImage">
                        @endif
                    </div>

                    @if ($product->images && $product->images->count() > 0)
                        <div class="thumbnail-gallery">
                            <div class="thumbnail-item active" data-image="{{ asset('storage/' . $product->thumbnail) }}">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail">
                                @endif
                            </div>
                            @foreach ($product->images as $image)
                                <div class="thumbnail-item" data-image="{{ asset('storage/' . $image->image_path) }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="product-info-detail">
                    <div class="product-breadcrumb">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="fas fa-chevron-right"></i>
                        @if ($product->category)
                            <a href="{{ route('products.all', ['category' => $product->category->slug]) }}">
                                {{ $product->category->name }}
                            </a>
                            <i class="fas fa-chevron-right"></i>
                        @endif
                        <span>{{ $product->name }}</span>
                    </div>

                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="product-rating-detail">
                        <div class="rating-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span
                                class="rating-value">{{ number_format($product->reviews()->avg('rating') ?? 0, 1) }}</span>
                        </div>
                        <span class="reviews-count">({{ $product->reviews()->count() ?? 0 }} customer reviews)</span>
                    </div>

                    <div class="product-price-detail">
                        <span class="current-price">₹{{ number_format($product->price, 2) }}</span>
                    </div>

                    {{-- <div class="product-short-description">
                        <p>{{ Str::limit($product->description, 200) }}</p>
                    </div> --}}

                    <div class="product-meta-detail">
                        <div class="meta-item">
                            <i class="fas fa-tag"></i>
                            <strong>Category:</strong>
                            @if ($product->category)
                                <a href="{{ route('products.all', ['category' => $product->category->slug]) }}">
                                    {{ $product->category->name }}
                                </a>
                            @endif
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-code"></i>
                            <strong>Type:</strong>
                            <span class="product-type-badge type-{{ $product->type }}">
                                {{ ucfirst($product->type) }}
                            </span>
                        </div>
                    </div>

                    <div class="product-actions-detail">
                        <div class="quantity-selector">
                            <button class="qty-btn" id="decreaseQty">-</button>
                            <input type="number" id="productQuantity" value="1" min="1" max="10">
                            <button class="qty-btn" id="increaseQty">+</button>
                        </div>

                        <button class="btn-add-to-cart-large" data-id="{{ $product->id }}">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>

                        <button class="btn-wishlist" data-id="{{ $product->id }}">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>

                    <div class="product-features">
                        <div class="feature-item">
                            <i class="fas fa-download"></i>
                            <div>
                                <strong>Lifetime Downloads</strong>
                                <small>Download anytime</small>
                            </div>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>Secure Payments</strong>
                                <small>Powered by Razorpay</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-tabs">
                <ul class="tabs-nav">
                    <li class="tab-link active" data-tab="description">Description</li>
                    <li class="tab-link" data-tab="features">Features</li>
                    <li class="tab-link" data-tab="reviews">Reviews ({{ $product->reviews()->count() ?? 0 }})</li>
                </ul>

                <div class="tabs-content">
                    <div class="tab-pane active" id="description">
                        <div class="product-description">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <div class="tab-pane" id="features">
                        <div class="product-features-list">
                            <ul>
                                <li><i class="fas fa-check-circle"></i> High-quality code and design</li>
                                <li><i class="fas fa-check-circle"></i> Fully responsive layout</li>
                                <li><i class="fas fa-check-circle"></i> SEO optimized</li>
                                <li><i class="fas fa-check-circle"></i> Browser compatibility</li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane" id="reviews">
                        <div class="reviews-section">
                            <div class="reviews-list">
                                @forelse ($product->reviews ?? [] as $review)
                                    <div class="review-item">
                                        <div class="review-avatar">
                                            <div
                                                style="width: 50px; height: 50px; background: #6366f1; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold;">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="review-content">
                                            <div class="review-header">
                                                <strong>{{ $review->user->name }}</strong>
                                                <div class="review-rating" style="color: #fbbf24;">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star"
                                                            style="color: {{ $i <= $review->rating ? '#fbbf24' : '#e5e7eb' }};"></i>
                                                    @endfor
                                                </div>
                                                <span class="review-date"
                                                    style="color: #9ca3af; font-size: 12px; margin-left: 10px;">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p style="margin-top: 5px; color: #4b5563;">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p style="text-align: center; color: #6b7280; padding: 20px;">No reviews yet. Be the
                                        first to review this product!</p>
                                @endforelse
                            </div>

                            <div
                                style="background: #f8fafc; padding: 30px; border-radius: 12px; margin-top: 30px; border: 1px solid #e2e8f0;">
                                @auth
                                    <h3 style="margin-bottom: 20px; font-size: 20px; color: #1e293b;">Write a Review</h3>
                                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                        @csrf
                                        <div style="margin-bottom: 15px;">
                                            <label
                                                style="display: block; margin-bottom: 5px; font-weight: bold; color: #475569;">Rating</label>
                                            <select name="rating" required
                                                style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                                                <option value="5">5 - Excellent</option>
                                                <option value="4">4 - Good</option>
                                                <option value="3">3 - Average</option>
                                                <option value="2">2 - Fair</option>
                                                <option value="1">1 - Poor</option>
                                            </select>
                                        </div>
                                        <div style="margin-bottom: 15px;">
                                            <label
                                                style="display: block; margin-bottom: 5px; font-weight: bold; color: #475569;">Your
                                                Review</label>
                                            <textarea name="comment" rows="4" required placeholder="What did you like or dislike about this product?"
                                                style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-family: inherit;"></textarea>
                                        </div>
                                        <button type="submit" class="btn-add-to-cart-large"
                                            style="width: auto; padding: 10px 20px; font-size: 14px;">Submit Review</button>
                                    </form>
                                @else
                                    <div style="text-align: center;">
                                        <i class="fas fa-lock"
                                            style="font-size: 30px; color: #cbd5e1; margin-bottom: 15px;"></i>
                                        <h4 style="color: #475569; margin-bottom: 10px;">Want to leave a review?</h4>
                                        <p style="color: #64748b; margin-bottom: 15px;">You need to be logged in to review this
                                            product.</p>
                                        <a href="{{ route('login') }}" class="btn-add-to-cart-large"
                                            style="display: inline-flex; width: auto; text-decoration: none; padding: 10px 20px; font-size: 14px;">Login
                                            to Review</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($relatedProducts && $relatedProducts->count() > 0)
                <div class="related-products">
                    <h2 class="section-title">You Might Also Like</h2>
                    <div class="products-grid">
                        @foreach ($relatedProducts as $related)
                            <div class="product-card">
                                <div class="product-image">
                                    <a
                                        href="{{ route('product.show', ['category_slug' => $related->category->slug ?? 'uncategorized', 'product_slug' => $related->slug ?? $related->id]) }}">
                                        @if ($related->thumbnail)
                                            <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                                alt="{{ $related->name }}">
                                        @else
                                            <img src="{{ asset('images/product-placeholder.jpg') }}"
                                                alt="{{ $related->name }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-info">
                                    <h3>
                                        <a
                                            href="{{ route('product.show', ['category_slug' => $related->category->slug ?? 'uncategorized', 'product_slug' => $related->slug ?? $related->id]) }}">
                                            {{ $related->name }}
                                        </a>
                                    </h3>
                                    <div class="product-footer">
                                        <span class="product-price">₹{{ number_format($related->price, 2) }}</span>
                                        <button class="btn-add-to-cart" data-id="{{ $related->id }}">
                                            Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@push('styles')
    <style>
        /* Product Detail Section */
        .product-detail-section {
            padding: 60px 0;
            background: #f9fafb;
        }

        .product-detail-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .product-gallery {
            position: sticky;
            top: 100px;
        }

        .main-image {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
            background: #f9fafb;
        }

        .main-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .thumbnail-gallery {
            display: flex;
            gap: 10px;
        }

        .thumbnail-item {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .thumbnail-item.active {
            border-color: var(--primary);
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-breadcrumb {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .product-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .product-breadcrumb i {
            margin: 0 8px;
            font-size: 12px;
            color: #9ca3af;
        }

        .product-breadcrumb span {
            color: #6b7280;
        }

        .product-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .product-rating-detail {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .rating-stars {
            color: #fbbf24;
        }

        .rating-value {
            color: var(--dark);
            font-weight: 600;
            margin-left: 5px;
        }

        .reviews-count {
            color: #6b7280;
            font-size: 14px;
        }

        .product-price-detail {
            margin-bottom: 20px;
        }

        .current-price {
            font-size: 32px;
            font-weight: 700;
            color: #6366f1;
        }

        .product-short-description {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-meta-detail {
            margin-bottom: 25px;
        }

        .meta-item {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .meta-item i {
            width: 20px;
            color: var(--primary);
            margin-right: 8px;
        }

        .meta-item strong {
            color: var(--dark);
            margin-right: 5px;
        }

        .meta-item a {
            color: #6b7280;
            text-decoration: none;
        }

        .meta-item a:hover {
            color: var(--primary);
        }

        .product-type-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            background: #e0e7ff;
            color: #4338ca;
        }

        .product-actions-detail {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .qty-btn {
            width: 40px;
            height: 50px;
            border: none;
            background: #f8fafc;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s;
        }

        .qty-btn:hover {
            background: #e2e8f0;
        }

        .quantity-selector input {
            width: 50px;
            height: 50px;
            text-align: center;
            border: none;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            font-size: 16px;
            font-weight: bold;
        }

        /* NEW ADD TO CART CSS */
        .btn-add-to-cart-large {
            flex: 1;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 24px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.4), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-add-to-cart-large:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4), 0 4px 6px -2px rgba(79, 70, 229, 0.05);
        }

        .btn-wishlist {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            width: 50px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 20px;
            color: #64748b;
        }

        .btn-wishlist:hover {
            background: #fee2e2;
            border-color: #ef4444;
            color: #ef4444;
        }

        .product-features {
            display: flex;
            gap: 20px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-item i {
            font-size: 24px;
            color: var(--primary);
        }

        .feature-item strong {
            display: block;
            font-size: 13px;
            margin-bottom: 2px;
        }

        .feature-item small {
            font-size: 11px;
            color: #6b7280;
        }

        .product-tabs {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .tabs-nav {
            display: flex;
            gap: 30px;
            border-bottom: 2px solid #f0f0f0;
            margin-bottom: 30px;
            list-style: none;
            padding: 0;
        }

        .tab-link {
            padding: 10px 0;
            cursor: pointer;
            color: #6b7280;
            font-weight: 600;
            position: relative;
            transition: color 0.3s;
        }

        .tab-link.active {
            color: var(--primary);
        }

        .tab-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary);
            border-radius: 3px 3px 0 0;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-description {
            line-height: 1.8;
            color: #4b5563;
        }

        .product-features-list ul {
            list-style: none;
            padding: 0;
        }

        .product-features-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-features-list li i {
            color: #10b981;
        }

        .review-item {
            display: flex;
            gap: 15px;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .related-products {
            margin-top: 40px;
        }

        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 700;
            color: var(--dark);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
        }

        @media (max-width: 1024px) {
            .product-detail-layout {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .product-gallery {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .product-detail-layout {
                padding: 20px;
            }

            .product-title {
                font-size: 24px;
            }

            .product-actions-detail {
                flex-direction: column;
            }

            .quantity-selector,
            .btn-add-to-cart-large,
            .btn-wishlist {
                width: 100%;
            }

            .product-features {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thumbnail gallery
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            const mainImage = document.getElementById('mainProductImage');

            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const imageUrl = this.dataset.image;
                    mainImage.src = imageUrl;
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Quantity selector
            const decreaseBtn = document.getElementById('decreaseQty');
            const increaseBtn = document.getElementById('increaseQty');
            const quantityInput = document.getElementById('productQuantity');

            if (decreaseBtn && increaseBtn && quantityInput) {
                decreaseBtn.addEventListener('click', function() {
                    let value = parseInt(quantityInput.value);
                    if (value > 1) {
                        quantityInput.value = value - 1;
                    }
                });

                increaseBtn.addEventListener('click', function() {
                    let value = parseInt(quantityInput.value);
                    if (value < 10) {
                        quantityInput.value = value + 1;
                    }
                });
            }

            // Product tabs
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const tabId = this.dataset.tab;
                    tabLinks.forEach(l => l.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });

        // Add to cart functionality
        const addToCartBtn = document.querySelector('.btn-add-to-cart-large');
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const productId = this.dataset.id;
                const quantity = document.getElementById('productQuantity').value;
                const originalText = this.innerHTML;

                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;

                // Send AJAX request to Laravel
                fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Revert button and redirect to Cart
                            this.innerHTML = '<i class="fas fa-check"></i> Added!';
                            setTimeout(() => {
                                window.location.href = '{{ route('cart.index') }}';
                            }, 500);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.innerHTML = originalText;
                        this.disabled = false;
                        alert('Something went wrong. Please try again.');
                    });
            });
        }
    </script>
@endpush

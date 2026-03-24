@extends('layouts.app')

@section('title', 'All Products - Themeur')
@section('content')

    <!-- Page Header -->
    <section class="page-header-section">
        <div class="container">
            <div class="page-header-content">
                <h1>All Products</h1>
                <p>Browse our collection of premium digital products</p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-page-section">
        <div class="container">
            <div class="products-page-layout">
                <!-- Sidebar Filters -->
                <div class="products-sidebar">
                    <div class="filter-card">
                        <h3>Categories</h3>
                        <div class="filter-list">
                            <a href="{{ route('products.all') }}"
                                class="filter-item {{ !request('category') ? 'active' : '' }}">
                                All Products
                                <span>{{ $products->total() }}</span>
                            </a>
                            @foreach ($categories ?? [] as $category)
                                <a href="{{ route('products.all', ['category' => $category->slug]) }}"
                                    class="filter-item {{ request('category') == $category->slug ? 'active' : '' }}">
                                    <i class="{{ $category->icon ?? 'fas fa-tag' }}"></i>
                                    {{ $category->name }}
                                    <span>{{ $category->products_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="filter-card">
                        <h3>Product Type</h3>
                        <div class="filter-list">
                            <a href="{{ route('products.all', array_merge(request()->all(), ['type' => 'theme'])) }}"
                                class="filter-item {{ request('type') == 'theme' ? 'active' : '' }}">
                                <i class="fab fa-wordpress"></i> WordPress Themes
                            </a>
                            <a href="{{ route('products.all', array_merge(request()->all(), ['type' => 'plugin'])) }}"
                                class="filter-item {{ request('type') == 'plugin' ? 'active' : '' }}">
                                <i class="fas fa-plug"></i> Plugins
                            </a>
                            <a href="{{ route('products.all', array_merge(request()->all(), ['type' => 'template'])) }}"
                                class="filter-item {{ request('type') == 'template' ? 'active' : '' }}">
                                <i class="fab fa-html5"></i> HTML Templates
                            </a>
                        </div>
                    </div>

                    <div class="filter-card">
                        <h3>Price Range</h3>
                        <div class="price-range">
                            <div class="price-inputs">
                                <input type="number" id="minPrice" placeholder="Min" value="{{ request('min') }}">
                                <span>-</span>
                                <input type="number" id="maxPrice" placeholder="Max" value="{{ request('max') }}">
                            </div>
                            <button id="applyPriceFilter" class="btn-filter">Apply</button>
                        </div>
                    </div>

                    <div class="filter-card">
                        <h3>Sort By</h3>
                        <select id="sortBy" class="form-control">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to
                                High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High
                                to Low</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular
                            </option>
                        </select>
                    </div>

                    <!-- Clear Filters -->
                    @if (request()->hasAny(['category', 'type', 'min', 'max', 'sort']))
                        <div class="filter-card">
                            <a href="{{ route('products.all') }}" class="btn-clear-filters">
                                <i class="fas fa-times"></i> Clear All Filters
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Products Grid -->
                <div class="products-main">
                    <div class="products-header">
                        <div class="products-count">
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                            {{ $products->total() }} products
                        </div>
                        <div class="products-view">
                            <button class="view-btn active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>

                    <div class="products-grid-view" id="productsGrid">
                        @forelse($products as $product)
                            <div class="product-card">
                                @if ($product->created_at->diffInDays(now()) <= 7)
                                    <div class="product-badge new">New</div>
                                @endif

                                <div class="product-image">
                                    <a
                                        href="{{ route('product.show', ['category_slug' => $product->category->slug ?? 'uncategorized', 'product_slug' => $product->slug ?? $product->id]) }}">
                                        @if ($product->thumbnail)
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('images/product-placeholder.jpg') }}"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    <div class="product-actions">
                                        <button class="action-btn wishlist-btn" data-id="{{ $product->id }}">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <button class="action-btn quick-view-btn" data-id="{{ $product->id }}">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="product-info">
                                    <div class="product-category">
                                        @if ($product->category)
                                            <i class="{{ $product->category->icon ?? 'fas fa-tag' }}"></i>
                                            <a
                                                href="{{ route('products.all', ['category' => $product->category->slug]) }}">
                                                {{ $product->category->name }}
                                            </a>
                                        @endif
                                    </div>

                                    <h3>
                                        <a
                                            href="{{ route('product.show', ['category_slug' => $product->category->slug ?? 'uncategorized', 'product_slug' => $product->slug ?? $product->id]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>

                                    <div class="product-meta">
                                        <div class="product-rating">
                                            <i class="fas fa-star"></i>
                                            <span>{{ number_format($product->avg_rating ?? 4.8, 1) }}</span>
                                            <span class="reviews">({{ $product->reviews_count ?? 0 }} reviews)</span>
                                        </div>
                                        <div class="product-type type-{{ $product->type }}">
                                            @if ($product->type == 'theme')
                                                <i class="fab fa-wordpress"></i> Theme
                                            @elseif($product->type == 'plugin')
                                                <i class="fas fa-plug"></i> Plugin
                                            @else
                                                <i class="fab fa-html5"></i> Template
                                            @endif
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
                                        <button class="btn-add-to-cart" data-id="{{ $product->id }}">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-products">
                                <i class="fas fa-box-open"></i>
                                <h3>No Products Found</h3>
                                <p>We couldn't find any products matching your criteria.</p>
                                <a href="{{ route('products.all') }}" class="btn btn-primary">Clear Filters</a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        /* Page Header Section */
        .page-header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 0;
            color: white;
            text-align: center;
        }

        .page-header-content h1 {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .page-header-content p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* Products Page Layout */
        .products-page-section {
            padding: 60px 0;
            background: #f9fafb;
        }

        .products-page-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
        }

        /* Sidebar Filters */
        .products-sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .filter-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .filter-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            color: #6b7280;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .filter-item i {
            margin-right: 8px;
            width: 20px;
        }

        .filter-item:hover {
            background: #f3f4f6;
            color: var(--primary);
        }

        .filter-item.active {
            background: var(--primary);
            color: white;
        }

        .filter-item span {
            font-size: 12px;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 12px;
            color: #6b7280;
        }

        .filter-item.active span {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Price Range */
        .price-range {
            margin-top: 10px;
        }

        .price-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
        }

        .price-inputs input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
        }

        .price-inputs input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-filter {
            width: 100%;
            padding: 10px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-filter:hover {
            background: var(--primary-dark);
        }

        .btn-clear-filters {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px;
            background: #fee2e2;
            color: #ef4444;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .btn-clear-filters:hover {
            background: #ef4444;
            color: white;
        }

        /* Products Header */
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .products-count {
            color: #6b7280;
            font-size: 14px;
        }

        .products-view {
            display: flex;
            gap: 10px;
        }

        .view-btn {
            width: 36px;
            height: 36px;
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .view-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Products Grid */
        .products-grid-view {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        /* List View (Hidden by default) */
        .products-list-view {
            display: none;
        }

        .products-list-view .product-card {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .products-list-view .product-image {
            width: 200px;
            height: 150px;
        }

        .products-list-view .product-info {
            flex: 1;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--primary);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 1;
        }

        .product-badge.new {
            background: #10b981;
        }

        .product-image {
            position: relative;
            overflow: hidden;
            aspect-ratio: 3/2;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 8px;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s;
        }

        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
        }

        .product-info {
            padding: 20px;
        }

        .product-category {
            margin-bottom: 10px;
        }

        .product-category a {
            color: var(--primary);
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
        }

        .product-category i {
            margin-right: 5px;
        }

        .product-info h3 {
            font-size: 16px;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-info h3 a {
            color: var(--dark);
            text-decoration: none;
        }

        .product-info h3 a:hover {
            color: var(--primary);
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .product-rating {
            color: #fbbf24;
            font-size: 13px;
        }

        .product-rating .reviews {
            color: #9ca3af;
            margin-left: 5px;
        }

        .product-type {
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .type-theme {
            background: #dbeafe;
            color: #3b82f6;
        }

        .type-plugin {
            background: #fef3c7;
            color: #d97706;
        }

        .type-template {
            background: #d1fae5;
            color: #10b981;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .btn-add-to-cart {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 13px;
        }

        .btn-add-to-cart:hover {
            background: var(--primary-dark);
        }

        /* No Products */
        .no-products {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
        }

        .no-products i {
            font-size: 64px;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .no-products h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .no-products p {
            color: #6b7280;
            margin-bottom: 20px;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
        }

        .pagination li a,
        .pagination li span {
            display: inline-block;
            padding: 8px 12px;
            background: white;
            border-radius: 6px;
            text-decoration: none;
            color: var(--dark);
            transition: all 0.3s;
        }

        .pagination li.active span {
            background: var(--primary);
            color: white;
        }

        .pagination li a:hover {
            background: var(--primary);
            color: white;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .products-page-layout {
                grid-template-columns: 1fr;
            }

            .products-sidebar {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .page-header-content h1 {
                font-size: 32px;
            }

            .products-header {
                flex-direction: column;
                gap: 10px;
            }

            .products-grid-view {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Price filter
            const applyPriceFilter = document.getElementById('applyPriceFilter');
            if (applyPriceFilter) {
                applyPriceFilter.addEventListener('click', function() {
                    const min = document.getElementById('minPrice').value;
                    const max = document.getElementById('maxPrice').value;
                    const url = new URL(window.location.href);

                    if (min) url.searchParams.set('min', min);
                    else url.searchParams.delete('min');

                    if (max) url.searchParams.set('max', max);
                    else url.searchParams.delete('max');

                    window.location.href = url.toString();
                });
            }

            // Sort by
            const sortBy = document.getElementById('sortBy');
            if (sortBy) {
                sortBy.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('sort', this.value);
                    window.location.href = url.toString();
                });
            }

            // Grid/List view toggle
            const viewBtns = document.querySelectorAll('.view-btn');
            const productsGrid = document.getElementById('productsGrid');

            viewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const view = this.dataset.view;

                    viewBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    if (view === 'list') {
                        productsGrid.classList.remove('products-grid-view');
                        productsGrid.classList.add('products-list-view');
                    } else {
                        productsGrid.classList.remove('products-list-view');
                        productsGrid.classList.add('products-grid-view');
                    }
                });
            });
        });
    </script>
@endpush

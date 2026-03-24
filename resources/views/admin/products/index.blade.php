@extends('admin.layouts.app')

@section('title', 'Manage Products - Themeour')
@section('page-title', 'Products')

@section('content')
    <div class="products-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-info">
                <h2>Manage Products</h2>
                <p>Manage your digital products and assets</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Products Table -->
        <div class="data-table">
            @if ($products->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th width="80">Image</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Downloads</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>#{{ $product->id }}</td>
                                    <td>
                                        @if ($product->thumbnail)
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}" class="product-thumbnail">
                                        @else
                                            <div class="thumbnail-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="product-info">
                                            <strong>{{ $product->name }}</strong>
                                            <small class="text-muted">{{ Str::limit($product->description, 60) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-category">
                                            <i class="{{ $product->category->icon ?? 'fas fa-tag' }}"></i>
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="product-type type-{{ $product->type }}">
                                            @if ($product->type == 'theme')
                                                <i class="fab fa-wordpress"></i> Theme
                                            @elseif($product->type == 'plugin')
                                                <i class="fas fa-plug"></i> Plugin
                                            @else
                                                <i class="fab fa-html5"></i> Template
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="product-price">
                                            ₹{{ number_format($product->price, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $product->status }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="download-count">
                                            <i class="fas fa-download"></i> {{ $product->downloads_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                class="btn-icon btn-edit" title="Edit Product">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn-icon btn-view" title="View Product"
                                                onclick="viewProduct({{ $product->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-icon btn-delete" title="Delete Product"
                                                onclick="confirmDelete({{ $product->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $product->id }}"
                                                action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>No Products Found</h3>
                    <p>Get started by adding your first product.</p>
                    {{-- <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Product
                    </a> --}}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .products-container {
            padding: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .header-info h2 {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .header-info p {
            color: var(--gray);
            font-size: 14px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background: #f9fafb;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 13px;
            border-bottom: 2px solid #e5e7eb;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        .thumbnail-placeholder {
            width: 50px;
            height: 50px;
            background: #f3f4f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 20px;
        }

        .product-info {
            display: flex;
            flex-direction: column;
        }

        .product-info strong {
            color: var(--dark);
            margin-bottom: 4px;
        }

        .product-info small {
            font-size: 12px;
            color: #6b7280;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-category {
            background: #e0f2fe;
            color: #0284c7;
        }

        .product-type {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
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

        .product-price {
            font-weight: 600;
            color: var(--dark);
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background: #d1fae5;
            color: #10b981;
        }

        .status-inactive {
            background: #fee2e2;
            color: #ef4444;
        }

        .download-count {
            color: #6b7280;
            font-size: 13px;
        }

        .download-count i {
            margin-right: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-edit {
            background: #dbeafe;
            color: #3b82f6;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-view {
            background: #e0e7ff;
            color: #6366f1;
        }

        .btn-view:hover {
            background: #6366f1;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function viewProduct(id) {
            // You can implement view modal or redirect to product page
            window.open('/product/' + id, '_blank');
        }
    </script>
@endpush

@extends('admin.layouts.app')

@section('title', 'Manage Categories - Themeour')
@section('page-title', 'Categories')

@section('content')
    <div class="categories-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-info">
                <h2>Manage Categories</h2>
                <p>Organize your products with categories</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Category
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

        <!-- Categories Table -->
        <div class="data-table">
            @if ($categories->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th width="50">Sl</th>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Products</th>
                            <th>Created</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if ($category->icon)
                                        <i class="{{ $category->icon }}"></i>
                                    @else
                                        <i class="fas fa-tag"></i>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </td>
                                <td>
                                    <code>{{ $category->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $category->products_count }} Products
                                    </span>
                                </td>
                                <td>
                                    {{ $category->created_at->format('d M, Y') }}
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-icon btn-edit"
                                            title="Edit Category">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn-icon btn-delete" title="Delete Category"
                                            onclick="confirmDelete({{ $category->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $category->id }}"
                                            action="{{ route('admin.categories.destroy', $category) }}" method="POST"
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
            @else
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No Categories Found</h3>
                    <p>Get started by creating your first category.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Category
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .categories-container {
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

        .header-actions .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-info {
            background: #e0f2fe;
            color: #0284c7;
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

        code {
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush

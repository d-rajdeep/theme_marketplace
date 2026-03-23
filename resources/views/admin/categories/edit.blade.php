@extends('admin.layouts.app')

@section('title', 'Edit Category - Themeour')
@section('page-title', 'Edit Category')

@section('content')
    <div class="category-form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="header-info">
                    <h3>Edit Category</h3>
                    <p>Update category information</p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Categories
                </a>
            </div>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="category-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-tag"></i> Category Name <span class="required">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}"
                        placeholder="e.g., WordPress Themes, HTML Templates, Plugins" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Current slug: <code>{{ $category->slug }}</code></small>
                </div>

                <div class="form-group">
                    <label for="icon" class="form-label">
                        <i class="fas fa-icons"></i> Category Icon (Optional)
                    </label>
                    <div class="icon-input-group">
                        <div class="icon-preview" id="iconPreview">
                            <i class="{{ old('icon', $category->icon ?? 'fas fa-tag') }}"></i>
                        </div>
                        <input type="text" name="icon" id="icon"
                            class="form-control @error('icon') is-invalid @enderror"
                            value="{{ old('icon', $category->icon) }}"
                            placeholder="e.g., fab fa-wordpress, fas fa-code, fas fa-plug">
                    </div>
                    @error('icon')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-text">
                        <i class="fas fa-info-circle"></i>
                        Enter Font Awesome icon class.
                        <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a>
                    </small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="danger-zone">
            <h4>Danger Zone</h4>
            <div class="danger-content">
                <div class="danger-info">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Delete this category</strong>
                        <p>Once deleted, all products in this category will become uncategorized.</p>
                    </div>
                </div>
                <button type="button" class="btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete Category
                </button>
            </div>
        </div>

        <form id="delete-form" action="{{ route('admin.categories.destroy', $category) }}" method="POST"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .category-form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: var(--white);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            margin-bottom: 30px;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-header h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .form-header p {
            color: var(--gray);
            font-size: 14px;
        }

        .required {
            color: #ef4444;
        }

        .icon-input-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-preview {
            width: 50px;
            height: 50px;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary);
        }

        .form-text {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: var(--gray);
        }

        .form-text a {
            color: var(--primary);
            text-decoration: none;
        }

        .form-text code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .danger-zone {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 16px;
            padding: 20px;
        }

        .danger-zone h4 {
            color: #dc2626;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #fed7d7;
        }

        .danger-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .danger-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .danger-info i {
            font-size: 24px;
            color: #dc2626;
        }

        .danger-info strong {
            display: block;
            color: #991b1b;
            margin-bottom: 5px;
        }

        .danger-info p {
            color: #7f1a1a;
            font-size: 13px;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        @media (max-width: 768px) {
            .danger-content {
                flex-direction: column;
                align-items: stretch;
            }

            .danger-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live icon preview
            const iconInput = document.getElementById('icon');
            const iconPreview = document.getElementById('iconPreview');

            if (iconInput) {
                iconInput.addEventListener('input', function() {
                    const iconClass = this.value.trim();
                    if (iconClass) {
                        iconPreview.innerHTML = `<i class="${iconClass}"></i>`;
                    } else {
                        iconPreview.innerHTML = '<i class="fas fa-tag"></i>';
                    }
                });
            }
        });

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endpush

@extends('admin.layouts.app')

@section('title', 'Create Category - Themeour')
@section('page-title', 'Create Category')

@section('content')
    <div class="category-form-container">
        <div class="form-card">
            <div class="form-header">
                <div class="header-info">
                    <h3>Add New Category</h3>
                    <p>Create a new category to organize your products</p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Categories
                </a>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="category-form">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-tag"></i> Category Name <span class="required">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                        placeholder="e.g., WordPress Themes, HTML Templates, Plugins" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-text">This will be used as the display name for the category.</small>
                </div>

                <div class="form-group">
                    <label for="icon" class="form-label">
                        <i class="fas fa-icons"></i> Category Icon (Optional)
                    </label>
                    <div class="icon-input-group">
                        <div class="icon-preview" id="iconPreview">
                            <i class="{{ old('icon', 'fas fa-tag') }}"></i>
                        </div>
                        <input type="text" name="icon" id="icon"
                            class="form-control @error('icon') is-invalid @enderror" value="{{ old('icon') }}"
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
                        <i class="fas fa-save"></i> Create Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Icon Suggestions -->
        <div class="icon-suggestions">
            <h4>Popular Icon Suggestions</h4>
            <div class="icon-list">
                <button type="button" class="icon-suggestion" data-icon="fab fa-wordpress">
                    <i class="fab fa-wordpress"></i> fab fa-wordpress
                </button>
                <button type="button" class="icon-suggestion" data-icon="fab fa-html5">
                    <i class="fab fa-html5"></i> fab fa-html5
                </button>
                <button type="button" class="icon-suggestion" data-icon="fas fa-code">
                    <i class="fas fa-code"></i> fas fa-code
                </button>
                <button type="button" class="icon-suggestion" data-icon="fas fa-plug">
                    <i class="fas fa-plug"></i> fas fa-plug
                </button>
                <button type="button" class="icon-suggestion" data-icon="fas fa-shopping-cart">
                    <i class="fas fa-shopping-cart"></i> fas fa-shopping-cart
                </button>
                <button type="button" class="icon-suggestion" data-icon="fas fa-paint-brush">
                    <i class="fas fa-paint-brush"></i> fas fa-paint-brush
                </button>
                <button type="button" class="icon-suggestion" data-icon="fas fa-mobile-alt">
                    <i class="fas fa-mobile-alt"></i> fas fa-mobile-alt
                </button>
                <button type="button" class="icon-suggestion" data-icon="fas fa-database">
                    <i class="fas fa-database"></i> fas fa-database
                </button>
            </div>
        </div>
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

        .form-text a:hover {
            text-decoration: underline;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .icon-suggestions {
            background: var(--white);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
        }

        .icon-suggestions h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .icon-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .icon-suggestion {
            padding: 8px 15px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .icon-suggestion:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .icon-suggestion i {
            font-size: 14px;
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

            // Icon suggestions click
            const suggestions = document.querySelectorAll('.icon-suggestion');
            suggestions.forEach(suggestion => {
                suggestion.addEventListener('click', function() {
                    const icon = this.getAttribute('data-icon');
                    if (iconInput) {
                        iconInput.value = icon;
                        iconInput.dispatchEvent(new Event('input'));
                    }
                });
            });
        });
    </script>
@endpush

@extends('admin.layouts.app')

@section('title', 'Edit Product - Themeour')
@section('page-title', 'Edit Product')

@section('content')
    <div class="product-form-container">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="product-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-main">
                    <div class="form-card">
                        <h3>Basic Information</h3>

                        <div class="form-group">
                            <label for="name" class="form-label">Product Name <span class="required">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}" placeholder="Enter product name" required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="category_id" class="form-label">Category <span class="required">*</span></label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type" class="form-label">Product Type <span
                                        class="required">*</span></label>
                                <select name="type" id="type"
                                    class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="theme" {{ old('type', $product->type) == 'theme' ? 'selected' : '' }}>
                                        WordPress Theme</option>
                                    <option value="plugin" {{ old('type', $product->type) == 'plugin' ? 'selected' : '' }}>
                                        WordPress Plugin</option>
                                    <option value="template"
                                        {{ old('type', $product->type) == 'template' ? 'selected' : '' }}>HTML Template
                                    </option>
                                </select>
                                @error('type')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="6"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-card">
                        <h3>Pricing & Details</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price" class="form-label">Price (₹) <span class="required">*</span></label>
                                <input type="number" name="price" id="price" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price', $product->price) }}" placeholder="0.00" required>
                                @error('price')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="required">*</span></label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="active"
                                        {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive"
                                        {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="demo_url" class="form-label">Demo URL</label>
                            <input type="url" name="demo_url" id="demo_url"
                                class="form-control @error('demo_url') is-invalid @enderror"
                                value="{{ old('demo_url', $product->demo_url) }}" placeholder="https://example.com/demo">
                            @error('demo_url')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-sidebar">
                    <div class="form-card">
                        <h3>Product Thumbnail</h3>
                        <div class="file-upload">
                            <div class="upload-preview" id="thumbnailPreview">
                                @if ($product->thumbnail)
                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                        style="max-width: 100%; max-height: 150px; object-fit: contain;">
                                @else
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click or drag to upload thumbnail</p>
                                    <small>JPG, PNG, WEBP (Max 2MB)</small>
                                @endif
                            </div>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp"
                                class="file-input">
                        </div>
                        @error('thumbnail')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-card">
                        <h3>Downloadable File</h3>
                        <div class="file-upload">
                            <div class="upload-preview" id="filePreview">
                                @if ($product->file_path)
                                    <i class="fas fa-file-archive"></i>
                                    <p>Current file: {{ basename($product->file_path) }}</p>
                                    <small>Upload new file to replace</small>
                                @else
                                    <i class="fas fa-file-archive"></i>
                                    <p>Upload product file</p>
                                    <small>ZIP (Max 50MB)</small>
                                @endif
                            </div>
                            <input type="file" name="file" id="file" accept=".zip" class="file-input">
                        </div>
                        @error('file')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-card">
                        <h3>Additional Images</h3>
                        <div class="file-upload multiple">
                            <div class="upload-preview" id="imagesPreview">
                                <i class="fas fa-images"></i>
                                <p>Upload product screenshots</p>
                                <small>Multiple images allowed (Max 2MB each)</small>
                            </div>
                            <input type="file" name="images[]" id="images"
                                accept="image/jpeg,image/png,image/webp" multiple class="file-input">
                        </div>
                        <div id="imageList" class="image-list">
                            @if ($product->images)
                                @foreach ($product->images as $image)
                                    <div class="image-item">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image">
                                        <div class="remove-image" onclick="removeImage({{ $image->id }})">×</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @error('images.*')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>

        <!-- Danger Zone -->
        <div class="danger-zone">
            <h4>Danger Zone</h4>
            <div class="danger-content">
                <div class="danger-info">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Delete this product</strong>
                        <p>Once deleted, all data related to this product will be permanently removed.</p>
                    </div>
                </div>
                <button type="button" class="btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete Product
                </button>
            </div>
        </div>

        <form id="delete-form" action="{{ route('admin.products.destroy', $product) }}" method="POST"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('styles')
    <style>
        /* Add danger zone styles */
        .danger-zone {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 16px;
            padding: 20px;
            margin-top: 20px;
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

        .image-item {
            position: relative;
            width: 80px;
            height: 80px;
            display: inline-block;
            margin: 5px;
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .image-item .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Thumbnail preview
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('thumbnailPreview');
                    preview.innerHTML =
                        `<img src="${e.target.result}" style="max-width: 100%; max-height: 150px; object-fit: contain;">`;
                };
                reader.readAsDataURL(file);
            }
        });

        // File preview
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('filePreview');
                preview.innerHTML = `
            <i class="fas fa-file-archive"></i>
            <p>${file.name}</p>
            <small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>
        `;
            }
        });

        // Multiple images preview
        document.getElementById('images').addEventListener('change', function(e) {
            const files = e.target.files;
            const imageList = document.getElementById('imageList');

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'image-item';
                    div.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <div class="remove-image" onclick="this.parentElement.remove()">×</div>
            `;
                    imageList.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }

        function removeImage(imageId) {
            if (confirm('Remove this image?')) {
                // You can implement AJAX call to remove image
                // For now, we'll just remove the element
                event.target.closest('.image-item').remove();
            }
        }
    </script>
@endpush

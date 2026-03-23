@extends('admin.layouts.app')

@section('title', 'Create Product - Themeour')
@section('page-title', 'Add New Product')

@section('content')
    <div class="product-form-container">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
            @csrf

            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-main">
                    <div class="form-card">
                        <h3>Basic Information</h3>

                        <div class="form-group">
                            <label for="name" class="form-label">Product Name <span class="required">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Enter product name" required>
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
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <option value="">Select Type</option>
                                    <option value="theme" {{ old('type') == 'theme' ? 'selected' : '' }}>WordPress Theme
                                    </option>
                                    <option value="plugin" {{ old('type') == 'plugin' ? 'selected' : '' }}>WordPress Plugin
                                    </option>
                                    <option value="template" {{ old('type') == 'template' ? 'selected' : '' }}>HTML Template
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
                                class="form-control @error('description') is-invalid @enderror" placeholder="Enter product description">{{ old('description') }}</textarea>
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
                                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}"
                                    placeholder="0.00" required>
                                @error('price')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="required">*</span></label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
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
                                class="form-control @error('demo_url') is-invalid @enderror" value="{{ old('demo_url') }}"
                                placeholder="https://example.com/demo">
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
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Click or drag to upload thumbnail</p>
                                <small>JPG, PNG, WEBP (Max 2MB)</small>
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
                                <i class="fas fa-file-archive"></i>
                                <p>Upload product file</p>
                                <small>ZIP (Max 50MB)</small>
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
                        <div id="imageList" class="image-list"></div>
                        @error('images.*')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .product-form-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 30px;
        }

        .form-card {
            background: var(--white);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            margin-bottom: 25px;
        }

        .form-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .required {
            color: #ef4444;
        }

        .file-upload {
            position: relative;
            margin-bottom: 10px;
        }

        .upload-preview {
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #f9fafb;
        }

        .upload-preview:hover {
            border-color: var(--primary);
            background: #f3f4f6;
        }

        .upload-preview i {
            font-size: 48px;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        .upload-preview p {
            color: var(--dark);
            margin-bottom: 5px;
        }

        .upload-preview small {
            color: var(--gray);
            font-size: 12px;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .image-list {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-item {
            position: relative;
            width: 80px;
            height: 80px;
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

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            padding: 20px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            bottom: 20px;
        }

        @media (max-width: 1024px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
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
            imageList.innerHTML = '';

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

        // Slug generation (optional)
        document.getElementById('name').addEventListener('input', function() {
            // You can add slug generation logic here if needed
        });
    </script>
@endpush

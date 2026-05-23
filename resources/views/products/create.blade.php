@extends('layouts.base')

@section('main_content')





@php
    // Mock categories for frontend testing
    $categories = [
        ['id' => 1, 'name' => 'Education'],
        ['id' => 2, 'name' => 'Development'],
        ['id' => 3, 'name' => 'Design'],
        ['id' => 4, 'name' => 'Business'],
        ['id' => 5, 'name' => 'Marketing'],
        ['id' => 6, 'name' => 'Other'],
    ];
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product</title>
    <link href="{{ asset('css/products.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    
    <!-- Navigation -->
    <nav class="nav">
        <div class="container">
            <div class="nav-content">
                <div class="nav-title">
                    <a href="{{ route('products.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1>Create New Product</h1>
                </div>
                <img src="{{ $user['avatar'] ?? 'https://via.placeholder.com/40' }}" 
                     alt="{{ $user['name'] ?? 'User' }}" class="avatar">
            </div>
        </div>
    </nav>

    <div class="container container--narrow" style="padding-top: 32px; padding-bottom: 32px;">
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Product Image Upload -->
            <div class="card">
                <h3 class="card-title">Product Image</h3>
                <div class="form-row form-row--two">
                    <div>
                        <div id="imagePreview" class="upload-area" onclick="document.getElementById('productImage').click()">
                            <i class="fas fa-image upload-icon"></i>
                            <p class="subtitle">Click to upload image</p>
                            <p class="hint">Recommended size: 800x600px</p>
                        </div>
                    </div>
                    <div>
                        <label class="label label--required">Product Image</label>
                        <input type="file" 
                               name="image" 
                               id="productImage"
                               accept="image/*"
                               style="display: none;">
                        <p class="hint mb-2">
                            Upload a high-quality image of your product. This will be the main image customers see.
                        </p>
                        <button type="button" onclick="document.getElementById('productImage').click()" 
                                class="btn btn--secondary">
                            <i class="fas fa-upload"></i> Choose Image
                        </button>
                        @error('image')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="card">
                <h3 class="card-title">Basic Information</h3>
                
                <div class="form-group">
                    <div class="field">
                        <label class="label label--required">Product Name</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               required
                               value="{{ old('name') }}"
                               placeholder="Enter a clear, descriptive product name">
                        <p class="hint">This is the main title customers will see. Make it descriptive and searchable.</p>
                        @error('name')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-row form-row--two">
                    <div class="field field--price">
                        <label class="label label--required">Price</label>
                        <input type="number" 
                               name="price" 
                               id="price" 
                               step="0.01"
                               min="0"
                               required
                               value="{{ old('price') }}"
                               placeholder="0.00">
                        @error('price')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label label--required">Category</label>
                        <select name="category" id="category" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat['id'] }}" {{ old('category') == $cat['id'] ? 'selected' : '' }}>
                                    {{ $cat['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="card">
                <h3 class="card-title">Product Description</h3>
                <div class="field">
                    <label class="label label--required">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="8"
                              required
                              placeholder="Describe your product in detail. Include features, benefits, what makes it special, and what customers will get when they purchase it...">{{ old('description') }}</textarea>
                    <div class="text-right mt-1">
                        <span class="hint">
                            <span id="charCount">0</span> characters - Write a compelling description
                        </span>
                    </div>
                    @error('description')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Details -->
            <div class="card">
                <h3 class="card-title">Additional Details</h3>
                
                <div class="form-group">
                    <div class="field">
                        <label class="label">Tags</label>
                        <input type="text" 
                               name="tags" 
                               id="tags"
                               value="{{ old('tags') }}" 
                               placeholder="laravel, php, development, course, tutorial">
                        <p class="hint">Add relevant tags separated by commas. Tags help customers find your product through search.</p>
                        @error('tags')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-row form-row--two">
                    <div>
                        <label class="label">Availability Status</label>
                        <div class="gap-3" style="display: flex; align-items: center; margin-top: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="in_stock" value="1" 
                                       {{ old('in_stock', '1') == '1' ? 'checked' : '' }}>
                                <span>In Stock</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="in_stock" value="0"
                                       {{ old('in_stock') == '0' ? 'checked' : '' }}>
                                <span>Out of Stock</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="label">Product Type</label>
                        <div style="margin-top: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="is_digital" value="1"
                                       {{ old('is_digital') ? 'checked' : '' }}>
                                <span>Digital Product</span>
                            </label>
                            <p class="hint mt-1">Check if this is a digital product (download, course, software, etc.)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="actions">
                <a href="{{ route('products.index') }}" class="btn btn--secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <div class="actions-group">
                    <button type="submit" name="status" value="draft" class="btn btn--secondary">
                        <i class="fas fa-save"></i> Save as Draft
                    </button>
                    <button type="submit" name="status" value="published" class="btn btn--primary">
                        <i class="fas fa-check"></i> Create Product
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Image preview
        document.getElementById('productImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div style="position: relative;">
                            <img src="${e.target.result}" alt="Preview" class="upload-preview">
                            <button type="button" class="remove-image" onclick="removeImage()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;
                    preview.style.padding = '0';
                };
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('productImage').value = '';
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `
                <i class="fas fa-image upload-icon"></i>
                <p class="subtitle">Click to upload image</p>
                <p class="hint">Recommended size: 800x600px</p>`;
            preview.style.padding = '48px 24px';
        }

        // Description char count
        document.getElementById('description').addEventListener('input', function(e) {
            document.getElementById('charCount').textContent = e.target.value.length;
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('charCount').textContent = document.getElementById('description').value.length;
        });

        // Client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const price = parseFloat(document.getElementById('price').value);
            const description = document.getElementById('description').value.trim();
            const category = document.getElementById('category').value;

            if (!name || !price || price <= 0 || !description || !category) {
                alert('Please fill in all required fields with valid values.');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
@endsection
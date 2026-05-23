<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - {{ $product->name ?? 'Product Name' }}</title>
    <link href="{{ asset('css/products.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>


@if(session('error'))
<div class="toast toast--error" id="toastError">
    {{ session('error') }}
</div>
<script>
    const toast = document.getElementById('toastError');
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 4000);
</script>
@endif
<style>
.toast {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background: #e74c3c;
    color: white;
    padding: 12px 20px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    z-index: 9999;
}
</style>

    <!-- Navigation -->
    <nav class="nav">
        <div class="container">
            <div class="nav-content">
                <div class="nav-title">
                    <a href="{{ route('products.show', $product->id ?? 1) }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1>Edit Product</h1>
                </div>
                <div class="nav-actions">
                    <span class="badge badge--published">Published</span>
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" 
                         alt="Profile" class="avatar">
                </div>
            </div>
        </div>
    </nav>

    <div class="container container--narrow" style="padding-top: 32px; padding-bottom: 32px;">
        <form action="{{ route('products.update', $product->id ?? 1) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Product Image Upload -->
            <div class="card">
                <h3 class="card-title">Product Image</h3>
                <div class="form-row form-row--two">
                    <div>
                        <div id="imagePreview" class="upload-area" onclick="document.getElementById('productImage').click()">
                            <!-- Show existing image or placeholder -->
                            @if(isset($product->image) && $product->image)
                            <div style="position: relative;">
<img src="{{ asset('images/' . $product->image) }}" alt="Current Product Image" class="upload-preview">
                                <button type="button" class="remove-image" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @else
                            <div style="position: relative;">
                                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=250&fit=crop" alt="Current product image" class="upload-preview">
                                <button type="button" class="remove-image" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <label class="label">Update Product Image</label>
                        <input type="file" 
                               name="image" 
                               id="productImage"
                               accept="image/*"
                               style="display: none;">
                        
                        <p class="hint mb-2">
                            Upload a new image to replace the current one. Leave empty to keep the current image.
                        </p>
                        
                        <div class="gap-2" style="display: flex;">
                            <button type="button" onclick="document.getElementById('productImage').click()" 
                                    class="btn btn--secondary">
                                <i class="fas fa-upload"></i>
                                Change Image
                            </button>
                            <button type="button" onclick="removeCurrentImage()" class="btn btn--danger btn--small">
                                <i class="fas fa-trash"></i>
                                Remove
                            </button>
                        </div>
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
                               value="{{ old('name', $product->name ?? 'Premium Laravel Course') }}"
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
                               value="{{ old('price', $product->price ?? '99.99') }}"
                               placeholder="0.00">
                        @error('price')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                   <div class="field">
    <label class="label label--required">Category</label>
   <select name="category" id="category" required>
    <option value="Education" {{ old('category', $product->category ?? '') == 'Education' ? 'selected' : '' }}>Education</option>
    <option value="Development" {{ old('category', $product->category ?? '') == 'Development' ? 'selected' : '' }}>Development</option>
    <option value="Design" {{ old('category', $product->category ?? '') == 'Design' ? 'selected' : '' }}>Design</option>
    <option value="Business" {{ old('category', $product->category ?? '') == 'Business' ? 'selected' : '' }}>Business</option>
    <option value="Marketing" {{ old('category', $product->category ?? '') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
    <option value="Other" {{ old('category', $product->category ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
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
                              placeholder="Describe your product in detail...">{{ old('description', $product->description ?? 'Complete Laravel development course from beginner to advanced. Includes real-world projects, API development, and deployment strategies. Perfect for developers who want to master Laravel and build professional web applications.') }}</textarea>
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
                               value="{{ old('tags', $product->tags ?? 'laravel, php, backend, api, course') }}" 
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
                                       {{ old('in_stock', $product->in_stock ?? '1') == '1' ? 'checked' : '' }}>
                                <span>In Stock</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="in_stock" value="0"
                                       {{ old('in_stock', $product->in_stock ?? '1') == '0' ? 'checked' : '' }}>
                                <span>Out of Stock</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="label">Product Type</label>
                        <div style="margin-top: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="is_digital" value="1"
                                       {{ old('is_digital', $product->is_digital ?? '1') ? 'checked' : '' }}>
                                <span>Digital Product</span>
                            </label>
                            <p class="hint mt-1">Check if this is a digital product (download, course, software, etc.)</p>
                        </div>
                    </div>
                </div>

                <!-- Product Stats (Read-only info) -->
                <div class="form-row form-row--three" style="margin-top: 24px;">
                    <div class="card card--compact">
                        <p class="hint mb-1">Sales Count</p>
                        <p class="title">{{ $product->sales_count ?? '342' }}</p>
                    </div>
                    <div class="card card--compact">
                        <p class="hint mb-1">Views</p>
                        <p class="title">{{ $product->views_count ?? '1,250' }}</p>
                    </div>
                    <div class="card card--compact">
                        <p class="hint mb-1">Revenue</p>
                        <p class="title">${{ number_format(($product->sales_count ?? 342) * ($product->price ?? 99.99), 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="actions">
                <div class="actions-group">
                    <a href="{{ route('products.show', $product->id ?? 1) }}" class="btn btn--secondary">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                    <button type="button" onclick="deleteProduct()" class="btn btn--danger">
                        <i class="fas fa-trash"></i>
                        Delete Product
                    </button>
                </div>
                
                <div class="actions-group">
                    <button type="submit" name="status" value="draft" class="btn btn--secondary">
                        <i class="fas fa-save"></i>
                        Save as Draft
                    </button>
                    <button type="submit" class="btn btn--primary">
                        <i class="fas fa-check"></i>
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Image preview functionality
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
                        </div>
                    `;
                    preview.style.padding = '0';
                };
                reader.readAsDataURL(file);
            }
        });

  function removeImage() {
    // Clear file input (new image)
    document.getElementById('productImage').value = '';
    const preview = document.getElementById('imagePreview');

    preview.innerHTML = `
        <i class="fas fa-image upload-icon"></i>
        <p class="subtitle">Click to upload new image</p>
        <p class="hint">Recommended size: 800x600px</p>
    `;
    preview.style.padding = '48px 24px';
}

function removeCurrentImage() {
    if (confirm('Are you sure you want to remove the current image?')) {
        const preview = document.getElementById('imagePreview');

        // Replace with placeholder
        preview.innerHTML = `
            <i class="fas fa-image upload-icon"></i>
            <p class="subtitle">Click to upload new image</p>
            <p class="hint">Recommended size: 800x600px</p>
        `;
        preview.style.padding = '48px 24px';

        // Add hidden input to notify backend
        const form = document.querySelector('form');
        let removeInput = document.querySelector('input[name="remove_image"]');
        if (!removeInput) {
            removeInput = document.createElement('input');
            removeInput.type = 'hidden';
            removeInput.name = 'remove_image';
            removeInput.value = '1';
            form.appendChild(removeInput);
        }
    }
}



        function removeCurrentImage() {
            if (confirm('Are you sure you want to remove the current image?')) {
                removeImage();
                // Add hidden input to indicate image should be removed
                const form = document.querySelector('form');
                const removeInput = document.createElement('input');
                removeInput.type = 'hidden';
                removeInput.name = 'remove_image';
                removeInput.value = '1';
                form.appendChild(removeInput);
            }
        }

        function deleteProduct() {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("products.destroy", $product->id ?? 1) }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Character counter for description
        document.getElementById('description').addEventListener('input', function(e) {
            document.getElementById('charCount').textContent = e.target.value.length;
        });

        // Initialize character count
        document.addEventListener('DOMContentLoaded', function() {
            const description = document.getElementById('description');
            document.getElementById('charCount').textContent = description.value.length;
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const price = parseFloat(document.getElementById('price').value);
            const description = document.getElementById('description').value.trim();
            const category = document.getElementById('category').value;
            
            if (!name) {
                alert('Please enter a product name');
                e.preventDefault();
                return false;
            }
            
            if (!price || price <= 0) {
                alert('Please enter a valid price greater than 0');
                e.preventDefault();
                return false;
            }
            
            if (!description) {
                alert('Please enter a product description');
                e.preventDefault();
                return false;
            }
            
            if (!category) {
                alert('Please select a category');
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>
</html>
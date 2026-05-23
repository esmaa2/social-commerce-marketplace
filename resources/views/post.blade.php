@extends('layouts.base')

@section('main_content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    
    <!-- Navigation Header -->
    <nav style="background: var(--card, #0f1720); border-bottom: 1px solid var(--border, rgba(255,255,255,.1)); padding: 16px 0; margin-bottom: 32px;">
        <div style="max-width: 1024px; margin: 0 auto; padding: 0 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <a href="{{ route('dashboard') }}" style="color: var(--muted, #a2b3c5); text-decoration: none; font-size: 18px; transition: color 0.2s;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 style="margin: 0; font-size: clamp(20px, 2.6vw, 24px); font-weight: 600;">Create New Post</h1>
                </div>
                <img src="{{ auth()->user()->avatar_path ? asset('storage/' . auth()->user()->avatar_path) : asset('images/default-avatar.png') }}" 
                     alt="Profile" 
                     style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
            </div>
        </div>
    </nav>

    <div style="max-width: 1024px; margin: 0 auto; padding: 0 16px 32px;">
        <form action="{{ route('feed.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

            
            <!-- Post Image Upload -->
            <div style="background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: var(--radius, 16px); box-shadow: var(--shadow, 0 12px 30px rgba(0,0,0,.35)); padding: 24px; margin-bottom: 24px;">
                <h3 style="font-size: 20px; font-weight: 600; color: var(--text, #e6edf3); margin: 0 0 16px 0;">Post Image</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start;">
                    <div>
                        <div id="imagePreview" style="border: 2px dashed var(--border, rgba(255,255,255,.1)); border-radius: 12px; padding: 48px 24px; text-align: center; background: #0b131c; transition: border-color 0.2s; cursor: pointer;" onclick="document.getElementById('postImage').click()">
                            <i class="fas fa-image" style="font-size: 48px; color: var(--muted, #a2b3c5); margin-bottom: 16px; display: block;"></i>
                            <p style="color: var(--muted, #a2b3c5); font-size: 14px; margin: 0;">Click to upload image</p>
                            <p style="color: var(--muted, #a2b3c5); font-size: 12px; margin: 8px 0 0 0;">Recommended: 1200x800px</p>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #cfe6dd; margin-bottom: 8px;">
                            Post Image <span style="color: var(--error, #ff7a85);">*</span>
                        </label>
                        <input type="file" 
                               name="image" 
                               id="postImage"
                               accept="image/*"
                               required
                               style="display: none;">
                        <p style="font-size: 12px; color: var(--muted, #a2b3c5); line-height: 1.45; margin: 0 0 12px 0;">
                            Upload a high-quality image for your post. This will be the main visual that appears in the feed.
                        </p>
                        <button type="button" onclick="document.getElementById('postImage').click()" 
                                style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; background: transparent; color: #cfe6dd; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.2s;">
                            <i class="fas fa-upload"></i> Choose Image
                        </button>
                        @error('image')
                            <p style="color: var(--error, #ff7a85); font-size: 12px; margin-top: 8px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Post Caption -->
            <div style="background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: var(--radius, 16px); box-shadow: var(--shadow, 0 12px 30px rgba(0,0,0,.35)); padding: 24px; margin-bottom: 24px;">
                <h3 style="font-size: 20px; font-weight: 600; color: var(--text, #e6edf3); margin: 0 0 16px 0;">Post Content</h3>
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #cfe6dd; margin-bottom: 8px;">
                        Caption <span style="color: var(--error, #ff7a85);">*</span>
                    </label>
                    <div style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; padding: 12px; transition: border-color 0.2s, box-shadow 0.2s;">
                        <textarea name="caption" 
                                  id="caption" 
                                  rows="6"
                                  required
                                  placeholder="What's on your mind? Share your thoughts, story, or experience..."
                                  style="width: 100%; background: transparent; border: 0; outline: 0; color: var(--text, #e6edf3); font: 14px/1.5 var(--font, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif); resize: vertical; min-height: 120px;">{{ old('caption') }}</textarea>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                        <p style="font-size: 12px; color: var(--muted, #a2b3c5); margin: 0;">Write an engaging caption for your post</p>
                        <span style="font-size: 12px; color: var(--muted, #a2b3c5);">
                            <span id="charCount" style="font-weight: 600; color: var(--primary, #14B8A6);">0</span> characters
                        </span>
                    </div>
                    @error('caption')
                        <p style="color: var(--error, #ff7a85); font-size: 12px; margin-top: 8px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Optional Product Link
            <div style="background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: var(--radius, 16px); box-shadow: var(--shadow, 0 12px 30px rgba(0,0,0,.35)); padding: 24px; margin-bottom: 24px;">
                <h3 style="font-size: 20px; font-weight: 600; color: var(--text, #e6edf3); margin: 0 0 16px 0;">Product Link (Optional)</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #cfe6dd; margin-bottom: 8px;">Link a Product</label>
                        <div style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; padding: 12px;">
                            <select name="product_id" style="width: 100%; background: transparent; border: 0; outline: 0; color: var(--text, #e6edf3); font: 14px/1.5 var(--font, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif);">
                                <option value="">No product linked</option>
                                @foreach(auth()->user()->products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} - ${{ $product->price }}</option>
                                @endforeach
                            </select>
                        </div>
                        <p style="font-size: 12px; color: var(--muted, #a2b3c5); margin: 8px 0 0 0;">Optionally link one of your products to this post</p>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; color: #cfe6dd; margin-bottom: 8px;">Location</label>
                        <div style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; padding: 12px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: var(--muted, #a2b3c5);"></i>
                            <input type="text" 
                                   name="location" 
                                   value="{{ old('location') }}"
                                   placeholder="Add a location"
                                   style="flex: 1; background: transparent; border: 0; outline: 0; color: var(--text, #e6edf3); font: 14px/1.2 var(--font, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif);">
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Action Buttons -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 1px solid var(--border, rgba(255,255,255,.1));">
    
    <!-- Cancel button on the left -->
    <a href="{{ route('feed.index') }}" 
       style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: transparent; color: #cfe6dd; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: all 0.2s;">
        <i class="fas fa-times"></i> Cancel
    </a>

    <!-- Buttons on the right -->
    <div style="display: flex; gap: 12px;">
        <button type="submit" name="status" value="published" 
                style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(180deg, var(--primary, #14B8A6), var(--primary-600, #0D9488)); color: #051d1a; border: none; border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 14px; box-shadow: 0 10px 24px rgba(20,184,166,.3); transition: all 0.2s;">
            <i class="fas fa-paper-plane"></i> Publish Post
        </button>
    </div>
</div>

        </form>
    </div>

    <script>
        // Image preview
        document.getElementById('postImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div style="position: relative;">
                            <img src="${e.target.result}" alt="Preview" style="width: 100%; height: 256px; border-radius: 12px; object-fit: cover; border: 1px solid var(--border, rgba(255,255,255,.1));">
                            <button type="button" onclick="removeImage()" style="position: absolute; top: 8px; right: 8px; background: var(--error, #ff7a85); border: none; color: white; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;
                    preview.style.padding = '0';
                };
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('postImage').value = '';
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = `
                <i class="fas fa-image" style="font-size: 48px; color: var(--muted, #a2b3c5); margin-bottom: 16px; display: block;"></i>
                <p style="color: var(--muted, #a2b3c5); font-size: 14px; margin: 0;">Click to upload image</p>
                <p style="color: var(--muted, #a2b3c5); font-size: 12px; margin: 8px 0 0 0;">Recommended: 1200x800px</p>`;
            preview.style.padding = '48px 24px';
        }

        // Character counter
        document.getElementById('caption').addEventListener('input', function(e) {
            document.getElementById('charCount').textContent = e.target.value.length;
        });
    </script>
</body>
</html>
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Laravel Course - Marketplace</title>
    <link href="{{ asset('css/products_show.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
 

    <!-- Navigation -->
    <nav class="nav">
        <div class="container">
            <div class="nav-content">
                <div class="nav-title">
                    <a href="/products" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1>Product Details</h1>
                </div>
     <div class="nav-actions" style="margin-left: auto; display: flex; align-items: center; gap: 12px;">
    @auth
        @if($product->user_id === auth()->id())
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn--secondary btn--small">
                <i class="fas fa-edit"></i> Edit
            </a>
        @endif
    @endauth

   
</div>





                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face"
                         alt="Profile" class="avatar">
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="padding-top: 32px; padding-bottom: 32px
 <div class="grid grid--two" style="gap: 32px; align-items: start;">
            <!-- Product Image -->
            <div>
                <div class="card" style="padding: 0; overflow: hidden;">
<img 
    src="{{ $product->image ? asset('images/' . $product->image) : asset('images/default-product.jpg') }}"
    alt="{{ $product->name }}"
    style="width: 100%; height: 400px; object-fit: cover;"
    onerror="this.onerror=null;this.src='{{ asset('images/default-product.jpg') }}';">
             </div>

                <!-- <div class="grid grid--three" style="margin-top: 16px;">
                    <div style="aspect-ratio: 1; background: #f8f9fa; border-radius: 6px; border: 1px solid #ddd;"></div>
                    <div style="aspect-ratio: 1; background: #f8f9fa; border-radius: 6px; border: 1px solid #ddd;"></div>
                    <div style="aspect-ratio: 1; background: #f8f9fa; border-radius: 6px; border: 1px solid #ddd;"></div>
                </div> -->
            </div>

            <!-- Product Info -->



            @php
    $inCart = auth()->check() 
        ? auth()->user()->cart?->items()->where('product_id', $product->id)->exists() 
        : false;
@endphp

            <div>
                <div class="card">
                    <div style="margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
<span class="badge badge--category">{{ $product->category }}</span>
                              <!-- <div class="rating">
                                <i class="fas fa-star rating-stars"></i>
                                <span>4.8 (124 reviews)</span>
                            </div> -->
                        </div>
                        <h1 style="margin-bottom: 16px;">{{ $product->name }}</h1>

                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" class="avatar">
                            <div>
                                <p style="font-weight: 600; margin: 0;">{{ $product->user->name }}</p>
                                <p class="hint" style="margin: 0;">{{ $product->sales_count }} sales • Member since 2020</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <span style="font-size: 28px; font-weight: 600; color: #4f46e5;">${{ $product->price }}</span>
                            <span class="badge {{ $product->in_stock ? 'badge--published' : 'badge--draft' }}">
                                {{ $product->in_stock ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>

          @if($product->in_stock)
    <button id="cart-btn" class="btn btn--primary btn--large" data-id="{{ $product->id }}">
        <i class="fas fa-shopping-cart"></i>
        <span id="cart-btn-text">
            {{ $inCart ? 'Remove from Cart' : 'Add to Cart' }}
        </span>
    </button>
@else
    <button class="btn btn--disabled btn--large" disabled>
        <i class="fas fa-shopping-cart"></i> Out of Stock
    </button>
@endif




                        <!-- <button class="btn btn--secondary btn--icon btn--large">
                            <i class="fas fa-heart"></i>
                        </button>
                        <button class="btn btn--secondary btn--icon btn--large">
                            <i class="fas fa-share-alt"></i>
                        </button> -->
                    </div>

                    <div>
                        <h3 style="margin-bottom: 16px;">Tags</h3>
                        @php $tags = explode(',', $product->tags); @endphp
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach($tags as $tag)
                                <span class="badge badge--category">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card" style="margin-top: 32px;">
            <h2 style="margin-bottom: 24px;">Product Description</h2>
            <div class="lead" style="line-height: 1.6;">{{ $product->description }}</div>
        </div>
    </div>


   <!-- Toast container -->
<div id="cart-toast" style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #4f46e5;
    color: white;
    padding: 12px 20px;
    border-radius: 6px;
    display: none;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
"></div>

<script>
const btn = document.getElementById('cart-btn');
const toast = document.getElementById('cart-toast');

function showToast(message) {
    toast.innerText = message;
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 2000); // disappears after 2 seconds
}

if(btn){
    btn.addEventListener('click', async () => {
        const productId = btn.dataset.id;

        const res = await fetch(`/cart/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        // Show toast instead of alert
        showToast(data.message);

        // Update button text
        document.getElementById('cart-btn-text').innerText =
            data.status === 'added' ? 'Remove from Cart' : 'Add to Cart';

        // Optionally update cart count in header
        const cartCount = document.getElementById('cart-count');
        if(cartCount){
            let count = parseInt(cartCount.innerText);
            count = data.status === 'added' ? count + 1 : count - 1;
            cartCount.innerText = count;
        }
    });
}
</script>

</body>
</html>

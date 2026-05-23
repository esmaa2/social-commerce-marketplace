@extends('layouts.base')

@section('main_content')


<!-- Header -->
<div class="header d-flex align-items-center justify-content-between mb-4">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <h1 class="title" style="font-size: clamp(22px, 3.4vw, 32px); margin: 0; color: var(--text, #e6edf3);">
        Marketplace
    </h1>

    <div class="actions d-flex gap-3 align-items-center">
        <!-- Back to Feed -->
        <a href="{{ url('/') }}" class="btn btn-primary" 
           style="background: linear-gradient(180deg, var(--primary, #14B8A6), var(--primary-600, #0D9488)); color: #051d1a; border-color: transparent;">
            <i class="bi bi-arrow-left"></i> Back to Feed
        </a>

        <!-- Add Product -->
        <a href="/products/create" class="btn btn-primary" 
           style="background: linear-gradient(180deg, var(--primary, #14B8A6), var(--primary-600, #0D9488)); color: #051d1a; border-color: transparent;">
            <i class="bi bi-plus"></i> Add Product
        </a>

        <!-- Cart Icon -->
       <a href="{{ route('cart.index', ['user' => auth()->id()]) }}" 
   class="btn btn-primary position-relative"
   style="background: linear-gradient(180deg, var(--primary, #14B8A6), var(--primary-600, #0D9488)); color: #051d1a; border-color: transparent;">
    <i class="bi bi-cart3"></i> Cart
    @if(session('cart') && count(session('cart')) > 0)
        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle"
              style="font-size: 10px; border-radius: 50%;">
              {{ count(session('cart')) }}
        </span>
    @endif
</a>


        <!-- User Avatar -->
        <a href="{{ route('profile.show') }}">
            <img src="{{ Auth::user()?->avatar_path 
                ? asset('storage/' . Auth::user()->avatar_path) 
                : asset('images/default-avatar.png') }}" 
                 alt="Profile" 
                 class="rounded-circle" 
                 style="width: 32px; height: 32px; border: 1px solid var(--border, rgba(255,255,255,.1)); object-fit: cover;">
        </a>
    </div>
</div>


<!-- Filters -->
<div class="card mb-4" style="background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: var(--radius, 16px); box-shadow: var(--shadow, 0 12px 30px rgba(0,0,0,.35)); transition: none;">
    <div class="card-body p-3">
        <form class="form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; align-items: end;">
            <div>
                <x-input-label for="search" :value="__('Search')" style="color: #cfe6dd; font-size: 13px;" />
                <div class="field" style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; display: flex; align-items: center; gap: 10px; padding: 10px 12px; transition: border-color .2s, box-shadow .2s, background .2s;">
                <x-text-input type="text" id="search" placeholder="Search products..."  style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; color: var(--text, #e6edf3); font: 14px/1.2 var(--font, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif); min-width: 0; padding: 10px 12px; outline: 0; transition: border-color 0.2s, box-shadow 0.2s; box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2) inset; -webkit-text-fill-color: var(--text, #e6edf3); -webkit-background-clip: text;" />                </div>
            </div>
            <div>
                <x-input-label for="category" :value="__('Category')" style="color: #cfe6dd; font-size: 13px;" />
                <div class="field" style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; display: flex; align-items: center; gap: 10px; padding: 10px 12px; transition: border-color .2s, box-shadow .2s, background .2s;">
                    <select id="category" class="form-select" style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; color: var(--text, #e6edf3); font: 14px/1.2 var(--font, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif); min-width: 0; flex: 1; appearance: none; -webkit-appearance: none; -moz-appearance: none; padding: 10px 12px; outline: 0; transition: border-color 0.2s, box-shadow 0.2s; box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2) inset;">
                        <option value="all" style="background: #0b131c; color: var(--text, #e6edf3);">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}" style="background: #0b131c; color: var(--text, #e6edf3);">{{ $cat['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <x-input-label for="sort" :value="__('Sort')" style="color: #cfe6dd; font-size: 13px;" />
                <div class="field" style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; display: flex; align-items: center; gap: 10px; padding: 10px 12px; transition: border-color .2s, box-shadow .2s, background .2s;">
                    <select id="sort" class="form-select" style="background: #0b131c; border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 12px; color: var(--text, #e6edf3); font: 14px/1.2 var(--font, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif); min-width: 0; flex: 1; appearance: none; -webkit-appearance: none; -moz-appearance: none; padding: 10px 12px; outline: 0; transition: border-color 0.2s, box-shadow 0.2s; box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2) inset;">
                        <option value="newest" style="background: #0b131c; color: var(--text, #e6edf3);">Newest First</option>
                        <option value="price_low" style="background: #0b131c; color: var(--text, #e6edf3);">Price: Low to High</option>
                        <option value="price_high" style="background: #0b131c; color: var(--text, #e6edf3);">Price: High to Low</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Container -->
<div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
    @foreach ($products as $product)
        <div class="card" style="width: 100%; max-width: 350px; min-height: 420px; background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: var(--radius, 16px); box-shadow: var(--shadow, 0 12px 30px rgba(0,0,0,.35)); overflow: hidden; display: flex; flex-direction: column; transition: box-shadow 0.3s ease, transform 0.3s ease;">
            <!-- Product Image -->
            <img 
                src="{{ $product->image ? asset('images/' . $product->image) : asset('images/default-product.jpg') }}" 
                alt="{{ $product->name }}" 
                style="width: 100%; height: 192px; object-fit: cover; border-bottom: 1px solid var(--border, rgba(255,255,255,.1));"
                onerror="this.onerror=null;this.src='{{ asset('images/default-product.jpg') }}';">
            
            <div class="card-body" style="padding: 22px 26px 16px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <!-- Product Name -->
                    <h3 class="title card-title" style="font-size: clamp(16px, 2.0vw, 18px); margin-bottom: 8px; color: var(--text, #e6edf3); font-weight: 600; line-height: 1.35; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        {{ $product->name }}
                    </h3>

                    <!-- Product Description -->
                    <p class="product-description" style="margin: 0; color: var(--text, #e6edf3); overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; max-height: 72px; font-size: 14px; line-height: 1.4;">
                        {{ $product->description }}
                    </p>
                </div>

                <div class="actions d-flex justify-content-between align-items-center" style="margin-top: 16px; padding-top: 10px; border-top: 1px solid var(--border, rgba(255,255,255,.1)); padding-bottom: 15px;">
                    <span class="product-price" style="font-size: 18px; font-weight: 600; color: var(--text, #e6edf3);">
                        ${{ number_format($product->price, 2) }}
                    </span>

                    <!-- View button -->
                    <a href="{{ route('products.show', $product->id) }}" 
                       class="btn btn-primary" 
                       style="background: linear-gradient(180deg, var(--primary, #14B8A6), var(--primary-600, #0D9488)); color: #051d1a; border-color: transparent; padding: 8px 16px; display: inline-flex; align-items: center; gap: 10px; transition: box-shadow 0.3s ease, transform 0.3s ease;">
                        <i class="bi bi-eye"></i> View
                    </a>
                </div>

                <div style="height: 10px; background: transparent;"></div> <!-- Spacer -->
            </div>
        </div>
    @endforeach
</div>
@endsection


<!-- Chat Widget -->
<!-- Chat Widget -->
<div id="chat-widget" class="minimized">
    <div id="chat-header">
        AI Chat <span id="chat-toggle">_</span>
    </div>
    <div id="chat-body"></div>
    <input type="text" id="chat-input" placeholder="Ask me about products...">
</div>

<!-- Styles -->
<!-- Styles -->
<style>
/* Chat Widget Container */
/* Chat Widget Container */
#chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 300px;
    height: 400px;
    border: 1px solid #0f1720; /* card color */
    border-radius: 12px;
    background: #0f1720; /* card background */
    display: flex;
    flex-direction: column;
    font-family: Arial, sans-serif;
    z-index: 1000;
    transition: height 0.3s ease, width 0.3s ease;
    color: #e6edf3; /* primary text */
    cursor: pointer; /* allow click anywhere */
}

/* Minimized */
#chat-widget.minimized {
    height: 50px;
    width: 220px;
}

/* Header */
#chat-header {
    background: #14B8A6; /* primary teal */
    color: #0c1116; /* dark text */
    padding: 10px;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 500;
}

/* Toggle Button */
#chat-toggle {
    font-weight: bold;
}

/* Chat Body */
#chat-body {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    background: #0c1116; /* app background */
    color: #e6edf3;
}

/* Messages */
#chat-body .message {
    margin: 5px 0;
    padding: 8px 12px;
    border-radius: 12px;
    max-width: 80%;
}

/* User message */
#chat-body .user {
    background: #14B8A6; /* primary teal */
    color: #0c1116; /* dark text */
    align-self: flex-end;
}

/* Bot message */
#chat-body .bot {
    background: #0f1720; /* card background */
    color: #e6edf3; /* primary text */
    align-self: flex-start;
}

/* Input */
#chat-input {
    border: none;
    border-top: 1px solid #0D9488; /* primary-600 */
    padding: 10px;
    width: 100%;
    box-sizing: border-box;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
    background: #0f1720; /* card */
    color: #e6edf3;
}

/* Hide body and input when minimized */
#chat-widget.minimized #chat-body,
#chat-widget.minimized #chat-input {
    display: none;
}

</style>


<!-- Script -->
<script>
const chatWidget = document.getElementById('chat-widget');
const chatBody = document.getElementById('chat-body');
const chatInput = document.getElementById('chat-input');
const chatToggle = document.getElementById('chat-toggle');

// Open/close chat by clicking anywhere on header or minimized widget
chatWidget.addEventListener('click', function(e) {
    if(e.target.id !== 'chat-input') { // ignore typing clicks
        chatWidget.classList.toggle('minimized');
        chatToggle.textContent = chatWidget.classList.contains('minimized') ? '_' : '✖';
    }
});

// Send message on Enter
chatInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && chatInput.value.trim() !== '') {
        const userMessage = chatInput.value;
        addMessage(userMessage, 'user');
        chatInput.value = '';

        fetch('/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: userMessage })
        })
        .then(res => res.json())
        .then(data => addMessage(data.reply, 'bot'))
    
        
        .catch(async err => {  // make it async
    console.error(err);

    let errorMsg = "Sorry, I can't respond right now.";

    // Try to extract JSON error if possible
    if (err.json) {
        try {
            const data = await err.json();
            if (data.reply) errorMsg = data.reply;
        } catch {}
    }

    addMessage(errorMsg, 'bot');
});

    }
});

function addMessage(message, sender) {
    const msgDiv = document.createElement('div');
    msgDiv.classList.add('message', sender);
    msgDiv.textContent = message;
    chatBody.appendChild(msgDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
}

</script>



<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput    = document.getElementById('search');
    const categorySelect = document.getElementById('category');
    const sortSelect     = document.getElementById('sort');
    const productsGrid   = document.querySelector('.products-grid'); // make sure your products container has this class

    // Fetch products from backend
    async function fetchProducts() {
        const params = new URLSearchParams({
            search: searchInput.value,
            category: categorySelect.value,
            sort: sortSelect.value,
        });

        try {
            const res = await fetch('/products/search?' + params.toString());
            const products = await res.json();
            renderProducts(products);
        } catch (err) {
            console.error(err);
            productsGrid.innerHTML = '<p style="color:#e6edf3;">Failed to load products.</p>';
        }
    }

    // Render products dynamically
    function renderProducts(products) {
        productsGrid.innerHTML = '';
        if (!products.length) {
            productsGrid.innerHTML = '<p style="color:#e6edf3;">No products found.</p>';
            return;
        }

        products.forEach(product => {
            const img = product.image ? `/images/${product.image}` : '/images/default-product.jpg';
            const card = `
                <div class="card" style="width: 280px; height: 420px; background: color-mix(in srgb, var(--card, #0f1720) 92%, black 8%); border: 1px solid var(--border, rgba(255,255,255,.1)); border-radius: 16px; display:flex; flex-direction:column; margin-bottom:20px;">
                    <img src="${img}" alt="${product.name}" style="width:100%; height:192px; object-fit:cover; border-bottom:1px solid var(--border, rgba(255,255,255,.1));">
                    <div class="card-body" style="padding:22px 26px 16px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">
                        <h3 style="font-size:18px; margin-bottom:8px; color:var(--text,#e6edf3); overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${product.name}</h3>
                        <p style="margin:0; color:var(--text,#e6edf3); overflow:hidden; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical;">${product.description ?? ''}</p>
                        <div class="actions d-flex justify-content-between align-items-center" style="margin-top:16px; border-top:1px solid var(--border, rgba(255,255,255,.1)); padding-top:10px;">
                            <span style="font-size:18px; font-weight:600; color:var(--text,#e6edf3);">$${Number(product.price).toFixed(2)}</span>
                            <a href="/products/${product.id}" class="btn btn-primary" style="background:linear-gradient(180deg, var(--primary,#14B8A6), var(--primary-600,#0D9488)); color:#051d1a; border-color:transparent; padding:8px 16px;">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            `;
            productsGrid.insertAdjacentHTML('beforeend', card);
        });
    }

    // Event listeners
    searchInput.addEventListener('input', debounce(fetchProducts, 300));
    categorySelect.addEventListener('change', fetchProducts);
    sortSelect.addEventListener('change', fetchProducts);

    // Initial load
    fetchProducts();

    // Debounce helper to prevent too many requests
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }
});
</script>


</body>
</html>

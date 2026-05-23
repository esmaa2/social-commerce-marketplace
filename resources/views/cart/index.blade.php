<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart - NotFbMarketplace</title>
  @vite(['resources/css/cart.css'])
</head>

<body>
<div class="app-container">

  <!-- Header -->
  <header class="header">
    <div class="brand">
      <div class="logo" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round" />
          <rect x="4" y="7" width="16" height="14" rx="3" stroke="white" stroke-width="2" />
        </svg>
      </div>
      NotFbMarketplace
    </div>

    <div class="user-profile">
      <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'GU', 0, 2)) }}</div>
      <div>
        <div style="font-size: 14px; font-weight: 600;">{{ auth()->user()->name ?? 'Guest User' }}</div>
        <div class="small">{{ auth()->check() ? 'Member' : 'Browsing as Guest' }}</div>
      </div>
    </div>
  </header>

  <main class="main-content">
    <div class="cart-content">

      <!-- Shopping Cart -->
      <div class="card">
        <div class="card-header">
          <h2 class="title">Shopping Cart</h2>
          <p class="subtitle"><span id="cart-count">{{ $cart->items->count() }}</span> items in your cart</p>
        </div>

        <div class="cart-items" id="cart-items">
          @forelse($cart->items as $item)
            <div class="cart-item">
<img 
    src="{{ $item->product->image ? asset('images/' . $item->product->image) : asset('images/default-product.png') }}" 
    alt="{{ $item->product->name }}" 
    class="cart-item-img"
/>

              <div class="cart-item-details">
                <h4>{{ $item->product->name }}</h4>
                <p>${{ number_format($item->product->price, 2) }}</p>

                <!-- <form action="{{ route('cart.update', $item->product->id) }}" method="POST">
                  @csrf
                  <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width:60px;">
                  <button type="submit" class="btn btn-sm btn-info">Update</button>
                </form> -->

                <form action="{{ route('cart.remove', $item->product->id) }}" method="POST" style="display:inline;">
  @csrf
  @method('DELETE')
  <button type="submit" class="remove-btn" aria-label="Remove item">✕</button>
</form>

              </div>
            </div>
          @empty
            <p>Your cart is empty.</p>
          @endforelse
        </div>
      </div>
    </div>

    <!-- Sidebar Summary -->
    <div class="cart-sidebar">
      <div class="card cart-summary">
        <div class="card-header">
          <h3 class="title">Order Summary</h3>
        </div>
        <div class="card-body">
          <div class="summary-row">
            <span>Subtotal</span>
            <span id="subtotal">${{ number_format($subtotal, 2) }}</span>
          </div>
          <div class="summary-row">
            <span>Shipping</span>
            <span id="shipping">${{ number_format($shipping, 2) }}</span>
          </div>
          <div class="summary-row">
            <span>Tax</span>
            <span id="tax">${{ number_format($tax, 2) }}</span>
          </div>
          <div class="summary-row">
            <span>Total</span>
            <span id="total">${{ number_format($total, 2) }}</span>
          </div>

      @if($cart->items->count())
    <a href="{{ route('checkout') }}" class="checkout-btn btn btn-primary">
        <span class="btn-text">Proceed to Checkout</span>
    </a>
@endif


        </div>
      </div>
    </div>
  </main>

</div>

@vite(['resources/js/cart_UI.js'])
</body>
</html>

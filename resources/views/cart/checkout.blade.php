<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Pay with Visa — NotFbMarketplace</title>
@vite(['resources/css/checkout.css', 'resources/js/checkout.js'])

</head>
<body>
  <!-- Header -->
  <header class="site-header" aria-label="Site">
    <a class="logo-top" href="{{ url('/') }}" aria-label="Home">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round"/>
        <rect x="4" y="7" width="16" height="14" rx="3" stroke="white" stroke-width="2"/>
      </svg>
      <span>NotFbMarketplace</span>
    </a>
    <nav class="topnav" aria-label="Primary">
      <a href="{{ route('cart.index') }}">Cart</a>
      <a href="{{ route('orders.index') }}">Orders</a>
      @guest
        <a class="pill" href="{{ route('login') }}">Sign in</a>
      @else
        <span class="pill">{{ Auth::user()->name }}</span>
      @endguest
    </nav>
  </header>

  <main class="page">
    <h1>Checkout</h1>

    <section class="layout">
      <!-- Payment form -->
<form id="payForm" method="POST" action="{{ route('checkout.process') }}">
  @csrf

        <h2 class="section-title">Payment (Visa only)</h2>
        <p class="disclaimer">
          Demo only — do <strong>not</strong> enter real card details. In production use Stripe/Adyen/etc.
        </p>

        <div class="grid">
          <label>
            <span>Cardholder name *</span>
            <div class="field">
              <input id="name" name="name" autocomplete="cc-name" placeholder="Sara Ali" required>
            </div>
          </label>

          <label>
  <span>Card number (Visa) *</span>
  <div class="field">
    <input id="card" name="card" inputmode="numeric" autocomplete="cc-number"
           placeholder="4xxx xxxx xxxx xxxx" maxlength="19" required>
    <div id="brand" class="brand">VISA</div>
    <div id="cardErr" class="error-msg"></div>
  </div>
</label>

<label>
  <span>Expiry (MM/YY) *</span>
  <div class="field">
    <input id="exp" name="exp" inputmode="numeric" autocomplete="cc-exp" placeholder="MM/YY" maxlength="5" required>
    <div id="expErr" class="error-msg"></div>
  </div>
</label>


          <label>
            <span>CVV *</span>
            <div class="field">
              <input id="cvv" name="cvv" inputmode="numeric" autocomplete="cc-csc" placeholder="CVC" maxlength="3" required>
            </div>
          </label>

          <label>
            <span>Email for receipt *</span>
            <div class="field">
              <input id="email" name="email" type="email" autocomplete="email" placeholder="you@example.com" required value="{{ Auth::user()->email ?? '' }}">
            </div>
          </label>

          <label>
            <span>Billing address (optional)</span>
            <div class="field">
              <input id="addr" name="addr" autocomplete="address-line1" placeholder="Street, City, Country">
            </div>
          </label>
        </div>


        

        <div class="actions">
    <a class="btn btn-ghost" href="{{ route('cart.index') }}">Back to cart</a>
    <button id="payBtn" class="btn btn-primary" type="submit" data-label="Pay €{{ number_format($total, 2) }}">
  Pay €{{ number_format($total, 2) }}
</button>


  </div>
</form>

      <!-- Order summary -->
      <aside class="card summary" aria-labelledby="sumTitle">
        <h2 id="sumTitle" class="section-title">Order summary</h2>
        <div id="sumList" class="sum-list">
          @foreach($cart->items as $item)
            <div class="sum-item">
              <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
              <strong>€{{ number_format($item->product->price * $item->quantity, 2) }}</strong>
            </div>
          @endforeach
        </div>
        <div class="sum-line">
          <span>Subtotal</span><strong id="sumSubtotal">€{{ number_format($subtotal, 2) }}</strong>
        </div>
        <div class="sum-line">
          <span>Shipping</span><strong>€{{ number_format($shipping, 2) }}</strong>
        </div>
        <div class="sum-line total">
          <span>Total</span><strong id="sumTotal">€{{ number_format($total, 2) }}</strong>
        </div>
      </aside>
    </section>
  </main>

</body>
</html>

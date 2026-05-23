<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
@vite(['resources/css/payment.css', 'resources/js/payment.js'])
  <title>Order Status</title>
  
</head>
<body>
  <div class="shell">
    <div class="card" role="region" aria-labelledby="title">
      <div class="header">
      <div class="logo" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M7 7V6a5 5 0 1 1 10 0v1" stroke="white" stroke-width="2" stroke-linecap="round"/>
              <rect x="4" y="7" width="16" height="14" rx="3" stroke="white" stroke-width="2"/>
            </svg>
          </div>
        <h1 class="title" id="title">Your payment was received.</h1>
        <p class="subtitle">We’re processing your order now.</p>
        <div class="status" id="statusChip"><span class="dot info"></span><span id="statusText">Processing</span></div>
      </div>

      <div class="body">
        <div class="grid">
       <section class="panel" aria-labelledby="orderSummaryTitle">
  <h3 id="orderSummaryTitle">Order summary</h3>
  <div class="kv"><div class="muted">Order #</div><div id="orderNo">{{ $order->id }}</div></div>
  <div class="kv"><div class="muted">Payment method</div><div id="payMethod">Visa</div></div>
  <div class="kv"><div class="muted">Items (lines)</div><div id="itemsCount">{{ $order->items->count() }}</div></div>
  <div class="kv"><div class="muted">Total quantity</div><div id="totalQty">{{ $order->items->sum('quantity') }}</div></div>
  <div class="kv"><div class="muted">Subtotal</div><div id="subtotal">€{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity),2) }}</div></div>
  <div class="kv"><div class="muted">Shipping</div><div id="shipping">€10.00</div></div>
  <div class="kv"><div class="muted">Tax</div><div id="tax">€{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity) * 0.15,2) }}</div></div>
  <div class="kv"><div class="muted"><strong>Total</strong></div><div id="grandTotal"><strong>€{{ number_format($order->total_amount,2) }}</strong></div></div>
</section>


          <section class="panel" aria-labelledby="itemsTitle">
            <h3 id="itemsTitle">Items</h3>
            <div class="items" id="itemsList" aria-live="polite"></div>
          </section>
        </div>
      </div>

      <div class="footer">
  <div class="note">A receipt was sent to <span id="buyerEmail" class="muted">{{ auth()->user()->email }}</span>.</div>
        <div class="actions">
          <a class="btn" href="/" id="continueBtn">Continue shopping</a>
          <a class="btn primary" href="#" id="trackBtn">Track order</a>
        </div>
      </div>
    </div>
  </div>

  <script src="js.js">
 
   
  </script>


</body>
</html>
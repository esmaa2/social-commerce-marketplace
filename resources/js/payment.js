
  // ===== Mock data (replace with your server payload) =====
  window.ORDER_DATA = {
    orderNumber: "MG-2025-100173",
    buyerEmail: "customer@example.com",
    paymentMethod: "mastercard", // visa|mastercard|paypal|stripe|applepay|googlepay|cash
    status: "pending",           // pending|paid|shipped|delivered|cancelled
    currency: "EUR",
    amounts: { subtotal: 79.98, shipping: 4.99, tax: 6.40, total: 91.37 },
    items: [
      { name: "Classic Tee — Black / L", quantity: 1, price: 29.99 },
      { name: "Embroidered Cap — Navy", quantity: 2, price: 24.99 }
    ],
    links: { track: "/orders/MG-2025-100173", continue: "/" }
  };

  // --- Inline wordmarks as STRING SVGs (no JSX) ---
  const PAYMARKS = {
    visa: () => `
      <svg viewBox="0 0 120 24" xmlns="http://www.w3.org/2000/svg" aria-label="VISA">
        <text x="0" y="17" font-size="18" font-weight="800" font-family="system-ui">VISA</text>
      </svg>`,
    mastercard: () => `
      <svg viewBox="0 0 120 24" xmlns="http://www.w3.org/2000/svg" aria-label="Mastercard">
        <circle cx="28" cy="12" r="8" fill="#ea001b"></circle>
        <circle cx="38" cy="12" r="8" fill="#ff5f00"></circle>
        <text x="52" y="17" font-size="12" font-weight="700" font-family="system-ui">mastercard</text>
      </svg>`,
    paypal: () => `
      <svg viewBox="0 0 140 24" xmlns="http://www.w3.org/2000/svg" aria-label="PayPal">
        <text x="0" y="17" font-size="16" font-weight="800" font-family="system-ui">Pay</text>
        <text x="40" y="17" font-size="16" font-weight="800" font-family="system-ui">Pal</text>
      </svg>`,
    stripe: () => `
      <svg viewBox="0 0 120 24" xmlns="http://www.w3.org/2000/svg" aria-label="Stripe">
        <text x="0" y="17" font-size="16" font-weight="800" font-family="system-ui">stripe</text>
      </svg>`,
    applepay: () => `
      <svg viewBox="0 0 140 24" xmlns="http://www.w3.org/2000/svg" aria-label="Apple Pay">
        <circle cx="10" cy="12" r="6"></circle>
        <text x="24" y="17" font-size="16" font-weight="800" font-family="system-ui">Pay</text>
      </svg>`,
    googlepay: () => `
      <svg viewBox="0 0 160 24" xmlns="http://www.w3.org/2000/svg" aria-label="Google Pay">
        <text x="0" y="17" font-size="16" font-weight="800" font-family="system-ui">G</text>
        <text x="14" y="17" font-size="16" font-family="system-ui">oogle</text>
        <text x="64" y="17" font-size="16" font-weight="800" font-family="system-ui">Pay</text>
      </svg>`,
    cash: () => `
      <svg viewBox="0 0 120 24" xmlns="http://www.w3.org/2000/svg" aria-label="Cash">
        <rect x="0" y="4" width="40" height="16" rx="3" ry="3" fill="currentColor" opacity=".2"></rect>
        <text x="48" y="17" font-size="14" font-weight="700" font-family="system-ui">Cash</text>
      </svg>`
  };

  // --- Status (restricted to 5) ---
  const ALLOWED_STATUSES = ["pending","paid","shipped","delivered","cancelled"];
  const STATUS_META = {
    pending:   { label: "Pending",   tone: "warn", subtitle: "We’ve received your order and it’s awaiting confirmation." },
    paid:      { label: "Paid",      tone: "ok",   subtitle: "Payment confirmed. We’re preparing your order." },
    shipped:   { label: "Shipped",   tone: "info", subtitle: "Your order is on the way." },
    delivered: { label: "Delivered", tone: "ok",   subtitle: "Package delivered." },
    cancelled: { label: "Cancelled", tone: "bad",  subtitle: "This order was cancelled." }
  };
  const normalizeStatus = (s) => {
    s = String(s || "").toLowerCase();
    return ALLOWED_STATUSES.includes(s) ? s : "pending";
  };

  const fmtMoney = (n, ccy) =>
    new Intl.NumberFormat(undefined, { style: "currency", currency: ccy || "USD" }).format(n);

  function renderOrder(){
    const d = window.ORDER_DATA || {};

    // Logo
    const mark = (PAYMARKS[(d.paymentMethod || "").toLowerCase()] || PAYMARKS.cash)();
    document.getElementById("paymark").innerHTML = mark;

    // Heading + status
    const normStatus = normalizeStatus(d.status);
    const sm = STATUS_META[normStatus];
    document.getElementById("statusText").textContent = sm.label;
    const dot = document.querySelector(".status .dot");
    dot.className = `dot ${sm.tone}`;
    document.querySelector(".subtitle").textContent = sm.subtitle;

    // Summary
    document.getElementById("orderNo").textContent = d.orderNumber || "—";
    document.getElementById("payMethod").textContent = (d.paymentMethod || "").toUpperCase() || "—";
    document.getElementById("buyerEmail").textContent = d.buyerEmail || "your email";

    const items = Array.isArray(d.items) ? d.items : [];
    document.getElementById("itemsCount").textContent = items.length;
    const totalQty = items.reduce((acc, it) => acc + (Number(it.quantity) || 0), 0);
    document.getElementById("totalQty").textContent = totalQty;

    const c = d.currency || "USD";
    const a = d.amounts || {};
    document.getElementById("subtotal").textContent = (a.subtotal != null) ? fmtMoney(a.subtotal, c) : "—";
    document.getElementById("shipping").textContent = (a.shipping != null) ? fmtMoney(a.shipping, c) : "—";
    document.getElementById("tax").textContent      = (a.tax != null)      ? fmtMoney(a.tax, c)      : "—";
    document.getElementById("grandTotal").innerHTML = `<strong>${(a.total != null) ? fmtMoney(a.total, c) : "—"}</strong>`;

    // Items
    const list = document.getElementById("itemsList");
    if (!items.length) {
      list.innerHTML = `<div class="muted">No items.</div>`;
    } else {
      list.innerHTML = items.map(it => {
        const name = it.name || "Item";
        const qty  = Number(it.quantity) || 0;
        const price = (it.price != null) ? fmtMoney(it.price, c) : "—";
        const line  = (it.price != null) ? fmtMoney(it.price * qty, c) : "—";
        return `
          <div class="item">
            <div>
              <h4>${name}</h4>
              <small>${price} × ${qty}</small>
            </div>
            <div class="qty">${line}</div>
          </div>`;
      }).join("");
    }

    // Links
    const track = document.getElementById("trackBtn");
    const cont  = document.getElementById("continueBtn");
    if (d.links && d.links.track) track.href = d.links.track;
    if (d.links && d.links.continue) cont.href = d.links.continue;

    // Hide "Track order" if cancelled
    if (normStatus === "cancelled") track.style.display = "none";
  }

  // If server passed JSON as string, parse it
  (function ensureObject(){
    if (typeof window.ORDER_DATA === "string") {
      try { window.ORDER_DATA = JSON.parse(window.ORDER_DATA); } catch(_){}
    }
  })();

  renderOrder();


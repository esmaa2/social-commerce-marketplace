// resources/js/checkout.js

// ---- Helpers ----
function onlyDigits(str) {
  return (str || '').replace(/\D+/g, '');
}

function luhnOk(numStr) {
  let sum = 0,
    alt = false;
  for (let i = numStr.length - 1; i >= 0; i--) {
    let n = Number(numStr[i]);
    if (alt) {
      n *= 2;
      if (n > 9) n -= 9;
    }
    sum += n;
    alt = !alt;
  }
  return sum % 10 === 0;
}

function isVisa(numStr) {
  return /^4\d{12,18}$/.test(numStr);
}

function formatCardValue(raw) {
  const d = onlyDigits(raw).slice(0, 19);
  return d.replace(/(\d{4})(?=\d)/g, '$1 ').trim();
}

function formatExpValue(raw) {
  const d = onlyDigits(raw).slice(0, 4);
  if (d.length <= 2) return d;
  return d.slice(0, 2) + '/' + d.slice(2);
}

function expValid(mmYY) {
  const m = mmYY.match(/^(\d{2})\/(\d{2})$/);
  if (!m) return false;
  const mm = Number(m[1]),
    yy = Number(m[2]);
  if (mm < 1 || mm > 12) return false;
  const year = 2000 + yy;
  const now = new Date();
  const expEnd = new Date(year, mm, 0, 23, 59, 59, 999);
  return expEnd >= now;
}

// ---- Form logic ----
window.addEventListener("load", () => {
  const form = document.getElementById('payForm');
  if (!form) {
    console.error("Form #payForm not found!");
    return;
  }
  console.log("Form found, attaching submit listener");

  const nameI = document.getElementById('name');
  const cardI = document.getElementById('card');
  const expI = document.getElementById('exp');
  const cvvI = document.getElementById('cvv');
  const emailI = document.getElementById('email');
  const payBtn = document.getElementById('payBtn');
  const cardErr = document.getElementById('cardErr');
  const expErr = document.getElementById('expErr');

  // Format card number on input
  cardI.addEventListener("input", () => {
    cardI.value = formatCardValue(cardI.value);
  });

  // Format expiry date on input
  expI.addEventListener("input", () => {
    expI.value = formatExpValue(expI.value);
  });

  // Submit handler
  form.addEventListener('submit', (e) => {
    e.preventDefault(); // prevent auto submit until checks are ok
    console.log("Submit triggered");

    payBtn.disabled = true;
    payBtn.textContent = 'Processing…';

    let bad = false;
    const mark = (el, msg, errEl) => {
      el.closest('label').classList.add('is-invalid');
      if (errEl) errEl.textContent = msg;
      bad = true;
      console.warn("Validation failed:", msg);
    };

    // Reset errors
    [cardErr, expErr].forEach(el => el.textContent = '');
    document.querySelectorAll('label').forEach(l => l.classList.remove('is-invalid'));

    // Validate fields
    if (!nameI.value.trim()) mark(nameI, "Name required");
    if (!/^\d{3}$/.test(cvvI.value)) mark(cvvI, "CVV must be 3 digits");
    if (!emailI.checkValidity()) mark(emailI, "Invalid email");

    const cardNum = onlyDigits(cardI.value);
    if (!isVisa(cardNum) || !luhnOk(cardNum)) {
      mark(cardI, "Invalid Visa card number", cardErr);
    }

    if (!expValid(expI.value)) {
      mark(expI, "Invalid expiry date", expErr);
    }

    if (bad) {
      payBtn.disabled = false;
      payBtn.textContent = payBtn.dataset.label || 'Pay';
      return;
    }

    console.log("All checks passed → submitting form");
    form.submit();
  });
});

// Cart Data, if they don't appear open developer tools on chrome -> console -> paste this localStorage.removeItem('cart'); location.reload();



// Wishlist
let wishlist = new Set([2]);

// Initialize the cart
function initCart() {
    renderCartItems();
    updateCartSummary();
    updateCartCount();
}

// Render cart items
function renderCartItems() {
    const container = document.getElementById('cart-items');
    
    if (cartData.length === 0) {
        container.innerHTML = `
            <div class="empty-cart">
                <h3>Your cart is empty</h3>
                <p>Add some items to get started!</p>
            </div>
        `;
        return;
    }

    container.innerHTML = cartData.map(item => `
        <div class="cart-item" data-id="${item.id}">
            <button class="wishlist-btn ${wishlist.has(item.id) ? 'active' : ''}" 
                    onclick="toggleWishlist(${item.id})" 
                    aria-label="Add to wishlist">
                ❤️
            </button>
            <button class="remove-btn" onclick="removeItem(${item.id})" aria-label="Remove item">
                ✕
            </button>
            
            <div class="item-image">${item.image}</div>
            
            <div class="item-info">
                <h4 class="item-name">${item.name}</h4>
                <div class="item-seller">
                    <span>by ${item.seller}</span>
                </div>
                <div class="item-rating">
                    <span class="stars">★★★★★</span>
                    <span>${item.rating}</span>
                    <span class="small">(${item.reviews.toLocaleString()})</span>
                </div>
                <div class="item-social">
                    <button class="social-btn" onclick="shareItem(${item.id})">Share</button>
                    <button class="social-btn">${item.friends.length} friends bought this</button>
                </div>
            </div>
            
            <div class="quantity-controls">
                <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">−</button>
                <input type="number" class="qty-input" value="${item.quantity}" 
                       onchange="setQuantity(${item.id}, this.value)" min="1" max="10">
                <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
            </div>
            
            <div class="item-price">
                <div class="current-price">${item.price.toLocaleString('en-US', {minimumFractionDigits: 2})}</div>
                ${item.originalPrice ? `<div class="original-price">${item.originalPrice.toLocaleString('en-US', {minimumFractionDigits: 2})}</div>` : ''}
            </div>
        </div>
    `).join('');
}



// Update cart count
function updateCartCount() {
    const count = cartData.reduce((sum, item) => sum + item.quantity, 0);
    document.getElementById('cart-count').textContent = count;
}

// Remove item from cart
function removeItem(id) {
    const item = cartData.find(item => item.id === id);
    if (!item) return;

    // Add loading state
    const itemElement = document.querySelector(`[data-id="${id}"]`);
    itemElement.classList.add('loading');

    setTimeout(() => {
        cartData = cartData.filter(item => item.id !== id);
        renderCartItems();
        updateCartSummary();
        updateCartCount();
        
        // Save to localStorage
        saveCart();
    }, 300);
}

// Update quantity
function updateQuantity(id, change) {
    const item = cartData.find(item => item.id === id);
    if (!item) return;

    const newQuantity = Math.max(1, Math.min(10, item.quantity + change));
    if (newQuantity !== item.quantity) {
        item.quantity = newQuantity;
        
        // Update the input field
        const input = document.querySelector(`[data-id="${id}"] .qty-input`);
        input.value = newQuantity;
        
        updateCartSummary();
        updateCartCount();
        saveCart();
    }
}

// Set quantity directly
function setQuantity(id, value) {
    const item = cartData.find(item => item.id === id);
    if (!item) return;

    const quantity = Math.max(1, Math.min(10, parseInt(value) || 1));
    item.quantity = quantity;
    
    updateCartSummary();
    updateCartCount();
    saveCart();
}

// Toggle wishlist
function toggleWishlist(id) {
    const btn = document.querySelector(`[data-id="${id}"] .wishlist-btn`);
    
    if (wishlist.has(id)) {
        wishlist.delete(id);
        btn.classList.remove('active');
    } else {
        wishlist.add(id);
        btn.classList.add('active');
    }
    
    // Save wishlist state (would normally sync with backend)
    localStorage.setItem('wishlist', JSON.stringify([...wishlist]));
}

// Share item (social feature)
function shareItem(id) {
    const item = cartData.find(item => item.id === id);
    if (!item) return;

    // Simulate social sharing
    if (navigator.share) {
        navigator.share({
            title: item.name,
            text: `Check out this ${item.name} I found on NotFbMarketplace!`,
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(`${item.name} - ${window.location.href}`).then(() => {
            // Show temporary feedback
            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(() => {
                btn.textContent = originalText;
            }, 1000);
        });
    }
}

// Handle checkout with professional micro-interaction
function handleCheckout() {
    const btn = event.target.closest('.checkout-btn');
    const btnText = btn.querySelector('.btn-text');
    
    // Start processing state
    btn.classList.add('processing');
    btnText.textContent = 'Processing Order...';
    btn.disabled = true;
    
    // Simulate processing time with progress animation
    setTimeout(() => {
        // Show success state
        btn.classList.remove('processing');
        btn.classList.add('success');
        btnText.textContent = 'Order Confirmed!';
        
        // Show success message
        setTimeout(() => {
            alert('🎉 Order placed successfully!\n\nYour items will be delivered within 2-3 business days.\nTracking information will be sent to your email.');
            
            // Reset button after delay
            setTimeout(() => {
                btn.classList.remove('success');
                btnText.textContent = 'Proceed to Checkout';
                btn.disabled = false;
            }, 1500);
        }, 500);
    }, 2000);
}

// Handle history link click with micro-interaction  
function handleHistoryClick(event) {
    event.preventDefault(); // Prevent actual navigation for demo
    
    const link = event.currentTarget;
    const icon = link.querySelector('.history-icon');
    const text = link.querySelector('.history-text');
    
    // Create ripple effect
    const ripple = document.createElement('div');
    ripple.style.cssText = `
        position: absolute;
        border-radius: 50%;
        background: color-mix(in srgb, var(--primary) 30%, transparent);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    `;
    
    const rect = link.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.left = (event.clientX - rect.left - size / 2) + 'px';
    ripple.style.top = (event.clientY - rect.top - size / 2) + 'px';
    
    link.appendChild(ripple);
    
    // Animate icon and text
    icon.style.transform = 'rotate(-360deg)';
    text.style.transform = 'translateX(4px)';
    
    // Show loading state
    text.textContent = 'Loading...';
    
    // Simulate loading and show message
    setTimeout(() => {
        alert('🕒 Order History\n\nThis would navigate to your order history page.\nShowing your past 15 orders and delivery status.');
        
        // Reset animation
        setTimeout(() => {
            icon.style.transform = '';
            text.style.transform = '';
            text.textContent = 'View History';
            ripple.remove();
        }, 300);
    }, 1000);
}

// // Save cart to localStorage
// function saveCart() {
//     localStorage.setItem('cart', JSON.stringify(cartData));
// }

// // Load cart from localStorage
// function loadCart() {
//     const saved = localStorage.getItem('cart');
//     if (saved) {
//         cartData = JSON.parse(saved);
//     }
    
//     const savedWishlist = localStorage.getItem('wishlist');
//     if (savedWishlist) {
//         wishlist = new Set(JSON.parse(savedWishlist));
//     }
// }

// // Initialize when DOM is loaded
// document.addEventListener('DOMContentLoaded', () => {
//     loadCart();
//     initCart();
// });

// // Handle keyboard navigation
// document.addEventListener('keydown', (e) => {
//     if (e.key === 'Escape') {
//         // Close any open modals or focus states
//         document.activeElement?.blur();
//     }
// });

// // Auto-save cart periodically
// setInterval(saveCart, 30000); // Save every 30 seconds

// // Add ripple animation to CSS
// const rippleStyle = document.createElement('style');
// rippleStyle.textContent = `
//     @keyframes ripple {
//         to {
//             transform: scale(4);
//             opacity: 0;
//         }
//     }
// `;
// document.head.appendChild(rippleStyle);
// let appliedCoupon = null;
// let discountValue = 0;

// // Sample coupon codes
// const coupons = {
//     "SAVE10": 0.10, // 10% off
//     "FREESHIP": 29.99, // Free shipping
//     "WELCOME5": 5.00 // $5 off
// };

// function validateCoupon(code) {
//     code = code.trim().toUpperCase();
//     if (coupons[code]) {
//         appliedCoupon = code;
//         discountValue = coupons[code];
//     } else {
//         appliedCoupon = null;
//         discountValue = 0;
//     }
//     updateCartSummary();
// }

function updateCartSummary() {
    const subtotal = cartData.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    let shipping = subtotal > 0 ? 29.99 : 0;
    let discount = 0;

    if (appliedCoupon) {
        if (appliedCoupon === "FREESHIP") {
            shipping = 0;
            discount = 29.99;
        } else if (typeof discountValue === "number") {
            discount = typeof discountValue === "number" && discountValue < 1
                ? subtotal * discountValue
                : discountValue;
        }
        document.getElementById('discount-row').style.display = 'flex';
        document.getElementById('discount-amount').textContent = `-$${discount.toFixed(2)}`;
    } else {
        document.getElementById('discount-row').style.display = 'none';
    }

    const tax = subtotal * 0.08;
    const total = subtotal + shipping + tax - discount;

    document.getElementById('subtotal').textContent = `${subtotal.toLocaleString('en-US', {minimumFractionDigits: 2})}`;
    document.getElementById('shipping').textContent = shipping > 0 ? `${shipping.toFixed(2)}` : 'FREE';
    document.getElementById('tax').textContent = `${tax.toFixed(2)}`;
    document.getElementById('total').textContent = `${total.toFixed(2)}`;
}

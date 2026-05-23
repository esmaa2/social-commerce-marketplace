document.querySelectorAll('[data-eye]').forEach(btn => {
  btn.addEventListener('click', () => {
    const input = document.querySelector(btn.dataset.eye);
    if (!input) return;
    const isPwd = input.type === 'password';
    input.type = isPwd ? 'text' : 'password';
    btn.setAttribute('aria-label', (isPwd ? 'Hide' : 'Show') + ' password');
  });
});

const formLogin = document.getElementById('loginForm');
const loginBtn = document.getElementById('loginBtn');
formLogin?.addEventListener('submit', () => {
  loginBtn.disabled = true;
});

const formSignup = document.getElementById('signupForm');
const first = document.getElementById('first');
const last = document.getElementById('last');
const full_name = document.getElementById('full_name');
formSignup?.addEventListener('submit', () => {
  full_name.value = [first.value, last.value].filter(Boolean).join(' ');
});

function switchCard(card) {
  const loginCard = document.getElementById('loginCard');
  const registerCard = document.getElementById('registerCard');
  if (card === 'login') {
    loginCard.classList.add('active-card');
    registerCard.classList.add('slide-in');
    registerCard.classList.remove('active-card');
  } else {
    registerCard.classList.add('active-card');
    loginCard.classList.remove('active-card');
    loginCard.classList.add('slide-in');
  }
}
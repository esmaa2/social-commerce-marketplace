// resources/js/register.js
document.addEventListener('DOMContentLoaded', () => {
  // 👁 Toggle password visibility
  document.querySelectorAll('[data-eye]').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = document.querySelector(btn.dataset.eye);
      if (!input) return;
      const isPwd = input.type === 'password';
      input.type = isPwd ? 'text' : 'password';
      btn.setAttribute('aria-label', (isPwd ? 'Hide' : 'Show') + ' password');
    }, { passive: true });
  });

  // Join first + last into hidden name
  const form = document.getElementById('signupForm');
  const first = document.getElementById('first');
  const last  = document.getElementById('last');
  const nameHidden = document.getElementById('full_name');

  form.addEventListener('submit', () => {
    const f = (first?.value || '').trim();
    const l = (last?.value  || '').trim();
    nameHidden.value = [f,l].filter(Boolean).join(' ');
  });

  // Avatar preview (optional)
  const fileInput = document.getElementById('avatar');
  const preview = document.getElementById('preview');
  fileInput?.addEventListener('change', () => {
    const file = fileInput.files && fileInput.files[0];
    if (!file) { preview.textContent = 'No image'; return; }
    if (!/image\/(jpeg|png)/.test(file.type) || file.size > 2 * 1024 * 1024) {
      preview.textContent = 'Invalid image'; return;
    }
    const reader = new FileReader();
    reader.onload = e => {
      preview.innerHTML = '<img alt="Avatar preview">';
      preview.querySelector('img').src = e.target.result;
    };
    reader.readAsDataURL(file);
  });
});
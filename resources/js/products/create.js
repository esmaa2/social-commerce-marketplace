document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('product-create-form');
  const submitBtn = document.getElementById('submit-btn');
  const desc = document.getElementById('description');
  const descCount = document.getElementById('desc-count');
  const imageInput = document.getElementById('image');
  const preview = document.getElementById('image-preview');

  // Description counter
  const LIMIT = 500;
  if (desc && descCount) {
    const update = () => {
      const len = desc.value.length;
      descCount.textContent = `${len} / ${LIMIT}`;
    };
    desc.addEventListener('input', update);
    update();
  }

  // Image preview
  if (imageInput && preview) {
    imageInput.addEventListener('change', (e) => {
      const file = e.target.files?.[0];
      if (!file) {
        preview.classList.add('d-none');
        preview.removeAttribute('src');
        return;
      }
      const reader = new FileReader();
      reader.onload = () => {
        preview.src = reader.result;
        preview.classList.remove('d-none');
      };
      reader.readAsDataURL(file);
    });
  }

  // Prevent double submit
  if (form && submitBtn) {
    form.addEventListener('submit', () => {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Submitting...';
    });
  }
});

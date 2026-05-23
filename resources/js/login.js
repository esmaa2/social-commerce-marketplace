 document.querySelectorAll('[data-eye]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const input = document.querySelector(btn.dataset.eye);
        if(!input) return;
        const isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';
        btn.setAttribute('aria-label', (isPwd ? 'Hide' : 'Show') + ' password');
      });
    });

    // (Optional) disable button on submit to avoid double click
    const form = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    form?.addEventListener('submit', ()=>{ loginBtn.disabled = true; });
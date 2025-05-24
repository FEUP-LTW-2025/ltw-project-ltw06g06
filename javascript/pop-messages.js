  window.addEventListener('DOMContentLoaded', () => {
    const msg = document.getElementById('login-error');
    if (msg) {
      setTimeout(() => {
        msg.classList.add('hidden');
      }, 3000); 
    }
  });
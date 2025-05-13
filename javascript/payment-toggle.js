document.addEventListener('DOMContentLoaded', () => {
    const radios = document.querySelectorAll('input[name="payment_method"]');
    const methodSections = document.querySelectorAll('.payment-method');
  
    function updateVisibleSection() {
      methodSections.forEach(section => section.style.display = 'none');
      const selected = document.querySelector('input[name="payment_method"]:checked');
      if (selected) {
        const selectedSection = document.querySelector('.payment-method.' + selected.value);
        if (selectedSection) selectedSection.style.display = 'block';
      }
    }
  
    radios.forEach(radio => {
      radio.addEventListener('change', updateVisibleSection);
    });
  
    updateVisibleSection();
  });
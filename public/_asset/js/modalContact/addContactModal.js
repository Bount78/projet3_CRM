export function handleAddContactModal() {
    const addContactModal = new bootstrap.Modal(document.getElementById('add-contact-modal'), {
      keyboard: false
    });
  
    const addContactButton = document.getElementById('add-contact-button');
    addContactButton.addEventListener('click', function () {
      addContactModal.show();
    });
  
    const confirmAddContactButton = document.getElementById('confirm-add-contact-button');
    confirmAddContactButton.addEventListener('click', function () {
      // Code de confirmation d'ajout de contact ici
      addContactModal.hide();
    });
  }
  
  const confirmationModal = document.getElementById('confirmationModal');
  confirmationModal.addEventListener('click', (event) => {
    if (event.target.classList.contains('confirm-button')) {
      const contactId = event.target.dataset.contactId;
      const userId = event.target.dataset.userId;
  
      fetch(`/user/${userId}/contact/${contactId}/link`, {
        method: 'POST'
      }).then(() => {
        location.reload();
      });
    }
  });
  
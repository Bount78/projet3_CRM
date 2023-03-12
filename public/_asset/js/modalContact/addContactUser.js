export function handleAddContactUser() {
  console.log('handleAddContactUser called');

  const addContactForms = document.querySelectorAll('form.add-contact-form');

  addContactForms.forEach((form) => {
    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const contactId = form.querySelector('input[name="contactId"]').value;
      const userId = form.querySelector('input[name="userId"]').value;

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            contactId,
            userId,
          }),
        });

        if (!response.ok) {
          throw new Error('Une erreur s\'est produite');
        }

        const data = await response.json();
        console.log(data);

        const message = data.message;
        const modalBody = document.querySelector('#addContactModal .modal-body');
        modalBody.textContent = message;
        const modal = new bootstrap.Modal(document.getElementById('addContactModal'));
        modal.show();
      } catch (error) {
        console.error(error);
      }
    });
  });
}

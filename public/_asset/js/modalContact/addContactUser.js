export function handleAddContactUser() {
  const addContactForms = document.querySelectorAll('form.add-contact-form');

  addContactForms.forEach((form) => {
    form.addEventListener('submit', (event) => {
      event.preventDefault();

      const contactId = form.querySelector('input[name="contactId"]').value;
      const userId = form.querySelector('input[name="userId"]').value;

      fetch(form.action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          contactId,
          userId,
        }),
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error('Une erreur s\'est produite');
          }
          return response.json();
        })
        .then((data) => {
          console.log(data);
          const message = data.message;
          const successModal = document.getElementById('successModal');
          const modalBody = successModal.querySelector('.modal-body');
          const modalMessage = successModal.getAttribute('data-message');
          modalBody.textContent = message;
          successModal.setAttribute('data-message', message);
          if (modalMessage !== message) {
            new bootstrap.Modal(successModal).show();
          }
        })
        .catch((error) => {
          console.error(error);
        });
    });
  });
}

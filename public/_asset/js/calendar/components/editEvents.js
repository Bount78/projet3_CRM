export default function handleEditEvent(calendar) {
  const editEventForm = document.querySelector('#editEventForm');
  const editEventButton = document.querySelector('#editEventButton');

  // Récupérer l'ID de l'utilisateur via une requête AJAX
  fetch('/user/id')
    .then(response => response.json())
    .then(data => {
        const userId = data.userId;
        // Utiliser l'ID de l'utilisateur comme valeur pour le champ eventId
        document.querySelector('#eventId').value = userId;
    })
    .catch(error => console.error(error));

  editEventButton.addEventListener('click', (e) => {
    e.preventDefault();
    
    const formData = new FormData(editEventForm);
    const eventId = editEventForm.getAttribute('data-id');
    const url = editEventForm.action + '/' + eventId;
    console.log(url);
    // Convertir la date en timestamp avant de l'envoyer
    const eventStartTimestamp = new Date(formData.get('eventStart').replace('T', ' ')).getTime() / 1000;
    const eventEndTimestamp = new Date(formData.get('eventEnd').replace('T', ' ')).getTime() / 1000;

    // Mettre les dates converties dans le FormData
    formData.set('eventStart', eventStartTimestamp);
    formData.set('eventEnd', eventEndTimestamp);
    
    fetch(url, {
      method: 'PUT',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        console.log(data.message); // Afficher la réponse du serveur
        $('#editEventModal').modal('hide'); // Masquer le modal
        if (data.success) {
          // Mettre à jour l'événement modifié dans le calendrier
          const event = calendar.getEventById(eventId);
          event.setProp('title', data.event.name);
          event.setStart(data.event.dateStart);
          event.setEnd(data.event.dateEnd);
          // Afficher le message de succès dans un pop-up
          alert('Evénement modifié avec succès !');
        }
      })
      .catch(error => console.error(error));
  });
}
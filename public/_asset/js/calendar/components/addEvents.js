export default function handleAddEvent(calendar) {
    const addEventForm = document.querySelector('#addEventForm');
    const addEventButton = document.querySelector('#addEventButton');
    addEventButton.addEventListener('click', (e) => {
      e.preventDefault();

      const formData = new FormData(addEventForm);
      const url = addEventForm.action;

      // Convertir la date en timestamp avant de l'envoyer
      const eventStartTimestamp = new Date(formData.get('eventStart')).getTime() / 1000;
      const eventEndTimestamp = new Date(formData.get('eventEnd')).getTime() / 1000;

      // Mettre les dates converties dans le FormData
      formData.set('eventStart', eventStartTimestamp);
      formData.set('eventEnd', eventEndTimestamp);

      fetch(url, {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          console.log(data.message); // Afficher la réponse du serveur
          $('#addEventModal').modal('hide'); // Masquer le modal
          if (data.success) {
            // Ajouter l'événement au calendrier
            calendar.addEvent(data.event);
            // Afficher le message de succès dans un pop-up
            alert('Evénement ajouté avec succès !');
          }
        })
        .catch(error => console.error(error));
    });
}
export default function handleEditEvent(calendar) {
  const editEventForm = document.querySelector('#editEventForm');
  const editEventButton = document.querySelector('#editEventButton');

  editEventButton.addEventListener('click', (e) => {
    e.preventDefault();

    const formData = new FormData(editEventForm);
    const eventId = formData.get('id');
    const url = editEventForm.action + '/' + eventId;

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
          const event = calendar.getEventById(id);
          event.setProp('name', data.event.name);
          event.setStart(data.event.dateStart);
          event.setEnd(data.event.dateEnd);
          // Afficher le message de succès dans un pop-up
          alert('Evénement modifié avec succès !');
        }
      })
      .catch(error => console.error(error));
  });

  const searchEventButton = document.querySelector('#searchEventButton');

  searchEventButton.addEventListener('click', (e) => {
    e.preventDefault();
  
    // Récupérer la chaîne de recherche
    var searchQuery = document.querySelector('#searchEvent').value;
    console.log('Search query:', searchQuery);

    // Envoyer une requête AJAX pour récupérer les informations de l'événement
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      console.log('XHR readyState:', xhr.readyState);
      console.log('XHR status:', xhr.status);
      console.log('XHR response:', xhr.responseText);
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success && response.event) {
          fillFormWithEvent(response.event);
        } else {
          console.error('L\'événement est indéfini ou la recherche a échoué.');
        }
      }
    };
    xhr.open('GET', '/event/search?query=' + encodeURIComponent(searchQuery));
    xhr.send();
  });
  

  function fillFormWithEvent(event) {
    if (!event.name || !event.dateStart || !event.dateEnd) {
      console.error('L\'événement est manquant de propriétés requises.');
      return;
    }

    // document.querySelector('#eventId').value = event.id;
    document.querySelector('#eventName').value = event.name;
    document.querySelector('#eventStart').value = event.dateStart.substring(0, 16);
    document.querySelector('#eventEnd').value = event.dateEnd.substring(0, 16);
  }
}

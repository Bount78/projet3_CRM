export default function handleEditEvent(calendar) {
    const editEventForm = document.querySelector('#editEventForm');
    const editEventButton = document.querySelector('#editEventButton');
  
    editEventButton.addEventListener('click', (e) => {
      e.preventDefault();
  
      const formData = new FormData(editEventForm);
      const eventId = formData.get('eventId');
      const url = editEventForm.action + '/' + eventId;
  
      // Convertir la date en timestamp avant de l'envoyer
      const eventStartTimestamp = new Date(formData.get('eventStart').replace('T', ' ')).getTime() / 1000;
      const eventEndTimestamp = new Date(formData.get('eventEnd').replace('T', ' ')).getTime() / 1000;
  
      // Mettre les dates converties dans le FormData
      formData.set('eventStart', eventStartTimestamp);
      formData.set('eventEnd', eventEndTimestamp);

      document.querySelector('#searchEventButton').addEventListener('click', function() {
        // Récupérer la chaîne de recherche
        var searchQuery = document.querySelector('#searchEvent').value;
    
        // Envoyer une requête AJAX pour récupérer les informations de l'événement
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var event = JSON.parse(xhr.responseText);
                // Afficher les informations de l'événement dans le formulaire
                document.querySelector('#eventId').value = event.id;
                document.querySelector('#eventName').value = event.title;
                document.querySelector('#eventStart').value = event.start;
                document.querySelector('#eventEnd').value = event.end;
            }
        };
        xhr.open('GET', '/event/search?query=' + encodeURIComponent(searchQuery));
        xhr.send();
    });
    
  
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
  
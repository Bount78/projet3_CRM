export default function deleteEvent() {
  const deleteEventButton = document.querySelector('#deleteEventButton');

  deleteEventButton.addEventListener('click', (e) => {
    e.preventDefault();

    // Ouvrir la modal de confirmation
    $('#deleteConfirmationModal').modal('show');

    // Ajouter un événement "click" sur le bouton "Supprimer" dans la modal de confirmation
    const confirmDeleteButton = document.querySelector('#confirmDeleteButton');
    confirmDeleteButton.addEventListener('click', (e) => {
      e.preventDefault();

      // Récupérer l'identifiant de l'événement à supprimer
      const eventId = document.querySelector('#eventId').value;

      // Envoyer une requête AJAX pour supprimer l'événement
      $.ajax({
          url: '/event/' + eventId,
          type: 'DELETE',
          data: JSON.stringify({ confirmed: true }),
          contentType: 'application/json',
          success: function(response) {
              // Actualiser la page ou supprimer l'événement de l'interface utilisateur
              location.reload();
          },
          error: function(xhr, status, error) {
              // Afficher une erreur à l'utilisateur
              console.error('La suppression de l\'événement a échoué.');
          }
      });

      // Cacher la modal de confirmation
      $('#deleteConfirmationModal').modal('hide');
    });
  });

  // Rechercher un événement à supprimer
  const searchDeleteEventButton = document.querySelector('#searchDeleteEventButton');
  searchDeleteEventButton.addEventListener('click', (e) => {
    e.preventDefault();

    // Récupérer la chaîne de recherche
    const searchQuery = document.querySelector('#searchDeleteEvent').value;
    // Envoyer une requête AJAX pour récupérer les informations de l'événement à supprimer
    $.ajax({
        url: '/event/searchDelete',
    type: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ searchTerm: searchQuery }),
    success: function(response) {
        if (response.success && response.event) {
            // Récupérer l'identifiant de l'événement
            const eventId = response.event.id;
            // Mettre à jour la valeur de l'identifiant dans le formulaire de suppression
            const eventIdInput = document.querySelector('#eventId');
            eventIdInput.setAttribute('value', eventId);
            
            // Remplir le formulaire avec les informations de l'événement
            const eventNameInput = document.querySelector('#eventDeleteName');
            console.log(eventNameInput);
            eventNameInput.setAttribute('value', response.event.name);
            const eventStartInput = document.querySelector('#eventDeleteStart');
            console.log(eventStartInput);
            eventStartInput.setAttribute('value', response.event.dateStart.substring(0, 16));
            const eventEndInput = document.querySelector('#eventDeleteEnd');
            console.log(eventEndInput);
          eventEndInput.setAttribute('value', response.event.dateEnd.substring(0, 16));
        } else {
          console.error('L\'événement est indéfini ou la recherche a échoué.');
        }
        
        // Cacher la modal de confirmation
        $('#deleteConfirmationModal').modal('hide');
      },
      error: function(xhr, status, error) {
        console.error('La requête a échoué.');
      }
    });
  });
}
export default function searchEvents(calendar) {
  const searchEventButton = document.querySelector('#searchEventButton');

  searchEventButton.addEventListener('click', (e) => {
    e.preventDefault();

    // Récupérer la chaîne de recherche
    var searchQuery = document.querySelector('#searchEvent').value;
    console.log('Search query:', searchQuery);

    // Envoyer une requête AJAX pour récupérer les informations de l'événement
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/event/search');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.success && response.event) {
            fillFormWithEvent(response.event, document.querySelector('#editEventForm'));
          } else {
            console.error('L\'événement est indéfini ou la recherche a échoué.');
          }
        } else {
          console.error('La requête a échoué.');
        }
      }
    };
    var data = { searchTerm: searchQuery };
    xhr.send(JSON.stringify(data));

  });


  function fillFormWithEvent(event, form) {
    if (!event.name || !event.dateStart || !event.dateEnd) {
      console.error('L\'événement est manquant de propriétés requises.');
      return;
    }

    form.querySelector('#eventName').setAttribute('value', event.name);
    form.querySelector('#eventStart').setAttribute('value', event.dateStart.substring(0, 16));
    form.querySelector('#eventEnd').setAttribute('value', event.dateEnd.substring(0, 16));
  }

  const editEventButton = document.querySelector('#editEventButton');
  const confirmationModal = new bootstrap.Modal(document.querySelector('#confirmationModal'));
    
  editEventButton.addEventListener('click', (e) => {
      e.preventDefault();
  
      // afficher la modal de confirmation
      confirmationModal.show();
  });
    
  // lorsqu'on clique sur le bouton confirmer
  const confirmButton = document.querySelector('#confirmButton');
  confirmButton.addEventListener('click', (e) => {
      // cacher la boîte de dialogue de confirmation
      confirmationModal.hide();
  
      // envoyer le formulaire
      const editEventForm = document.querySelector('#editEventForm');
      editEventForm.submit();
  });
  
  // lorsque la boîte de dialogue est cachée
  $(confirmationModal._element).on('hidden.bs.modal', () => {
    // afficher à nouveau le formulaire
    const editEventForm = document.querySelector('#editEventForm');
    editEventForm.style.display = 'block';
  });
}
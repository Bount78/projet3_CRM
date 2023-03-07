export default function searchEvent() {
    // Récupération de la valeur de l'input de recherche
    const searchTerm = document.getElementById('searchEvent').value;
  
    // Envoi d'une requête AJAX pour récupérer les événements correspondants
    fetch('/event/search', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ searchTerm: searchTerm })
    })
      .then(response => response.json())
      .then(data => {
        // Affichage des événements dans le formulaire
        const eventNameInput = document.getElementById('eventName');
        const eventStartInput = document.getElementById('eventStart');
        const eventEndInput = document.getElementById('eventEnd');
  
        eventNameInput.value = data.name;
        eventStartInput.value = data.dateStart;
        eventEndInput.value = data.dateEnd;
      })
      .catch(error => console.error(error));
  }
  
  // Ajout d'un événement au clic sur le bouton de recherche
  const searchEventButton = document.getElementById('searchEventButton');
  searchEventButton.addEventListener('click', searchEvent);
  
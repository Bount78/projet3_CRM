export default function addCustomButtons(calendar) {
    calendar.setOption('customButtons', {
        addEventButton: {
          text: 'Ajouter un événement',
          icon: 'bi bi-plus-circle',
          click: function () {
            // ouvrir la fenêtre modale lorsqu'on clique sur le bouton
            $('#addEventModal').modal('show');
          },
        },
        editEventButton: {
          text: 'Modifier un événement',
          icon: 'bi bi-pencil',
          click: function () {
            // ouvrir la fenêtre modale pour modifier un événement existant
            $('#editEventModal').modal('show');
          },
        },
        deleteEventButton: {
          text: 'Supprimer un événement',
          icon: 'bi bi-trash',
          click: function () {
            // supprimer l'événement sélectionné
            alert('Événement supprimé !');
          },
        },
      });
    }
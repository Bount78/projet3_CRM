export default function addEvent(calendar) {
  // Déclencher une requête AJAX pour récupérer le formulaire à afficher dans le modal
  $.ajax({
    url: '/app_event_add',
    dataType: 'html',
    success: function (data) {
      // Créer un élément pour stocker le formulaire
      var formContainer = $('<div>');

      // Ajouter le contenu HTML du formulaire à l'élément
      formContainer.append(data);

      // Injecter le contenu du formulaire dans le modal
      $('#addEventModal .modal-content').html(formContainer);

      // Afficher le modal
      $('#addEventModal').modal('show');

      // Ajouter la fonction d'écoute du submit du formulaire
      $('#add-event-form').on('submit', function(e) {
        e.preventDefault();

        // Récupérer les données du formulaire
        var formData = $(this).serialize();

        // Envoyer les données en AJAX pour ajouter l'événement
        $.ajax({
          url: '/app_event_add',
          type: 'POST',
          data: formData,
          success: function (response) {
            // Si l'ajout a réussi, rafraîchir le calendrier
            calendar.refetchEvents();
            // Fermer le modal
            $('#addEventModal').modal('hide');
          },
          error: function() {
            // En cas d'erreur, afficher un message d'erreur
            alert('Erreur lors de l\'ajout de l\'événement.');
          }
        });
      });
    }
  });
}

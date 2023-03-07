export default function loadEvents(calendar) {
    // charger les événements au démarrage
    $.ajax({
        url: '/events',
        dataType: 'json',
        success: function (events) {
          calendar.addEventSource(events);
        }
      });
}
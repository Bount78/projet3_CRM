export default class MyCalendar {
  constructor() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      themeSystem: 'bootstrap5',
      initialView: 'dayGridMonth',
      timeZone: 'Europe/Paris',
      headerToolbar: {
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listDay'
      },
      buttonText: {
        today: 'Aujourd\'hui',
        month: 'Mois',
        week: 'Semaine',
        day: 'Jour',
        list: 'Agenda'
      },
      dayHeaderFormat: { weekday: 'long' },
      locale: 'fr',
      dayMaxEvents: true,
      eventTimeFormat: { hour: 'numeric', minute: '2-digit', hour12: false }
    });
    calendar.setOption('customButtons', {
      addEventButton: {
        text: 'Ajouter un événement',
        icon: 'bi bi-plus-circle',
        click: function () {
          // Déclencher une requête AJAX pour récupérer le formulaire à afficher dans le modal
          $.post($(this).data('route'), function (data) {
            // Injecter le contenu du formulaire dans le modal
            $('#addEventModal .modal-content').html(data);
            // console.log(data)
            // Afficher le modal
            $('#addEventModal').modal('show');
          });
        },
        data: {
          route: "/app_event_add",
        }
      }
    });

    calendar.setOption('headerToolbar', {
      start: 'prev,next today',
      center: 'title',
      end: 'addEventButton dayGridMonth,timeGridWeek,timeGridDay,listDay'
    });


    this.calendar = calendar;
  }
}

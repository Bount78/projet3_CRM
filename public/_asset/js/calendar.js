document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      timeZone: 'Europe/Paris',
      headerToolbar: {
        start: 'prev,next today',
        center: 'title',
        end: 'timeGridDay,timeGridWeek,dayGridMonth,listDay'
      },
      buttonText: {
        today: 'Aujourd\'hui',
        month: 'Mois',
        week: 'Semaine',
        day: 'Jour',
        list: 'Agenda'
      },
      dayHeaderFormat: { weekday: 'long' }, // format du titre des jours dans le mois
      titleFormat: { year: 'numeric', month: 'long', day: 'numeric' }, // format du titre du calendrier
      views: {
        timeGridWeek: {
          dayHeaderFormat: { weekday: 'long', day: 'numeric', month: 'long' }, // format du titre des jours dans la semaine
          titleFormat: { day: 'numeric', month: 'long', year: 'numeric' }, // format du titre du calendrier dans la semaine
          columnHeaderFormat: { weekday: 'long', day: 'numeric', month: 'numeric', omitCommas: true }, // format des titres des colonnes dans la semaine
          slotLabelFormat: { hour: 'numeric', minute: '2-digit', hour12: false, meridiem: false } // format des heures des événements dans la semaine
        },
        timeGridDay: {
          dayHeaderFormat: { weekday: 'long', day: 'numeric', month: 'long' }, // format du titre des jours dans la journée
          titleFormat: { day: 'numeric', month: 'long', year: 'numeric' }, // format du titre du calendrier dans la journée
          slotLabelFormat: { hour: 'numeric', minute: '2-digit', hour12: false, meridiem: false } // format des heures des événements dans la journée
        }
      },
      locale: 'fr', // langue française
      dayMaxEvents: true, // permet l'affichage de "+n événements" en cas de surcharge
      eventTimeFormat: { hour: 'numeric', minute: '2-digit', hour12: false } // format de l'heure des événements
    });
    calendar.render();
  });
  
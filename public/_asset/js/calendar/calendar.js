import addCustomButtons from './components/customButtons.js';
import loadEvents from './components/events.js';
import handleAddEvent from './components/addEvents.js';
import handleEditEvent from './components/editEvents.js';
import handlesearchEvents from './components/searchEvents.js';
import deleteEvent from './components/deleteEvent.js';


export default class MyCalendar {
  constructor() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      // themeSystem: 'bootstrap5',
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
      eventTimeFormat: { hour: 'numeric', minute: '2-digit', hour12: false },
      aspectRatio: 1.35, // valeur par défaut
      editable: true, // permet la modification des événements
    });


    addCustomButtons(calendar);
    loadEvents(calendar);

    // Ajouter un écouteur de changement de taille d'écran
    window.addEventListener('resize', function () {
      var screenWidth = window.innerWidth;
      if (screenWidth < 576) { // Écran XS
        calendar.setOption('aspectRatio', 0.8); // Réduire l'aspectRatio pour les petits écrans
      } else {
        calendar.setOption('aspectRatio', 1.35); // Retour à la valeur par défaut pour les grands écrans
      }
      calendar.render(); // Rendre le calendrier avec la nouvelle valeur d'aspectRatio
    });


    // Ajouter des animations pour les transitions d'aspectRatio
    calendar.on('aspectRatio', function () {
      calendarEl.classList.add('fc-transitions');
      setTimeout(function () {
        calendarEl.classList.remove('fc-transitions');
      }, 500); // Durée de l'animation en millisecondes
    });

    calendar.setOption('headerToolbar', {
      start: 'prev,next today',
      center: 'title',
      end: 'addEventButton,editEventButton,deleteEventButton dayGridMonth,timeGridWeek,timeGridDay,listDay'
    });
    
    handleAddEvent(calendar);
    handlesearchEvents(calendar);
    handleEditEvent(calendar);
    deleteEvent(calendar);

    this.calendar = calendar;
  }
}

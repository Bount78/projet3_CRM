import addCustomButtons from './components/customButtons.js';
import loadEvents from './components/events.js';
import handleAddEvent from './components/addEvents.js';
import handleEditEvent from './components/editEvents.js';
import handlesearchEvents from './components/searchEvents.js';

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

    addCustomButtons(calendar);
    loadEvents(calendar);

    calendar.setOption('headerToolbar', {
      start: 'prev,next today',
      center: 'title',
      end: 'addEventButton,editEventButton,deleteEventButton dayGridMonth,timeGridWeek,timeGridDay,listDay'
    });
 
    handleAddEvent(calendar);
    handleEditEvent(calendar);
    handlesearchEvents(calendar);

    this.calendar = calendar;

  }
}
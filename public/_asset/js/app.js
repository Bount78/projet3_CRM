import MyCalendar from './calendar/calendar.js';
// import searchEvent from './calendar/components/searchEvents.js';



document.addEventListener('DOMContentLoaded', () => {
  const calendar = new MyCalendar();


  calendar.calendar.render();
});

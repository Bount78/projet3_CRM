import MyCalendar from './components/calendar.js';
import addEventToCalendar from './components/addEvent.js';


document.addEventListener('DOMContentLoaded', () => {
  const calendar = new MyCalendar();


  calendar.calendar.render();
  addEventToCalendar(calendar);
});

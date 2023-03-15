import MyCalendar from './calendar/calendar.js';
import { handleAddContactUser } from './modalContact/addContactUser.js';
import { handleAddContactModal } from './modalContact/addContactModal.js';
// import searchEvent from './calendar/components/searchEvents.js';




document.addEventListener('DOMContentLoaded', () => {
  const calendar = new MyCalendar();
  
  
  calendar.calendar.render();
  // handleAddContactModal();
  // handleAddContactUser();
});

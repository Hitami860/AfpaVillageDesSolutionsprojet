document.addEventListener('DOMContentLoaded', function () {


    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: "/calendar/date",
      // selectable: true,
      

      eventClick:  function(info) {
        var event = info.event;

        console.log('clik', event);
        document.getElementById('modalTitle').innerText = event.title;
        document.getElementById('modalDescription').innerText = event.extendedProps.description;
        document.getElementById('modalDate').innerText = new Intl.DateTimeFormat('fr-FR').format(event.start);
        document.getElementById('modalstartDate').innerText = new Intl.DateTimeFormat('fr-FR', { hour: 'numeric', minute: 'numeric'}).format(event.start);
        document.getElementById('modalendDate').innerText =  new Intl.DateTimeFormat('fr-FR', { hour: 'numeric', minute: 'numeric'}).format(event.end);
        document.getElementById('modalPlaces').innerText = event.extendedProps.places || 'Non défini' ;
        document.getElementById('eventModal').classList.remove('hidden');
        }

    });
    calendar.render();
  })

  function modalClose() {
    document.getElementById('eventModal').classList.add('hidden');
  }

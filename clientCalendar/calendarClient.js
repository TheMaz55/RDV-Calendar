document.addEventListener('DOMContentLoaded', function() {

  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendar.Draggable;

  var containerEl = document.getElementById('external-events');
  var calendarEl = document.getElementById('calendar');
  var checkbox = document.getElementById('drop-remove');

  new Draggable(containerEl, {
    itemSelector: '.fc-event',
    eventData: function(eventEl) {
      return {
        title: eventEl.innerText
      };
    }
  });

  var calendar = new Calendar(calendarEl, {
    headerToolbar: {
      left: 'prev,next today',
      center: 'title addEventButton deleteEventButton',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },

    editable:     true,
    droppable:    true,
    selectable:   false,
    dragScroll:   true,
    nowIndicator: true,
    eventOverlap: false,

    
    //le calendrier en français
    locale: 'fr',
    height: 'auto',

    customButtons: {
      //Boutton ajouter (aide de l'ia pour les vérifications)
      addEventButton: {
        text: 'Ajouter un evenement',
        click: function() {
          openPopup("backgroundPopupAjouter");
        }
      },
      //Boutton supprimer
      deleteEventButton: {
        text: 'Supprimer un evenement',
        click: function() {
          openPopup("backgroundPopupSupprimer");
        }
      }
    },  

    //Les évenements sont récuprés sous format JSON
    events: eventsBDD
  });
  calendar.render();
});


function supprimerPresetEvent(){
  var nomPreset = prompt('Quel est le nom du preset a supprimer ? : ');
  $.ajax({
    type: "POST",
    url: "./fonctions/supprimerPreset.php",
    data: nomPreset,
    contentType: "text/plain; charset=utf-8",
    dataType: "text", 
  });
  location.reload();
}

$("#valider").on("click",function(){
  $.ajax({
    type: "POST",
    url: "./fonctions/ajouterEvent.php",
    data: {
      debutRDV: debutRDV,
      finRDV: finRDV,
      title: title
    },
    dataType: "text",

    success: function(response) {
      console.log(response);

      // Ajout dans FullCalendar seulement si l'AJAX a réussi
      calendar.addEvent({
        title: title,
        start: debutRDV,
        end: finRDV,
        allDay: false
      });

      alert('RDV ajouté avec succès.');
    },

    error: function(xhr) {
      console.log(xhr.responseText);
      alert("Erreur lors de l'ajout en base de données.");
    }
  });
})
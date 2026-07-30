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
    selectable:   true,
    dragScroll:   true,
    nowIndicator: true,

    
    //le calendrier en français
    locale: 'fr',
    height: 'auto',

    eventClick: function(info) {
      $.ajax({
        type: "POST",
        url: "./fonctions/recupererEvent.php",
        data: {
          id: info.event.id
        },
        dataType: "json",
        
        success: function(event){
          
          //Je stock l'id de l'évenement dans la value du bouton
          //C'est pas propre mais j'ai pas trouver autre chose
          $(".ModifierEvent").val(info.event.id);
          $(".debutModifier").val(event.start);
          $(".finModifier").val(event.end);
          $(".titleModifier").val(event.title);
          $("#clientSelect2").val(event.id_client).trigger("change");
          console.log(event);

          openPopup("backgroundContenuEvenement");
        },
        error: function(xhr) {
        console.log("ERREUR");
        console.log(xhr.responseText);
    }
    });
  },

    //Fonction pour les presets a gauche
    eventReceive: function(info) {
    alert("Nouvel événement ajouté sur : " + info.event.startStr);
    },

    //Fonction pour décaller un evenement deja présent dans le calendrier
    eventDrop:function(info){
      var event = calendar.getEventById(info.event.id)
      alert("Nouveau debut: "+event.startStr+" Nouvelle fin: "+event.endStr+" id: "+event.id)
      $.ajax({
        type: "POST",
        url: "./fonctions/changerDateEvent.php",
        data: {
          NouveauDebut: event.startStr,
          NouveauFin: event.endStr,
          id: event.id
        },
        dataType: "text",
      });
    },

    eventResize: function(info) {
    alert(info.event.title + " s'arrete maintenant ici: " + info.event.endStr);

    if (!confirm("Valider?")) {
      info.revert();
      }
    },

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
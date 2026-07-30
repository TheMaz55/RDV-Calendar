document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        $(".popup").addClass("hidden");
    }
});

function openPopup(id) {
    document.getElementById(id).classList.remove("hidden");
}

//Bar de recherche dans le popup AjouterEvent
$(document).ready(function () {
    $("#clientSelect, #clientSelect2").select2({
        placeholder: "Rechercher un client...",
        allowClear: true,
        width: "100%"
    });
});

$(".fermerPopup").on("click", function () {
    $(this)
      .closest(".popup")
      .addClass("hidden");
});

//Ajouter un event
$(".validerPopupEvent").on("click", function () {

    var debutRDV = $(".debut").val();
    var finRDV = $(".fin").val();
    var client = $("#clientSelect").val();
    var title = $(".title").val().trim();

    // Vérification champs vides
    if (debutRDV === "" || finRDV === "" || title === "" || client === "") {
        alert("Tous les champs sont obligatoires.");
        return;
    }

    // Conversion en Date
    var debutDate = new Date(debutRDV);
    var finDate = new Date(finRDV);

    // Vérification des dates
    if (isNaN(debutDate.getTime()) || isNaN(finDate.getTime())) {
        alert("Date invalide.");
        return;
    }

    // La fin doit être après le début
    if (finDate <= debutDate) {
        alert("La date de fin doit être après la date de début.");
        return;
    }

    // Horaires autorisés : 09h00 → 19h00
    var heureDebut = debutDate.getHours();
    var minuteDebut = debutDate.getMinutes();

    var heureFin = finDate.getHours();
    var minuteFin = finDate.getMinutes();

    // Vérification plage horaire
    if (heureDebut < 9 || heureFin > 19 || (heureFin === 19 && minuteFin > 0)) {
        alert("Les horaires doivent être compris entre 09h00 et 19h00.");
        return;
    }

    $.ajax({
        type: "POST",
        url: "./fonctions/ajouterEvent.php",
        data: {
            debutRDV: debutRDV,
            finRDV: finRDV,
            title: title,
            client: client
        },
        dataType: "text",

        success: function (response) {
            location.reload();
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Erreur lors de l'ajout en base de données.");
        }
    });
});

//Supprimer un event
$("#supprimerPopupEvent").on("click", function(){
  $.ajax({
    type: "POST",
    url: "./fonctions/supprimerEvenement.php",
    data:{id: $("#idEvent").val()},
    dataType: "text",

    success: function (response) {
        location.reload();
    },

    error: function (xhr) {
        console.log(xhr.responseText);
        alert("Erreur lors de l'ajout en base de données.");
    }
  });
})

//Metre a jour un evenement
$(".ModifierEvent").on("click", function () {

    var idEvent = $(this).val();
    
    var debutRDV = $(".debutModifier").val();
    var finRDV = $(".finModifier").val();
    var client = $("#clientSelect2").val();
    var title = $(".titleModifier").val().trim();

    // Vérification champs vides
    if (debutRDV === "" || finRDV === "" || title === "" || client === "") {
        alert("Tous les champs sont obligatoires.");
        return;
    }

    // Conversion en Date
    var debutDate = new Date(debutRDV);
    var finDate = new Date(finRDV);

    // Vérification des dates
    if (isNaN(debutDate.getTime()) || isNaN(finDate.getTime())) {
        alert("Date invalide.");
        return;
    }

    // La fin doit être après le début
    if (finDate <= debutDate) {
        alert("La date de fin doit être après la date de début.");
        return;
    }

    // Horaires autorisés : 09h00 → 19h00
    var heureDebut = debutDate.getHours();
    var minuteDebut = debutDate.getMinutes();

    var heureFin = finDate.getHours();
    var minuteFin = finDate.getMinutes();

    // Vérification plage horaire
    if (heureDebut < 9 || heureFin > 19 || (heureFin === 19 && minuteFin > 0)) {
        alert("Les horaires doivent être compris entre 09h00 et 19h00.");
        return;
    }

    $.ajax({
        type: "POST",
        url: "./fonctions/updateEvent.php",
        data: {
            debutRDV: debutRDV,
            finRDV: finRDV,
            title: title,
            client: client,
            id:idEvent
        },
        dataType: "text",

        success: function (response) {
            location.reload();
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Erreur lors de l'ajout en base de données.");
        }
    });
});

//Ouvrir popup ajouter preset
$("#ajouterPreset").on("click", function () {
    openPopup("backgroundAjouterPreset");
});

//Ouvrir popup supprimer preset
$("#supprimerPreset").on("click", function () {
    openPopup("backgroundSupprimerPreset");
});

//Ajouter un preset
$("#AjouterPresetEvent").on("click", function () {

    var nom = $(".ajouterPreset").val().trim();

    // Champ vide
    if (nom === "") {
        alert("Veuillez saisir un nom.");
        return;
    }

    $.ajax({
        type: "POST",
        url: "./fonctions/ajouterPreset.php",
        data: {
            nom: nom
        },
        dataType: "text",

        success: function (response) {
            location.reload();
        },

        error: function (xhr) {
            console.log(xhr.responseText);
            alert("Erreur lors de l'ajout en base de données.");
        }
    });
});

//Supprimer un preset
$("#SupprimerPresetEvent").on("click",function(){
  $.ajax({
    type: "POST",
    url: "./fonctions/supprimerPreset.php",
    data:{id: $("#idPreset").val()},
    dataType: "text",

    success: function (response) {
        console.log($("#idPreset").val())
        location.reload();
    },

    error: function (xhr) {
        console.log(xhr.responseText);
        alert("Erreur lors de l'ajout en base de données.");
    }
  });
})
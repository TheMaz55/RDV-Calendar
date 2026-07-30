<?php

$host = "localhost";
$dbname = "test";
$user = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion réussie !";
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$stmt = $pdo->query("
    SELECT id, title, start, end
    FROM rdv_calendar
"); 

$events = $stmt->fetchAll();
?>

<html>
    <link rel="stylesheet" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <head>
        <title>FullCalendar</title>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
        <!-- Permet de traduire les boutons, le mois, jour et de mettre le lundi en premier jour de la semaine  -->
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/locales/fr.global.min.js'></script>    
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    <body><h2>
        <center>Calendrier<center></h2>
        <div class="container">
            <div id="external-events" class="events">
                <p><center><strong>Evenements</strong></center></p>
                <hr>
                <p>
                <?php 
                    $stmt = $pdo->prepare("SELECT title FROM event_preset");
                    $stmt->execute();
                    foreach($stmt as $title){
                        echo "<div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                        <div class='fc-event-main'>".$title["title"]."</div>
                    </div>";
                    }
                ?>
                </p>
                <div class="modification">
                    <button class="boutton_modif" id="ajouterPreset" name="Ajouter">Ajouter</button>
                    <button class="boutton_modif" id="supprimerPreset" name="Supprimer">Supprimer</button>   
                </div>
            </div>
            <div class="container">
                <div id="calendar"></div>
            </div>
        </div>
        <br>

        <!-- Partie pour les popups -->

        <!-- Popup Ajouter -->
        <div id="backgroundPopupAjouter" class="popup hidden">
            <div class="popup-content">
                <h2>Ajouter un événement</h2>
                <div>
                    <h2>Debut du RDV:</h2> <br>
                    <input class="debut" type="datetime-local" name="dateDebut" value="">
                </div>
                <br>
                <div>
                    <h2>Fin du RDV:</h2> <br>
                    <input class="fin" type="datetime-local" name="dateFin" value="">
                </div>
                <br>
                <div>
                    <h2>Nom du RDV:</h2> <br>
                    <input type="text" class="title" value="">                
                </div>
                <br>
                <div>
                    <h2>Client:</h2> <br>
                    <select name="" id="clientSelect">
                    <?php  
                        $stmt = $pdo->query("SELECT `id`,`last_name`, `first_name` FROM `client`");
                        while ($row = $stmt->fetch()) {
                            echo '<option value="'.$row["id"].'">'.$row["last_name"]." ".$row["first_name"].'</option>';
                        }
                    ?>
                    </select>
                </div>
                <br>
                <div class="bouttonsPopup">
                    <button class="validerPopupEvent">Valider</button>
                    <button class="fermerPopup">Fermer</button>
                </div>
            </div>
        </div>

        <!-- Popup supprimer -->
        <div id="backgroundPopupSupprimer" class="popup hidden">
            <div class="popup-content">
                <h2>Supprimer un événement</h2>
                <select name="" id="idEvent">
                    <option id="selection" value="">Veuillez choisir un evenement</option>
                    <?php 
                    $stmt = $pdo->query("SELECT title,EXTRACT(day FROM start) AS jourDebut, EXTRACT(month FROM start) AS moisDebut,EXTRACT(hour FROM start) AS heureDebutRDVdebut, EXTRACT(minute FROM start) AS minDebutRDVdebut, EXTRACT(day FROM end) AS jourFin, EXTRACT(month FROM end) AS moisFin, EXTRACT(hour FROM end) AS hourFin, EXTRACT(minute FROM end) AS minFin, id FROM `rdv_calendar` WHERE start > NOW() ORDER BY UNIX_TIMESTAMP(start) ASC ");
                    $row = $stmt->fetch();
                    if($row===false){
                        echo '<option id="selection" value="">Aucun évenement futur</option>';

                    }
                    else{
                        $stmt = $pdo->query("SELECT title,EXTRACT(day FROM start) AS jourDebut, EXTRACT(month FROM start) AS moisDebut,EXTRACT(hour FROM start) AS heureDebutRDVdebut, EXTRACT(minute FROM start) AS minDebutRDVdebut, EXTRACT(day FROM end) AS jourFin, EXTRACT(month FROM end) AS moisFin, EXTRACT(hour FROM end) AS hourFin, EXTRACT(minute FROM end) AS minFin, id FROM `rdv_calendar` WHERE start > NOW() ORDER BY UNIX_TIMESTAMP(start) ASC ");
                        while ($row = $stmt->fetch()) {
                            echo '<option value="'.$row["id"].'">'.$row["title"]." du ".$row["jourDebut"]."/".$row["moisDebut"].", ".$row["heureDebutRDVdebut"]."h".$row["minDebutRDVdebut"]." au ".$row["jourFin"]."/".$row["moisFin"].", ".$row["hourFin"]."h".$row["minFin"].'</option>';
                            }
                        }
                    ?>
                    
                </select>
                <br> <br>
                <div class="bouttonsPopup">
                    <button id="supprimerPopupEvent">Valider</button>
                    <button class="fermerPopup">Fermer</button>
                </div>
            </div>
        </div>

        <!-- Popup Ajouter Preset -->
        <div id="backgroundAjouterPreset" class="popup hidden">
            <div class="popup-content">
                <h2>Ajouter un preset</h2>
                <input type="text" name="" class="ajouterPreset" placeholder="Entrez le nom du preset">
                <br> <br>
                <div class="bouttonsPopup">
                    <button id="AjouterPresetEvent" >Valider</button>
                    <button class="fermerPopup">Fermer</button>
                </div>
                <br>
            </div>
        </div>  

        <!-- Popup Supprimer Preset -->
        <div id="backgroundSupprimerPreset" class="popup hidden">
            <div class="popup-content">
                <h2>Supprimer un preset</h2>
                <select name="" id="idPreset">
                <?php 
                    $stmt = $pdo->query("SELECT title FROM event_preset");
                    while ($row = $stmt->fetch()) {
                        echo '<option value="'.$row["title"].'">'.$row["title"];
                    }
                ?>
                </select>
                <br> <br>
                <div class="bouttonsPopup">
                    <button id="SupprimerPresetEvent">Valider</button>
                    <button class="fermerPopup">Fermer</button>
                </div>
            </div>
        </div> 
        
         <!-- Popup contenu evenement -->
        <div id="backgroundContenuEvenement" class="popup hidden">
            <div class="popup-content">
                <h2>Modifier un événement</h2>
                <div>
                    <h2>Debut du RDV:</h2> <br>
                    <input class="debutModifier" type="datetime-local" name="dateDebut" value="">
                </div>
                <br>
                <div>
                    <h2>Fin du RDV:</h2> <br>
                    <input class="finModifier" type="datetime-local" name="dateFin" value="">
                </div>
                <br>
                <div>
                    <h2>Nom du RDV:</h2> <br>
                    <input type="text" class="titleModifier" value="">                
                </div>
                <br>
                <div>
                    <h2>Client:</h2> <br>
                    <select name="" id="clientSelect2">
                    <?php  
                        $stmt = $pdo->query("SELECT `id`,`last_name`, `first_name` FROM `client`");
                        while ($row = $stmt->fetch()) {
                            echo '<option value="'.$row["id"].'">'.$row["last_name"]." ".$row["first_name"].'</option>';
                        }
                    ?>
                    </select>
                </div>
                <br>
                <div class="bouttonsPopup">
                    <button class="ModifierEvent" value="">Modifier</button>
                    <button class="fermerPopup">Fermer</button>
                </div>
            </div>
        </div> 


        <script>
            const eventsBDD = <?= json_encode($events) ?>;
        </script>
        <script src="../popup.js"></script>
        <script src="../calendar.js"></script>
    </body>
</html>
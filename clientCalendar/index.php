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
        <div class="container" id="external-events">
            <div>
                <div id="calendar"></div>
            </div>
        </div>
        <br>

        <!-- Partie pour les popups -->


        <script>
            const eventsBDD = <?= json_encode($events) ?>;
        </script>
        <script src="./popup.js"></script>
        <script src="./calendar.js"></script>
    </body>
</html>
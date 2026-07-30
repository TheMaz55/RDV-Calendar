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

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$stmt = $pdo->prepare(" SELECT  rdv_calendar.id, rdv_calendar.title, rdv_calendar.id_client, rdv_calendar.start, rdv_calendar.end, client.first_name, client.last_name FROM rdv_calendar JOIN client ON client.id = rdv_calendar.id_client WHERE rdv_calendar.id = :id");

$stmt->execute([":id" => $_POST["id"]]);

echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
?>

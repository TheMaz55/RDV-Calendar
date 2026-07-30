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


$stmt = $pdo->prepare(" INSERT INTO `rdv_calendar` (`start`, `end`, `id_client` , `title`) VALUES (:start, :end, :id_client, :title)");
$stmt->execute([':start' => $_POST['debutRDV'],':end' => $_POST['finRDV'],':title' => $_POST['title'],':id_client' => $_POST['client']]);

?>

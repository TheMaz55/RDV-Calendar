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

$stmt = $pdo->prepare(" UPDATE `rdv_calendar` SET `start`=:start,`end`=:end WHERE `id`=:id");
$stmt->execute([':start' => $_POST['NouveauDebut'],':end' => $_POST['NouveauFin'],':id' => $_POST['id']]);

?>

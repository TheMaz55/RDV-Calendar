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
    
    $stmt = $pdo->prepare(" DELETE FROM `rdv_calendar` WHERE `id`=:id ");
    $stmt->execute([':id' => $_POST["id"]]);

    echo "l id: ".$_POST["id"]." a ete supprime"
?>

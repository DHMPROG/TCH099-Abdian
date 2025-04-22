<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';


    $verif = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    $verif->execute([$email]);

    if ($verif->rowCount() > 0) {
        die("Cet email est déjà utilisé.");
    }

 
    $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, mot_de_passe_en_clair, telephone) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$prenom, $nom, $email, $hash, $mot_de_passe, $telephone]);


    header("Location: ../index.html?inscription=success");
    exit();
} else {
    die("Méthode non autorisée.");
}

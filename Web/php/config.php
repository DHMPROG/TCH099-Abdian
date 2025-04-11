<?php
$host = 'mysql'; 
$port = '3306';  
$dbname = 'abdian_db';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

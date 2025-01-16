<?php
$servername = "localhost";
$username = "root"; 
$password = "hamdi"; 
$dbname = "YoudemyDB";

try {
    // Création de la connexion
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion: " . $e->getMessage();
}
?>

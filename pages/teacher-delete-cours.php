<?php
require_once '../db.php'; 
require_once '../classes/Cours.php'; 

if (isset($_GET['id'])) {
    $coursId = $_GET['id'];

    $cours = new Cours($conn);
    $cours->supprimerCours($coursId);

    // Redirige vers la page de gestion des cours après suppression
    header("Location: teacher-manageCourses.php");
    exit();
} else {
    echo "ID de cours non spécifié.";
}
?>

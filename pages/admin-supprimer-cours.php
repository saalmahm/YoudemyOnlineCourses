<?php
require_once '../db.php';
require_once '../classes/User.php';
require_once '../classes/Cours.php';
require_once '../classes/Administrateur.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$cours_id = $_GET['id'] ?? null;
if (!$cours_id) {
    header("Location: admin-listCourses.php");
    exit();
}

$coursObj = new Cours($conn);
try {
    if ($coursObj->supprimerCours($cours_id)) {
        header("Location: admin-listCourses.php");
        exit();
    } else {
        echo "Échec de la suppression du cours.";
    }
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>

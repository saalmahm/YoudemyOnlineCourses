<?php
require_once '../db.php'; // Connexion à la base de données
require_once '../classes/Etudiant.php'; // Classe Etudiant

session_start();

// Vérifie si l'utilisateur est connecté et est un étudiant
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'étudiant') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$etudiantId = $_SESSION['user_id'];
$coursId = $_POST['cours_id'];

try {
    $etudiant = new Etudiant($conn, $etudiantId, $_SESSION['nom'], $_SESSION['email'], $_SESSION['password']);
    $etudiant->sinscrireCours($coursId);
    echo json_encode(['success' => true, 'message' => 'Inscription réussie']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

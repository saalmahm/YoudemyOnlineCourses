<?php
session_start();
require_once '../db.php';
require_once '../classes/Etudiant.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'étudiant') {
    echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
    exit();
}

$userId = $_SESSION['user_id'];
$coursId = $_POST['cours_id'] ?? '';

if (empty($coursId)) {
    echo json_encode(['success' => false, 'message' => 'ID de cours manquant.']);
    exit();
}

try {
    $etudiant = new Etudiant($conn, $userId, '', '', ''); 
    $etudiant->sinscrireCours($coursId);
    echo json_encode(['success' => true, 'message' => 'Inscription réussie.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

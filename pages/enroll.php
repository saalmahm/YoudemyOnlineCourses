<?php
require_once '../db.php'; 
require_once '../classes/Etudiant.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

$studentId = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$courseId = $data['courseId'] ?? null;

if (!$courseId) {
    echo json_encode(['success' => false, 'message' => 'ID de cours manquant']);
    exit();
}

// Debugging outputs
error_log("Student ID: " . $studentId);
error_log("Received course ID: " . $courseId);

try {
    $etudiant = new Etudiant($conn, $studentId, $_SESSION['user_nom'], $_SESSION['user_email'], '');
    $etudiant->sinscrireCours($courseId);
    echo json_encode(['success' => true, 'message' => 'Inscription réussie']);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

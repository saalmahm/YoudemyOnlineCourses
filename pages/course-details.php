<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'étudiant') {
    header("Location: login.php");
    exit();
}

require_once '../db.php';
require_once '../classes/Cours.php';

$coursId = $_GET['id'] ?? '';

if (empty($coursId)) {
    echo "ID de cours manquant.";
    exit();
}

$cours = new Cours($conn);
$courseDetails = $cours->recupererUnCours($coursId);
$courseContents = $cours->recupererContenusParCours($coursId);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails du cours</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-indigo-700 mb-6"><?= htmlspecialchars($courseDetails['titre'] ?? '') ?></h1>
    <p class="text-gray-600 mb-4"><?= htmlspecialchars($courseDetails['description'] ?? '') ?></p>
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Contenu du cours</h2>
    <ul class="list-disc list-inside">
        <?php foreach ($courseContents as $content): ?>
            <li class="text-gray-600"><?= htmlspecialchars($content['titre'] ?? '') ?>: <?= htmlspecialchars($content['data'] ?? '') ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="/pages/student-courses.php" class="text-indigo-500 hover:underline mt-4 inline-block">Retour à la liste des cours</a>
  </div>
</body>
</html>

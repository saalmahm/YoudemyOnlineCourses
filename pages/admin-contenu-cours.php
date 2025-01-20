<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
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
  <style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .iframe-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 75%; 
    }
    .iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
  </style>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-indigo-700 mb-6"><?= htmlspecialchars($courseDetails['titre'] ?? '') ?></h1>
    <p class="text-gray-600 mb-4"><?= htmlspecialchars($courseDetails['description'] ?? '') ?></p>
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Contenu du cours</h2>
    <ul class="list-disc list-inside">
        <?php foreach ($courseContents as $content): ?>
            <li class="text-gray-600">
                <?= htmlspecialchars($content['titre'] ?? '') ?>:
                <?php if ($content['type'] === 'document' && pathinfo($content['data'], PATHINFO_EXTENSION) === 'pdf'): ?>
                    <div class="iframe-container">
                        <iframe src="<?= htmlspecialchars($content['data'] ?? '') ?>"></iframe>
                    </div>
                <?php else: ?>
                    <?= htmlspecialchars($content['data'] ?? '') ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="/pages/admin-listCourses.php" class="text-indigo-500 hover:underline mt-4 inline-block">Retour à la liste des cours</a>
  </div>
</body>
</html>

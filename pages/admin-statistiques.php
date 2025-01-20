<?php
require_once '../db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer le nombre total de cours
$query = "SELECT COUNT(*) as total_courses FROM Cours";
$stmt = $conn->query($query);
$total_courses = $stmt->fetch(PDO::FETCH_ASSOC)['total_courses'];

// Récupérer la répartition des cours par catégorie
$query = "SELECT Catégorie.nom, COUNT(Cours.id) as nombre FROM Cours 
          JOIN Catégorie ON Cours.catégorie_id = Catégorie.id 
          GROUP BY Catégorie.nom";
$stmt = $conn->query($query);
$courses_by_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le cours avec le plus d'étudiants
$query = "SELECT Cours.titre, COUNT(ÉtudiantCours.étudiant_id) as nombre_etudiants FROM ÉtudiantCours
          JOIN Cours ON ÉtudiantCours.cours_id = Cours.id
          GROUP BY Cours.titre
          ORDER BY nombre_etudiants DESC
          LIMIT 1";
$stmt = $conn->query($query);
$most_popular_course = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer les Top 3 enseignants
$query = "SELECT Utilisateur.nom, COUNT(Cours.id) as nombre_cours FROM Cours
          JOIN Utilisateur ON Cours.created_by = Utilisateur.id
          GROUP BY Utilisateur.nom
          ORDER BY nombre_cours DESC
          LIMIT 3";
$stmt = $conn->query($query);
$top_teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Statistiques Globales</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col items-center justify-center py-12">
        <h1 class="text-3xl font-bold text-blue-700 mb-8">Statistiques Globales</h1>
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-4xl">
            <h2 class="text-2xl font-semibold mb-4">Nombre total de cours</h2>
            <p class="text-xl"><?= $total_courses ?></p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-4xl mt-6">
            <h2 class="text-2xl font-semibold mb-4">Répartition des cours par catégorie</h2>
            <ul class="list-disc list-inside">
                <?php foreach ($courses_by_category as $category): ?>
                    <li class="text-lg"><?= htmlspecialchars($category['nom']) ?> : <?= $category['nombre'] ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-4xl mt-6">
            <h2 class="text-2xl font-semibold mb-4">Le cours avec le plus d'étudiants</h2>
            <p class="text-xl"><?= htmlspecialchars($most_popular_course['titre']) ?> : <?= $most_popular_course['nombre_etudiants'] ?> étudiants</p>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-4xl mt-6">
            <h2 class="text-2xl font-semibold mb-4">Top 3 enseignants</h2>
            <ul class="list-decimal list-inside">
                <?php foreach ($top_teachers as $teacher): ?>
                    <li class="text-lg"><?= htmlspecialchars($teacher['nom']) ?> : <?= $teacher['nombre_cours'] ?> cours</li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>

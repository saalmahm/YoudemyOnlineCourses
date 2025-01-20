<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'étudiant') {
    header("Location: login.php");
    exit();
}

require_once '../db.php';
require_once '../classes/Etudiant.php';

// Récupérer l'ID de l'utilisateur connecté
$userId = $_SESSION['user_id'];

$etudiant = new Etudiant($conn, $userId, '', '', '');

// Récupérer la liste des cours inscrits
$coursesList = $etudiant->consulterCoursInscrits();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col">
      <div class="p-6 text-center bg-indigo-800">
        <h1 class="text-2xl font-bold">Student Page</h1>
      </div>
      <nav class="flex-grow p-4">
        <ul>
          <li class="mb-4">
            <a href="/pages/myCourses-student.php" class="flex items-center p-3 rounded hover:bg-indigo-600 transition">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              My Courses
            </a>
          </li>
          <li class="mb-4">
            <a href="/pages/student-courses.php" class="flex items-center p-3 rounded hover:bg-indigo-600 transition">
              <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              All courses
            </a>
          </li>
          <li class="mb-4">
          <div class="p-4 bg-indigo-800 mt-80">
     <a href="/pages/logout.php" class="w-full bg-red-500 text-white py-2 px-10 rounded hover:bg-red-600 transition text-center">Logout</a>    
      </div>
          </li>
        </ul>
      </nav>
    </aside>

    <main class="flex-grow p-6">
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-indigo-700">Welcome Student,</h2>
    </header>
    
    <!-- Section pour afficher les cours inscrits -->
    <section class="pb-16">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Mes Cours</h2>
    <div id="courses-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if (!empty($coursesList) && is_array($coursesList)): ?>
            <?php foreach ($coursesList as $course): ?>
                <div class="course-card bg-white rounded-lg shadow-md p-4 flex flex-col space-y-3">
                    <h2 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($course['titre'] ?? '') ?></h2>
                    <p class="text-gray-600 mb-2"><?= htmlspecialchars($course['description'] ?? '') ?></p>
                    <a href="/pages/course-details.php?id=<?= htmlspecialchars($course['id'] ?? '') ?>" class="text-indigo-500 hover:underline">Voir détails</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-600">Aucun cours inscrit pour le moment.</p>
        <?php endif; ?>
    </div>
  </div>
</section>
  </main>
  </div>
</body>
</html>

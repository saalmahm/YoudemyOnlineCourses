<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'étudiant') {
    header("Location: login.php");
    exit();
}

require_once '../db.php';
require_once '../classes/Etudiant.php';

$userId = $_SESSION['user_id'];

$etudiant = new Etudiant($conn, $userId, '', '', '');

$coursesList = $etudiant->consulterCoursInscrits();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .logout-btn {
        background: linear-gradient(to right, #ff4c4c, #ff1a1a); /* Red gradient */
        color: white;
      margin-bottom: 1rem;
      padding: 0.75rem;
      border-radius: 0.375rem;
      display: flex;
      align-items: center;
      transition: background 0.3s ease;
    }
    .nav-link {
      background: linear-gradient(to right, #11998e, #38ef7d);
      color: white;
      margin-bottom: 1rem;
      padding: 0.75rem;
      border-radius: 0.375rem;
      display: flex;
      align-items: center;
      transition: background 0.3s ease;
    }
    .nav-link:hover {
      background: linear-gradient(to right, #0f766e, #33d17a);
    }
    .nav-link svg {
      margin-right: 0.75rem;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen relative">
    <!-- Sidebar -->
    <aside class="w-64 bg-green-700 text-white flex flex-col relative">
      <div class="p-6 text-center bg-green-800">
        <h1 class="text-2xl font-bold">Student Page</h1>
      </div>
      <nav class="flex-grow p-4">
        <ul>
          <li>
            <a href="/pages/myCourses-student.php" class="nav-link">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              My Courses
            </a>
          </li>
          <li>
            <a href="/pages/student-courses.php" class="nav-link">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              All courses
            </a>
          </li>
          <li>
            <a href="/pages/logout.php" class="logout-btn">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12h6M12 15v-6M19 12a7 7 0 11-14 0a7 7 0 0114 0z"></path>
              </svg>
              Logout
            </a>    
          </li>
        </ul>
      </nav>
    </aside>

    <main class="flex-grow p-6">
      <header class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-green-700">Welcome Student,</h2>
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
                        <a href="/pages/course-details.php?id=<?= htmlspecialchars($course['id'] ?? '') ?>" class="text-green-500 hover:underline">Voir détails</a>
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

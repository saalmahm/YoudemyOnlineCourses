<?php
require_once '../db.php';
require_once '../classes/Administrateur.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Admin';
$user_email = $_SESSION['user_email'] ?? '';
$user_password = $_SESSION['user_password'] ?? '';

$admin = new Administrateur($conn, $user_id, $user_name, $user_email, $user_password);

$total_courses = $admin->totalCours();
$courses_by_category = $admin->repartitionCoursParCategorie();
$most_popular_course = $admin->coursPlusPopulaire();
$top_teachers = $admin->topEnseignants();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Statistiques Globales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    .nav-link {
      background: linear-gradient(to right, #0066cc, #00ccff);
      color: white;
      margin-bottom: 1rem;
      padding: 0.75rem;
      border-radius: 0.375rem;
      display: flex;
      align-items: center;
      transition: background 0.3s ease;
    }
    .nav-link:hover {
      background: linear-gradient(to right, #004d99, #0099cc);
    }
    .nav-link svg {
      margin-right: 0.75rem;
    }
    .logout-btn {
      background: linear-gradient(to right, #ff416c, #ff4b2b);
      color: white;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-700 text-white flex flex-col relative">
            <div class="p-6 text-center bg-blue-800">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            </div>
            <nav class="flex-grow p-4">
                <ul>
                    <li>
                        <a href="/pages/admin-statistiques.php" class="nav-link">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Statistics
                        </a>
                    </li>
                    <li>
                        <a href="/pages/admin-listUsers.php" class="nav-link">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Manage Users account
                        </a>
                    </li>
                    <li>
                        <a href="/pages/admin-listCourses.php" class="nav-link">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Manage Courses
                        </a>
                    </li>
                    <li>
                        <a href="/pages/admin-listCategories.php" class="nav-link">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Manage Categories
                        </a>
                    </li>
                    <li>
                        <a href="/pages/admin-listTags.php" class="nav-link">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Manage Tags
                        </a>
                    </li>
                    <li>
                        <a href="/pages/logout.php" class="nav-link logout-btn">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12h6M12 15v-6M19 12a7 7 0 11-14 0a7 7 0 0114 0z"></path>
                            </svg>
                            Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="flex-grow p-6 bg-gray-100">
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-4xl font-extrabold text-blue-700">Statistiques Globales</h2>
    </header>

    <div class="grid gap-6 grid-cols-1 lg:grid-cols-2 xl:grid-cols-2">
        <!-- Nombre total de cours -->
        <div class="bg-gradient-to-r from-teal-300 to-teal-500 text-black shadow-lg rounded-lg p-6 transform transition-transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center">
                <div class="text-4xl mr-4">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">Nombre total de cours</h2>
                    <p class="text-3xl font-semibold"><?= $total_courses ?></p>
                </div>
            </div>
        </div>

        <!-- Répartition des cours par catégorie -->
        <div class="bg-gradient-to-r from-green-200 to-green-400 text-gray-800 shadow-lg rounded-lg p-6 transform transition-transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center">
                <div class="text-4xl mr-4">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">Répartition des cours par catégorie</h2>
                    <ul class="list-disc list-inside text-lg space-y-2">
                        <?php foreach ($courses_by_category as $category): ?>
                            <li><?= htmlspecialchars($category['nom']) ?> : <span class="font-semibold"><?= $category['total'] ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Le cours avec le plus d'étudiants -->
        <div class="bg-gradient-to-r from-purple-200 to-purple-400 text-gray-800 shadow-lg rounded-lg p-6 transform transition-transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center">
                <div class="text-4xl mr-4">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">Le cours avec le plus d'étudiants</h2>
                    <p class="text-lg">
                        <span class="font-bold"><?= htmlspecialchars($most_popular_course['titre']) ?></span> : 
                        <span class="font-semibold"><?= $most_popular_course['total'] ?> étudiants</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Top 3 enseignants -->
        <div class="bg-gradient-to-r from-pink-200 to-pink-400 text-gray-800 shadow-lg rounded-lg p-6 transform transition-transform hover:scale-105 hover:shadow-2xl">
            <div class="flex items-center">
                <div class="text-4xl mr-4">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-2">Top 3 enseignants</h2>
                    <ul class="list-decimal list-inside text-lg space-y-2">
                        <?php foreach ($top_teachers as $teacher): ?>
                            <li>
                                <span class="font-semibold"><?= htmlspecialchars($teacher['nom']) ?></span> :
                                <span class="font-semibold"><?= $teacher['nombre_cours'] ?> cours</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>



    </div>
</body>
</html>

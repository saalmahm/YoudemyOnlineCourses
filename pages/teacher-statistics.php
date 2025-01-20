<?php
require_once '../db.php'; 
require_once '../classes/Cours.php';

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'enseignant') {
    header("Location: login.php");
    exit();
}

$cours = new Cours($conn);
$user_id = $_SESSION['user_id'];
$totalCours = $cours->getTotalCours($user_id);
$totalEtudiants = $cours->getTotalEtudiants($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
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
  <div class="flex min-h-screen relative">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-700 text-white flex flex-col relative">
      <div class="p-6 text-center bg-blue-800">
        <h1 class="text-2xl font-bold">Teacher Dashboard</h1>
      </div>
      <nav class="flex-grow p-4">
        <ul>
          <li>
            <a href="/pages/teacher-statistics.php" class="nav-link">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Statistiques
            </a>
          </li>
          <li>
            <a href="/pages/teacher-manageCourses.php" class="nav-link">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Gestion des Cours
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

    <main class="flex-grow p-6">
      <header class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-blue-700">Welcome Teacher,</h2>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-2">Total de Cours</h3>
          <p class="text-4xl font-bold"><?php echo $totalCours; ?></p>
        </div>
        <div class="bg-gradient-to-r from-blue-400 to-blue-500 text-white shadow-lg rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-2">Total d'Étudiants</h3>
          <p class="text-4xl font-bold"><?php echo $totalEtudiants; ?></p>
        </div>
        <div class="bg-gradient-to-r from-blue-400 to-red-500 text-white shadow-lg rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-2">Cours les Plus Populaires</h3>
          <p class="text-4xl font-bold">"Introduction à PHP"</p>
        </div>
      </div>
    </main>
  </div>
</body>
</html>

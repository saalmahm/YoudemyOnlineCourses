<?php
require_once '../db.php';
require_once '../classes/User.php';
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
$utilisateurs = $admin->afficherUsers();
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
            <a href="/pages/teacher-statistics.php" class="nav-link">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Manage Category
            </a>
          </li>
          <li>
            <a href="/pages/teacher-statistics.php" class="nav-link">
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

    <main class="flex-grow p-6">
      <header class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-blue-700">Welcome Admin,</h2>
      </header>

    <!-- Tableau des Utilisateurs -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nom</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Rôle</th>
                    <th scope="col" class="px-6 py-3">Statut</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <?php if ($utilisateur['id'] !== $user_id): // Exclure l'utilisateur connecté ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            <?= htmlspecialchars($utilisateur['id']) ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= htmlspecialchars($utilisateur['nom']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= htmlspecialchars($utilisateur['email']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= htmlspecialchars($utilisateur['rôle']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= htmlspecialchars($utilisateur['active'] ? 'Actif' : 'Inactif') ?>
                        </td>
                        <td class="px-6 py-4 flex space-x-4">
                            <?php if ($utilisateur['active']) { ?>
                                <a href="./admin-suspendre-user.php?id=<?= $utilisateur['id'] ?>" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline">Suspendre</a>
                            <?php } else { ?>
                                <a href="./admin-activer-user.php?id=<?= $utilisateur['id'] ?>" class="font-medium text-green-600 dark:text-green-500 hover:underline">Activer</a>
                            <?php } ?>
                            <a href="./admin-supprimer-user.php?id=<?= $utilisateur['id'] ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline">Supprimer</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>
  </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-700 text-white flex flex-col">
      <div class="p-6 text-center bg-indigo-800">
        <h1 class="text-2xl font-bold">Teacher Dashboard</h1>
      </div>
      <nav class="flex-grow p-4">
        <ul>
          <li class="mb-4">
            <a href="/pages/teacher-statistics.php" class="flex items-center p-3 rounded hover:bg-indigo-600 transition">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Statistiques
            </a>
          </li>
          <li class="mb-4">
            <a href="/pages/teacher-manageCourses.php" class="flex items-center p-3 rounded hover:bg-indigo-600 transition">
              <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Gestion des Cours
            </a>
          </li>
        </ul>
      </nav>
      <div class="p-4 bg-indigo-800">
      <a href="/pages/logout.php" class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition text-center px-10">Déconnexion</a>    
      </div>
    </aside>

    <main class="flex-grow p-6">
      <header class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-indigo-700">Welcome Teacher,</h2>
      </header>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-2">Total de Cours</h3>
          <p class="text-4xl font-bold">120</p>
        </div>
        <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white shadow-lg rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-2">Total d'Étudiants</h3>
          <p class="text-4xl font-bold">1,500</p>
        </div>
        <div class="bg-gradient-to-r from-yellow-400 to-red-500 text-white shadow-lg rounded-lg p-6">
          <h3 class="text-lg font-semibold mb-2">Cours les Plus Populaires</h3>
          <p class="text-4xl font-bold">"Introduction à PHP"</p>
        </div>
      </div>


    </main>
  </div>
</body>
</html>

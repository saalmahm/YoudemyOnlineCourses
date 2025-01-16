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
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
      </div>
      <nav class="flex-grow p-4">
        <ul>
          <li class="mb-4">
            <a href="#" class="flex items-center p-3 rounded hover:bg-indigo-600 transition">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Statistiques
            </a>
          </li>
          <li class="mb-4">
            <a href="#" class="flex items-center p-3 rounded hover:bg-indigo-600 transition">
              <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h7"></path>
              </svg>
              Gestion des Cours
            </a>
          </li>
        </ul>
      </nav>
      <div class="p-4 bg-indigo-800">
        <button class="w-full bg-red-500 text-white py-2 rounded hover:bg-red-600 transition">Déconnexion</button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow p-6">
      <!-- Header -->
      <header class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-indigo-700">Tableau de Bord</h2>
        <input type="text" placeholder="Rechercher..." class="p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-200">
      </header>

      <!-- Statistiques Globales -->
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

      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-bold mb-4 text-gray-700">Gestion des Cours</h3>
        <table class="table-auto w-full border-collapse">
          <thead>
            <tr class="bg-gray-200 text-gray-700">
              <th class="border p-3">ID</th>
              <th class="border p-3">Titre</th>
              <th class="border p-3">Catégorie</th>
              <th class="border p-3">Auteur</th>
              <th class="border p-3">Étudiants</th>
              <th class="border p-3">Statut</th>
              <th class="border p-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="hover:bg-gray-100">
              <td class="border p-3 text-center">1</td>
              <td class="border p-3">Introduction à PHP</td>
              <td class="border p-3">Programmation</td>
              <td class="border p-3">John Doe</td>
              <td class="border p-3 text-center">200</td>
              <td class="border p-3 text-center">
                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm">Publié</span>
              </td>
              <td class="border p-3 text-center">
                <button class="bg-blue-500 text-white px-3 py-1 rounded shadow hover:bg-blue-600 transition">Modifier</button>
                <button class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 transition">Supprimer</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>

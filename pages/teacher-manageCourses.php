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
     <a href="/pages/logout.php" class="w-full bg-red-500 text-white py-2 px-10 rounded hover:bg-red-600 transition text-center">Déconnexion</a>    
      </div>
    </aside>

    <main class="flex-grow p-6">
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-indigo-700">Welcome Teacher,</h2>
        <!-- Bouton pour ouvrir la modal -->
        <button id="open-modal" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700" > Add New Course  </button>
    </header>

    <!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl w-full">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-bold text-gray-700">Add New Course</h2>
      <button id="close-modal" class="text-gray-500 hover:text-gray-700 font-bold text-lg">×</button>
    </div>
    <form id="course-form" method="POST" action="/path/to/handle/form.php">
      <!-- Section Cours -->
      <div class="mb-4">
        <label for="course-title" class="block text-sm font-medium text-gray-700">Course Title</label>
        <input type="text" id="course-title" name="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter course title" required />
      </div>
      <div class="mb-4">
        <label for="course-description" class="block text-sm font-medium text-gray-700">Course Description</label>
        <textarea id="course-description" name="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter course description" required></textarea>
      </div>
      <div class="mb-4">
        <label for="course-category" class="block text-sm font-medium text-gray-700">Category</label>
        <?php
            require_once '../db.php'; 
            require_once '../classes/Categorie.php'; 

            $categorie = new Categorie($conn);
            $categories = $categorie->recupererCategories();
            ?>
        <select id="course-category" name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
          <option value="">Select a category</option>
          <?php foreach ($categories as $cat) : ?>
            <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['nom']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <!-- Section Contenus -->
      <div id="content-section" class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Contents</label>
        <div id="content-fields" class="space-y-4">
          <div class="content-item flex space-x-4 items-center">
            <select name="content-type[]" class="block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
              <option value="">Select content type</option>
              <option value="video">Video</option>
              <option value="document">Document</option>
            </select>
            <input type="text" name="content-data[]" class="block flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter content data (URL or description)" required />
            <button type="button" class="remove-content px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remove</button>
          </div>
        </div>
        <button id="add-content" type="button" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Add Content</button>
      </div>
      <!-- Boutons d'action -->
      <div class="flex justify-end space-x-2">
        <button type="button" id="cancel-modal" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Course</button>
      </div>
    </form>
  </div>
</div>

      <!-- Tableau des Cours -->
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr>
      <th scope="col" class="px-6 py-3">
        Titre du Cours
      </th>
      <th scope="col" class="px-6 py-3">
        Description
      </th>
      <th scope="col" class="px-6 py-3">
        Contenu
      </th>
      <th scope="col" class="px-6 py-3">
        Tags
      </th>
      <th scope="col" class="px-6 py-3">
        Catégorie
      </th>
      <th scope="col" class="px-6 py-3">
        Action
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
      <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        Cours Python
      </th>
      <td class="px-6 py-4">
        Apprendre Python de manière interactive.
      </td>
      <td class="px-6 py-4">
        Vidéo + Document
      </td>
      <td class="px-6 py-4">
        Python, Développement
      </td>
      <td class="px-6 py-4">
        Programmation
      </td>
      <td class="px-6 py-4 flex space-x-4">
        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Modifier</a>
        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Supprimer</a>
      </td>
    </tr>
    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
      <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        Cours JavaScript
      </th>
      <td class="px-6 py-4">
        Introduction au JavaScript moderne.
      </td>
      <td class="px-6 py-4">
        Vidéo
      </td>
      <td class="px-6 py-4">
        JavaScript, Frontend
      </td>
      <td class="px-6 py-4">
        Développement Web
      </td>
      <td class="px-6 py-4 flex space-x-4">
        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Modifier</a>
        <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">Supprimer</a>
      </td>
    </tr>
  </tbody>
</table>


      </div>
    </main>
  </div>

  <script>
  // Get elements
  const modal = document.getElementById("modal");
  const openModal = document.getElementById("open-modal");
  const closeModal = document.getElementById("close-modal");
  const cancelModal = document.getElementById("cancel-modal");
  const addContent = document.getElementById("add-content");
  const contentFields = document.getElementById("content-fields");

  // Open modal
  openModal.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });

  // Close modal
  [closeModal, cancelModal].forEach((button) => {
    button.addEventListener("click", () => {
      modal.classList.add("hidden");
    });
  });

  // Add new content field
  addContent.addEventListener("click", () => {
    const contentItem = document.createElement("div");
    contentItem.classList.add("content-item", "flex", "space-x-4", "items-center");
    contentItem.innerHTML = `
      <select name="content-type[]" class="block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
        <option value="">Select content type</option>
        <option value="video">Video</option>
        <option value="document">Document</option>
      </select>
      <input type="text" name="content-data[]" class="block flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter content data (URL or description)" required />
      <button type="button" class="remove-content px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remove</button>
    `;
    contentFields.appendChild(contentItem);

    // Add event listener for removing content
    contentItem.querySelector(".remove-content").addEventListener("click", () => {
      contentItem.remove();
    });
  });

  // Remove existing content field
  contentFields.addEventListener("click", (event) => {
    if (event.target.classList.contains("remove-content")) {
      event.target.closest(".content-item").remove();
    }
  });
</script>

</body>
</html>

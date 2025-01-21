
<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'enseignant') {
    header("Location: login.php");
    exit();
}

require '../db.php';
require '../classes/Cours.php';

$cours = new Cours($conn);
$user_id = $_SESSION['user_id'];
$tousLesCours = $cours->recupererEnseignantCours($user_id);

// Vérifiez si $tousLesCours est défini et contient des cours
if ($tousLesCours === false) {
    $tousLesCours = [];
}

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
        <button id="open-modal" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Add New Course</button>
      </header>

      <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl w-full max-h-full overflow-y-auto">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-700">Add New Course</h2>
            <button id="close-modal" class="text-gray-500 hover:text-gray-700 font-bold text-lg">×</button>
          </div>
          <form id="course-form" method="POST" action="./add-cours.php" enctype="multipart/form-data">
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
                require_once '../classes/Tag.php'; 

                $categorie = new Categorie($conn);
                $categories = $categorie->recupererCategories();

                $tag = new Tag($conn);
                $tags = $tag->recupererTags();
              ?>
              <select id="course-category" name="category" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $cat) : ?>
                  <option value="<?= htmlspecialchars($cat['id']) ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- Section Tags -->
            <div class="mb-4">
              <label for="course-tags" class="block text-sm font-medium text-gray-700">Tags</label>
              <select id="course-tags" name="tags[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" multiple required>
                <?php foreach ($tags as $tag) : ?>
                  <option value="<?= htmlspecialchars($tag['id']) ?>"><?= htmlspecialchars($tag['nom']) ?></option>
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
            <input type="file" name="content-data[]" class="block flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter content data (URL or description)" required />
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
                <th scope="col" class="px-6 py-3">Titre du Cours</th>
                <th scope="col" class="px-6 py-3">Description</th>
                <th scope="col" class="px-6 py-3">Contenu</th>
                <th scope="col" class="px-6 py-3">Tags</th>
                <th scope="col" class="px-6 py-3">Catégorie</th>
                <th scope="col" class="px-6 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($tousLesCours as $coursInfo) {
                $contenus = $cours->recupererContenusParCours($coursInfo['id']);
                $tags = $cours->recupererTagsParCours($coursInfo['id']);

                $contenusStr = implode(", ", array_map(function($contenu) {
                    return ucfirst($contenu['type']);
                }, $contenus));

                $tagsStr = implode(", ", array_map(function($tag) {
                    return ucfirst($tag['nom']);
                }, $tags));
            ?>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?= htmlspecialchars($coursInfo['titre']) ?>
                </th>
                <td class="px-6 py-4">
                    <?= htmlspecialchars($coursInfo['description']) ?>
                </td>
                <td class="px-6 py-4">
                    <?= htmlspecialchars($contenusStr) ?>
                </td>
                <td class="px-6 py-4">
                    <?= htmlspecialchars($tagsStr) ?>
                </td>
                <td class="px-6 py-4">
                    <?= htmlspecialchars($coursInfo['categorie_nom']) ?>
                </td>
                <td class="px-6 py-4 flex space-x-4">
                    <a href="./teacher-edit-cours.php?id=<?= $coursInfo['id'] ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Modifier</a>
                    <a href="./teacher-delete-cours.php?id=<?= $coursInfo['id'] ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline">Supprimer</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
    </main>
  </div>

<script>
  const modal = document.getElementById("modal");
  const openModal = document.getElementById("open-modal");
  const closeModal = document.getElementById("close-modal");
  const cancelModal = document.getElementById("cancel-modal");
  const addContent = document.getElementById("add-content");
  const contentFields = document.getElementById("content-fields");

  openModal.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });

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
      <input type="file" name="content-data[]" class="block flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter content data (URL or description)" required />
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

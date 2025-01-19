<?php
require_once '../db.php'; 
require_once '../classes/Cours.php'; 

function getCourses($conn) {
    $cours = new Cours($conn);
    $coursesList = $cours->recupererTousLesCours();

    foreach ($coursesList as &$course) {
        $courseTags = $cours->recupererTagsParCours($course['id']);
        $course['tags'] = array_column($courseTags, 'nom');
    }

    return $coursesList;
}

$coursesList = getCourses($conn);
?>
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
        <h1 class="text-2xl font-bold">Student Page</h1>
      </div>
      <nav class="flex-grow p-4">
        <ul>
          <li class="mb-4">
            <a href="/pages/teacher-statistics.php" class="flex items-center p-3 rounded hover:bg-indigo-600 transition">
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
    <section class= pb-16">
    <div class="container mx-auto px-4">
        <div id="courses-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($coursesList as $course): ?>
                <div class="course-card bg-white rounded-lg shadow-md p-4 flex flex-col space-y-3">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full">
                            <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="text-gray-800 font-semibold">
                            Prof <?= htmlspecialchars($course['enseignant_nom']) ?>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($course['titre']) ?></h2>
                    <p class="text-gray-600 mb-2"><?= htmlspecialchars($course['description']) ?></p>
                    <p class="text-gray-500 mb-2">Created on <?= htmlspecialchars(date('d M Y', strtotime($course['created_at']))) ?></p>
                    <p class="text-gray-500 mb-2">Category: <?= htmlspecialchars($course['categorie_nom']) ?></p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach ($course['tags'] as $tag): ?>
                            <span class="tag px-3 py-1 text-sm"><?= htmlspecialchars($tag) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="flex justify-end">
                        <a href="#" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-teal-300 to-lime-300 hover:from-teal-300 hover:to-lime-300 focus:ring-4 focus:outline-none focus:ring-lime-200 show-modal">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white text-black rounded-md group-hover:bg-opacity-0">
                            register for the course
                            </span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modale de confirmation -->
    <div id="confirmation-modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m6 4a9 9 0 11-18 0a9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Confirmation                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                You are about to enroll in this course. Do you want to continue?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirm
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm close-modal">
                    Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmation-modal');
    const showModalButtons = document.querySelectorAll('.show-modal');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    showModalButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            modal.classList.remove('hidden');
        });
    });

    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });

    // Optional: Close modal when clicking outside of it
    window.addEventListener('click', (e) => {
        if (e.target == modal) {
            modal.classList.add('hidden');
        }
    });
});
const menu = document.getElementById("burger-icon");
    const sidebar = document.getElementById("sidebar");
    const closeSidebar = document.getElementById("close-sidebar");

    menu.addEventListener("click", () => {
        sidebar.classList.remove("translate-x-full");  
        sidebar.classList.add("translate-x-0");
    });

    closeSidebar.addEventListener("click", () => {
        sidebar.classList.add("translate-x-full");    
        sidebar.classList.remove("translate-x-0");   
    });
</script>
  </main>
  </div>
</body>
</html>

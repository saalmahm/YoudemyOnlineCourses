<?php
require_once '../db.php'; 
require_once '../classes/Cours.php'; 

function getCourses($conn, $limite, $offset) {
    $cours = new Cours($conn);
    $coursesList = $cours->recupererCoursAvecPagination($limite, $offset);

    foreach ($coursesList as &$course) {
        $courseTags = $cours->recupererTagsParCours($course['id']);
        $course['tags'] = array_column($courseTags, 'nom');
    }

    return $coursesList;
}

$limite = 3; 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$offset = ($page - 1) * $limite;

$coursesList = getCourses($conn, $limite, $offset);

$cours = new Cours($conn);
$totalCours = $cours->compterTotalCours();

$totalPages = ceil($totalCours / $limite);

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'étudiant') {
    header("Location: login.php");
    exit();
}
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
      <section class="pb-16">
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
                  <a href="#" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-teal-300 to-lime-300 hover:from-teal-300 hover:to-lime-300 focus:ring-4 focus:outline-none focus:ring-lime-200 register-course" data-id="<?= htmlspecialchars($course['id']) ?>">
                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white text-black rounded-md group-hover:bg-opacity-0">
                      Register for the course
                    </span>
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="flex justify-center mt-8">
            <nav>
              <ul class="flex space-x-4">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                  <li>
                    <a href="?page=<?= $i ?>" class="px-4 py-2 border <?= ($i === $page) ? 'bg-gray-300' : 'bg-white' ?>"><?= $i ?></a>
                  </li>
                <?php endfor; ?>
              </ul>
            </nav>
          </div>
        </div>
      </section>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const registerButtons = document.querySelectorAll('.register-course');

          registerButtons.forEach(button => {
            button.addEventListener('click', async (e) => {
              e.preventDefault();
              const courseId = button.getAttribute('data-id');

              const response = await fetch('/pages/inscription.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ cours_id: courseId })
              });

              const result = await response.json();
              if (result.success) {
                alert(result.message);
                window.location.href = "/pages/myCourses-student.php"; 
              } else {
                alert(`Erreur : ${result.message}`);
              }
            });
          });
        });
      </script>
    </main>
  </div>
</body>
</html>

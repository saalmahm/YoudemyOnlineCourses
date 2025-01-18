<?php
require_once '../db.php'; 
require_once '../classes/Cours.php'; 

function getCourses($conn) {
    $cours = new Cours($conn);
    $coursesList = $cours->recupererTousLesCours();

    // Inclure les tags pour chaque cours
    foreach ($coursesList as &$course) {
        $courseTags = $cours->recupererTagsParCours($course['id']);
        $course['tags'] = array_column($courseTags, 'nom');
    }

    return $coursesList;
}

$coursesList = getCourses($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses | Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .tag {
            background-color: #e0f7fa;
            color: #00796b;
            border-radius: 9999px;
        }
        .tag:hover {
            background-color: #b2ebf2;
            color: #004d40;
        }
        .course-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50">

<header class="flex justify-between p-4 fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <a href="/index.php" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
        <img src="/images/icon-learning.png" class="h-8" alt="Youdemy Logo" />
        <span class="text-2xl font-bold whitespace-nowrap dark:text-gray-500"> Youdemy</span>
    </a>
    <div class="lg:hidden" id="burger-icon">
        <img src="images/menu.png" alt="Menu">
    </div>
    <div id="sidebar" class="shadow-xl fixed top-0 right-0 w-1/3 h-full bg-gray-200 z-50 transform translate-x-full duration-300">
        <div class="flex justify-end p-4">
            <button id="close-sidebar" class="text-3xl">X</button>
        </div>
        <div class="flex flex-col items-center space-y-4 text-white">
            <a href="/index.php" class="text-black text-lg">Home</a>
            <a href="courses.php" class="text-black text-lg">Courses</a>
                <a href="/pages/signup.php" class="text-green-700 text-lg">Sign Up</a>
            
        </div>
    </div>
    <div class="hidden lg:flex justify-center space-x-4">
        <ul class="flex items-center text-sm font-medium text-gray-400 mb-0">
            <li><a href="/index.php" class="hover:underline me-4 md:me-6">Home</a></li>
            <li><a href="courses.php" class="hover:underline me-4 md:me-6">Courses</a></li>
                <li>
                    <a href="/pages/signup.php" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Sign Up</a>
                </li>
            
        </ul>
    </div>
</header>

<section class="pt-24 pb-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Explore Our Courses</h1>
        <div id="courses-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
        <!-- Pagination -->
        <div class="flex justify-center mt-10">
            <nav aria-label="Pagination">
                <ul id="pagination" class="inline-flex items-center space-x-2"></ul>
            </nav>
        </div>
    </div>
</section>

<footer class="bg-white py-6 shadow-md">
    <div class="container mx-auto px-4 text-center">
        <p class="text-sm text-gray-500">© 2025 <a href="#" class="hover:underline">Youdemy™</a>. All Rights Reserved.</p>
    </div>
</footer>

<script>
    const courses = <?php echo json_encode($coursesList); ?>;
    const coursesPerPage = 6;
    const coursesContainer = document.getElementById('courses-container');
    const paginationContainer = document.getElementById('pagination');

function showCourses(page) {
    const startIndex = (page - 1) * coursesPerPage;
    const endIndex = Math.min(startIndex + coursesPerPage, courses.length);

    coursesContainer.innerHTML = '';

    for (let i = startIndex; i < endIndex; i++) {
        const course = courses[i];
        const courseElement = document.createElement('div');
        courseElement.className = 'course-card bg-white rounded-lg shadow-md p-4 flex flex-col space-y-3';

        courseElement.innerHTML = `
            <div class="flex items-center space-x-3 mb-4">
                <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                    <svg class="absolute w-12 h-12 text-gray-400 -left-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="text-gray-800 font-semibold">
                    Le Prof ${course.enseignant_nom}
                </div>
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">${course.titre}</h2>
            <p class="text-gray-600 mb-2">${course.description}</p>
            <p class="text-gray-500 mb-2">Created on ${new Date(course.created_at).toLocaleDateString()}</p>
            <p class="text-gray-500 mb-2">Category: ${course.categorie_nom}</p>
            <div class="flex flex-wrap gap-2 mb-4">
                ${course.tags.map(tag => `<span class="tag px-3 py-1 text-sm">${tag}</span>`).join('')}
            </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Start course</button>
            </div>
        `;
        coursesContainer.appendChild(courseElement);
    }
}

    function setupPagination() {
        const totalPages = Math.ceil(courses.length / coursesPerPage);
        paginationContainer.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('li');
            pageButton.innerHTML = `
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300" data-page="${i}">${i}</a>
            `;
            pageButton.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(e.target.getAttribute('data-page'));
                showCourses(page);

                document.querySelectorAll('#pagination a').forEach(btn => btn.classList.remove('bg-gray-300', 'font-bold'));
                e.target.classList.add('bg-gray-300', 'font-bold');
            });
            paginationContainer.appendChild(pageButton);
        }
    }

    setupPagination();
    showCourses(1);
    document.querySelector('#pagination a').classList.add('bg-gray-300', 'font-bold');
</script>

</body>
</html>

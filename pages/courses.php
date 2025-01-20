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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
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
        <img src="/images/menu.png" alt="Menu">
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
        <div class="mb-8"> 
            <input type="text" id="search-keywords" class="w-full p-2 border border-gray-300 rounded" placeholder="Search courses by keywords...">
        </div>
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
                        <a href="login.php" class="relative inline-flex items-center justify-center p-0.5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-teal-300 to-lime-300 hover:from-teal-300 hover:to-lime-300 focus:ring-4 focus:outline-none focus:ring-lime-200">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white text-black rounded-md group-hover:bg-opacity-0">
                                Register for the course
                            </span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menu = document.getElementById("burger-icon");
    const sidebar = document.getElementById("sidebar");
    const closeSidebar = document.getElementById("close-sidebar");
    const searchInput = document.getElementById("search-keywords");
    const coursesContainer = document.getElementById("courses-container");

    menu.addEventListener("click", () => {
        sidebar.classList.remove("translate-x-full");  
        sidebar.classList.add("translate-x-0");
    });

    closeSidebar.addEventListener("click", () => {
        sidebar.classList.add("translate-x-full");    
        sidebar.classList.remove("translate-x-0");   
    });

    searchInput.addEventListener("keyup", () => {
        const searchValue = searchInput.value.toLowerCase();
        const courseCards = coursesContainer.getElementsByClassName("course-card");

        Array.from(courseCards).forEach(card => {
            const title = card.querySelector("h2").textContent.toLowerCase();
            const description = card.querySelector("p").textContent.toLowerCase();
            const tags = Array.from(card.getElementsByClassName("tag")).map(tag => tag.textContent.toLowerCase());

            if (title.includes(searchValue) || description.includes(searchValue) || tags.some(tag => tag.includes(searchValue))) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
});
</script>



</body>
<footer class="bg-white rounded-lg shadow dark:bg-gray-900 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="/index.php" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="/images/icon-learning.png" class="h-8" alt="Youdemy Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"> Youdemy</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="/index.php" class="hover:underline me-4 md:me-6">Home</a>
                </li>
                <li>
                    <a href="/pages/courses.php" class="hover:underline me-4 md:me-6">Courses</a>
                </li>
                <li>
                    <a href="#about" class="hover:underline">About</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a href="#" class="hover:underline">Youdemy™</a>. All Rights Reserved.</span>
    </div>
</footer>
</html>

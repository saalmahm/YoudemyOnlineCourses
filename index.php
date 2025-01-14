
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<header class="flex justify-between p-4 fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <a href="/home.php" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
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
            <a href="home.php" class="text-black text-lg">Home</a>
            <a href="#about" class="text-black text-lg">About</a>
            <a href="index.php" class="text-black text-lg">Courses</a>
                <a href="/pages/signup.php" class="text-green-700 text-lg">Sign Up</a>
            
        </div>
    </div>
    <div class="hidden lg:flex justify-center space-x-4">
        <ul class="flex items-center text-sm font-medium text-gray-400 mb-0">
            <li><a href="home.php" class="hover:underline me-4 md:me-6">Home</a></li>
            <li><a href="#about" class="hover:underline me-4 md:me-6">About</a></li>
            <li><a href="index.php" class="hover:underline me-4 md:me-6">Courses</a></li>
                <li>
                    <a href="/pages/signup.php" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Sign Up</a>
                </li>
            
        </ul>
    </div>
</header>


<section class="bg-green-600 text-white py-20 pt-40">
    <div class="container mx-auto px-4 flex flex-col lg:flex-row items-center lg:space-x-8">
        <!-- Texte -->
        <div class="lg:w-1/2 text-center lg:text-left">
            <h1 class="text-5xl font-bold mb-6">Welcome to Youdemy</h1>
            <p class="text-lg leading-relaxed mb-6">
                Unlock your potential with our wide range of expert-led courses. Learn new skills, pursue your passions, and achieve your goals with Youdemy. Whether you're a student or a professional, we've got something for everyone.
            </p>
            <a href="index.php" class="inline-block bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-lg px-6 py-3 text-gray-900 shadow-lg">
                Explore Courses
            </a>
        </div>

        <!-- Image -->
        <div class="lg:w-1/2 mt-8 lg:mt-0 flex justify-center">
            <img src="images/unique-study-tips-sacap.jpg" alt="Learning Together" class="rounded-lg shadow-lg w-3/4 object-cover">
        </div>
    </div>
</section>




<section class="bg-gray-100 text-gray-900 py-16" id="about">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center">About Me</h2>
        <p class="mt-4 text-lg text-center">Hi, I'm Salma Hamdi, a passionate web developer. Here are some of the projects I've worked on:</p>

        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <img src="images/todolist.jpg" alt="Todo List Project" class="w-full h-40 object-cover rounded-lg">
                <h3 class="text-xl font-semibold mt-4">Todo List</h3>
                <p class="text-gray-600 mt-2">TaskFlow is a task management application that allows you to add, search, filter and prioritize tasks.</p>
                <a href="https://saalmahm.github.io/to-do-list/" class="mt-8 text-green-700 underline">View Project</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <img src="images/fifa.avif" alt="FUTeamBuilder Project" class="w-full h-40 object-cover rounded-lg">
                <h3 class="text-xl font-semibold mt-4">FUTeamBuilder</h3>
                <p class="text-gray-600 mt-2">This interactive app allows you to build your FUT team by adding, positioning and modifying players while respecting the popular tactical formation (4-4-2).</p>
                <a href="https://fu-team-builder.vercel.app/" class="mt-8 text-green-700 underline">View Project</a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                <img src="images/rent.jpg" alt="CarRental Project" class="w-full h-40 object-cover rounded-lg">
                <h3 class="text-xl font-semibold mt-4">CarRental</h3>
                <p class="text-gray-600 mt-2">This project is to manage customers, cars and rental contracts of a car rental company. Transform your data management with efficiency and accuracy.</p>
                <a href="https://github.com/saalmahm/Car-Rental" class="mt-8 text-green-700 underline">View Project</a>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="https://github.com/saalmahm" class="inline-block bg-gradient-to-r from-teal-200 to-lime-200 hover:bg-gradient-to-l hover:from-teal-200 hover:to-lime-200 focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-lg text-lg px-6 py-3 text-gray-900 shadow-lg">Learn More About Me</a>
        </div>
    </div>
</section>




<footer class="bg-white rounded-lg shadow dark:bg-gray-900 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="/home.php" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="/images/icon-learning.png" class="h-8" alt="Youdemy Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"> Youdemy</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="home.php" class="hover:underline me-4 md:me-6">Home</a>
                </li>
                <li>
                    <a href="/index.php" class="hover:underline me-4 md:me-6">Courses</a>
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
<script>
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

</body> 
</html>

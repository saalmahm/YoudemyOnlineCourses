<?php
session_start();
require_once '../db.php';
require_once '../classes/User.php'; // Inclure la classe User

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    try {
        $isConnected = User::seConnecter($conn, $email, $password);

        if ($isConnected) {
            header("Location: teacher-statistics.php");
            exit();
        } else {
            echo "<p class='text-red-500 text-center'>Invalid credentials. Please try again.</p>";
        }
    } catch (Exception $e) {
        echo "<p class='text-red-500 text-center'>{$e->getMessage()}</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>
<body>
    <header class="flex justify-between p-4 fixed top-0 left-0 right-0 bg-white shadow-md z-50">
        <a href="/index.php" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
            <img src="/images/icon-learning.png" class="h-8" alt="Youdemy Logo" />
            <span class="text-2xl font-bold whitespace-nowrap dark:text-gray-500">Youdemy</span>
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
                <a href="/pages/courses.php" class="text-black text-lg">Courses</a>
                <a href="/pages/signup.php" class="text-green-700 text-lg">Sign Up</a>
            </div>
        </div>
        <div class="hidden lg:flex justify-center space-x-4">
            <ul class="flex items-center text-sm font-medium text-gray-400 mb-0">
                <li><a href="/index.php" class="hover:underline me-4 md:me-6">Home</a></li>
                <li><a href="/pages/courses.php" class="hover:underline me-4 md:me-6">Courses</a></li>
                <li>
                    <a href="/pages/signup.php" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Sign Up</a>
                </li>
            </ul>
        </div>
    </header>

    <section class="bg-green-100 h-screen mt-8">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-[20px] h-full">
            <div class="w-full max-w-md bg-white rounded-lg shadow-md">
                <div class="p-6 space-y-6">
                    <h1 class="text-2xl font-bold text-center text-green-700">
                        Sign in to your account
                    </h1>
                    <form class="space-y-6" method="post">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                                Your Email
                            </label>
                            <input type="email" name="usernameOrEmail" id="email" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                focus:ring-green-600 focus:border-green-600 block w-full p-2.5" 
                                placeholder="Enter your email" required>
                        </div>

                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                                Password
                            </label>
                            <input type="password" name="password" id="password" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                focus:ring-green-600 focus:border-green-600 block w-full p-2.5" 
                                placeholder="Enter your password" required>
                        </div>

                        <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium 
                            rounded-lg text-sm px-5 py-2.5 text-center">
                            Sign in
                        </button>

                        <p class="text-sm font-light text-gray-500 text-center">
                            Don’t have an account yet? 
                            <a href="signup.php" class="font-medium text-green-700 hover:underline">
                                Sign up
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white rounded-lg shadow dark:bg-gray-900 m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="/index.php" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="/images/icon-learning.png" class="h-8" alt="Youdemy Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Youdemy</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="/index.php" class="hover:underline me-4 md:me-6">Home</a>
                    </li>
                    <li>
                        <a href="/pages/courses.php" class="hover:underline me-4 md:me-6">Courses</a>
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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
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
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-full">
      <div class="w-full max-w-md bg-white rounded-lg shadow-md">
          <div class="p-6 space-y-6">
              <h1 class="text-2xl font-bold text-center text-green-700">
                  Create an Account
              </h1>
              <form class="space-y-6" action="#" method="post">
                  <div>
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                          Your Name
                      </label>
                      <input type="text" name="username" id="name" 
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                          focus:ring-green-600 focus:border-green-600 block w-full p-2.5" 
                          placeholder="Enter your name" required>
                  </div>

                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                          Your Email
                      </label>
                      <input type="email" name="email" id="email" 
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

                  <div>
                      <label for="role" class="block mb-2 text-sm font-medium text-gray-900">
                          Select Role
                      </label>
                      <select name="role" id="role" 
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                          focus:ring-green-600 focus:border-green-600 block w-full p-2.5" 
                          required>
                          <option value="" disabled selected>Select your role</option>
                          <option value="student">Student</option>
                          <option value="teacher">Teacher</option>
                      </select>
                  </div>

                  <button type="submit" 
                      class="w-full bg-green-600 hover:bg-green-700 text-white font-medium 
                      rounded-lg text-sm px-5 py-2.5 text-center">
                      Create an Account
                  </button>

                  <p class="text-sm font-light text-gray-500 text-center">
                      Already have an account? 
                      <a href="login.php" class="font-medium text-green-700 hover:underline">
                          Login here
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
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"> Youdemy</span>
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

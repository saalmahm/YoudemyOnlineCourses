
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

  </main>
  </div>
</body>
</html>

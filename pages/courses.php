
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
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
        <h1 class="text-4xl font-bold text-center mb-10 text-gray-800">Browse Categories</h1>
        <div id="categories-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        </div>
        <!-- Pagination -->
        <div class="flex justify-center mt-10">
            <nav aria-label="Pagination">
                <ul id="pagination" class="inline-flex items-center space-x-2">
                </ul>
            </nav>
        </div>-
    </div>
</section>

<script>
    const categories = [
        'Développement Web', 'Design Graphique', 'Marketing Digital', 'Langues Étrangères',
        'Programmation', 'Data Science', 'Sécurité Informatique', 'Intelligence Artificielle',
        'Gestion de Projet', 'Photographie', 'Montage Vidéo', 'Écriture Créative',
        'Musique', 'Développement Personnel', 'Santé et Bien-être', 'Cuisine',
        'Arts et Loisirs', 'Langage de Signe', 'Sciences Humaines', 'Sciences Naturelles'
    ];

    // Configuration de la pagination
    const categoriesPerPage = 6;
    const totalPages = Math.ceil(categories.length / categoriesPerPage);

    const categoriesContainer = document.getElementById('categories-container');
    const paginationContainer = document.getElementById('pagination');

    function showCategories(page) {
        const startIndex = (page - 1) * categoriesPerPage;
        const endIndex = Math.min(startIndex + categoriesPerPage, categories.length);

        categoriesContainer.innerHTML = '';

        for (let i = startIndex; i < endIndex; i++) {
            const categoryElement = document.createElement('div');
            categoryElement.className = 'flex justify-center';
            categoryElement.innerHTML = `
                <div class="w-40 h-40 rounded-full bg-green-200 flex items-center justify-center shadow-lg">
                    <p class="text-xl font-semibold text-gray-800 text-center">${categories[i]}</p>
                </div>
            `;
            categoriesContainer.appendChild(categoryElement);
        }
    }

    function setupPagination() {
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('li');
            pageButton.innerHTML = `
                <a href="#" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300" data-page="${i}">
                    ${i}
                </a>
            `;
            pageButton.addEventListener('click', (e) => {
                e.preventDefault();
                const page = parseInt(e.target.getAttribute('data-page'));
                showCategories(page);

                // Mettre en surbrillance le bouton actif
                document.querySelectorAll('#pagination a').forEach(btn => btn.classList.remove('bg-gray-300', 'font-bold'));
                e.target.classList.add('bg-gray-300', 'font-bold');
            });
            paginationContainer.appendChild(pageButton);
        }
    }

    setupPagination();
    showCategories(1); // Afficher la première page par défaut
    document.querySelector('#pagination a').classList.add('bg-gray-300', 'font-bold'); // Mettre le bouton 1 en surbrillance
</script>


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

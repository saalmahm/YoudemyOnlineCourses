<?php
require_once '../db.php';
require_once '../classes/Categorie.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $categorie_id = $_GET['id'];
    $categorieObj = new Categorie($conn);
    $categorie = $categorieObj->recupererCategorie($categorie_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nouveau_nom = $_POST['nom'];
        $categorieObj->modifierCategorie($categorie_id, $nouveau_nom);
        header("Location: admin-listCategories.php");
        exit();
    }
} else {
    header("Location: admin-listCategories.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Catégorie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Modifier Catégorie</h1>
        <form method="POST" class="space-y-4">
            <div>
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom de la catégorie :</label>
                <input 
                    type="text" 
                    id="nom" 
                    name="nom" 
                    value="<?= htmlspecialchars($categorie['nom']) ?>" 
                    required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                >
            </div>
            <div class="flex justify-end ">
                <a href="admin-listCategories.php" 
                class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
            >Retour à la liste</a>
                <button 
                    type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"                >
                    Modifier
                </button>
            </div>
        </form>
    </div>
</body>
</html>

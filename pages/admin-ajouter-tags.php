<?php
require_once '../db.php';
require_once '../classes/Tag.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$tagObj = new Tag($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noms = $_POST['noms'];
    $tagNoms = explode(',', $noms);
    try {
        foreach ($tagNoms as $nom) {
            $tagObj->creeTag(trim($nom));
        }
        header("Location: admin-listTags.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des Tags</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Ajouter des Tags</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label for="noms" class="block text-sm font-medium text-gray-700">Noms des tags (séparés par des virgules) :</label>
                <textarea 
                    id="noms" 
                    name="noms" 
                    required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
            </div>
            <div class="flex justify-end">
                <a href="admin-listTags.php" 
                class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100"
            >Retour à la liste</a>
                <button 
                    type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    Ajouter
                </button>
            </div>
        </form>
    </div>
</body>
</html>

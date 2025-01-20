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
</head>
<body>
    <h1>Modifier Catégorie</h1>
    <form method="POST">
        <label for="nom">Nom de la catégorie:</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($categorie['nom']) ?>" required>
        <button type="submit">Modifier</button>
    </form>
    <a href="admin-listCategories.php">Retour à la liste des catégories</a>
</body>
</html>

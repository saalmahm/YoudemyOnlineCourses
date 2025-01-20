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
    $categorieObj->supprimerCategorie($categorie_id);
    
    header("Location: admin-listCategories.php");
    exit();
} else {
    echo "ID de la catégorie non spécifié.";
}
?>

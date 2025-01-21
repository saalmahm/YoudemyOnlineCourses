<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'enseignant') {
    header("Location: login.php");
    exit();
}

require_once '../db.php';
require_once '../classes/Cours.php';
require_once '../classes/Contenu.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];
    $created_by = $_SESSION['user_id'];

    $contenus = [];
    $contentTypes = $_POST['content-type'];
    $contentFiles = $_FILES['content-data'];

    for ($i = 0; $i < count($contentTypes); $i++) {
        $contentType = $contentTypes[$i];
        $contentFile = $contentFiles['tmp_name'][$i];
        $contentFileName = $contentFiles['name'][$i];

        $uploadDir = '../uploads/';
        $uploadFilePath = $uploadDir . basename($contentFileName);

        if (move_uploaded_file($contentFile, $uploadFilePath)) {
            $contenus[] = [
                'type' => $contentType,
                'data' => $uploadFilePath
            ];
        } else {
            echo "Erreur lors de l'upload du fichier : " . $_FILES['content-data']['error'][$i];
        }
    }

    $cours = new Cours($conn);
    $cours->creeCours($title, $description, $category, $created_by, $contenus);

    $coursId = $cours->getId();
    if ($coursId) {
        foreach ($tags as $tagId) {
            $cours->ajouterTag($tagId);
        }

        header("Location: teacher-manageCourses.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
}
?>

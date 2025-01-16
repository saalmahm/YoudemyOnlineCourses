<?php
require_once '../db.php'; 
require_once '../classes/Cours.php'; 
require_once '../classes/Contenu.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $tags = $_POST['tags']; // Récupérer les tags sélectionnés

    // Insertion du cours dans la base de données
    $cours = new Cours($conn);
    $cours->creeCours($title, $description, $category);
    $coursId = $cours->getId(); // Utiliser la méthode getId pour obtenir l'ID du cours

    if ($coursId) {
        // Ajouter les tags au cours
        foreach ($tags as $tagId) {
            $cours->ajouterTag($tagId);
        }

        $contentTypes = $_POST['content-type'];
        $contentFiles = $_FILES['content-file'];

        for ($i = 0; $i < count($contentTypes); $i++) {
            $contentType = $contentTypes[$i];
            $contentFile = $contentFiles['tmp_name'][$i];
            $contentFileName = $contentFiles['name'][$i];

            $uploadDir = '../uploads/';
            $uploadFilePath = $uploadDir . basename($contentFileName);

            if (move_uploaded_file($contentFile, $uploadFilePath)) {
                // Insertion du contenu dans la base de données
                $contenu = new Contenu($conn);
                $contenu->setType($contentType);
                $contenu->setData($uploadFilePath);
                $cours->ajouterContenu($contenu);
            } else {
                echo "Erreur lors de l'upload du fichier : " . $_FILES['content-file']['error'][$i];
            }
        }
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
}
?>

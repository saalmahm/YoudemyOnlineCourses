<?php
require_once '../db.php'; 
require_once '../classes/Cours.php'; 
require_once '../classes/Contenu.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Insertion du cours dans la base de données
    $cours = new Cours($conn);
    $cours->creeCours($title, $description, $category);
    $coursId = $cours->getId(); // Utiliser la méthode getId pour obtenir l'ID du cours

    if ($coursId) {
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
                $contenu->setType($contentType);  // Utiliser le setter pour type
                $contenu->setData($uploadFilePath);  // Utiliser le setter pour data
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

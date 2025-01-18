<?php
require_once '../db.php'; 
require_once '../classes/Cours.php'; 
require_once '../classes/Categorie.php'; 
require_once '../classes/Tag.php'; 
require_once '../classes/Contenu.php'; 
require_once '../classes/CoursTag.php';

$cours = new Cours($conn);
$categorie = new Categorie($conn);
$tag = new Tag($conn);
$contenu = new Contenu($conn);
$coursTag = new CoursTag($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titre = $_POST['title'];
    $description = $_POST['description'];
    $categorie_id = $_POST['category'];
    $tags = $_POST['tags'] ?? [];
    $contentIds = $_POST['content-id'] ?? [];
    $contentTypes = $_POST['content-type'];
    $contentFiles = $_FILES['content-file'];

    $cours->modifierCours($titre, $description, $categorie_id, $id);

    $cours->supprimerTagsParCours($id);
    foreach ($tags as $tag_id) {
        $coursTag->creerAssociation($id, $tag_id);
    }

    for ($i = 0; $i < count($contentTypes); $i++) {
        $contentType = $contentTypes[$i];
        $contentFile = $contentFiles['tmp_name'][$i];
        $contentFileName = $contentFiles['name'][$i];
        
        if (isset($contentIds[$i]) && !empty($contentIds[$i])) {
            $contenu = new Contenu($conn, $contentType, $uploadFilePath, $contentIds[$i]);
            if ($contentFile) {
                $uploadDir = '../uploads/';
                $uploadFilePath = $uploadDir . basename($contentFileName);
                if (move_uploaded_file($contentFile, $uploadFilePath)) {
                    $contenu->setData($uploadFilePath);
                }
            }
            $contenu->modifierContenu($contentType, $contenu->afficherContenu());
        } else {
            if ($contentFile) {
                $uploadDir = '../uploads/';
                $uploadFilePath = $uploadDir . basename($contentFileName);
                if (move_uploaded_file($contentFile, $uploadFilePath)) {
                    $contenu = new Contenu($conn, $contentType, $uploadFilePath);
                    $contenu->ajouterContenu($id);
                }
            }
        }
    }
    
    header('Location: teacher-manageCourses.php');
    exit;
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $coursInfo = $cours->recupererUnCours($id);
    $contenus = $cours->recupererContenusParCours($id);
    $tags = $cours->recupererTagsParCours($id);
    $categories = $categorie->recupererCategories();
    $allTags = $tag->recupererTags();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Cours</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-3xl w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Modifier le Cours</h2>
                <a href="teacher-manageCourses.php" class="text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</a>
            </div>
            <form id="course-form" method="POST" action="teacher-edit-cours.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($coursInfo['id']); ?>">

                <div class="mb-4">
                    <label for="course-title" class="block text-sm font-medium text-gray-700">Titre du Cours</label>
                    <input type="text" id="course-title" name="title" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="<?= htmlspecialchars($coursInfo['titre']); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="course-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="course-description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"><?= htmlspecialchars($coursInfo['description']); ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="course-category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select id="course-category" name="category" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Sélectionnez une catégorie</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['id']); ?>" <?= $cat['id'] == $coursInfo['catégorie_id'] ? 'selected' : ''; ?>><?= htmlspecialchars($cat['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="course-tags" class="block text-sm font-medium text-gray-700">Tags</label>
                    <select id="course-tags" name="tags[]" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" multiple>
                        <?php foreach ($allTags as $tag): ?>
                            <option value="<?= htmlspecialchars($tag['id']); ?>" <?= in_array($tag['nom'], array_column($tags, 'nom')) ? 'selected' : ''; ?>><?= htmlspecialchars($tag['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Contenus</label>
                    <div id="content-fields" class="space-y-2">
                        <?php foreach ($contenus as $contenu): ?>
                            <div class="flex items-center space-x-4">
                                <input type="hidden" name="content-id[]" value="<?= htmlspecialchars($contenu['id']); ?>">
                                <select name="content-type[]" class="block w-1/3 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="video" <?= $contenu['type'] == 'vidéo' ? 'selected' : ''; ?>>Vidéo</option>
                                    <option value="document" <?= $contenu['type'] == 'document' ? 'selected' : ''; ?>>Document</option>
                                </select>
                                <input type="file" name="content-file[]" class="block w-2/3 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <button type="button" class="remove-content text-red-500 hover:text-red-700">Supprimer</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" id="add-content" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Ajouter un Contenu</button>
                </div>


                <div class="flex justify-end space-x-4">
                    <a href="teacher-manageCourses.php" class="px-4 py-2 bg-gray-400 text-white rounded-lg shadow hover:bg-gray-500">Annuler</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

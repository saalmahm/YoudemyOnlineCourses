<?php
require_once 'User.php';

class Administrateur extends User {
    private $utilisateurs = [];
    private $cours = [];

    public function __construct($pdo, $id, $nom, $email, $password) {
        parent::__construct($pdo, $id, $nom, $email, 'admin', $password);
    }

    public function activerUser($userId) {
        $stmt = $this->pdo->prepare("UPDATE Utilisateur SET active = 1 WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public function suspendreUser($userId) {
        $stmt = $this->pdo->prepare("UPDATE Utilisateur SET active = 0 WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public function supprimerUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM Utilisateur WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public function afficherUsers() {
        $stmt = $this->pdo->query("SELECT id, nom, email, rôle, active FROM Utilisateur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalCours() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM Cours");
        $row = $stmt->fetch();
        return $row['total'];
    }

    public function repartitionCoursParCategorie() {
        $stmt = $this->pdo->query("SELECT Catégorie.nom, COUNT(Cours.id) as total FROM Cours JOIN Catégorie ON Cours.catégorie_id = Catégorie.id GROUP BY Catégorie.nom");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function coursPlusPopulaire() {
        $stmt = $this->pdo->query("SELECT Cours.titre, COUNT(ÉtudiantCours.cours_id) as total FROM ÉtudiantCours JOIN Cours ON ÉtudiantCours.cours_id = Cours.id GROUP BY ÉtudiantCours.cours_id ORDER BY total DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function topEnseignants() {
        $stmt = $this->pdo->query("SELECT Utilisateur.nom, COUNT(Cours.id) as nombre_cours FROM Cours JOIN Utilisateur ON Cours.created_by = Utilisateur.id GROUP BY Utilisateur.nom ORDER BY nombre_cours DESC LIMIT 3");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

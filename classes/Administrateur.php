<?php 
class Administrateur extends User {
    private $utilisateurs = [];
    private $cours = [];

    public function __construct($pdo, $id, $nom, $email, $password) {
        parent::__construct($pdo, $id, $nom, $email, 'admin', $password);
    }

    public function seConnecter() {
        echo "Connexion en tant qu'administrateur...";
    }

    public function activéeUser($userId) {
        $stmt = $this->pdo->prepare("UPDATE Utilisateur SET active = 1 WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public function suspenséeUser($userId) {
        $stmt = $this->pdo->prepare("UPDATE Utilisateur SET active = 0 WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public function supprimerUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM Utilisateur WHERE id = :id");
        $stmt->execute(['id' => $userId]);
    }

    public function afficherUsers() {
        $stmt = $this->pdo->query("SELECT * FROM Utilisateur");
        while ($row = $stmt->fetch()) {
            echo "Nom: " . $row["nom"] . " - Email: " . $row["email"] . " - Rôle: " . $row["rôle"] . "<br>";
        }
    }

    public function totalCours() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM Cours");
        $row = $stmt->fetch();
        return $row['total'];
    }

    public function consulterStatistiquesGlobales() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM Cours");
        $row = $stmt->fetch();
        echo "Nombre total de cours: " . $row['total'] . "<br>";

        $stmt = $this->pdo->query("SELECT Catégorie.nom, COUNT(Cours.id) as total FROM Cours JOIN Catégorie ON Cours.catégorie_id = Catégorie.id GROUP BY Catégorie.nom");
        echo "Répartition par catégorie:<br>";
        while ($row = $stmt->fetch()) {
            echo "Catégorie: " . $row['nom'] . " - Total: " . $row['total'] . "<br>";
        }

        $stmt = $this->pdo->query("SELECT Cours.titre, COUNT(ÉtudiantCours.cours_id) as total FROM ÉtudiantCours JOIN Cours ON ÉtudiantCours.cours_id = Cours.id GROUP BY ÉtudiantCours.cours_id ORDER BY total DESC LIMIT 1");
        $row = $stmt->fetch();

        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM Utilisateur");
        $row = $stmt->fetch();
    }
}

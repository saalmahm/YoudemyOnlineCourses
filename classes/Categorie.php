<?php
class Categorie {
    protected $id;
    protected $nom;
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function creeCategorie($nom) {
        $query = "INSERT INTO categorie (nom) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nom]);
        $this->id = $this->db->lastInsertId(); // Récupérer l'ID de la catégorie créée
    }

    public function modifierCategorie($nom) {
        $this->nom = $nom;
        $query = "UPDATE categorie SET nom = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nom, $this->id]);
    }

    public function supprimerCategorie() {
        $query = "DELETE FROM cours WHERE categorie_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);

        $query = "DELETE FROM categorie WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function recupererCategories() {
        try {
            $query = "SELECT * FROM Catégorie";
            $stmt = $this->db->query($query); // Assurez-vous que $this->db est bien défini et contient l'instance PDO
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }
    
    

    public function recupererCategorie($id) {
        $query = "SELECT * FROM categorie WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

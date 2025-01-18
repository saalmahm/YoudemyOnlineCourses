<?php
class Categorie {
        private $id;
        private $nom;
        private $db;
    
        public function __construct($db, $id = null, $nom = null) {
            $this->db = $db;
            $this->id = $id;
            $this->nom = $nom;
        }
    
        public function getId() {
            return $this->id;
        }
    
        public function setNom($nom) {
            $this->nom = $nom;
        }
    
        public function creeCategorie($nom) {
            if (empty($nom)) {
                throw new Exception("Le nom de la catégorie ne peut pas être vide.");
            }
            $query = "INSERT INTO Catégorie (nom) VALUES (?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nom]);
            $this->id = $this->db->lastInsertId();
        }
    
        public function modifierCategorie($nom) {
            $this->setNom($nom);
            $query = "UPDATE Catégorie SET nom = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nom, $this->id]);
        }
    
        public function supprimerCategorie() {
            $query = "DELETE FROM cours WHERE categorie_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$this->id]);
    
            $query = "DELETE FROM Catégorie WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$this->id]);
        }
    
        public function recupererCategories() {
            try {
                $query = "SELECT * FROM Catégorie";
                $stmt = $this->db->query($query);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
                return [];
            }
        }
    
        public function recupererCategorie($id) {
            $query = "SELECT * FROM Catégorie WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

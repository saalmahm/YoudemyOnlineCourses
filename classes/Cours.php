<?php
class Cours {
    protected $id;
    protected $titre;
    protected $description;
    protected $contenus = []; 
    protected $tags = [];     
    protected $categorie;     
    protected $db;

    public function __construct($db, $titre = null, $description = null, $categorie = null) {
        $this->db = $db;
        $this->titre = $titre;
        $this->description = $description;
        $this->categorie = $categorie;
    }

    public function setTitre($titre) {
        $this->titre = $titre;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function creeCours($titre, $description, $categorie_id, $created_by) {
        $query = "INSERT INTO Cours (titre, description, catégorie_id, created_by) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$titre, $description, $categorie_id, $created_by]);
        $this->id = $this->db->lastInsertId();
    }    
    

    public function getTotalCours($user_id = null) {
            if ($user_id) {
                $query = "SELECT COUNT(*) AS total FROM Cours WHERE created_by = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$user_id]);
            } else {
                $query = "SELECT COUNT(*) AS total FROM Cours";
                $stmt = $this->db->query($query);
            }
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
    }

    public function recupererTousLesCours() {
        $query = "SELECT Cours.*, Catégorie.nom AS categorie_nom, Utilisateur.nom AS enseignant_nom 
                  FROM Cours 
                  JOIN Catégorie ON Cours.catégorie_id = Catégorie.id
                  JOIN Utilisateur ON Cours.created_by = Utilisateur.id";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function recupererEnseignantCours($user_id) {
        $query = "SELECT Cours.*, Catégorie.nom AS categorie_nom FROM Cours 
                  JOIN Catégorie ON Cours.catégorie_id = Catégorie.id
                  WHERE Cours.created_by = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function recupererContenusParCours($cours_id) {
        $query = "SELECT * FROM contenu WHERE cours_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recupererTagsParCours($cours_id) {
        $query = "SELECT tag.nom FROM tag
                  JOIN coursTag ON tag.id = coursTag.tag_id
                  WHERE coursTag.cours_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifierCours($titre, $description, $categorie_id, $id) {
        $query = "UPDATE Cours SET titre = ?, description = ?, catégorie_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$titre, $description, $categorie_id, $id]);
    }
     

    public function supprimerCours($id) {
        $query1 = "DELETE FROM contenu WHERE cours_id = :id";
        $query2 = "DELETE FROM coursTag WHERE cours_id = :id";
        $query3 = "DELETE FROM Cours WHERE id = :id";
    
        try {
            $stmt1 = $this->db->prepare($query1);
            $stmt1->execute([':id' => $id]);
    
            $stmt2 = $this->db->prepare($query2);
            $stmt2->execute([':id' => $id]);
    
            $stmt3 = $this->db->prepare($query3);
            $stmt3->execute([':id' => $id]);
    
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    
   
    public function supprimerTagsParCours($cours_id) {
        $query = "DELETE FROM coursTag WHERE cours_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id]);
    }
    
    
    public function recupererUnCours($id) {
        $query = "SELECT * FROM Cours WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function filtrerCoursParCategorie($categorie_id) {
        $query = "SELECT * FROM Cours WHERE catégorie_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categorie_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filtrerCoursParTag($tag_id) {
        $query = "SELECT c.* FROM Cours c
                  JOIN coursTag ct ON c.id = ct.cours_id
                  WHERE ct.tag_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$tag_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterContenu($contenu) {
        $this->contenus[] = $contenu;
        $contenu->ajouterContenu($this->id); 
    }

    public function ajouterTag($tag_id) {
        $query = "INSERT INTO coursTag (cours_id, tag_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id, $tag_id]);
    }

    public function getId() {
        return $this->id;
    }
}
?>

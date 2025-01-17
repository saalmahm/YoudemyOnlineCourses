<?php
class Cours {
    protected $id;
    protected $titre;
    protected $description;
    protected $contenus = []; 
    protected $tags = [];     
    protected $categorie;     
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function creeCours($titre, $description, $categorie_id) {
        $query = "INSERT INTO cours (titre, description, catégorie_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$titre, $description, $categorie_id]);
        $this->id = $this->db->lastInsertId(); // Récupère l'ID du cours créé
    }

    public function recupererTousLesCours() {
        $query = "SELECT cours.*, Catégorie.nom AS categorie_nom FROM cours 
                  JOIN Catégorie ON cours.catégorie_id = Catégorie.id";
        $stmt = $this->db->query($query);
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

    public function modifierCours($titre, $description) {
        $query = "UPDATE cours SET titre = ?, description = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$titre, $description, $this->id]);
    }

    public function supprimerCours($id) {
        // Supprimer les contenus associés
        $query = "DELETE FROM contenu WHERE cours_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        // Supprimer le cours
        $query = "DELETE FROM cours WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
    }

    public function recupererUnCours($id) {
        $query = "SELECT * FROM cours WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function filtrerCoursParCategorie($categorie_id) {
        $query = "SELECT * FROM cours WHERE catégorie_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$categorie_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filtrerCoursParTag($tag_id) {
        $query = "SELECT c.* FROM cours c
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

    // Nouvelle méthode pour obtenir l'ID du cours
    public function getId() {
        return $this->id;
    }
}
?>

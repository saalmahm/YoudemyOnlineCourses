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

    public function modifierCours($titre, $description) {
        $query = "UPDATE cours SET titre = ?, description = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$titre, $description, $this->id]);
    }

    public function supprimerCours() {
        $query = "DELETE FROM coursTag WHERE cours_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);

        foreach ($this->contenus as $contenu) {
            $contenu->supprimerContenu();
        }

        $query = "DELETE FROM cours WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function recupererTousLesCours() {
        $query = "SELECT * FROM cours";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

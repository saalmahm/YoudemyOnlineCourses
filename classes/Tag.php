<?php
class Tag {
    private $id;
    private $nom;
    private $db;

    public function __construct($db, $nom = null, $id = null) {
        $this->db = $db;
        $this->nom = $nom;
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function creeTag($nom) {
        if (empty($nom)) {
            throw new Exception("Le nom du tag ne peut pas être vide.");
        }
        $query = "INSERT INTO tag (nom) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nom]);
        $this->id = $this->db->lastInsertId();
    }

    public function modifierTag($nom) {
        $this->setNom($nom);
        $query = "UPDATE tag SET nom = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nom, $this->id]);
    }

    public function supprimerTag() {
        $query = "DELETE FROM coursTag WHERE tag_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);

        $query = "DELETE FROM tag WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function recupererTags() {
        $query = "SELECT * FROM tag";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function recupererTag($id) {
        $query = "SELECT * FROM tag WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


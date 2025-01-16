<?php
class Tag {
    protected $id;
    protected $nom;
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function creeTag($nom) {
        $query = "INSERT INTO tag (nom) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nom]);
        $this->id = $this->db->lastInsertId(); // Récupère l'ID du tag créé
    }

    public function modifierTag($nom) {
        $this->nom = $nom;
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

<?php
class Contenu {
    protected $id;
    protected $type;
    protected $data;
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterContenu($cours_id) {
        $query = "INSERT INTO contenu (type, data, cours_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->type, $this->data, $cours_id]);
        $this->id = $this->db->lastInsertId(); // Récupérer l'ID du contenu créé
    }

    public function supprimerContenu() {
        $query = "DELETE FROM contenu WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function modifierContenu($type, $data) {
        $this->type = $type;
        $this->data = $data;
        $query = "UPDATE contenu SET type = ?, data = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->type, $this->data, $this->id]);
    }

    public function listerContenus($cours_id) {
        $query = "SELECT * FROM contenu WHERE cours_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function afficherContenu() {
        return $this->data;
    }
}

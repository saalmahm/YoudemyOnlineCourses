<?php
class Contenu {
    private $id;
    private $type;
    private $data;
    private $db;

    public function __construct($db, $type = null, $data = null, $id = null) {
        $this->db = $db;
        $this->type = $type;
        $this->data = $data;
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function ajouterContenu($cours_id) {
        if (empty($this->type) || empty($this->data)) {
            throw new Exception("Le type et les données du contenu ne peuvent pas être vides.");
        }
        $query = "INSERT INTO contenu (type, data, cours_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->type, $this->data, $cours_id]);
        $this->id = $this->db->lastInsertId(); // Récupérer l'ID du contenu créé
    }

    public function modifierContenu($type, $data) {
        $this->setType($type);
        $this->setData($data);
        $query = "UPDATE contenu SET type = ?, data = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->type, $this->data, $this->id]);
    }

    public function supprimerContenu() {
        $query = "DELETE FROM contenu WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
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

?>

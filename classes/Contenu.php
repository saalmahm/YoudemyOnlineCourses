<?php
class Contenu {
    private $id;
    private $type;
    private $data;
    private $cours_id;
    private $db;

    public function __construct($db, $type = null, $data = null, $cours_id = null) {
        $this->db = $db;
        $this->type = $type;
        $this->data = $data;
        $this->cours_id = $cours_id;
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

    public function setCoursId($cours_id) {
        $this->cours_id = $cours_id;
    }

    public function ajouterContenu() {
        if (empty($this->type) || empty($this->data) || empty($this->cours_id)) {
            throw new Exception("Le type, les données du contenu et l'ID du cours ne peuvent pas être vides.");
        }
        $query = "INSERT INTO Contenu (type, data, cours_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->type, $this->data, $this->cours_id]);
        $this->id = $this->db->lastInsertId();
    }

    public function modifierContenu($type, $data) {
        $this->setType($type);
        $this->setData($data);
        $query = "UPDATE Contenu SET type = ?, data = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->type, $this->data, $this->id]);
    }

    public function supprimerContenu() {
        $query = "DELETE FROM Contenu WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function listerContenus($cours_id) {
        $query = "SELECT * FROM Contenu WHERE cours_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function afficherContenu() {
        return $this->data;
    }
}

?>

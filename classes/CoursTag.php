<?php
class CoursTag {
    protected $tag_id;
    protected $cours_id;
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function creerAssociation($cours_id, $tag_id) {
        $query = "INSERT INTO coursTag (cours_id, tag_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id, $tag_id]);
    }

    public function supprimerAssociation() {
        $query = "DELETE FROM coursTag WHERE cours_id = ? AND tag_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->cours_id, $this->tag_id]);
    }
}

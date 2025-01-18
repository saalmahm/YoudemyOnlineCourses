<?php
class CoursTag {
    private $tag_id;
    private $cours_id;
    private $db;

    public function __construct($db, $cours_id = null, $tag_id = null) {
        $this->db = $db;
        $this->cours_id = $cours_id;
        $this->tag_id = $tag_id;
    }

    public function getCoursId() {
        return $this->cours_id;
    }

    public function setCoursId($cours_id) {
        $this->cours_id = $cours_id;
    }

    public function getTagId() {
        return $this->tag_id;
    }

    public function setTagId($tag_id) {
        $this->tag_id = $tag_id;
    }

    public function creerAssociation($cours_id, $tag_id) {
        $query = "INSERT INTO coursTag (cours_id, tag_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id, $tag_id]);
    }

    public function supprimerAssociation($cours_id, $tag_id) {
        $query = "DELETE FROM coursTag WHERE cours_id = ? AND tag_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$cours_id, $tag_id]);
    }
}

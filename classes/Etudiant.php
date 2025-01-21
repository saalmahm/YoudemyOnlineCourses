<?php
require_once 'User.php';

class Etudiant extends User {
    private $coursInscrit = [];

    public function __construct($pdo, $id, $nom, $email, $password) {
        parent::__construct($pdo, $id, $nom, $email, 'étudiant', $password);
    }

    public function sinscrireCours($coursId) {
        $stmt = $this->pdo->prepare("SELECT * FROM ÉtudiantCours WHERE étudiant_id = :etudiant_id AND cours_id = :cours_id");
        $stmt->execute(['etudiant_id' => $this->id, 'cours_id' => $coursId]);
        if ($stmt->rowCount() > 0) {
            echo "Vous êtes déjà inscrit à ce cours.";
            return;
        }

        $stmt = $this->pdo->prepare("INSERT INTO ÉtudiantCours (étudiant_id, cours_id) VALUES (:etudiant_id, :cours_id)");
        $stmt->execute(['etudiant_id' => $this->id, 'cours_id' => $coursId]);
        $this->coursInscrit[] = $coursId;
        echo "Inscription au cours ID: $coursId réussie.";
    }

    public function consulterCoursInscrits() {
        $stmt = $this->pdo->prepare("SELECT Cours.id, Cours.titre, Cours.description 
                                     FROM ÉtudiantCours 
                                     JOIN Cours ON ÉtudiantCours.cours_id = Cours.id 
                                     WHERE ÉtudiantCours.étudiant_id = :etudiant_id");
        $stmt->execute(['etudiant_id' => $this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php
class Etudiant extends User {
    private $coursInscrit = [];

    public function __construct($pdo, $id, $nom, $email, $password) {
        parent::__construct($pdo, $id, $nom, $email, 'étudiant', $password);
    }

    public static function créeCompte($pdo, $nom, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            echo "Cet email est déjà utilisé.";
            return;
        }

        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, email, mot_de_passe, rôle, active) VALUES (:nom, :email, :password, 'étudiant', 1)");
        $stmt->execute(['nom' => $nom, 'email' => $email, 'password' => $passwordHash]);
        echo "Compte étudiant créé pour $nom.";
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
        $stmt = $this->pdo->prepare("SELECT Cours.titre, Cours.description FROM ÉtudiantCours JOIN Cours ON ÉtudiantCours.cours_id = Cours.id WHERE ÉtudiantCours.étudiant_id = :etudiant_id");
        $stmt->execute(['etudiant_id' => $this->id]);
        while ($row = $stmt->fetch()) {
            echo "Titre: " . $row["titre"] . " - Description: " . $row["description"] . "<br>";
        }
    }

    public function seConnecter() {
        echo "Connexion en tant qu'étudiant...";
    }
}

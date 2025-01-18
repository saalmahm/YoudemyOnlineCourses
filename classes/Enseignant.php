<?php
class Enseignant extends User {
    private $coursCrée = [];

    public function __construct($pdo, $id, $nom, $email, $password) {
        parent::__construct($pdo, $id, $nom, $email, 'enseignant', $password);
    }

    public static function créeCompte($pdo, $nom, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            echo "Cet email est déjà utilisé.";
            return;
        }

        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, email, mot_de_passe, rôle, active) VALUES (:nom, :email, :password, 'enseignant', 1)");
        $stmt->execute(['nom' => $nom, 'email' => $email, 'password' => $passwordHash]);
        echo "Compte enseignant créé pour $nom.";
    }

    public function consulterInscription($coursId) {
        $stmt = $this->pdo->prepare("SELECT Utilisateur.nom FROM ÉtudiantCours JOIN Utilisateur ON ÉtudiantCours.étudiant_id = Utilisateur.id WHERE ÉtudiantCours.cours_id = :cours_id");
        $stmt->execute(['cours_id' => $coursId]);
        while ($row = $stmt->fetch()) {
            echo "Étudiant: " . $row["nom"] . "<br>";
        }
    }

    public static function seConnecter($pdo, $email, $password) {
        $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            if ($user['rôle'] == 'étudiant') {
                echo "Bienvenue, étudiant!";
            } elseif ($user['rôle'] == 'enseignant') {
                echo "Bienvenue, enseignant!";
            } elseif ($user['rôle'] == 'administrateur') {
                echo "Bienvenue, administrateur!";
            } else {
                echo "Rôle inconnu.";
            }
        } else {
            echo "L'utilisateur n'existe pas ou les informations de connexion sont incorrectes.";
        }
    }
}


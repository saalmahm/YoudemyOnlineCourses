<?php

abstract class User {
    protected $id;
    protected $nom;
    protected $email;
    protected $role;
    protected $password;
    protected $pdo;

    public function __construct($pdo, $id = null, $nom = null, $email = null, $role = null, $password = null) {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
    }

    public function seDéconnecter() {
        session_start();
        session_unset();
        session_destroy();
    }

    public static function seConnecter($conn, $email, $password) {
        $stmt = $conn->prepare("SELECT * FROM Utilisateur WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            if (!$user['active']) {
                throw new Exception("Compte inactif. Veuillez contacter l'administrateur.");
            }
    
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['rôle'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['nom']; 
            $_SESSION['user_password'] = $password; 
    
            return true;
        } else {
            throw new Exception("Échec de la connexion. Vérifiez vos identifiants.");
        }
    }

    public static function créeCompte($conn, $nom, $email, $role, $password, $active = 0) {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            
            $checkQuery = "SELECT * FROM Utilisateur WHERE email = :email";
            $stmt = $conn->prepare($checkQuery);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return "L'utilisateur existe déjà.";
            }
    
            $insertQuery = "INSERT INTO Utilisateur (nom, email, rôle, mot_de_passe, active) VALUES (:nom, :email, :role, :motDePasse, :active)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':motDePasse', $passwordHash);
            $stmt->bindParam(':active', $active, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Erreur lors de l'inscription : " . $stmt->errorInfo()[2]);
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        }
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setMotDePasse(string $motDePasse): void {
        $this->password = $motDePasse;
    }

    public function setRole(string $role): void {
        $this->role = $role;
    }


}

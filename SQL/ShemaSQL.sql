CREATE DATABASE YoudemyDB;

USE YoudemyDB;

-- Table Utilisateur
CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    email VARCHAR(255),
    rôle ENUM('admin', 'enseignant', 'étudiant')
);

-- Table Catégorie
CREATE TABLE Catégorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255)
);
-- Table Cours
CREATE TABLE Cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    description TEXT,
    catégorie_id INT,
    FOREIGN KEY (catégorie_id) REFERENCES Catégorie(id)
);

-- Table Contenu
CREATE TABLE Contenu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50),
    data TEXT,
    cours_id INT,
    FOREIGN KEY (cours_id) REFERENCES Cours(id)
);

-- Table Tag
CREATE TABLE Tag (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255)
);

-- Table Associative ÉtudiantCours
CREATE TABLE ÉtudiantCours (
    étudiant_id INT,
    cours_id INT,
    PRIMARY KEY (étudiant_id, cours_id),
    FOREIGN KEY (étudiant_id) REFERENCES Utilisateur(id),
    FOREIGN KEY (cours_id) REFERENCES Cours(id)
);

-- Table Associative CoursTag
CREATE TABLE CoursTag (
    cours_id INT,
    tag_id INT,
    PRIMARY KEY (cours_id, tag_id),
    FOREIGN KEY (cours_id) REFERENCES Cours(id),
    FOREIGN KEY (tag_id) REFERENCES Tag(id)
);

-- insertion

INSERT INTO Catégorie (nom) VALUES ('Développement Web');
INSERT INTO Catégorie (nom) VALUES ('Design Graphique');
INSERT INTO Catégorie (nom) VALUES ('Marketing Digital');
INSERT INTO Catégorie (nom) VALUES ('Langues Étrangères');
-- plus d'insertion des catégories
INSERT INTO Catégorie (nom) VALUES ('Programmation');
 INSERT INTO Catégorie (nom) VALUES ('Data Science'); 
 INSERT INTO Catégorie (nom) VALUES ('Sécurité Informatique');
 INSERT INTO Catégorie (nom) VALUES ('Intelligence Artificielle');
 INSERT INTO Catégorie (nom) VALUES ('Gestion de Projet'); 
 INSERT INTO Catégorie (nom) VALUES ('Photographie'); 
 INSERT INTO Catégorie (nom) VALUES ('Montage Vidéo');
 INSERT INTO Catégorie (nom) VALUES ('Écriture Créative');
 INSERT INTO Catégorie (nom) VALUES ('Musique'); 
 INSERT INTO Catégorie (nom) VALUES ('Développement Personnel'); 
 INSERT INTO Catégorie (nom) VALUES ('Santé et Bien-être');
 INSERT INTO Catégorie (nom) VALUES ('Cuisine'); 
 INSERT INTO Catégorie (nom) VALUES ('Arts et Loisirs'); 
 INSERT INTO Catégorie (nom) VALUES ('Langage de Signe');
 INSERT INTO Catégorie (nom) VALUES ('Sciences Humaines'); 
 INSERT INTO Catégorie (nom) VALUES ('Sciences Naturelles');

INSERT INTO Tag (nom) VALUES ('HTML');
INSERT INTO Tag (nom) VALUES ('CSS');
INSERT INTO Tag (nom) VALUES ('JavaScript');
INSERT INTO Tag (nom) VALUES ('Photoshop');
INSERT INTO Tag (nom) VALUES ('SEO');
INSERT INTO Tag (nom) VALUES ('Espagnol');
INSERT INTO Tag (nom) VALUES ('Anglais');


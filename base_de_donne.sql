-- Création de la base de données
CREATE DATABASE donne_Projet;

-- Sélection de la base de données
USE donne_Projet;


-- Création de la table administrateur
CREATE TABLE administrateur (
    ID_administrateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Création de la table coachpersonelle_de_sport
CREATE TABLE coachpersonelle_de_sport (
    ID_coach INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    photos VARCHAR(255),
    specialite VARCHAR(100),
    disponibilite VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    ID_administrateur INT,
    FOREIGN KEY (ID_administrateur) REFERENCES administrateur(ID_administrateur)
);

-- Création de la table CV
CREATE TABLE CV (
    ID_CV INT AUTO_INCREMENT PRIMARY KEY,
    ID_coach INT,
    formations TEXT,
    experience TEXT,
    cursus TEXT,
    FOREIGN KEY (ID_coach) REFERENCES coachpersonelle_de_sport(ID_coach)
);

-- Création de la table client
CREATE TABLE client (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    carte_etudiante VARCHAR(100),
    adresse VARCHAR(255),
    numero_de_telephone VARCHAR(20)
);

-- Création de la table communication
CREATE TABLE communication (
    ID_communication INT AUTO_INCREMENT PRIMARY KEY,
    type_communication VARCHAR(100),
    ID_client INT,
    ID_coach INT,
    FOREIGN KEY (ID_client) REFERENCES client(id_client),
    FOREIGN KEY (ID_coach) REFERENCES coachpersonelle_de_sport(ID_coach)
);

-- Création de la table payement
CREATE TABLE payement (
    ID_payement INT AUTO_INCREMENT PRIMARY KEY,
    ID_client INT,
    type_carte VARCHAR(50),
    numero_carte VARCHAR(20),
    nom_carte VARCHAR(100),
    date_expiration DATE,
    code_de_securite VARCHAR(10),
    FOREIGN KEY (ID_client) REFERENCES client(id_client)
);

-- Création de la table salle_de_sport
CREATE TABLE salle_de_sport (
    id_salle INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    adresse VARCHAR(255) NOT NULL
);

-- Création de la table consultation
CREATE TABLE consultation (
    id_consultation INT AUTO_INCREMENT PRIMARY KEY,
    id_coach INT,
    id_client INT,
    id_salle INT,
    date_heure DATETIME NOT NULL,
    commentaire TEXT,
    FOREIGN KEY (id_coach) REFERENCES coachpersonelle_de_sport(ID_coach),
    FOREIGN KEY (id_client) REFERENCES client(id_client),
    FOREIGN KEY (id_salle) REFERENCES salle_de_sport(id_salle)
);

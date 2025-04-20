CREATE DATABASE abdian_db;
USE abdian_db;

CREATE TABLE Utilisateur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  prenom VARCHAR(50),
  nom VARCHAR(50),
  email VARCHAR(100) UNIQUE,
  mot_de_passe VARCHAR(255),
  mot_de_passe_en_clair VARCHAR(100),
  telephone VARCHAR(20),
  date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Vol (
  id INT AUTO_INCREMENT PRIMARY KEY,
  airline VARCHAR(100),             
  flightNumber VARCHAR(20),
  aircraftModele VARCHAR(100),        
  departureDate DATE,             
  departureTime TIME,             
  departureAirport VARCHAR(100),    
  departureCode VARCHAR(10),        
  arrivalDate DATE,               
  arrivalTime TIME,                 
  arrivalAirport VARCHAR(100),      
  arrivalCode VARCHAR(10),          
  duration VARCHAR(20),             
  stops VARCHAR(20),                
  stopDetails TEXT NULL,           
  price DECIMAL(10,2)               
);


CREATE TABLE Ppassager (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_utilisateur INT,
  prenom VARCHAR(50),
  deuxieme_prenom VARCHAR(50),
  nom VARCHAR(50),
  date_naissance DATE,
  email VARCHAR(100),
  telephone VARCHAR(20),
  urgence_prenom VARCHAR(50),
  urgence_nom VARCHAR(50),
  urgence_email VARCHAR(100),
  urgence_telephone VARCHAR(20),
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id)
);

CREATE TABLE Siege (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_vol INT,
  id_passager INT,
  numero_siege VARCHAR(10),
  classe VARCHAR(20),
  statut ENUM('libre', 'réservé') DEFAULT 'libre'
);

CREATE TABLE Paiement (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_passager INT,
  montant DECIMAL(10,2),
  date_paiement DATETIME DEFAULT CURRENT_TIMESTAMP,
  methode VARCHAR(50),
  reference VARCHAR(100),
  FOREIGN KEY (id_passager) REFERENCES passagers(id)
);

CREATE TABLE Messages_contact (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100),
  email VARCHAR(100),
  sujet VARCHAR(255),
  message TEXT,
  date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP
);



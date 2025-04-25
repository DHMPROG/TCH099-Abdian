-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 24, 2025 at 09:04 PM
-- Server version: 8.0.42
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abdian_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Messages_contact`
--

CREATE TABLE `Messages_contact` (
  `id` int NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `message` text,
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Messages_contact`
--

INSERT INTO `Messages_contact` (`id`, `nom`, `email`, `sujet`, `message`, `date_envoi`) VALUES
(1, 'Karim B.', 'karim.b@example.com', 'Problème de réservation', 'Bonjour, je n’arrive pas à finaliser ma réservation. Merci de m’aider.', '2025-04-24 16:56:44'),
(2, 'Lucie F.', 'lucie.f@example.com', 'Paiement non validé', 'J’ai essayé de payer mais rien ne s’affiche.', '2025-04-24 16:56:44'),
(3, 'Antoine L.', 'antoine.l@example.com', 'Vol annulé', 'Mon vol a été annulé et je n’ai pas reçu de mail.', '2025-04-24 16:56:44'),
(4, 'Fatima Z.', 'fatima.z@example.com', 'Changement de siège', 'Puis-je changer mon siège après validation ?', '2025-04-24 16:56:44'),
(5, 'Nora C.', 'nora.c@example.com', 'Mauvais email', 'Je me suis trompée d’email à l’inscription.', '2025-04-24 16:56:44'),
(6, 'Yassine H.', 'yassine.h@example.com', 'Erreur de date', 'J’ai mis la mauvaise date de naissance dans le formulaire.', '2025-04-24 16:56:44'),
(7, 'Julie T.', 'julie.t@example.com', 'Suggestion', 'Pourquoi ne pas proposer des alertes prix par mail ?', '2025-04-24 16:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `Paiement`
--

CREATE TABLE `Paiement` (
  `id` int NOT NULL,
  `id_passager` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_paiement` datetime DEFAULT CURRENT_TIMESTAMP,
  `methode` varchar(50) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Paiement`
--

INSERT INTO `Paiement` (`id`, `id_passager`, `montant`, `date_paiement`, `methode`, `reference`) VALUES
(1, 1, 150.00, '2025-04-24 16:56:44', 'Carte bancaire', 'REF123456789'),
(2, 2, 180.00, '2025-04-24 16:56:44', 'PayPal', 'REF987654321'),
(3, 3, 120.00, '2025-04-24 16:56:44', 'Virement', 'REF456789123'),
(4, 4, 200.00, '2025-04-24 16:56:44', 'Carte bancaire', 'REF321654987'),
(5, 5, 90.00, '2025-04-24 16:56:44', 'Apple Pay', 'REF654321789'),
(6, 6, 250.00, '2025-04-24 16:56:44', 'Google Pay', 'REF852741963'),
(7, 7, 800.00, '2025-04-24 16:56:44', 'Carte bancaire', 'REF147258369');

-- --------------------------------------------------------

--
-- Table structure for table `Passager`
--

CREATE TABLE `Passager` (
  `id` int NOT NULL,
  `id_utilisateur` int DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `deuxieme_prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `urgence_prenom` varchar(50) DEFAULT NULL,
  `urgence_nom` varchar(50) DEFAULT NULL,
  `urgence_email` varchar(100) DEFAULT NULL,
  `urgence_telephone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Passager`
--

INSERT INTO `Passager` (`id`, `id_utilisateur`, `prenom`, `deuxieme_prenom`, `nom`, `date_naissance`, `email`, `telephone`, `urgence_prenom`, `urgence_nom`, `urgence_email`, `urgence_telephone`) VALUES
(1, 1, 'Alice', '', 'Martin', '1990-04-15', 'alice.martin@example.com', '0612345678', 'Claire', 'Martin', 'claire.martin@example.com', '0611122233'),
(2, 2, 'Jean', 'Paul', 'Dupont', '1985-06-22', 'jean.dupont@example.com', '0698765432', 'Luc', 'Dupont', 'luc.dupont@example.com', '0699332211'),
(3, 3, 'Leila', 'Fatima', 'Benali', '1993-12-01', 'leila.benali@example.com', '0789456123', 'Nadia', 'Benali', 'nadia.benali@example.com', '0711223344'),
(4, 4, 'Marc', '', 'Durand', '1980-01-30', 'marc.durand@example.com', '0623456789', 'Julie', 'Durand', 'julie.durand@example.com', '0611332244'),
(5, 5, 'Sophie', '', 'Roux', '1992-11-11', 'sophie.roux@example.com', '0654321987', 'Pierre', 'Roux', 'pierre.roux@example.com', '0611223344'),
(6, 6, 'Karim', '', 'Belkacem', '1988-03-12', 'karim.belkacem@example.com', '0777888999', 'Samira', 'Belkacem', 'samira.belkacem@example.com', '0788223344'),
(7, 7, 'Emma', '', 'Lemoine', '1995-08-08', 'emma.lemoine@example.com', '0644556677', 'Chloe', 'Lemoine', 'chloe.lemoine@example.com', '0677223344');

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `id` int NOT NULL,
  `id_passager` int DEFAULT NULL,
  `id_vol` int DEFAULT NULL,
  `id_siege` int DEFAULT NULL,
  `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('confirmée','annulée') DEFAULT 'confirmée'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Reservation`
--

INSERT INTO `Reservation` (`id`, `id_passager`, `id_vol`, `id_siege`, `date_reservation`, `statut`) VALUES
(1, 1, 1, 1, '2025-04-24 16:56:44', 'confirmée'),
(2, 2, 2, 2, '2025-04-24 16:56:44', 'confirmée'),
(3, 3, 3, 3, '2025-04-24 16:56:44', 'confirmée'),
(4, 4, 4, 4, '2025-04-24 16:56:44', 'confirmée'),
(5, 5, 5, 5, '2025-04-24 16:56:44', 'confirmée'),
(6, 6, 6, 6, '2025-04-24 16:56:44', 'confirmée'),
(7, 7, 7, 7, '2025-04-24 16:56:44', 'confirmée');

-- --------------------------------------------------------

--
-- Table structure for table `Siege`
--

CREATE TABLE `Siege` (
  `id` int NOT NULL,
  `id_vol` int DEFAULT NULL,
  `id_passager` int DEFAULT NULL,
  `numero_siege` varchar(10) DEFAULT NULL,
  `classe` varchar(20) DEFAULT NULL,
  `statut` enum('libre','réservé') DEFAULT 'libre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Siege`
--

INSERT INTO `Siege` (`id`, `id_vol`, `id_passager`, `numero_siege`, `classe`, `statut`) VALUES
(1, 1, 1, '12A', 'Économie', 'réservé'),
(2, 2, 2, '14C', 'Économie', 'réservé'),
(3, 3, 3, '16B', 'Économie', 'réservé'),
(4, 4, 4, '10D', 'Affaires', 'réservé'),
(5, 5, 5, '18F', 'Économie', 'réservé'),
(6, 6, 6, '2A', 'Première', 'réservé'),
(7, 7, 7, '22E', 'Économie', 'réservé');

-- --------------------------------------------------------

--
-- Table structure for table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int NOT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `mot_de_passe_en_clair` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `date_inscription` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `prenom`, `nom`, `email`, `mot_de_passe`, `mot_de_passe_en_clair`, `telephone`, `date_inscription`) VALUES
(1, 'Alice', 'Martin', 'alice.martin@example.com', 'hashedpass1', 'motdepasse1', '0612345678', '2025-04-24 16:56:44'),
(2, 'Jean', 'Dupont', 'jean.dupont@example.com', 'hashedpass2', 'motdepasse2', '0698765432', '2025-04-24 16:56:44'),
(3, 'Leila', 'Benali', 'leila.benali@example.com', 'hashedpass3', 'motdepasse3', '0789456123', '2025-04-24 16:56:44'),
(4, 'Marc', 'Durand', 'marc.durand@example.com', 'hashedpass4', 'motdepasse4', '0623456789', '2025-04-24 16:56:44'),
(5, 'Sophie', 'Roux', 'sophie.roux@example.com', 'hashedpass5', 'motdepasse5', '0654321987', '2025-04-24 16:56:44'),
(6, 'Karim', 'Belkacem', 'karim.belkacem@example.com', 'hashedpass6', 'motdepasse6', '0777888999', '2025-04-24 16:56:44'),
(7, 'Emma', 'Lemoine', 'emma.lemoine@example.com', 'hashedpass7', 'motdepasse7', '0644556677', '2025-04-24 16:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `Vol`
--

CREATE TABLE `Vol` (
  `id` int NOT NULL,
  `airline` varchar(100) DEFAULT NULL,
  `flightNumber` varchar(20) DEFAULT NULL,
  `aircraftModele` varchar(100) DEFAULT NULL,
  `departureDate` date DEFAULT NULL,
  `departureTime` time DEFAULT NULL,
  `departureAirport` varchar(100) DEFAULT NULL,
  `departureCode` varchar(10) DEFAULT NULL,
  `arrivalDate` date DEFAULT NULL,
  `arrivalTime` time DEFAULT NULL,
  `arrivalAirport` varchar(100) DEFAULT NULL,
  `arrivalCode` varchar(10) DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `stops` varchar(20) DEFAULT NULL,
  `stopDetails` text,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Vol`
--

INSERT INTO `Vol` (`id`, `airline`, `flightNumber`, `aircraftModele`, `departureDate`, `departureTime`, `departureAirport`, `departureCode`, `arrivalDate`, `arrivalTime`, `arrivalAirport`, `arrivalCode`, `duration`, `stops`, `stopDetails`, `price`) VALUES
(1, 'Air France', 'AF123', 'Airbus A320', '2025-05-10', '10:00:00', 'Paris Charles de Gaulle', 'CDG', '2025-05-10', '13:00:00', 'Madrid Barajas', 'MAD', '3h', 'Non', NULL, 150.00),
(2, 'Royal Air Maroc', 'AT456', 'Boeing 737', '2025-05-15', '14:30:00', 'Casablanca', 'CMN', '2025-05-15', '18:00:00', 'Tunis', 'TUN', '3h30', 'Oui', 'Escale à Alger', 180.00),
(3, 'TAP Air Portugal', 'TP789', 'Airbus A321', '2025-06-01', '08:00:00', 'Lisbonne', 'LIS', '2025-06-01', '10:30:00', 'Rome', 'FCO', '2h30', 'Non', NULL, 120.00),
(4, 'Lufthansa', 'LH321', 'Airbus A350', '2025-07-12', '16:45:00', 'Berlin', 'BER', '2025-07-12', '20:00:00', 'Istanbul', 'IST', '3h15', 'Oui', 'Escale à Vienne', 200.00),
(5, 'EasyJet', 'EJ007', 'Airbus A319', '2025-08-20', '06:00:00', 'Londres', 'LHR', '2025-08-20', '08:00:00', 'Paris', 'CDG', '2h', 'Non', NULL, 90.00),
(6, 'Turkish Airlines', 'TK888', 'Boeing 777', '2025-09-10', '12:00:00', 'Istanbul', 'IST', '2025-09-10', '16:00:00', 'Dubai', 'DXB', '4h', 'Non', NULL, 250.00),
(7, 'Emirates', 'EK202', 'Airbus A380', '2025-10-05', '22:00:00', 'New York JFK', 'JFK', '2025-10-06', '20:00:00', 'Dubai', 'DXB', '12h', 'Non', NULL, 800.00),
(8, 'Air Canada', 'AC101', 'Boeing 787', '2025-06-15', '19:00:00', 'Montréal-Trudeau', 'YUL', '2025-06-16', '07:30:00', 'Paris Charles de Gaulle', 'CDG', '7h30', 'Non', NULL, 620.00),
(9, 'Air Transat', 'TS456', 'Airbus A330', '2025-07-10', '17:15:00', 'Montréal-Trudeau', 'YUL', '2025-07-11', '06:45:00', 'Barcelone El Prat', 'BCN', '7h30', 'Non', NULL, 580.00),
(10, 'Lufthansa', 'LH493', 'Airbus A350', '2025-08-02', '21:00:00', 'Montréal-Trudeau', 'YUL', '2025-08-03', '10:10:00', 'Francfort', 'FRA', '7h10', 'Non', NULL, 690.00),
(11, 'Royal Air Maroc', 'AT209', 'Boeing 787', '2025-09-05', '20:30:00', 'Montréal-Trudeau', 'YUL', '2025-09-06', '08:50:00', 'Casablanca Mohamed V', 'CMN', '7h20', 'Non', NULL, 720.00),
(12, 'Air France', 'AF351', 'Boeing 777', '2025-10-01', '18:45:00', 'Montréal-Trudeau', 'YUL', '2025-10-02', '07:10:00', 'Lyon Saint-Exupéry', 'LYS', '6h25', 'Oui', 'Escale à Paris CDG', 630.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Messages_contact`
--
ALTER TABLE `Messages_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Paiement`
--
ALTER TABLE `Paiement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_passager` (`id_passager`);

--
-- Indexes for table `Passager`
--
ALTER TABLE `Passager`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_passager` (`id_passager`),
  ADD KEY `id_vol` (`id_vol`),
  ADD KEY `id_siege` (`id_siege`);

--
-- Indexes for table `Siege`
--
ALTER TABLE `Siege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Vol`
--
ALTER TABLE `Vol`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Messages_contact`
--
ALTER TABLE `Messages_contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Paiement`
--
ALTER TABLE `Paiement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Passager`
--
ALTER TABLE `Passager`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Siege`
--
ALTER TABLE `Siege`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Vol`
--
ALTER TABLE `Vol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Paiement`
--
ALTER TABLE `Paiement`
  ADD CONSTRAINT `Paiement_ibfk_1` FOREIGN KEY (`id_passager`) REFERENCES `Passager` (`id`);

--
-- Constraints for table `Passager`
--
ALTER TABLE `Passager`
  ADD CONSTRAINT `Passager_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id`);

--
-- Constraints for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`id_passager`) REFERENCES `Passager` (`id`),
  ADD CONSTRAINT `Reservation_ibfk_2` FOREIGN KEY (`id_vol`) REFERENCES `Vol` (`id`),
  ADD CONSTRAINT `Reservation_ibfk_3` FOREIGN KEY (`id_siege`) REFERENCES `Siege` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 19, 2021 at 12:23 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
time_zone = "+00:00";

--
-- Database: `lo07`
--

-- --------------------------------------------------------

--
-- Table structure for table `aeroport`
--

CREATE TABLE `aeroport`
(
    `id`   int(11) NOT NULL,
    `nom`  varchar(255) NOT NULL,
    `code` varchar(10)  NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `aeroport`
--

INSERT INTO `aeroport` (`id`, `nom`, `code`)
VALUES (1, 'Roissy', 'CDG'),
       (2, 'Orly', 'ORY'),
       (3, 'Heathrow', 'LHR');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location`
(
    `id`                  int(11) NOT NULL,
    `voiture_id`          int(11) DEFAULT NULL,
    `parking_id`          int(11) DEFAULT NULL,
    `debut_disponibilite` date DEFAULT NULL,
    `fin_disponibilite`   date DEFAULT NULL,
    `prix`                int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `voiture_id`, `parking_id`, `debut_disponibilite`, `fin_disponibilite`, `prix`)
VALUES (1, 1, 1, '2021-05-16', '2021-05-22', 0),
       (2, 1, 1, '2021-05-26', '2021-05-27', 20);

-- --------------------------------------------------------

--
-- Table structure for table `parking`
--

CREATE TABLE `parking`
(
    `id`          int(11) NOT NULL,
    `aeroport_id` int(11) NOT NULL,
    `adresse`     varchar(255) DEFAULT NULL,
    `lieu`        varchar(255) DEFAULT NULL,
    `nb_places`   int(11) DEFAULT NULL,
    `prix`        int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parking`
--

INSERT INTO `parking` (`id`, `aeroport_id`, `adresse`, `lieu`, `nb_places`, `prix`)
VALUES (1, 1, '21 rue', 'Parking Aérien', 120, 10),
       (3, 1, 'roissy rue', 'parking 8', 20, 31);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation`
(
    `id`           int(11) NOT NULL,
    `voiture_id`   int(11) DEFAULT NULL,
    `locataire_id` int(11) DEFAULT NULL,
    `parking_id`   int(11) DEFAULT NULL,
    `date_debut`   date DEFAULT NULL,
    `date_fin`     date DEFAULT NULL,
    `prix`         int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `voiture_id`, `locataire_id`, `parking_id`, `date_debut`, `date_fin`, `prix`)
VALUES (1, 1, 1, 1, '2021-05-19', '2021-05-21', 25),
       (2, 1, 1, 1, '2021-05-19', '2021-05-20', 30);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur`
(
    `id`        int(11) NOT NULL,
    `prenom`    varchar(255) DEFAULT NULL,
    `nom`       varchar(255) DEFAULT NULL,
    `email`     varchar(255) DEFAULT NULL,
    `telephone` varchar(255) DEFAULT NULL,
    `pseudo`    varchar(255) DEFAULT NULL,
    `mdp`       text,
    `naissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `prenom`, `nom`, `email`, `telephone`, `pseudo`, `mdp`, `naissance`)
VALUES (1, 'admin', 'adminn', 'admin@admin.fr', '0689212223', 'admin', '21232f297a57a5a743894a0e4a801fc3',
        '2019-05-05'),
       (3, 'aa', 'bb', 'dd@dd.fr', '1904884', 'cc', '1aabac6d068eef6a7bad3fdf50a05cc8', '2021-05-11'),
       (4, 'aa', 'bb', 'dd@dd.fr', '1904884', 'cc', '1aabac6d068eef6a7bad3fdf50a05cc8', '2021-05-11');

-- --------------------------------------------------------

--
-- Table structure for table `voiture`
--

CREATE TABLE `voiture`
(
    `id`              int(11) NOT NULL,
    `proprietaire_id` int(11) DEFAULT NULL,
    `couleur`         varchar(255) DEFAULT NULL,
    `marque`          varchar(255) DEFAULT NULL,
    `nb_place`        int(11) DEFAULT NULL,
    `etat`            varchar(255) DEFAULT NULL,
    `type`            varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `voiture`
--

INSERT INTO `voiture` (`id`, `proprietaire_id`, `couleur`, `marque`, `nb_place`, `etat`, `type`)
VALUES (1, 1, 'a', 'a', 1, 'd', 'a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aeroport`
--
ALTER TABLE `aeroport`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
    ADD PRIMARY KEY (`id`),
  ADD KEY `voiture_id` (`voiture_id`),
  ADD KEY `parking_id` (`parking_id`);

--
-- Indexes for table `parking`
--
ALTER TABLE `parking`
    ADD PRIMARY KEY (`id`),
  ADD KEY `aeroport_id` (`aeroport_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
    ADD PRIMARY KEY (`id`),
  ADD KEY `voiture_id` (`voiture_id`),
  ADD KEY `locataire_id` (`locataire_id`),
  ADD KEY `parking_id` (`parking_id`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voiture`
--
ALTER TABLE `voiture`
    ADD PRIMARY KEY (`id`),
  ADD KEY `proprietaire_id` (`proprietaire_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aeroport`
--
ALTER TABLE `aeroport`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `parking`
--
ALTER TABLE `parking`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `voiture`
--
ALTER TABLE `voiture`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `location`
--
ALTER TABLE `location`
    ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`) ON
DELETE
CASCADE;

--
-- Constraints for table `parking`
--
ALTER TABLE `parking`
    ADD CONSTRAINT `parking_ibfk_1` FOREIGN KEY (`aeroport_id`) REFERENCES `aeroport` (`id`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
    ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id`) ON DELETE CASCADE ,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`locataire_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `voiture`
--
ALTER TABLE `voiture`
    ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`proprietaire_id`) REFERENCES `utilisateur` (`id`);

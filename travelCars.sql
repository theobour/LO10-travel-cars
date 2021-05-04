-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Lun 05 Avril 2021 à 18:42
-- Version du serveur :  5.5.42
-- Version de PHP :  7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `lo07`
--

-- --------------------------------------------------------

--
-- Structure de la table `aeroport`
--

CREATE TABLE `aeroport` (
  `aeroport` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `aeroport`
--

INSERT INTO `aeroport` (`aeroport`) VALUES
('Orly'),
('Roissy');

-- --------------------------------------------------------

--
-- Structure de la table `identifiant`
--

CREATE TABLE `identifiant` (
  `mdp` varchar(300) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `birthdate` date NOT NULL,
  `telephone` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `identifiant`
--

INSERT INTO `identifiant` (`mdp`, `prenom`, `nom`, `email`, `birthdate`, `telephone`, `pseudo`) VALUES
('$2y$10$YGslrwCuS3P4GKD5Ez6T/O8jgqehUsLSynaYrgpfNEPrL/eJoE5Da', 'Travelcars', 'Administrateur', 'admin@travelcars.com', '1999-01-01', 787641123, 'administrateur'),
('$2y$10$uUold8KAdaM9zqeCLmgQAuPwUql7Kh0X48sNtdNKoFgR1f./YsorW', 'Candice', 'Alcaraz', 'candalc@gmail.com', '1999-10-01', 657456341, 'candalc'),
('$2y$10$BJtecAxq.zR.SEX2HSOAkeBeDXQuVXuiQAMU9.WVpGVB9FhzLPAI6', 'Lara', 'Croft', 'laracroft@gmail.fr', '1977-02-01', 677889935, 'laracroft');

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

CREATE TABLE `site` (
  `lieu` varchar(50) NOT NULL,
  `aeroport` varchar(50) NOT NULL,
  `nb_places` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `adresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `site`
--

INSERT INTO `site` (`lieu`, `aeroport`, `nb_places`, `prix`, `adresse`) VALUES
('Parking Ibis Budget', 'Orly', 10, 9, '45, boulevard des Champs'),
('Parking P2', 'Roissy', 79, 7, '25, rue des Champs-Elysées'),
('Parking P4', 'Orly', 150, 8, '4, allée de Orly Centre'),
('Parking PECO', 'Orly', 199, 5, '6b, rue de l''Aeroport'),
('Parking Premium', 'Roissy', 45, 32, '21, rue de Charles de Gaulle');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `couleur` varchar(20) NOT NULL,
  `marque` varchar(20) NOT NULL,
  `car_places` varchar(20) NOT NULL,
  `car_etat` varchar(20) NOT NULL,
  `date_entree` date NOT NULL,
  `date_sortie` date NOT NULL,
  `location` varchar(20) NOT NULL,
  `aeroport` varchar(50) NOT NULL,
  `proprietaire` varchar(50) NOT NULL,
  `copie` varchar(20) NOT NULL,
  `locataire` varchar(50) NOT NULL,
  `lieu` varchar(50) NOT NULL,
  `datedebut` date NOT NULL,
  `datefin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vehicule`
--

INSERT INTO `vehicule` (`id`, `type`, `couleur`, `marque`, `car_places`, `car_etat`, `date_entree`, `date_sortie`, `location`, `aeroport`, `proprietaire`, `copie`, `locataire`, `lieu`, `datedebut`, `datefin`) VALUES
(0, 'Familiale', 'Grise', 'Kia', '6 et plus', 'Très Bon', '2020-06-01', '2020-06-15', 'non', 'Orly', 'candalc', 'non', 'administrateur', 'Parking PECO', '2020-06-01', '2020-06-15');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `aeroport`
--
ALTER TABLE `aeroport`
  ADD PRIMARY KEY (`aeroport`);

--
-- Index pour la table `identifiant`
--
ALTER TABLE `identifiant`
  ADD PRIMARY KEY (`pseudo`);

--
-- Index pour la table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`lieu`);

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 07 juin 2024 à 21:39
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `firebirds_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE `evenements` (
  `id` int(11) NOT NULL,
  `categorie` enum('U10M','U10F','U12M','U12F','U14M','U14F','U16M','U16F','U18M','U18F','U20M','U20F','SENIOR M','SENIOR F') DEFAULT NULL,
  `adversaire` varchar(50) DEFAULT NULL,
  `date_evenement` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `score_final` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `evenements`
--

INSERT INTO `evenements` (`id`, `categorie`, `adversaire`, `date_evenement`, `heure`, `lieu`, `score_final`) VALUES
(2, 'SENIOR M', 'la salle', '2024-06-17', '11:00:00', 'mojas', '111-125'),
(4, 'SENIOR M', 'lakers', '2024-04-09', '20:01:00', 'mojas', '130-115'),
(5, 'U10M', 'vikings', '2024-03-01', '08:10:00', 'libermann', '12-230'),
(6, 'U10M', 'lakers', '2023-12-16', '08:10:00', 'mojas', '112-23'),
(9, 'SENIOR M', 'la salle', '2024-05-10', '08:58:00', 'libermann', '112-112'),
(10, 'SENIOR M', 'UD', '2024-05-13', '08:59:00', 'central park', '130-115'),
(11, 'U10F', 'lakers', '2024-04-13', '09:00:00', 'libermann', '112-23');

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` enum('M','F') DEFAULT NULL,
  `taille` float DEFAULT NULL,
  `poids` float DEFAULT NULL,
  `date_inscription` date DEFAULT NULL,
  `ancien_centre` varchar(100) DEFAULT NULL,
  `categorie` enum('U10M','U10F','U12M','U12F','U14M','U14F','U16M','U16F','U18M','U18F','U20M','U20F','SENIOR M','SENIOR F') DEFAULT NULL,
  `lieu_residence` varchar(100) DEFAULT NULL,
  `ecole_frequentee` varchar(100) DEFAULT NULL,
  `main_forte` enum('gauche','droite') DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `telephone_pere` varchar(15) DEFAULT NULL,
  `telephone_mere` varchar(15) DEFAULT NULL,
  `inscription` tinyint(1) DEFAULT 0,
  `tranche1` tinyint(1) DEFAULT 0,
  `tranche2` tinyint(1) DEFAULT 0,
  `tranche3` tinyint(1) DEFAULT 0,
  `assurance` tinyint(1) DEFAULT 0,
  `fiche_evaluation` varchar(255) DEFAULT NULL,
  `dorcas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `joueurs`
--

INSERT INTO `joueurs` (`id`, `photo`, `nom`, `prenom`, `date_naissance`, `sexe`, `taille`, `poids`, `date_inscription`, `ancien_centre`, `categorie`, `lieu_residence`, `ecole_frequentee`, `main_forte`, `telephone`, `telephone_pere`, `telephone_mere`, `inscription`, `tranche1`, `tranche2`, `tranche3`, `assurance`, `fiche_evaluation`, `dorcas`) VALUES
(3, 'i.jpg', 'Djomo', 'Fabiola', '2012-05-16', 'F', 1.7, 76, '2024-06-03', 'libermann', 'U12F', 'douala', 'la salle', 'gauche', '1952844354', '38729459', '975682445', 1, 1, 1, 1, 0, '356 en.pdf', 0),
(4, 'i.jpg', 'Djomo', 'Jason', '2004-01-11', 'M', 1.71, 80, '2023-06-09', 'libermann', 'U20M', 'douala', 'libermann', 'droite', '1952844354', '38729459', '975682445', 1, 1, 1, 0, 0, '[ Zetorrents.pw ] Conjuring 3 _ sous l\'emprise du diable FRENCH DVDRIP 2021   .torrent', 0);

-- --------------------------------------------------------

--
-- Structure de la table `saison_actuelle`
--

CREATE TABLE `saison_actuelle` (
  `id` int(11) NOT NULL,
  `annee` varchar(10) DEFAULT NULL,
  `en_cours` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `saison_actuelle`
--

INSERT INTO `saison_actuelle` (`id`, `annee`, `en_cours`) VALUES
(1, '2024', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `saison_actuelle`
--
ALTER TABLE `saison_actuelle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `evenements`
--
ALTER TABLE `evenements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `saison_actuelle`
--
ALTER TABLE `saison_actuelle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

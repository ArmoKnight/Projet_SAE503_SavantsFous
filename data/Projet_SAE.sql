-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 29 jan. 2024 à 18:40
-- Version du serveur : 10.5.21-MariaDB-0+deb11u1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Projet_SAE`
--

-- --------------------------------------------------------

--
-- Structure de la table `Classe`
--

CREATE TABLE `Classe` (
  `id_class` bigint(20) UNSIGNED NOT NULL,
  `Nom_Classe` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Classe`
--

INSERT INTO `Classe` (`id_class`, `Nom_Classe`) VALUES
(1, 'RT3');

-- --------------------------------------------------------

--
-- Structure de la table `Cours`
--

CREATE TABLE `Cours` (
  `id_cours` bigint(20) UNSIGNED NOT NULL,
  `Matiere` char(255) NOT NULL,
  `Salle` char(255) NOT NULL,
  `id_classe` bigint(20) UNSIGNED NOT NULL,
  `id_prof` bigint(20) UNSIGNED NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `Date` date NOT NULL,
  `Presence` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Cours`
--

INSERT INTO `Cours` (`id_cours`, `Matiere`, `Salle`, `id_classe`, `id_prof`, `heure_debut`, `heure_fin`, `Date`, `Presence`) VALUES
(3, 'Cyber', 'TD2', 1, 5, '08:00:00', '10:00:00', '2024-01-29', '4,');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `Nom` char(255) NOT NULL,
  `Prenom` char(255) NOT NULL,
  `Classe_ID` bigint(20) UNSIGNED DEFAULT NULL,
  `Mail` char(255) NOT NULL,
  `Role` char(255) NOT NULL,
  `mdp` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `Nom`, `Prenom`, `Classe_ID`, `Mail`, `Role`, `mdp`) VALUES
(3, 'Ye', 'Anthony', 1, 'a.ye@rt-iut.re', 'Etudiant', 'admin'),
(4, 'Payet', 'Jean', 1, 'j.payet@rt-iut.re', 'Etudiant', 'admin'),
(5, 'Hoarau', 'Luc', NULL, 'l.hoarau@rt-iut.re', 'Professeur', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Classe`
--
ALTER TABLE `Classe`
  ADD PRIMARY KEY (`id_class`);

--
-- Index pour la table `Cours`
--
ALTER TABLE `Cours`
  ADD PRIMARY KEY (`id_cours`),
  ADD KEY `Cours_ibfk_1` (`id_classe`),
  ADD KEY `id_prof` (`id_prof`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `Classe_ID` (`Classe_ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Classe`
--
ALTER TABLE `Classe`
  MODIFY `id_class` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Cours`
--
ALTER TABLE `Cours`
  MODIFY `id_cours` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Cours`
--
ALTER TABLE `Cours`
  ADD CONSTRAINT `Cours_ibfk_1` FOREIGN KEY (`id_classe`) REFERENCES `Classe` (`id_class`),
  ADD CONSTRAINT `Cours_ibfk_2` FOREIGN KEY (`id_prof`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`Classe_ID`) REFERENCES `Classe` (`id_class`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

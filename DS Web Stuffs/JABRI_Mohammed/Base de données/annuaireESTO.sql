-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 23 avr. 2020 à 21:21
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `annuaireesto`
--

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`dept_id`, `dept_name`) VALUES
(1, 'Génie Informatique'),
(2, 'Génie Appliquée'),
(3, 'Management');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `cne` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `filiere_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`cne`, `email`, `filiere_id`) VALUES
('F123456789', 'new@test.com', 5),
('H130385779', 'etudiant@test.com', 1),
('H131313131', 'ayman@test.com', 1);

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `filiere_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `filiere_name` varchar(10) NOT NULL,
  `filiere_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`filiere_id`, `dept_id`, `filiere_name`, `filiere_description`) VALUES
(1, 1, 'DAI', 'Developpement d\'applications informatiques'),
(2, 1, 'ASR', 'Adminstrateur de systèmes et reseaux'),
(3, 3, 'GBA', 'Gestion de banques et assurances'),
(4, 3, 'FCF', 'Fiscalité et Comptabillité Fincancière'),
(5, 2, 'EII', 'Electronique et Informatique Indutrielle'),
(6, 2, 'GEER', 'Génie Electrique et Energie Renouvlables'),
(7, 3, 'GLT', 'Gestion de Logistique et Transport'),
(8, 2, 'GC', 'Génie Civile'),
(9, 3, 'WM', 'Web Marketing'),
(10, 3, 'TV', 'Technique de Ventes'),
(11, 3, 'IGE', 'Informatique et Gestion des Entreprises');

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE `personnel` (
  `ppr` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `personnel`
--

INSERT INTO `personnel` (`ppr`, `email`) VALUES
(1099, 'fonct@test.com'),
(9870, 'prof@test.com');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `description` varchar(2) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `nom`, `prenom`, `description`, `telephone`, `email`, `password`, `created_at`, `verified`) VALUES
(1, 'MJR', 'Admin', 'AD', '0612345665', 'admin@test.com', '4c8ec5d6824ba3942d9d872f69dfccf2e9148177', '2020-04-04 18:42:52', 1),
(4, 'JABRI', 'Mohammed', 'ET', '0618259699', 'etudiant@test.com', '4c8ec5d6824ba3942d9d872f69dfccf2e9148177', '2020-04-05 19:14:31', 1),
(7, 'SERGHINI', 'Abdelhafid', 'EN', '0987643221', 'prof@test.com', '4c8ec5d6824ba3942d9d872f69dfccf2e9148177', '2020-04-06 13:54:28', 1),
(11, 'MAKHOUKHI', 'Ayman', 'ET', '0212928374', 'ayman@test.com', '4c8ec5d6824ba3942d9d872f69dfccf2e9148177', '2020-04-08 20:17:35', 1),
(16, 'HAKIMI', 'Jamal', 'FN', '0987654321', 'fonct@test.com', '4c8ec5d6824ba3942d9d872f69dfccf2e9148177', '2020-04-23 18:41:32', 1),
(17, 'NOUVEL', 'Utilisateur', 'ET', '0012898671', 'new@test.com', '4c8ec5d6824ba3942d9d872f69dfccf2e9148177', '2020-04-23 18:47:28', 0),
(18, 'NOUVEL', 'Administrateur', 'AD', '0000008961', 'admin2@test.com', '4c8ec5d6824ba3942d9d872f69dfccf2e9148177', '2020-04-23 18:48:37', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`dept_id`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`cne`),
  ADD KEY `filiere_id` (`filiere_id`),
  ADD KEY `email` (`email`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`filiere_id`),
  ADD KEY `dept_id` (`dept_id`);

--
-- Index pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`ppr`),
  ADD KEY `email` (`email`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `telephone` (`telephone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `filiere_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`filiere_id`) REFERENCES `filiere` (`filiere_id`),
  ADD CONSTRAINT `etudiant_ibfk_3` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD CONSTRAINT `filiere_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `departement` (`dept_id`);

--
-- Contraintes pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

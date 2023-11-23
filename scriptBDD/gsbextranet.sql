-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 08 nov. 2023 à 15:33
-- Version du serveur : 10.3.39-MariaDB-0+deb10u1
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gsbextranet`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `idAvis` int(11) NOT NULL,
  `textAvis` text DEFAULT NULL,
  `visioId` int(11) NOT NULL,
  `verifAvis` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`idAvis`, `textAvis`, `visioId`, `verifAvis`) VALUES
(15, 'c\'était pas bien', 5, 1),
(16, 'intéressant', 6, 1),
(17, 'inintéressant', 7, 0),
(18, 'inutile', 8, 0),
(19, 'super !', 10, 0),
(20, 'trop cool', 9, 0);

-- --------------------------------------------------------

--
-- Structure de la table `historiqueconnexion`
--

CREATE TABLE `historiqueconnexion` (
  `idMedecin` int(11) NOT NULL,
  `dateDebutLog` datetime NOT NULL,
  `dateFinLog` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `historiqueconnexion`
--

INSERT INTO `historiqueconnexion` (`idMedecin`, `dateDebutLog`, `dateFinLog`) VALUES
(46, '2023-10-19 16:32:24', '2023-10-19 16:41:07'),
(46, '2023-10-19 16:38:13', '2023-10-19 16:41:07'),
(46, '2023-11-02 10:08:10', NULL),
(46, '2023-11-02 10:08:57', NULL),
(46, '2023-11-03 11:45:26', NULL),
(46, '2023-11-03 11:52:45', NULL),
(47, '2023-10-19 16:33:40', NULL),
(47, '2023-10-21 20:05:06', NULL),
(47, '2023-11-03 11:37:03', NULL),
(48, '2023-10-19 16:35:12', '2023-11-02 11:39:05'),
(48, '2023-10-25 14:14:58', '2023-11-02 11:39:05'),
(48, '2023-10-25 14:15:14', '2023-11-02 11:39:05'),
(48, '2023-10-25 14:15:25', '2023-11-02 11:39:05'),
(48, '2023-10-25 14:15:31', '2023-11-02 11:39:05'),
(48, '2023-10-25 14:15:34', '2023-11-02 11:39:05'),
(48, '2023-11-02 10:56:22', '2023-11-02 11:39:05'),
(48, '2023-11-08 15:10:53', NULL),
(49, '2023-10-19 16:36:40', NULL),
(49, '2023-10-21 16:52:31', NULL),
(49, '2023-11-03 11:57:14', NULL),
(49, '2023-11-03 11:57:38', NULL),
(52, '2023-11-07 19:38:26', '2023-11-08 15:10:36'),
(52, '2023-11-08 13:48:28', '2023-11-08 15:10:36'),
(53, '2023-11-03 11:49:58', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `maintenance`
--

CREATE TABLE `maintenance` (
  `idmaintenance` int(1) NOT NULL,
  `maintenance` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `maintenance`
--

INSERT INTO `maintenance` (`idmaintenance`, `maintenance`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `id` int(11) NOT NULL,
  `nom` varchar(40) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `telephone` varchar(10) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `dateNaissance` date DEFAULT NULL,
  `motDePasse` varchar(200) DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `rpps` varchar(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `dateDiplome` date DEFAULT NULL,
  `dateConsentement` date DEFAULT NULL,
  `cle` int(6) NOT NULL,
  `verifToken` int(1) NOT NULL,
  `role` int(2) NOT NULL DEFAULT 1,
  `verifValidateur` int(1) NOT NULL DEFAULT 0,
  `limiteValidation` datetime DEFAULT NULL,
  `limiteDateToken` datetime DEFAULT NULL,
  `dateCodeActiver` datetime DEFAULT NULL,
  `dateTokenActiver` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id`, `nom`, `prenom`, `telephone`, `mail`, `dateNaissance`, `motDePasse`, `dateCreation`, `rpps`, `token`, `dateDiplome`, `dateConsentement`, `cle`, `verifToken`, `role`, `verifValidateur`, `limiteValidation`, `limiteDateToken`, `dateCodeActiver`, `dateTokenActiver`) VALUES
(46, 'test', 'test', NULL, 'test2@gmail.com', NULL, '$2y$10$F3C/tNv066lA.d7I4jHhmuVZP6jgVYGy7/r9pODhjWM3J/4mPh1o.', '2023-10-19 16:32:24', '11111111111', 'ee608ef9', NULL, '2023-10-19', 0, 1, 4, 1, NULL, NULL, NULL, NULL),
(47, 'test', 'test', NULL, 'test3@gmail.com', NULL, '$2y$10$1GygZW6eaLZ7MBq1Vpgh6uN7h9f7Aiznd9HUxVY0R/rI.nbqIxgGC', '2023-10-19 16:33:40', '11111111111', 'fee38561', NULL, '2023-10-19', 0, 1, 2, 1, NULL, NULL, NULL, NULL),
(48, 'test', 'test', NULL, 'test4@gmail.com', NULL, '$2y$10$CoyCRsA2sWAEIMR8kkaBUOs7hTQd.f45o0zBf1MeDHL5viILus56S', '2023-10-19 16:35:12', '11111111111', 'b50580c1', NULL, '2023-10-19', 0, 1, 5, 1, NULL, NULL, NULL, NULL),
(49, 'test', 'test', NULL, 'test5@gmail.com', NULL, '$2y$10$T/8TSQ2Fch5IqnRLjkOmHe/Th3PIoo4qnF3cqeo19GK1IMyaTzGLi', '2023-10-19 16:36:40', '11111111111', 'b00aa315', NULL, '2023-10-19', 0, 1, 3, 1, NULL, NULL, NULL, NULL),
(52, 'test', 'test', NULL, 'test1@gmail.com', NULL, '$2y$10$qakhJLM/NdeEYc0v0WsFGu2yIfEUqFOu77hrCygTiDOysJJ0tlioW', '2023-10-25 14:00:42', '11111111111', '04abfacc', NULL, '2023-10-25', 493478, 1, 1, 1, '2023-11-08 13:52:39', NULL, '2023-11-08 13:48:28', NULL),
(53, 'tata', 'toto', NULL, 'tototata@gmail.com', NULL, '$2y$10$60eKgKEGUVqrSAYLODUaP.G/4xikpAtH1g6JopFJUiP0OSvsM32wO', '2023-11-03 11:49:58', '11111111111', '92c41a3b', NULL, '2023-11-03', 0, 0, 1, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `medecinproduit`
--

CREATE TABLE `medecinproduit` (
  `idMedecin` int(11) NOT NULL,
  `idProduit` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Heure` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medecinvisio`
--

CREATE TABLE `medecinvisio` (
  `idMedecin` int(11) NOT NULL,
  `idVisio` int(11) NOT NULL,
  `dateInscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `medecin_no_connexion_3_years`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `medecin_no_connexion_3_years` (
`idMedecin` int(11)
);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `objectif` mediumtext NOT NULL,
  `information` mediumtext NOT NULL,
  `effetIndesirable` mediumtext NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `objectif`, `information`, `effetIndesirable`, `image`) VALUES
(1, 'doliprane', 'Se sentir mieux', 'Ce médicament est un antalgique et un antipyrétique qui contient du paracétamol.\r\n\r\nIl est utilisé pour faire baisser la fièvre et dans le traitement des affections douloureuses.', 'Rares : rougeur cutanée, urticaire, réaction allergique.\r\n\r\nTrès rares : réaction cutanée grave imposant l\'arrêt du traitement, anomalie de la numération formule sanguine.\r\n\r\nFréquence indéterminée : bronchospasme, diarrhée, douleurs abdominales, augmentation des transaminases.\r\n\r\nIrritation anale (suppositoire).', 'doliprane.jpg'),
(2, 'EFFERALGAN', 'Se sentir encore mieux', 'Ce médicament est indiqué chez l\'adulte et l\'enfant à partir de 50 kg (environ 15 ans) pour faire baisser la fièvre et/ou soulager les douleurs légères à modérées (par exemple : maux de tête, états grippaux, douleurs dentaires, courbatures, règles douloureuses, poussées douloureuses de l\'arthrose).', 'Rares : réaction allergique.\nTrès rares : réaction cutanée grave imposant l\'arrêt du traitement, anomalie de la numération formule sanguine.\n\nVous avez ressenti un effet indésirable susceptible d’être dû à ce médicament, vous pouvez le déclarer en ligne.', 'dafalgan-1000-mg-8-comprimes-.jpg'),
(31, 'sirop pour la toux', 'ne plus avoir mal à la gorge', 'Les antitussifs opiacés sont utilisés dans le traitement symptomatique de courte durée des toux sèches ou d\'irritation.', 'la constipation, les nausées, les sensations de vertiges et une somnolence', 'sanofi-toplexil-toux-seches-et-irritatives-sirop-150-ml-face.jpg'),
(32, 'xanax', 'ne plus stresser', 'Ce médicament est un anxiolytique (tranquillisant) de la famille des benzodiazépines.', 'diminution de l\'appétit, troubles de la libido, nervosité, insomnie, troubles de l\'équilibre, vision trouble, nausées, éruption cutanée.', 'xanax-145x145.jpg'),
(33, 'lysopaïne', 'ne plus avoir mal à la gorge', '  Lysopaïne est un médicament de la famille des Mucolytiques. Il est utilisé pour les traitements ou en cas d\'apparition des symptômes suivants : Douleur de la gorge, Pharyngite aiguë, sans précision', 'Des cas de réactions d\'allergie ont été rapportés avec des médicaments contenant du lysozyme ', 'lysopaine-sans-sucre-36-pastilles-a-sucer.png'),
(34, 'viagra', 'retrouver la fougue de la jeunesse', 'Ce médicament est un vasodilatateur qui agit spécifiquement sur la verge', ' infarctus du myocarde, angine de poitrine, troubles du rythme cardiaque, réaction allergique, convulsions.', 'viagra-compresse.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `idRole` int(2) NOT NULL,
  `nomRole` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`idRole`, `nomRole`) VALUES
(1, 'medecin'),
(2, 'moderateur'),
(3, 'admin'),
(4, 'validateur'),
(5, 'chefProduit');

-- --------------------------------------------------------

--
-- Structure de la table `statistique`
--

CREATE TABLE `statistique` (
  `idStat` int(11) NOT NULL,
  `nombreClick` int(11) DEFAULT NULL,
  `idProduit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `visioconference`
--

CREATE TABLE `visioconference` (
  `id` int(11) NOT NULL,
  `nomVisio` varchar(100) DEFAULT NULL,
  `objectif` text DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `dateVisio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `visioconference`
--

INSERT INTO `visioconference` (`id`, `nomVisio`, `objectif`, `url`, `dateVisio`) VALUES
(5, 'Conférence covid23', 'Combattre le covid23', 'covid23.com', '2023-11-30'),
(6, 'Conférence Grippe', 'Combattre la grippe', 'Grippe2023.com', '2023-12-24'),
(7, 'Conférence diabète', 'Combattre le diabète ', 'diabete2023.com', '2023-11-27'),
(8, 'Conférence Cancer', 'Combattre le cancer', 'fightcancer2023.com', '2024-01-25'),
(9, 'Conférence Variole', 'Combattre la variole', 'variole2023.com', '2024-02-23'),
(10, 'Conférence tétanos', 'Ne pas rouiller', 'tétanos2023.com', '2023-12-28');

-- --------------------------------------------------------

--
-- Structure de la vue `medecin_no_connexion_3_years`
--
DROP TABLE IF EXISTS `medecin_no_connexion_3_years`;

CREATE ALGORITHM=UNDEFINED DEFINER=`login4264`@`localhost` SQL SECURITY DEFINER VIEW `medecin_no_connexion_3_years`  AS SELECT `historiqueconnexion`.`idMedecin` AS `idMedecin` FROM `historiqueconnexion` WHERE to_days(sysdate()) - to_days(`historiqueconnexion`.`dateFinLog`) >= 1096 ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`idAvis`),
  ADD KEY `visioId` (`visioId`);

--
-- Index pour la table `historiqueconnexion`
--
ALTER TABLE `historiqueconnexion`
  ADD PRIMARY KEY (`idMedecin`,`dateDebutLog`) USING BTREE;

--
-- Index pour la table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`idmaintenance`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Index pour la table `medecinproduit`
--
ALTER TABLE `medecinproduit`
  ADD PRIMARY KEY (`idMedecin`,`idProduit`,`Date`,`Heure`),
  ADD KEY `idProduit` (`idProduit`);

--
-- Index pour la table `medecinvisio`
--
ALTER TABLE `medecinvisio`
  ADD PRIMARY KEY (`idMedecin`,`idVisio`),
  ADD KEY `idVisio` (`idVisio`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Index pour la table `visioconference`
--
ALTER TABLE `visioconference`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `idAvis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `idmaintenance` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `idRole` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `visioconference`
--
ALTER TABLE `visioconference`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `visioId` FOREIGN KEY (`visioId`) REFERENCES `visioconference` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historiqueconnexion`
--
ALTER TABLE `historiqueconnexion`
  ADD CONSTRAINT `historiqueconnexion_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `medecin_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`idRole`);

--
-- Contraintes pour la table `medecinproduit`
--
ALTER TABLE `medecinproduit`
  ADD CONSTRAINT `medecinproduit_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `medecinproduit_ibfk_2` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `medecinvisio`
--
ALTER TABLE `medecinvisio`
  ADD CONSTRAINT `medecinvisio_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`id`),
  ADD CONSTRAINT `medecinvisio_ibfk_2` FOREIGN KEY (`idVisio`) REFERENCES `visioconference` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`login4264`@`localhost` EVENT `delete token after 24 h` ON SCHEDULE EVERY 1 DAY STARTS '2023-10-09 18:13:40' ON COMPLETION PRESERVE ENABLE DO UPDATE medecin SET token = NULL WHERE token is NOT NULL$$

CREATE DEFINER=`login4264`@`localhost` EVENT `compte inactif depuis 3 ans` ON SCHEDULE EVERY 1 WEEK STARTS '2023-10-13 16:31:04' ENDS '2025-06-13 16:31:04' ON COMPLETION PRESERVE ENABLE DO BEGIN DELETE FROM historiqueconnexion WHERE historiqueconnexion.idMedecin in (SELECT idMedecin FROM medecin_no_connexion_3_years);

DELETE FROM medecinvisio WHERE medecinvisio.idMedecin in (SELECT idMedecin FROM medecin_no_connexion_3_years);

DELETE FROM medecinproduit WHERE medecinproduit.idMedecin in (SELECT idMedecin FROM medecin_no_connexion_3_years);

DELETE FROM medecin WHERE medecin.id in (SELECT idMedecin FROM medecin_no_connexion_3_years);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 03 jan. 2023 à 00:13
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `devweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `text` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `email`, `subject`, `text`) VALUES
(1, 'herilusallanow@gmail.com', 'Test 1 contact', 'test'),
(2, 'herilusallanow@gmail.com', 'Test 1 contact', 'test'),
(3, 'herilusallanow@gmail.com', 'Test 1 contact', 'test'),
(4, 'herilusallanow@gmail.com', 'Test 1 contact', 'test'),
(5, 'herilusallanow@gmail.com', 'Test 1 contact', 'test'),
(6, 'herilusallanow@gmail.com', 'Test 1 contact', 'test'),
(7, 'herilusallanow@gmail.com', 'Test 1 contact', 'test'),
(8, 'herilusallanow@gmail.com', 'Test 1 contact', 'test 5'),
(9, 'herilusallanow@gmail.com', 'Test 1 contact', 'test 5'),
(10, 'herilusallanow@gmail.com', 'Test 1 contact', 'test 5'),
(11, 'herilusallanow@gmail.com', 'Test 1 contact', 'test 5'),
(13, 'herilusallanow@gmail.com', 'test delete', 'wsh c\'est 12?');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

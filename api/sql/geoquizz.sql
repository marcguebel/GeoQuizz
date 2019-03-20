-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `partie`;
CREATE TABLE `partie` (
  `id` varchar(64) NOT NULL,
  `status` int(1) NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `joueur` varchar(100) DEFAULT NULL,
  `idSerie` int(11) NOT NULL,
  KEY `idSerie` (`idSerie`),
  CONSTRAINT `partie_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `serie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `url` varchar(100) NOT NULL,
  `idUser` varchar(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `photo` (`id`, `latitude`, `longitude`, `url`, `idUser`) VALUES
(1,	48.6939,	6.18291,	'https://i.imgur.com/HBbbnGu.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(2,	48.6898,	6.17445,	'https://i.imgur.com/ADvv40C.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(3,	48.6806,	6.17057,	'https://i.imgur.com/CBEcZoR.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(4,	48.6923,	6.17733,	'https://i.imgur.com/QzQXeMa.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(5,	48.6894,	6.17606,	'https://i.imgur.com/mw81Dv2.png',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(6,	48.6934,	6.1315,	'https://i.imgur.com/DFCecu1.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(7,	48.6866,	6.16726,	'https://i.imgur.com/U3qV1Ac.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(8,	48.6913,	6.18599,	'https://i.imgur.com/JjAiIzj.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(9,	48.695,	6.18823,	'https://i.imgur.com/TMJ6fcp.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(10,	48.6944,	6.18266,	'https://i.imgur.com/w9K3DZp.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(11,	48.683,	6.16095,	'https://i.imgur.com/g2Ao29a.jpg',	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265');

DROP TABLE IF EXISTS `serie`;
CREATE TABLE `serie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ville` varchar(100) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `distance` int(11) NOT NULL,
  `points` varchar(100) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `zoom` int(11) NOT NULL,
  `idUser` varchar(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `serie_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `serie` (`id`, `ville`, `libelle`, `distance`, `points`, `latitude`, `longitude`, `zoom`, `idUser`) VALUES
(1,	'Nancy',	'Quizz de la ville de Nancy - Facile',	200,	'1;3;5',	48.6925,	6.18324,	12,	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(2,	'Nancy',	'Quizz de la ville de Nancy - Normal',	150,	'1;3;5',	48.6925,	6.18324,	12,	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265'),
(3,	'Nancy',	'Quizz de la ville de Nancy - Difficile',	100,	'1;3;5',	48.6925,	6.18324,	12,	'5c4e22d5-0b43-43c6-ab04-49b47fd2a265');

DROP TABLE IF EXISTS `serie_photo`;
CREATE TABLE `serie_photo` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `idSerie` int(11) NOT NULL,
  `idPhoto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idSerie` (`idSerie`),
  KEY `idPhoto` (`idPhoto`),
  CONSTRAINT `serie_photo_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `serie` (`id`),
  CONSTRAINT `serie_photo_ibfk_2` FOREIGN KEY (`idPhoto`) REFERENCES `photo` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `serie_photo` (`id`, `idSerie`, `idPhoto`) VALUES
(1,	1,	1),
(2,	1,	2),
(3,	1,	3),
(4,	1,	4),
(5,	1,	5),
(6,	1,	6),
(7,	1,	7),
(8,	1,	8),
(9,	1,	9),
(10,	1,	10);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` varchar(36) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `login`, `password`) VALUES
('5c4e22d5-0b43-43c6-ab04-49b47fd2a265',	'user',	'$2y$10$eQRZWTl.wUK31XY50JTOtupFt7P7bcJ2t.A5uE96oN8E9a9fTsqgG');

-- 2019-03-20 03:43:59
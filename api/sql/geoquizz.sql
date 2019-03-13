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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` varchar(36) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2019-03-13 23:37:10


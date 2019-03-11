-- Adminer 4.7.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `geoquizz` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `geoquizz`;

CREATE TABLE `distance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `distance` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `partie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `score` int(11) NOT NULL,
  `serie` int(11) NOT NULL,
  `joueur` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `url` varchar(100) NOT NULL,
  `idSerie` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idSerie` (`idSerie`),
  CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `serie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `serie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ville` varchar(100) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `idDistance` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idDistance` (`idDistance`),
  CONSTRAINT `serie_ibfk_1` FOREIGN KEY (`idDistance`) REFERENCES `distance` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2019-03-11 09:50:28

/*
SQLyog Ultimate v8.32 
MySQL - 5.5.5-10.1.9-MariaDB : Database - fs_dev
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`fs_dev` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `fs_dev`;

/*Table structure for table `poll_options` */

DROP TABLE IF EXISTS `poll_options`;

CREATE TABLE `poll_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `options` varchar(64) DEFAULT NULL,
  `vote_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_poll_options` (`poll_id`),
  CONSTRAINT `FK_poll_options` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `poll_options` */

insert  into `poll_options`(`id`,`poll_id`,`options`,`vote_count`) values (20,14,'Eggs',3),(21,14,'Desserts',4),(22,14,'Sauces',7),(23,14,'Snack foods',0);

/*Table structure for table `poll_voltes` */

DROP TABLE IF EXISTS `poll_voltes`;

CREATE TABLE `poll_voltes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `poll_options_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_poll_voltes` (`user_id`),
  KEY `FK_poll_voltesa` (`poll_options_id`),
  CONSTRAINT `FK_poll_voltes` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_poll_voltesa` FOREIGN KEY (`poll_options_id`) REFERENCES `poll_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Data for the table `poll_voltes` */

insert  into `poll_voltes`(`id`,`user_id`,`poll_options_id`) values (57,21,21),(58,21,21),(59,21,22),(60,21,22),(61,21,20),(62,21,22),(63,21,20),(64,21,22),(65,21,22),(66,21,22),(67,21,20),(69,21,21);

/*Table structure for table `polls` */

DROP TABLE IF EXISTS `polls`;

CREATE TABLE `polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `poll_title` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_polls` (`user_id`),
  CONSTRAINT `FK_polls` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `polls` */

insert  into `polls`(`id`,`user_id`,`poll_title`) values (14,21,'What is your favorite food?');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `confirmation_id` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `uid` int(64) DEFAULT NULL,
  `identity` varchar(255) DEFAULT NULL,
  `network` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`password`,`status`,`created_at`,`updated_at`,`confirmation_id`,`profile`,`uid`,`identity`,`network`) values (21,'Hermine','Baghdassaryan','baghdassarianhermine@gmail.com','5fd924625f6ab16a19cc9807c7c506ae1813490e4ba675f843d5a10e0baacdb8','active','2017-01-19 06:08:10',NULL,'y3fIGnJfPPK9B9Cc6glN',NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2015 at 08:52 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bestseller`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_tokens`
--

CREATE TABLE IF NOT EXISTS `access_tokens` (
  `user_id` int(10) unsigned NOT NULL,
  `token` char(64) NOT NULL,
  `date_expires` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `author_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `gender` char(10) NOT NULL,
  `address` varchar(60) DEFAULT NULL,
  `place_of_birth` varchar(60) NOT NULL,
  `country` varchar(60) NOT NULL,
  `zip` mediumint(5) unsigned zerofill DEFAULT NULL,
  `phone` char(15) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `about` text,
  `cat_id` tinyint(3) unsigned NOT NULL,
  `image` varchar(45) NOT NULL,
  PRIMARY KEY (`author_id`),
  KEY `author_name` (`first_name`,`last_name`),
  KEY `first_name` (`first_name`,`last_name`),
  KEY `cat_id` (`cat_id`),
  FULLTEXT KEY `about` (`about`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- RELATIONS FOR TABLE `authors`:
--   `cat_id`
--       `categories` -> `cat_id`
--

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `first_name`, `last_name`, `gender`, `address`, `place_of_birth`, `country`, `zip`, `phone`, `email`, `website`, `about`, `cat_id`, `image`) VALUES
(1, 'Raymond', 'Khoury', 'male', 'Green Street 56', 'Beirut', 'LN', 52145, '25-365-698', 'raymond.k@example.com', 'www.raymondkhoury.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 7, '26011.jpg'),
(2, 'Ethan', 'Cross', 'male', 'Green Street 345', 'Abingdon', 'US', 25874, '01-895-6987', 'ethan.c@example.com', 'http://www.ethancross.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 7, '06c8c05d80572be246dee5da019ad4ae2f4d9782.jpg'),
(3, 'Paul', 'Miller', 'male', 'Blue Street 5874', 'New York', 'US', 52147, '98-987-85', 'paul.m@example.com', 'www.paulmiller.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 8, '34556.jpg'),
(4, 'Kady', 'Cross', 'female', 'Yellow Street 567', 'Hartford', 'US', 58745, '789-6587', 'kady.c@example.com', 'www.kadycross.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 12, '4308706.jpg'),
(5, 'Jeffery', 'Deaver', 'male', '3445 Green Street', 'Chicago', 'US', 10000, '1-8598-9654', 'jeffery.d@example.com', 'www.jefferydeaver.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 10, '1612.jpg'),
(6, 'Steve', 'Martini', 'male', '9786 Brown Street', 'San Francisco', 'US', 10000, '1-985-6985', 'steve.m@example.com', 'www.stevemartini.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 7, '1648.jpg'),
(7, 'Lee', 'Child', 'male', 'Blue Street 678', 'Birmingham', 'GB', 50000, '5-987-6232', 'lee.c@example.com', 'www.leechild.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 9, '5011.jpg'),
(8, 'Lincoln', 'Child', 'male', 'Green Street 7864', 'Westport', 'US', 60000, '1-987-6589', 'lincoln.c@example.com', 'www.lincolnchild.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 6, '11091.jpg'),
(9, 'Tom', 'Clancy', 'male', '4567 Blue Street', 'Baltimore', 'US', 50000, '1-987-3652', 'tom.c@example.com', 'www.tomclancy.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 7, '3892.jpg'),
(10, 'Brad', 'Thor', 'male', 'Blue Street 678', 'Chicago', 'US', 60000, '1-987-6325', 'brad.t@example.com', 'www.bradthor.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 6, '5088.jpg'),
(11, 'Sara', 'Gruen', 'female', '8976 Yellow Street', 'Vancouver', 'CA', 10000, '8-987-5112', 'sara.g@example.com', 'www.saragruen.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 12, '24556.jpg'),
(12, 'Clive', 'Cussler', 'male', 'Brown Street 678', 'Alhambra', 'US', 60000, '1-987-3652', 'clive.c@example.com', 'www.cusslerbooks.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 13, '18411.jpg'),
(13, 'Stephen', 'King', 'male', 'Green St 5747', 'Portland', 'US', 87441, '01-9874-987', 'stephen.k@example.com', 'www.stephenking.com ', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 15, '3389.jpg'),
(14, 'Cassandra', 'Clare', 'female', 'Horse Av. 456', 'Teheran', 'IR', 10000, '01-987-654', 'cassandra.c@example.com', 'www.cassandraclare.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 4, '150038.jpg'),
(15, 'Rick', 'Riordan', 'male', 'Green St. 7685', 'San Antonio', 'US', 14587, '01-98745', 'rick.r@example.com', 'www.rickriordan.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 11, '15872.jpg'),
(16, 'James', 'Patterson', 'male', 'Green St. 567', 'New York', 'US', 10000, '01-9874-987', 'james.p@example.com', 'www.jamespatterson.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 9, '3780.jpg'),
(17, 'Jodi', 'Picoult', 'female', 'Green St 6754', 'New York', 'US', 10000, '01-54441-87', 'jodi.p@example.com', 'www.jodipicoult.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 9, '7128.jpg'),
(18, 'John', 'Green', 'male', 'Blu St 567', 'Indianapolis', 'US', 14785, '01-987-654', 'john.g@example.com', 'www.johngreenbooks.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 9, '1406384.jpg'),
(19, 'Dan', 'Brown', 'male', 'Blue St. 678', 'Exeter', 'US', 87541, '01-98745', 'dan.b@example.com', 'www.danbrown.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 6, '630.jpg'),
(20, 'Richelle', 'Mead', 'female', 'Green St. 567', 'Michigan', 'US', 15478, '01-98744-87', 'richelle.m@example.com', 'www.richellemead.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 4, '137902.jpg'),
(21, 'Khaled', 'Hosseini', 'male', 'Green St. 567', 'Kabul', 'AF', 98754, '03-9874-987', 'khaled.h@example.com', 'www.khaledhosseini.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 9, '569.jpg'),
(22, 'Janet', 'Evanovich', 'female', 'Green St. 567', 'South River', 'US', 87965, '01-9874-985', 'janet.e@example.com', 'www.evanovich.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 6, '2384.jpg'),
(23, 'Paulo', 'Coelho', 'male', 'Green St 5747', 'Rio de Janeiro', 'BR', 98745, '01-9874-987', 'paulo.c@example.com', 'www.paulocoelhoblog.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 9, '566.jpg'),
(24, 'Gillian', 'Flynn', 'female', 'Green St 6754', 'Kansas City', 'US', 10547, '01-98744-87', 'gillian.f@example.com', 'www.gillian-flynn.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?\r\n', 7, '2383.jpg'),
(25, 'Jim', 'Butcher', 'male', 'Green St 6754', 'Independence', 'US', 98745, '01-987-654', 'jim.b@example.com', 'http://www.jim-butcher.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 4, '10746.jpg'),
(27, 'Sarah', 'Dessen', 'female', NULL, 'Chicago', 'US', NULL, NULL, NULL, NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 9, 'abf2914227ae5576847b1aa82564c518d32fc774.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `book_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `publisher_id` int(10) unsigned NOT NULL,
  `date_published` date DEFAULT NULL,
  `format_id` int(10) unsigned NOT NULL,
  `isbn` varchar(17) DEFAULT NULL,
  `isbn13` varchar(17) DEFAULT NULL,
  `asin` varchar(17) DEFAULT NULL,
  `price` decimal(6,2) unsigned NOT NULL,
  `stock` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `image` varchar(45) NOT NULL,
  `edition` tinyint(3) unsigned NOT NULL,
  `series` varchar(200) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`book_id`),
  KEY `publisher_id` (`publisher_id`),
  KEY `fk_05` (`format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

--
-- RELATIONS FOR TABLE `books`:
--   `publisher_id`
--       `publisher` -> `publisher_id`
--   `format_id`
--       `formats` -> `format_id`
--

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `publisher_id`, `date_published`, `format_id`, `isbn`, `isbn13`, `asin`, `price`, `stock`, `description`, `image`, `edition`, `series`, `date_created`) VALUES
(1, 'The Devil''s Elixir', 1, '2011-01-01', 1, '0525952438', '9780525952435', NULL, '14.99', 50, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'the-devils-elixir.jpg', 1, NULL, '2015-05-27 09:23:50'),
(2, 'The Shepherd', 2, '2014-01-14', 1, '1936558068', '9781936558063', NULL, '12.99', 45, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'the-shepherd.jpg', 1, 'Shepherd #1', '2015-05-27 16:00:18'),
(3, 'A Praying Life', 3, '2009-05-29', 1, '1600063004', '9781600063008', NULL, '9.99', 0, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'a-praying-life.jpg', 1, NULL, '2015-05-27 16:10:43'),
(4, 'The Strange Case of Finley Jayne', 4, '2011-05-01', 1, '145920414X', '9781459204140', NULL, '11.99', 36, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'strange-case.jpg', 1, NULL, '2015-05-27 16:16:44'),
(5, 'Carte Blanche', 9, '2011-01-01', 1, '1451620691', '9781451620696', NULL, '10.99', 21, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'carte-blanche.jpg', 1, NULL, '2015-05-27 16:23:04'),
(6, 'Trader Of Secrets', 6, '2011-05-31', 1, '0061930237', '9780061930232', NULL, '14.99', 12, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'trader-of-secrets.jpg', 1, NULL, '2015-05-27 16:30:52'),
(7, 'The Affair', 7, '2011-09-27', 1, '0385344325', '9780385344326', NULL, '9.99', 4, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'the-affair.jpg', 1, NULL, '2015-05-27 16:36:03'),
(8, 'The Third Gate', 8, '2012-06-12', 1, '0385531389', '9780385531382', NULL, '12.99', 15, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'the-third-gate.jpg', 1, NULL, '2015-05-27 16:47:55'),
(9, 'Full Black', 9, '2011-06-26', 1, '141658661X', '9781416586616', NULL, '9.99', 22, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'full-black.jpg', 1, NULL, '2015-05-27 16:53:40'),
(10, 'Water For Elephants', 11, '2007-05-01', 1, '1565125606', '9781565125605', NULL, '12.99', 9, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'water-for-elephants.jpg', 1, NULL, '2015-05-27 16:57:36'),
(11, 'The Kingdom', 11, '2011-06-06', 1, '0399157425', '9780399157424', NULL, '8.99', 7, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'the-kingdom.jpg', 1, NULL, '2015-05-27 17:08:07'),
(12, 'Against All Enemies', 10, '2011-06-14', 1, '0399157301', '9780399157301', NULL, '11.99', 16, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'against-all-enemies.jpg', 1, NULL, '2015-05-27 17:15:06'),
(14, 'The Last Templar', 12, '2005-12-24', 1, '0451219953', '9780451219954', NULL, '9.99', 45, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '46438.jpg', 1, NULL, '2015-08-07 17:05:59'),
(15, 'The Prophet', 13, '2012-10-16', 1, '1611880459 ', ' 9781611880458', NULL, '11.99', 34, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '15814903.jpg', 1, NULL, '2015-08-07 19:48:53'),
(16, 'Storm Front', 14, '2000-04-25', 1, '0451457811', '9780451457813', ' B000WH7PLS', '7.99', 7, 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '47212.jpg', 1, NULL, '2015-08-08 15:58:37'),
(22, 'Blind Justice', 10, '2015-09-22', 1, '1611882079', '9781611882070', NULL, '14.99', 23, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', 'b94e17a414082a3b7dfb7040030d8e5bfad6d647.jpg', 1, NULL, '2015-10-09 18:38:56'),
(32, 'Patriot Games', 18, '1992-05-01', 1, '0425134350', '9780425134351', NULL, '9.99', 9, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', '71a666f8df7e548bd97cb77bafba13d1e323a06f.jpg', 1, 'Jack Ryan #1', '2015-10-09 19:48:03'),
(33, 'The List', 16, '1997-12-01', 1, '0515121495', '9780515121490', NULL, '9.99', 14, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', 'eacf20a1321dc1907c2fe212ca54a09aab33ec74.jpg', 1, NULL, '2015-10-09 19:57:43'),
(35, 'My Sister''s Keeper', 22, '2005-02-01', 1, '0743454537', '9780743454537', NULL, '11.99', 20, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', 'e38edea028359c66d3f57d0dc2c16e93c25ca2fd.jpg', 1, NULL, '2015-10-09 20:59:56'),
(36, 'The Shining', 15, '1980-06-01', 1, '0450040186', '9780450040184', NULL, '8.99', 12, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 'bf1faf2c360f6af8515526ae7a7df9ed1e89ddb1.jpg', 1, 'The Shining #1', '2015-10-10 06:33:29'),
(41, 'The Lions of Lucerne', 5, '2007-02-27', 1, '1416543686', '9781416543688', NULL, '9.99', 8, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '5939c6824abfe6f045adf9bfd799538fc36c4dec.jpg', 1, 'Scot Harvath #1', '2015-10-10 07:14:11'),
(42, 'Sahara', 3, '2005-01-11', 1, '030720961X', '9780307209610', NULL, '10.99', 17, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '7a92d85ecc72af9f704ca8aabb6d6f6d6307d456.jpg', 1, 'Dirk Pitt #11', '2015-10-10 07:18:19'),
(43, 'The Alchemist', 22, '1993-05-01', 1, '0061122416', '9780061122415', NULL, '9.99', 15, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', '1661a5bc4c180b0349e51ce25bc8ae633dc0764a.jpg', 1, NULL, '2015-10-10 15:35:37'),
(44, 'Vampire Academy', 20, '2013-11-01', 1, NULL, NULL, NULL, '10.99', 12, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', '8861e7264eb6e255c0ab3ec914a455c108336ede.jpg', 1, 'Vampire Academy #1', '2015-10-10 15:41:05'),
(45, 'One for the Money', 10, '2006-01-01', 1, '0312362080', '9780312362089', NULL, '11.99', 15, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', '83c8304ff4c8d94a5ca842adc5bed3b26fbb28fc.jpg', 1, 'Stephanie Plum #1', '2015-10-10 17:37:51'),
(46, 'Just Listen', 5, '2006-04-06', 1, '0670061050', '9780670061051', NULL, '11.99', 12, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 'b2562457228d0c21725c72645be0d289ce11ba1e.jpg', 1, NULL, '2015-10-14 15:05:53'),
(48, 'Angels & Demons', 5, '2006-04-01', 1, '1416524797', '9781416524793', NULL, '10.99', 15, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '1ecbceced50b4b07abc5353cdb9616b51fef65e1.jpg', 1, 'Robert Langdon #1', '2015-10-29 08:50:49'),
(50, 'Gone Girl', 23, '2014-08-26', 1, '0553418351', '9780553418354', NULL, '11.99', 10, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 'cd2ad8159d4e8a917679820d457bea58ed801129.jpg', 1, NULL, '2015-10-29 09:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `book_authors`
--

CREATE TABLE IF NOT EXISTS `book_authors` (
  `author_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `author_id` (`author_id`,`book_id`),
  KEY `ba_fk1` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `book_authors`:
--   `book_id`
--       `books` -> `book_id`
--   `author_id`
--       `authors` -> `author_id`
--

--
-- Dumping data for table `book_authors`
--

INSERT INTO `book_authors` (`author_id`, `book_id`) VALUES
(1, 1),
(26, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(10, 9),
(11, 10),
(12, 11),
(9, 12),
(1, 14),
(2, 15),
(25, 16),
(2, 22),
(9, 32),
(6, 33),
(17, 35),
(13, 36),
(10, 41),
(12, 42),
(23, 43),
(20, 44),
(22, 45),
(27, 46),
(19, 48),
(24, 50);

-- --------------------------------------------------------

--
-- Table structure for table `book_category`
--

CREATE TABLE IF NOT EXISTS `book_category` (
  `book_id` int(10) unsigned NOT NULL,
  `cat_id` tinyint(3) unsigned NOT NULL,
  UNIQUE KEY `book_id` (`book_id`,`cat_id`),
  KEY `book_category_fk2` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `book_category`:
--   `book_id`
--       `books` -> `book_id`
--   `cat_id`
--       `categories` -> `cat_id`
--

--
-- Dumping data for table `book_category`
--

INSERT INTO `book_category` (`book_id`, `cat_id`) VALUES
(4, 4),
(1, 6),
(2, 6),
(6, 6),
(8, 6),
(33, 6),
(41, 6),
(45, 6),
(48, 6),
(1, 7),
(5, 7),
(6, 7),
(9, 7),
(12, 7),
(15, 7),
(32, 7),
(33, 7),
(41, 7),
(50, 7),
(3, 8),
(1, 9),
(2, 9),
(5, 9),
(10, 9),
(14, 9),
(22, 9),
(32, 9),
(35, 9),
(36, 9),
(44, 9),
(46, 9),
(48, 9),
(50, 9),
(11, 10),
(12, 10),
(41, 10),
(42, 10),
(4, 11),
(16, 11),
(43, 11),
(44, 11),
(8, 13),
(11, 13),
(42, 13),
(43, 13),
(7, 14),
(36, 15);

-- --------------------------------------------------------

--
-- Table structure for table `book_formats`
--

CREATE TABLE IF NOT EXISTS `book_formats` (
  `book_id` int(10) unsigned NOT NULL,
  `format_id` int(10) unsigned NOT NULL,
  `image` varchar(45) DEFAULT NULL,
  UNIQUE KEY `book_id` (`book_id`,`format_id`),
  KEY `bf_fk2` (`format_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `book_formats`:
--   `book_id`
--       `books` -> `book_id`
--   `format_id`
--       `formats` -> `format_id`
--

--
-- Dumping data for table `book_formats`
--

INSERT INTO `book_formats` (`book_id`, `format_id`, `image`) VALUES
(1, 1, ''),
(1, 2, NULL),
(1, 3, NULL),
(2, 1, ''),
(3, 1, ''),
(4, 1, ''),
(5, 1, ''),
(6, 1, ''),
(7, 1, ''),
(8, 1, ''),
(9, 1, ''),
(10, 1, ''),
(11, 1, ''),
(12, 1, ''),
(13, 1, ''),
(14, 1, ''),
(15, 1, ''),
(16, 1, ''),
(20, 1, NULL),
(22, 1, NULL),
(32, 1, NULL),
(33, 1, NULL),
(35, 1, NULL),
(36, 1, NULL),
(41, 1, NULL),
(42, 1, NULL),
(43, 1, NULL),
(44, 1, NULL),
(45, 1, NULL),
(46, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_ratings`
--

CREATE TABLE IF NOT EXISTS `book_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_session_id` char(32) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `rating` tinyint(1) unsigned NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `Fk1` (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

--
-- RELATIONS FOR TABLE `book_ratings`:
--   `book_id`
--       `books` -> `book_id`
--

--
-- Dumping data for table `book_ratings`
--

INSERT INTO `book_ratings` (`id`, `book_id`, `user_id`, `user_session_id`, `ip_address`, `rating`, `date_created`) VALUES
(2, 2, 0, 'vmqglc2c8dnn851i5ofagiupa7', '127.0.0.1', 3, '2015-08-24 16:34:47'),
(3, 12, 0, 'vmqglc2c8dnn851i5ofagiupa7', '127.0.0.1', 4, '2015-08-24 16:35:10'),
(4, 6, 0, 'vmqglc2c8dnn851i5ofagiupa7', '127.0.0.1', 4, '2015-08-24 16:35:43'),
(5, 2, 0, 'ekptha5p3i5vcpm81priccd5t6', '127.0.0.1', 4, '2015-08-24 16:42:47'),
(6, 11, 0, 'ekptha5p3i5vcpm81priccd5t6', '127.0.0.1', 3, '2015-08-24 16:43:14'),
(7, 2, 0, 'u53m2bu8qsg72v9vjvduobtst0', '127.0.0.1', 4, '2015-08-24 18:46:54'),
(8, 11, 0, 'u53m2bu8qsg72v9vjvduobtst0', '127.0.0.1', 4, '2015-08-24 18:47:46'),
(11, 7, 10, 'f35a4mj3b2hpug4oi29jai0fq4', '127.0.0.1', 4, '2015-08-24 19:04:38'),
(12, 6, 10, 'lokvifun0h6qttacscge370uf1', '127.0.0.1', 3, '2015-08-24 19:05:01'),
(13, 12, 10, '4sv5lk1jo3csgg5l6k9prt7ng3', '127.0.0.1', 4, '2015-08-24 19:06:50'),
(14, 8, 10, '0r83g3kjo2na1ocd87clbfhf01', '127.0.0.1', 3, '2015-08-24 19:08:30'),
(15, 11, 10, '3lqcfm96g3nvivmo93b3qvqot3', '127.0.0.1', 2, '2015-08-24 19:11:41'),
(16, 15, 10, 'lohu9ch8pgjttma3l1lt3uonq2', '127.0.0.1', 4, '2015-08-24 19:12:12'),
(17, 14, 10, 'dataafp2eahcguvm7sefk5q0a3', '127.0.0.1', 5, '2015-08-24 19:14:00'),
(18, 5, 0, 'rq3up3biga7utdiei0vknih887', '127.0.0.1', 3, '2015-08-24 19:14:31'),
(19, 12, 0, 'rq3up3biga7utdiei0vknih887', '127.0.0.1', 4, '2015-08-24 19:15:08'),
(20, 11, 6, 't8v2031soe30duh2bepgm3d187', '127.0.0.1', 2, '2015-08-24 19:16:51'),
(21, 8, 6, 'r1dlv41i1anca8l2m5ttv3sob2', '127.0.0.1', 4, '2015-08-24 19:17:11'),
(22, 6, 6, '7gs456obsn8b3658ni7ggk22s6', '127.0.0.1', 3, '2015-08-24 19:17:44'),
(23, 4, 10, '0lp8vfrckjq13coe1mcvou5ss6', '127.0.0.1', 3, '2015-08-24 20:13:44'),
(24, 7, 0, 'kj8hmbij393u7s6vehfnsc0dp3', '127.0.0.1', 4, '2015-08-25 19:09:26'),
(25, 8, 0, 'kj8hmbij393u7s6vehfnsc0dp3', '127.0.0.1', 3, '2015-08-25 20:24:31'),
(26, 12, 0, 'kj8hmbij393u7s6vehfnsc0dp3', '127.0.0.1', 4, '2015-08-25 20:41:39'),
(27, 10, 0, 'kj8hmbij393u7s6vehfnsc0dp3', '127.0.0.1', 5, '2015-08-25 21:00:22'),
(28, 11, 0, '5d1el7538prb5k8imj5v62htd0', '127.0.0.1', 4, '2015-08-26 15:07:21'),
(29, 1, 0, '5d1el7538prb5k8imj5v62htd0', '127.0.0.1', 4, '2015-08-26 15:38:34'),
(30, 10, 10, '0fhehnqk65li765ed4cb42tcr3', '127.0.0.1', 4, '2015-08-26 16:13:16'),
(31, 2, 0, 'hni18q7b678a9t2kupjthm9k26', '127.0.0.1', 3, '2015-08-27 12:57:38'),
(32, 14, 0, '3kn13uboeeo110e72k60633cd1', '127.0.0.1', 3, '2015-08-28 17:11:57'),
(33, 12, 0, '3kn13uboeeo110e72k60633cd1', '127.0.0.1', 5, '2015-08-28 17:12:36'),
(34, 11, 0, '3kn13uboeeo110e72k60633cd1', '127.0.0.1', 3, '2015-08-28 18:11:19'),
(35, 1, 0, '3kn13uboeeo110e72k60633cd1', '127.0.0.1', 4, '2015-08-28 18:16:17'),
(36, 16, 10, 'bvl8shhtpjbpl5hhgn0dvgfh57', '127.0.0.1', 4, '2015-08-28 19:41:52'),
(37, 10, 0, 'a7tcvl334gu2hqmftlmfsb1ju3', '127.0.0.1', 5, '2015-08-28 19:42:39'),
(38, 5, 0, '9ledcfvc6sl4tnasv2nlhoee84', '127.0.0.1', 4, '2015-08-28 19:44:16'),
(39, 10, 0, 'mo7q4j4id02tali3dg4ttq6fd5', '127.0.0.1', 4, '2015-08-29 08:37:34'),
(40, 9, 0, 'g33m7qii3m4kc73q5e0h8ga646', '127.0.0.1', 4, '2015-08-30 12:02:00'),
(41, 11, 0, 'g33m7qii3m4kc73q5e0h8ga646', '127.0.0.1', 3, '2015-08-30 12:02:16'),
(42, 14, 0, 'g33m7qii3m4kc73q5e0h8ga646', '127.0.0.1', 5, '2015-08-30 12:02:41'),
(43, 8, 20, '9klrh3jt62i8si6860mmn90me5', '127.0.0.1', 5, '2015-09-01 06:50:16'),
(44, 16, 20, 'n7rllj3og299aqgtj89sb8a6b0', '127.0.0.1', 5, '2015-09-01 06:50:41'),
(45, 1, 0, 'jve1oiuf91q9dj5m79kbml3i94', '127.0.0.1', 4, '2015-09-01 07:12:26'),
(46, 11, 0, 'qlhfu92sbnajevhg0346cbdoj0', '127.0.0.1', 5, '2015-09-02 07:40:29'),
(47, 6, 0, 'qlhfu92sbnajevhg0346cbdoj0', '127.0.0.1', 5, '2015-09-02 07:40:56'),
(48, 12, 0, 'qlhfu92sbnajevhg0346cbdoj0', '127.0.0.1', 4, '2015-09-02 07:41:09'),
(49, 1, 20, 'i646dvdrsi1tun15ivhbsgnd46', '127.0.0.1', 5, '2015-09-06 14:04:51'),
(50, 16, 0, 'u8vo2qcsl2a4se8m1u60r4e4v4', '127.0.0.1', 2, '2015-09-06 15:05:51'),
(51, 5, 20, 'rc46ofcihdh01cv1oukk7um565', '127.0.0.1', 3, '2015-09-06 15:11:58'),
(52, 7, 0, 'k74qoiot2u33mnpdhnus8f3oh7', '127.0.0.1', 3, '2015-09-06 15:13:57'),
(53, 7, 0, '8kofb1rura010conai0gru76g3', '127.0.0.1', 5, '2015-09-09 16:00:19'),
(54, 14, 20, '09ndubftlg2998cojsvd9eurj0', '127.0.0.1', 4, '2015-09-10 13:34:20'),
(55, 15, 20, 'm0trq38flq3pje0rqtn60ip563', '127.0.0.1', 4, '2015-09-11 18:52:39'),
(56, 12, 20, '1f0pp6o6crn0ss213pge59jpi4', '127.0.0.1', 4, '2015-09-11 18:53:18'),
(57, 2, 0, 'halq18rjdk0e3ub4gajbnccta4', '127.0.0.1', 4, '2015-09-12 16:01:53'),
(58, 4, 20, '41ia5ij82u549lo3ufvieo1og5', '127.0.0.1', 3, '2015-09-12 19:08:38'),
(59, 10, 20, 'qmgbn4a4rph0c4kpnu7v43scd2', '127.0.0.1', 4, '2015-09-12 19:11:03'),
(60, 7, 0, '5gb1rpp2lvika2ds997op6g1n3', '127.0.0.1', 4, '2015-09-14 08:04:45'),
(61, 1, 10, 'uhq515m2uukdo8hb6bjkb6sf84', '127.0.0.1', 3, '2015-09-14 08:41:48'),
(62, 10, 1, 'l0t73v2q1t03jhpvbkrf1apcr5', '127.0.0.1', 5, '2015-09-14 08:46:25'),
(63, 11, 1, 'hc8o469u0a5amjs78otm56sl62', '127.0.0.1', 5, '2015-09-14 18:07:09'),
(64, 5, 1, 'l59rgd7ng6vuo9ohrrpv0mbji6', '127.0.0.1', 4, '2015-09-14 18:09:35'),
(65, 5, 0, '4o1has66qg08hg9tqapav4t3u5', '127.0.0.1', 5, '2015-09-14 18:12:37'),
(66, 5, 0, 'kikk3sra3lcil4ctvka2j1lto0', '127.0.0.1', 5, '2015-09-14 18:17:05'),
(67, 1, 0, 'g5ebu5gr77okiijlq51sp97611', '127.0.0.1', 3, '2015-09-17 16:11:15'),
(68, 4, 0, 'g5ebu5gr77okiijlq51sp97611', '127.0.0.1', 4, '2015-09-17 17:20:28'),
(69, 8, 0, 'g5ebu5gr77okiijlq51sp97611', '127.0.0.1', 2, '2015-09-17 17:35:00'),
(70, 12, 0, 'g5ebu5gr77okiijlq51sp97611', '127.0.0.1', 3, '2015-09-17 17:40:04'),
(71, 2, 20, 'btnjd67uvu9iqle53bfu3h44p1', '127.0.0.1', 5, '2015-09-18 15:29:39'),
(72, 6, 20, 'a6scc07ud0tpjj11990unrh3b7', '127.0.0.1', 4, '2015-09-18 15:30:13'),
(73, 12, 1, 'tp0qispk6m8i906614v7mpmmo3', '127.0.0.1', 5, '2015-09-18 20:34:47'),
(74, 15, 0, 'ibh14485ee4gkja6uf2v0mcup5', '127.0.0.1', 4, '2015-09-20 15:43:33'),
(75, 12, 0, 'ibh14485ee4gkja6uf2v0mcup5', '127.0.0.1', 5, '2015-09-20 15:43:46'),
(76, 9, 0, 'ibh14485ee4gkja6uf2v0mcup5', '127.0.0.1', 2, '2015-09-20 15:43:58'),
(77, 8, 0, 'ibh14485ee4gkja6uf2v0mcup5', '127.0.0.1', 4, '2015-09-20 15:48:19'),
(78, 3, 1, 'f7f0kbt6vfdrqkel64kci9n6s7', '127.0.0.1', 3, '2015-09-23 18:41:41'),
(79, 2, 25, '5c5b9ogc8i8u0f4oagp521moc5', '127.0.0.1', 4, '2015-09-23 18:58:17'),
(80, 8, 1, 'qpmc1l9tqhiqd2bed92fia2lr0', '127.0.0.1', 4, '2015-09-23 19:55:43'),
(81, 2, 0, 'mu7uo9fh72g7lrd4d980atirg6', '127.0.0.1', 4, '2015-09-24 15:22:26'),
(82, 15, 0, 'v49hjc54lhr6t92g6a9gs5h792', '127.0.0.1', 4, '2015-09-24 15:22:26'),
(83, 8, 0, 'u8uic0ip9a2407onb3pd4ko9j3', '127.0.0.1', 4, '2015-09-24 15:22:26'),
(84, 7, 0, 'umjnvb4kresl6hn638c5okqa54', '127.0.0.1', 4, '2015-09-24 15:22:27'),
(85, 1, 0, '8pudtd589ofbb93vpdgira5ja4', '127.0.0.1', 4, '2015-09-24 15:22:27'),
(86, 12, 0, 'sv27r4rajp30umuma019v9b470', '127.0.0.1', 4, '2015-09-24 15:22:27'),
(87, 9, 0, 'pa5elvrdhubidvkh7ccaesakh3', '127.0.0.1', 4, '2015-09-24 15:22:28'),
(88, 11, 0, 'm52ka5onhaqgb7q1f1efted7t3', '127.0.0.1', 4, '2015-09-24 15:22:28'),
(89, 10, 0, 'a5v0kekl49prci4n9oqdbcb6i1', '127.0.0.1', 4, '2015-09-24 15:22:29'),
(90, 6, 0, 'ad0v9k2ok54gv95j4fdpaaicq4', '127.0.0.1', 4, '2015-09-24 15:22:29'),
(91, 4, 0, '816lsgftt2gmkj710urn141497', '127.0.0.1', 4, '2015-09-24 15:22:29'),
(92, 3, 0, 'nkgoti1fhotpcg4vf83m0cc4k6', '127.0.0.1', 4, '2015-09-24 15:22:29'),
(93, 14, 0, '3kdelt8r3boeakpu7etbe8f105', '127.0.0.1', 4, '2015-09-24 15:22:29'),
(94, 5, 0, 'vn8oa0t9fkiac01a79ft0dlqa5', '127.0.0.1', 4, '2015-09-24 15:22:29'),
(95, 16, 0, '5b2950h5uultst93a2mp1mcno2', '127.0.0.1', 4, '2015-09-24 15:22:30'),
(96, 7, 0, 'phg4godes5273onvcgmt81gdk7', '127.0.0.1', 5, '2015-09-24 19:43:51'),
(97, 8, 25, 'gr7entcif59v61crj5jfqe7567', '127.0.0.1', 5, '2015-09-24 19:53:40'),
(98, 14, 25, 'sg0dpri04215ipn48dqrbk5n93', '127.0.0.1', 2, '2015-09-24 20:06:09'),
(99, 2, 0, '770rfn8eo13a0qs1jf4ji0gdq5', '127.0.0.1', 3, '2015-09-25 15:27:45'),
(100, 15, 0, 'ka5td6jalahi2sc9069kah0sh6', '127.0.0.1', 5, '2015-09-25 15:29:14'),
(101, 32, 26, 'jkss8jen3q8et37799edev5q02', '127.0.0.1', 3, '2015-10-09 20:10:17'),
(102, 41, 26, '8d1etcpvsvjisqhb82f276uo95', '127.0.0.1', 5, '2015-10-10 07:19:31'),
(103, 44, 26, 'hn4i0b6t5ga2vl6r5ah138po41', '127.0.0.1', 4, '2015-10-10 15:41:36'),
(104, 46, 26, 'cp9ia0kkgkej6m2vl07bg7ca86', '127.0.0.1', 4, '2015-10-14 15:07:39'),
(105, 36, 0, 'c9vnfc28q17josga6tmvim15e5', '127.0.0.1', 4, '2015-10-15 16:06:20'),
(106, 45, 25, 'b55clu5pukckp18iktqmn7h1d1', '127.0.0.1', 3, '2015-10-15 17:34:59'),
(107, 44, 25, 'jsc08o1hkfb8qcgj4mh5oqo4h3', '127.0.0.1', 5, '2015-10-15 17:37:02'),
(108, 22, 28, '20desah76j4h9dg5hkm5d6u6o5', '127.0.0.1', 5, '2015-10-15 18:44:10'),
(109, 32, 28, 'obm6unkcv4a00clrgpi5lg7t83', '127.0.0.1', 5, '2015-10-15 18:44:25'),
(110, 33, 28, 'a8fsdutpq69eeuu9qk5gqi9cu1', '127.0.0.1', 4, '2015-10-15 18:53:42'),
(111, 22, 0, 'k4ini18j6frr4emu61r3v14ni4', '127.0.0.1', 3, '2015-10-17 11:03:29'),
(112, 43, 16, '3mnilju8ojaqivob1iblv75r67', '127.0.0.1', 5, '2015-10-17 14:50:36'),
(113, 7, 28, 'a3lpc8ss1la8cepubnequh8u04', '127.0.0.1', 3, '2015-10-21 18:55:51'),
(114, 44, 29, 'nlf41muo8g2hk8tbffnmgahat0', '127.0.0.1', 5, '2015-10-21 19:08:01'),
(115, 42, 29, 'jrff1rnrabm26s85a76r13q3c3', '127.0.0.1', 4, '2015-10-21 19:08:13'),
(116, 2, 26, 'a5ha4dtajsdl4qmt6q4ejnt947', '127.0.0.1', 4, '2015-10-29 11:39:28'),
(117, 50, 26, 'dn9eg9igh7m20n75oa2k29nn95', '127.0.0.1', 3, '2015-10-29 11:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_session_id` char(32) NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_session_id` (`user_session_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- RELATIONS FOR TABLE `carts`:
--   `book_id`
--       `books` -> `book_id`
--

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `user_session_id`, `book_id`, `quantity`, `ip_address`, `date_created`, `date_modified`) VALUES
(12, 25, 'k4ini18j6frr4emu61r3v14ni4', 15, 1, '127.0.0.1', '2015-10-17 10:52:29', '2015-10-17 11:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(40) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `category`, `description`) VALUES
(1, 'History', 'History is the discovery, collection, organization, and presentation of information about past events. History can also mean the period of time after writing was invented. Scholars who write about history are called historians. It is a field of research which uses a narrative to examine and analyse the sequence of events, and it sometimes attempts to investigate objectively the patterns of cause and effect that determine events. Historians debate the nature of history and its usefulness. This includes discussing the study of the discipline as an end in itself and as a way of providing "perspective" on the problems of the present. The stories common to a particular culture, but not supported by external sources (such as the legends surrounding King Arthur) are usually classified as cultural heritage rather than the "disinterested investigation" needed by the discipline of history. Events of the past prior to written record are considered prehistory.\r\nAmongst scholars, the fifth century BC Greek historian Herodotus is considered to be the "father of history", and, along with his contemporary Thucydides, forms the foundations for the modern study of history. Their influence, along with other historical traditions in other parts of their world, have spawned many different interpretations of the nature of history which has evolved over the centuries and are continuing to change. The modern study of history has many different fields including those that focus on certain regions and those which focus on certain topical or thematical elements of historical investigation. Often history is taught as part of primary and secondary education, and the academic study of history is a major discipline in University studies.'),
(2, 'Art', 'Books that showcase particular types of art.'),
(3, 'Biography', 'A biography (from the Greek words bios meaning "life", and graphos meaning "write") is an account of a person''s life, usually published in the form of a book or essay, or in some other form, such as a film.'),
(4, 'Science Fiction', 'Science fiction (abbreviated SF or sci-fi with varying punctuation and capitalization) is a broad genre of fiction that often involves speculations based on current or future science or technology. Science fiction is found in books, art, television, films, games, theatre, and other media. In organizational or marketing contexts, science fiction can be synonymous with the broader definition of speculative fiction, encompassing creative works incorporating imaginative elements not found in contemporary reality; this includes fantasy, horror and related genres.\nAlthough the two genres are often conflated as science fiction/fantasy, science fiction differs from fantasy in that, within the context of the story, its imaginary elements are largely possible within scientifically established or scientifically postulated laws of nature (though some elements in a story might still be pure imaginative speculation). Exploring the consequences of such differences is the traditional purpose of science fiction, making it a "literature of ideas". Science fiction is largely based on writing entertainingly and rationally about alternate possibilities in settings that are contrary to known reality.'),
(5, 'Satire', 'Satire is primarily a literary genre or form, although in practice it can also be found in the graphic and performing arts. In satire, vices, follies, abuses, and shortcomings are held up to ridicule, ideally with the intent of shaming individuals, and society itself, into improvement. Although satire is usually meant to be funny, its greater purpose is often constructive social criticism, using wit as a weapon.'),
(6, 'Mystery', 'Mystery fiction is a loosely-defined term that is often used as a synonym of detective fiction ? in other words a novel or short story in which a detective (either professional or amateur) solves a crime. The term "mystery fiction" may sometimes be limited to the subset of detective stories in which the emphasis is on the puzzle element and its logical solution (cf. whodunit), as a contrast to hardboiled detective stories which focus on action and gritty realism. However, in more general usage "mystery" may be used to describe any form of crime fiction, even if there is no mystery to be solved. For example, the Mystery Writers of America describes itself as "the premier organization for mystery writers, professionals allied to the crime writing field, aspiring crime writers, and those who are devoted to the genre".\r\nAlthough normally associated with the crime genre, the term "mystery fiction" may in certain situations refer to a completely different genre, where the focus is on supernatural mystery (even if no crime is involved). This usage was common in the pulp magazines of the 1930s and 1940s, where titles such as Dime Mystery, Thrilling Mystery and Spicy Mystery offered what at the time were described as "weird menace" stories ? supernatural horror in the vein of Grand Guignol. This contrasted with parallel titles such as Dime Detective, Thrilling Detective and Spicy Detective, which contained conventional hardboiled crime fiction. The first use of "mystery" in this sense was by Dime Mystery, which started out as an ordinary crime fiction magazine but switched to "weird menace" during the latter part of 1933.'),
(7, 'Thriller', 'Thrillers are characterized by fast pacing, frequent action, and resourceful heroes who must thwart the plans of more-powerful and better-equipped villains. Literary devices such as suspense, red herrings and cliffhangers are used extensively.\r\nThrillers often overlap with mystery stories, but are distinguished by the structure of their plots. In a thriller, the hero must thwart the plans of an enemy, rather than uncover a crime that has already happened. Thrillers also occur on a much grander scale: the crimes that must be prevented are serial or mass murder, terrorism, assassination, or the overthrow of governments. Jeopardy and violent confrontations are standard plot elements. While a mystery climaxes when the mystery is solved, a thriller climaxes when the hero finally defeats the villain, saving his own life and often the lives of others.'),
(8, 'Religion', 'Religion is a cultural system that establishes symbols that relate humanity to spirituality and moral values. Many religions have narratives, symbols, traditions and sacred histories that are intended to give meaning to life or to explain the origin of life or the universe. They tend to derive morality, ethics, religious laws or a preferred lifestyle from their ideas about the cosmos and human nature.'),
(9, 'Fiction', 'Fiction is the telling of stories which are not real. More specifically, fiction is an imaginative form of narrative, one of the four basic rhetorical modes. Although the word fiction is derived from the Latin fingo, fingere, finxi, fictum, "to form, create", works of fiction need not be entirely imaginary and may include real people, places, and events. Fiction may be either written or oral. Although not all fiction is necessarily artistic, fiction is largely perceived as a form of art or entertainment. The ability to create fiction and other artistic works is considered to be a fundamental aspect of human culture, one of the defining characteristics of humanity.'),
(10, 'Action', 'The action genre is characterized by more emphasis on exciting action sequences than on character development or story-telling.'),
(11, 'Fantasy', 'Fantasy is a genre that uses magic and other supernatural forms as a primary element of plot, theme, and/or setting. Fantasy is generally distinguished from science fiction and horror by the expectation that it steers clear of technological and macabre themes, respectively, though there is a great deal of overlap between the three (collectively known as speculative fiction or science fiction/fantasy). In its broadest sense, fantasy comprises works by many writers, artists, filmmakers, and musicians, from ancient myths and legends to many recent works embraced by a wide audience today, including young adults, most of whom are represented by the works below.'),
(12, 'Historical Fiction', 'Historical fiction presents a story set in the past, often during a significant time period. In historical fiction, the time period is an important part of the setting and often of the story itself. Historical fiction may include fictional characters, well-known historical figures or a mixture of the two. Authors of historical fiction usually pay close attention to the details of their stories (settings, clothing, dialogue, etc.) to ensure that they fit the time periods in which the narratives take place. As this is fiction, artistic license is permitted in regard to presentation and subject matter, so long as it does not deviate in significant ways from established history. If events should deviate significantly, the story may then fall into the genre of alternate history, which is known for speculating on what could have happened if a significant historical event had gone differently. On a similar note, events occurring in historical fiction must adhere to the laws of physics. Stories that extend into the magical or fantastic are often considered historical fantasy.'),
(13, 'Adventure', 'Adventure has been a common theme since the earliest days of written fiction. Indeed, the standard plot of Medieval romances was a series of adventures. Following a plot framework as old as Heliodorus, and so durable as to be still alive in Hollywood movies, a hero would undergo a first set of adventures before he met his lady. A separation would follow, with a second set of adventures leading to a final reunion. Variations kept the genre alive. From the mid-19th century onwards, when mass literacy grew, adventure became a popular subgenre of fiction. Although not exploited to its fullest, adventure has seen many changes over the years - from being constrained to stories of knights in armor to stories of high-tech espionages.'),
(14, 'Crime', 'The crime genre includes the broad selection of books on criminals, courts, and investigations. Mystery novels are usually placed into this category.'),
(15, 'Horror', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(16, 'Comics', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.'),
(17, 'Science', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.'),
(18, 'Philosophy', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.'),
(19, 'Memoir', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?');

-- --------------------------------------------------------

--
-- Table structure for table `controllers`
--

CREATE TABLE IF NOT EXISTS `controllers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(25) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `controllers`
--

INSERT INTO `controllers` (`id`, `controller`, `active`) VALUES
(1, 'products', 1),
(2, 'categories', 1),
(5, 'rating', 1),
(6, 'basket', 1),
(7, 'checkout', 1),
(8, 'account', 1),
(12, 'about', 1),
(13, 'contact', 1),
(14, 'main', 1),
(15, 'authenticate', 1),
(16, 'registration', 1),
(17, 'authors', 1);

-- --------------------------------------------------------

--
-- Table structure for table `controllers_admin`
--

CREATE TABLE IF NOT EXISTS `controllers_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `controller` varchar(25) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `controllers_admin`
--

INSERT INTO `controllers_admin` (`id`, `controller`, `active`) VALUES
(1, 'main', 1),
(2, 'products', 1),
(3, 'categories', 1),
(4, 'authors', 1),
(5, 'publishers', 1),
(6, 'customers', 1),
(7, 'orders', 1),
(8, 'reports', 1),
(9, 'reviews', 1),
(10, 'settings', 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `country_id` int(3) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) NOT NULL,
  `country_abbrev` varchar(3) NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=236 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `country_name`, `country_abbrev`) VALUES
(1, 'United States', 'US'),
(2, 'Canada', 'CA'),
(3, 'United Kingdom', 'GB'),
(4, 'Afghanistan', 'AF'),
(5, 'Albania', 'AL'),
(6, 'Algeria', 'DZ'),
(7, 'American Somoa', 'AS'),
(8, 'Andorra', 'AD'),
(9, 'Angola', 'AO'),
(10, 'Anguilla', 'AI'),
(11, 'Antarctica', 'AQ'),
(12, 'Antigua and Barbuda', 'AG'),
(13, 'Argentina', 'AR'),
(14, 'Armenia', 'AM'),
(15, 'Aruba', 'AW'),
(16, 'Australia', 'AU'),
(17, 'Austria', 'AT'),
(18, 'Bahamas', 'BS'),
(19, 'Bahrain', 'BH'),
(20, 'Bangladesh', 'BD'),
(21, 'Barbados', 'BB'),
(22, 'Belarus', 'BY'),
(23, 'Belgium', 'BE'),
(24, 'Belize', 'BZ'),
(25, 'Benin', 'BJ'),
(26, 'Bermuda', 'BM'),
(27, 'Bhutan', 'BT'),
(28, 'Bolivia', 'BO'),
(29, 'Bosnia and Herzegovina', 'BA'),
(30, 'Botswana', 'BW'),
(31, 'Bouvet Island', 'BV'),
(32, 'Brazil', 'BR'),
(33, 'British Indian Ocean Territory', 'IO'),
(34, 'Brunei Darussalam', 'BN'),
(35, 'Bulgaria', 'BG'),
(36, 'Burkina Faso', 'BF'),
(37, 'Burundi', 'BI'),
(38, 'Cambodia', 'KH'),
(39, 'Cameroon', 'CM'),
(40, 'Cape Verde', 'CV'),
(41, 'Cayman Islands', 'KY'),
(42, 'Central African Republic', 'CF'),
(43, 'Chad', 'TD'),
(44, 'Chile', 'CL'),
(45, 'China', 'CN'),
(46, 'Christmas Island', 'CX'),
(47, 'Cocos (Keeling) Islands', 'CC'),
(48, 'Colombia', 'CO'),
(49, 'Comoros', 'KM'),
(50, 'Congo', 'CG'),
(51, 'Cook Islands', 'CK'),
(52, 'Costa Rica', 'CR'),
(53, 'Croatia', 'HR'),
(54, 'Cuba', 'CU'),
(55, 'Cyprus', 'CY'),
(56, 'Czech Republic', 'CZ'),
(57, 'Denmark', 'DK'),
(58, 'Djibouti', 'DJ'),
(59, 'Dominica', 'DM'),
(60, 'Dominican Republic', 'DO'),
(61, 'East Timor', 'TP'),
(62, 'Ecuador', 'EC'),
(63, 'Egypt', 'EG'),
(64, 'El Salvador', 'SV'),
(65, 'Equatorial Guinea', 'GQ'),
(66, 'Eritrea', 'ER'),
(67, 'Estonia', 'EE'),
(68, 'Ethiopia', 'ET'),
(69, 'Faroe Islands', 'FO'),
(70, 'Falkland Islands', 'FK'),
(71, 'Fiji', 'FJ'),
(72, 'Finland', 'FI'),
(73, 'France', 'FR'),
(74, 'French Guiana', 'GF'),
(75, 'French Polynesia', 'PF'),
(76, 'French Southern and Antarctic Lands', 'FQ'),
(77, 'Gabon', 'GA'),
(78, 'Gambia', 'GM'),
(79, 'Georgia', 'GE'),
(80, 'Germany', 'DE'),
(81, 'Ghana', 'GH'),
(82, 'Gibraltar', 'GI'),
(83, 'Greece', 'GR'),
(84, 'Greenland', 'GL'),
(85, 'Grenada', 'GD'),
(86, 'Guadaloupe', 'GP'),
(87, 'Guam', 'GU'),
(88, 'Guatemala', 'GT'),
(89, 'Guinea', 'GN'),
(90, 'Guinea-Bissau', 'GW'),
(91, 'Guyana', 'GY'),
(92, 'Haiti', 'HT'),
(93, 'Heard Island and McDonald Islands', 'HM'),
(94, 'Honduras', 'HN'),
(95, 'Hong Kong', 'HK'),
(96, 'Hungary', 'HU'),
(97, 'Iceland', 'IS'),
(98, 'India', 'IN'),
(99, 'Indonesia', 'ID'),
(100, 'Iran', 'IR'),
(101, 'Iraq', 'IQ'),
(102, 'Ireland', 'IE'),
(103, 'Israel', 'IL'),
(104, 'Italy', 'IT'),
(105, 'Ivory Coast', 'CI'),
(106, 'Jamaica', 'JM'),
(107, 'Japan', 'JP'),
(108, 'Jordan', 'JO'),
(109, 'Kazakhstan', 'KZ'),
(110, 'Kenya', 'KE'),
(111, 'North Korea', 'KP'),
(112, 'South Korea', 'KR'),
(113, 'Kuwait', 'KW'),
(114, 'Kyrgyzstan', 'KG'),
(115, 'Laos', 'LA'),
(116, 'Latvia', 'LV'),
(117, 'Lebanon', 'LN'),
(118, 'Lesotho', 'LS'),
(119, 'Liberia', 'LR'),
(120, 'Libya', 'LY'),
(121, 'Liechtenstein', 'LI'),
(122, 'Lithuania', 'LT'),
(123, 'Luxembourg', 'LU'),
(124, 'Macau', 'MO'),
(125, 'Macedonia', 'MK'),
(126, 'Madagascar', 'MG'),
(127, 'Malawi', 'MW'),
(128, 'Malaysia', 'MY'),
(129, 'Maldives', 'MV'),
(130, 'Mali', 'ML'),
(131, 'Malta', 'MT'),
(132, 'Marshall Islands', 'MH'),
(133, 'Martinique', 'MQ'),
(134, 'Mauritania', 'MR'),
(135, 'Mauritius', 'MU'),
(136, 'Mayotte', 'YT'),
(137, 'Mexico', 'MX'),
(138, 'Micronesia', 'FM'),
(139, 'Moldova', 'MD'),
(140, 'Monaco', 'MC'),
(141, 'Mongolia', 'MN'),
(142, 'Montserrat', 'MS'),
(143, 'Morocco', 'MA'),
(144, 'Mozambique', 'MZ'),
(145, 'Myanmar', 'MM'),
(146, 'Namibia', 'NA'),
(147, 'Nauru', 'NR'),
(148, 'Nepal', 'NP'),
(149, 'Netherlands', 'NL'),
(150, 'Netherlands Antilles', 'AN'),
(151, 'New Caledonia', 'NC'),
(152, 'New Hebrides', 'NH'),
(153, 'New Zealand', 'NZ'),
(154, 'Nicaragua', 'NI'),
(155, 'Niger', 'NE'),
(156, 'Nigeria', 'NG'),
(157, 'Niue', 'NU'),
(158, 'Norfolk Island', 'NF'),
(159, 'Norway', 'NO'),
(160, 'Oman', 'OM'),
(161, 'Pakistan', 'PK'),
(162, 'Palau', 'PW'),
(163, 'Panama', 'PA'),
(164, 'Papua New Guinea', 'PG'),
(165, 'Paraguay', 'PY'),
(166, 'Peru', 'PE'),
(167, 'Philippines', 'PH'),
(168, 'Pitcairn', 'PN'),
(169, 'Poland', 'PL'),
(170, 'Portugal', 'PT'),
(171, 'Puerto Rico', 'PR'),
(172, 'Qatar', 'QA'),
(173, 'Reunion', 'RE'),
(174, 'Romania', 'RO'),
(175, 'Russia', 'RU'),
(176, 'Rwanda', 'RW'),
(177, 'St. Christopher-Nevis-Anguilla', 'KN'),
(178, 'St. Helena', 'SH'),
(179, 'St. Lucia', 'LC'),
(180, 'St. Pierre and Miquelon', 'PM'),
(181, 'St. Vincent', 'VC'),
(182, 'Samoa', 'WS'),
(183, 'San Marino', 'SM'),
(184, 'Sao Tome and Principe', 'ST'),
(185, 'Saudi Arabia', 'SA'),
(186, 'Senegal', 'SN'),
(187, 'Seychelles', 'SC'),
(188, 'Sierra Leone', 'SL'),
(189, 'Singapore', 'SG'),
(190, 'Slovakia', 'SK'),
(191, 'Slovenia', 'SI'),
(192, 'Solomon Islands', 'SB'),
(193, 'Somalia', 'SO'),
(194, 'South Africa', 'ZA'),
(195, 'Spain', 'ES'),
(196, 'Sri Lanka', 'LK'),
(197, 'Sudan', 'SD'),
(198, 'Surinam', 'SR'),
(199, 'Svalbard and Jan Mayen', 'SJ'),
(200, 'Swaziland', 'SZ'),
(201, 'Sweden', 'SE'),
(202, 'Switzerland', 'CH'),
(203, 'Syria', 'SY'),
(204, 'Taiwan', 'TW'),
(205, 'Tajikistan', 'TJ'),
(206, 'Tanzania', 'TZ'),
(207, 'Thailand', 'TH'),
(208, 'Togo', 'TG'),
(209, 'Tokelau Islands', 'TK'),
(210, 'Tonga', 'TO'),
(211, 'Trinidad and Tobago', 'TT'),
(212, 'Tunisia', 'TN'),
(213, 'Turkey', 'TR'),
(214, 'Turks and Caicos Islands', 'TC'),
(215, 'Tuvalu', 'TV'),
(216, 'Uganda', 'UG'),
(217, 'Ukraine', 'UA'),
(218, 'United Arab Emirates', 'AE'),
(219, 'United States Miscellaneous Pacific Islands', 'PU'),
(220, 'Uruguay', 'UY'),
(221, 'Uzbekistan', 'UZ'),
(222, 'Vatican City', 'VA'),
(223, 'Venezuela', 'VE'),
(224, 'Vietnam', 'VN'),
(225, 'Virgin Islands (U.S.)', 'VI'),
(226, 'Wallis and Futana', 'WF'),
(227, 'Western Sahara', 'EH'),
(228, 'Yemen', 'YE'),
(229, 'Yugoslavia', 'YU'),
(230, 'Zaire', 'ZR'),
(231, 'Zambia', 'ZM'),
(232, 'Zimbabwe', 'ZW'),
(233, 'Serbia', 'RS'),
(234, 'Montenegro', 'ME'),
(235, 'Republika Srpska', 'RS2');

-- --------------------------------------------------------

--
-- Table structure for table `discount_codes`
--

CREATE TABLE IF NOT EXISTS `discount_codes` (
  `discount_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vouchercode` varchar(25) NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `min_basket_cost` decimal(6,2) NOT NULL,
  `discount_operation` enum('-','%','s') NOT NULL,
  `discount_amount` decimal(6,2) NOT NULL,
  `num_vouchers` int(10) NOT NULL DEFAULT '-1',
  `expiry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`discount_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `discount_codes`
--

INSERT INTO `discount_codes` (`discount_id`, `vouchercode`, `active`, `min_basket_cost`, `discount_operation`, `discount_amount`, `num_vouchers`, `expiry`) VALUES
(1, 'zazaza', 0, '20.00', '-', '5.00', -1, '2015-09-14 22:00:00'),
(2, 'bubu75', 0, '20.00', '-', '5.00', -1, '2015-09-19 22:00:00'),
(3, 'bubu21', 0, '20.00', '-', '5.00', 0, '2015-09-19 22:00:00'),
(4, 'nexus12', 1, '30.00', '-', '10.00', 15, '2015-11-04 23:00:00'),
(5, 'alex123', 1, '20.00', '-', '4.00', 20, '2015-10-31 23:00:00'),
(6, 'flex050', 1, '20.00', '-', '4.00', -1, '2015-10-31 23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `formats`
--

CREATE TABLE IF NOT EXISTS `formats` (
  `format_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `format` varchar(200) NOT NULL,
  PRIMARY KEY (`format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `formats`
--

INSERT INTO `formats` (`format_id`, `format`) VALUES
(1, 'paperback'),
(2, 'hardback'),
(3, 'ebook'),
(4, 'audio book'),
(5, 'kindle edition');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `history`:
--   `user_id`
--       `users` -> `user_id`
--   `book_id`
--       `books` -> `book_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `amount` int(10) unsigned NOT NULL,
  `status_id` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `invoice`:
--   `order_id`
--       `orders` -> `order_id`
--   `user_id`
--       `users` -> `user_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `delivery_name` varchar(80) NOT NULL,
  `delivery_address` varchar(80) NOT NULL,
  `delivery_city` varchar(60) NOT NULL,
  `delivery_state` varchar(60) DEFAULT NULL,
  `delivery_country` varchar(60) NOT NULL,
  `delivery_zip` mediumint(5) unsigned zerofill NOT NULL,
  `subtotal` decimal(6,2) unsigned DEFAULT NULL,
  `discount` decimal(6,2) unsigned DEFAULT NULL,
  `total` decimal(6,2) unsigned DEFAULT NULL,
  `voucher_code` varchar(25) DEFAULT NULL,
  `order_status` int(10) unsigned NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `order_date` (`order_date`),
  KEY `user_id` (`user_id`),
  KEY `Fk2` (`order_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- RELATIONS FOR TABLE `orders`:
--   `order_status`
--       `order_statuses` -> `status_id`
--   `user_id`
--       `users` -> `user_id`
--

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `delivery_name`, `delivery_address`, `delivery_city`, `delivery_state`, `delivery_country`, `delivery_zip`, `subtotal`, `discount`, `total`, `voucher_code`, `order_status`, `order_date`) VALUES
(6, 20, 'Alex Morris', 'Hover St. 567', 'London', NULL, 'United Kingdom', 10000, '23.98', NULL, '23.98', NULL, 1, '2015-09-08 20:56:21'),
(7, 20, 'Alex Morris', 'Blue St. 987', 'London', NULL, 'United Kingdom', 10000, '27.97', '5.00', '22.97', 'zazaza', 1, '2015-09-10 13:45:08'),
(8, 10, 'Nicholas Wallace', 'Brown St 4567', 'New Castle', NULL, 'United Kingdom', 25698, '14.99', NULL, '14.99', NULL, 1, '2015-09-14 08:43:48'),
(9, 10, 'Nicholas Wallace', 'Brown St 4567', 'New Castle', NULL, 'United Kingdom', 10000, '21.98', NULL, '21.98', NULL, 1, '2015-09-18 07:32:14'),
(10, 20, 'Alex Morris', 'Blue St. 987', 'San Francisco', 'California', 'United States of America', 10000, '36.97', '5.00', '31.97', NULL, 1, '2015-09-18 09:02:05'),
(11, 16, 'Tony Jehnsen', 'Silver Avenue 1234', 'New York', 'New York', 'United States of America', 10000, '17.98', NULL, '17.98', NULL, 1, '2015-09-18 09:06:24'),
(12, 1, 'Naomi Matthews', '1234 Yellow Street', 'Barcelona', NULL, 'Spain', 12654, '19.98', NULL, '19.98', NULL, 1, '2015-09-18 20:31:58'),
(13, 22, 'Logan Lane', '1234 Yellow Street', 'London', NULL, 'United Kingdom', 65432, '29.98', '5.00', '24.98', NULL, 1, '2015-09-18 20:40:07'),
(14, 22, 'Logan Lane', '1234 Yellow Street', 'London', NULL, 'United Kingdom', 32134, '11.99', NULL, '11.99', NULL, 1, '2015-09-19 14:27:55'),
(15, 1, 'Naomi Matthews', '1234 Yellow Street', 'Barcelona', NULL, 'Spain', 12654, '9.99', NULL, '9.99', NULL, 1, '2015-09-23 18:54:14'),
(16, 25, 'Annie Fleming', '4981 Fincher Rd', 'Austin', 'Texas', 'United States of America', 54318, '12.99', NULL, '12.99', NULL, 1, '2015-09-23 18:59:31'),
(17, 25, 'Annie Fleming', '8111 View Street', 'Austin', 'Texas', 'United States', 50000, '51.95', '4.00', '47.95', 'flex050', 1, '2015-10-17 09:55:38'),
(18, 20, 'Alex Morris', '1234 Blue Street', 'New York', 'New York', 'United States', 10000, '10.99', NULL, '10.99', NULL, 1, '2015-10-18 10:47:18'),
(19, 9, 'Naomi Fiesta', '1234 Blue Street', 'Madrid', NULL, 'Spain', 10000, '32.97', NULL, '32.97', NULL, 1, '2015-10-18 10:57:36'),
(20, 28, 'Peggy Gardner', '1234 Blue Street', 'New Castle', NULL, 'United Kingdom', 10000, '34.97', '4.00', '30.97', 'flex050', 1, '2015-10-21 18:58:41'),
(21, 29, 'Sebastian Woods', '8111 View Street', 'Miami', 'Florida', 'United States', 25554, '21.98', '4.00', '17.98', 'flex050', 1, '2015-10-21 19:12:49'),
(22, 1, 'Naomi Matthews', '1234 Blue Street', 'Barcelona', NULL, 'Spain', 10000, '21.98', NULL, '21.98', NULL, 1, '2015-10-22 13:00:41'),
(23, 16, 'Tony Jehnsen', 'Silver Avenue 1234', 'New York', 'New York', 'United States', 10000, '29.98', '4.00', '25.98', 'flex050', 2, '2015-10-22 13:03:34'),
(24, 1, 'Naomi Matthews', '1234 Blue Street', 'Madrid', NULL, 'Spain', 12344, '12.99', NULL, '12.99', NULL, 1, '2015-10-29 08:31:48');

-- --------------------------------------------------------

--
-- Table structure for table `order_contents`
--

CREATE TABLE IF NOT EXISTS `order_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `price_per` decimal(6,2) unsigned NOT NULL,
  `ship_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ship_date` (`ship_date`),
  KEY `order_id` (`order_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- RELATIONS FOR TABLE `order_contents`:
--   `order_id`
--       `orders` -> `order_id`
--   `book_id`
--       `books` -> `book_id`
--

--
-- Dumping data for table `order_contents`
--

INSERT INTO `order_contents` (`id`, `order_id`, `book_id`, `quantity`, `price_per`, `ship_date`) VALUES
(16, 6, 15, 2, '11.99', NULL),
(17, 7, 7, 2, '9.99', NULL),
(18, 7, 16, 1, '7.99', NULL),
(19, 8, 1, 1, '14.99', NULL),
(20, 9, 9, 1, '9.99', NULL),
(21, 9, 12, 1, '11.99', NULL),
(22, 10, 4, 1, '11.99', NULL),
(23, 10, 10, 1, '12.99', NULL),
(24, 10, 12, 1, '11.99', NULL),
(25, 11, 14, 1, '9.99', NULL),
(26, 11, 16, 1, '7.99', NULL),
(27, 12, 5, 1, '10.99', NULL),
(28, 12, 11, 1, '8.99', NULL),
(29, 13, 1, 1, '14.99', NULL),
(30, 13, 6, 1, '14.99', NULL),
(31, 14, 15, 1, '11.99', NULL),
(32, 15, 7, 1, '9.99', NULL),
(33, 16, 2, 1, '12.99', NULL),
(34, 17, 7, 1, '9.99', NULL),
(35, 17, 8, 1, '12.99', NULL),
(36, 17, 9, 1, '9.99', NULL),
(37, 17, 11, 1, '8.99', NULL),
(38, 17, 33, 1, '9.99', NULL),
(42, 18, 44, 1, '10.99', NULL),
(43, 19, 33, 1, '9.99', NULL),
(44, 19, 44, 1, '10.99', NULL),
(45, 19, 46, 1, '11.99', NULL),
(46, 20, 7, 1, '9.99', NULL),
(47, 20, 22, 1, '14.99', NULL),
(48, 20, 33, 1, '9.99', NULL),
(49, 21, 42, 1, '10.99', NULL),
(50, 21, 44, 1, '10.99', NULL),
(51, 22, 43, 1, '9.99', NULL),
(52, 22, 46, 1, '11.99', NULL),
(53, 23, 1, 1, '14.99', NULL),
(54, 23, 22, 1, '14.99', NULL),
(55, 24, 2, 1, '12.99', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE IF NOT EXISTS `order_statuses` (
  `status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `awaiting_customer` tinyint(1) NOT NULL,
  `awaiting_staff` tinyint(1) NOT NULL,
  `complete` tinyint(1) NOT NULL,
  PRIMARY KEY (`status_id`),
  KEY `awaiting_customer` (`awaiting_customer`,`awaiting_staff`,`complete`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`status_id`, `name`, `awaiting_customer`, `awaiting_staff`, `complete`) VALUES
(1, 'Awaiting Payment', 1, 0, 0),
(2, 'Awaiting Dispatch', 0, 1, 0),
(3, 'Dispatched', 0, 0, 1),
(4, 'Cancelled', 0, 0, 1),
(5, 'Refunded', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE IF NOT EXISTS `payment_methods` (
  `method_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('online','offline') NOT NULL,
  `key` varchar(255) NOT NULL,
  PRIMARY KEY (`method_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`method_id`, `name`, `type`, `key`) VALUES
(1, 'Online with PayPal', 'online', 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE IF NOT EXISTS `publisher` (
  `publisher_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address` varchar(80) NOT NULL,
  `city` varchar(60) NOT NULL,
  `country` varchar(60) NOT NULL,
  `phone` char(15) NOT NULL,
  `description` tinytext,
  `email` varchar(60) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`publisher_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`publisher_id`, `name`, `address`, `city`, `country`, `phone`, `description`, `email`, `website`) VALUES
(1, 'Dutton(Adult Trade)', '375 Hudson Street', 'New York', 'US', '212-366-2003', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'dutton@example.com', 'www.dutton.com'),
(2, 'Fiction Std', '567 River Street', 'Chicago', 'US', '234-345-7895', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'fictionstd@example.com', 'www.fictionstd.com'),
(3, 'NavPress Publishing Group', '351 Executive Drive', 'Carol Stream', 'US', '630-784-5291', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'navpress@example.com', 'www.navpress.com'),
(4, 'Harlequin', 'P.O.Box 5190', 'Fort Erie', 'CA', '1-888-432-4879', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'harlequin@example.com', 'www.harlequin.com'),
(5, 'Pocket Books', '1230 Avenue of the Americas', 'New York', 'US', '1-564-6545-6587', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'pocket.books@example.com', 'www.pocketbooks.com'),
(6, 'William Morrow and Company', '567 Green Street', 'New York', 'US', '1-56-6987-698', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'william.m@example.com', 'www.williammorrow.com'),
(7, 'Delacorte Press', '1745 Broadway', 'New York', 'US', '212-782-9000', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'delacorte@example.com', 'www.delacortepress.com'),
(8, 'Doubleday', '1745 Broadway', 'New York', 'US', '212-940-7390', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'doubleday@example.com', 'www.knopfdoubleday.com'),
(9, 'Atria Books', '1230 Avenue of the Americas', 'New York', 'US', '212-698-7000', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'atriabooks@example.com', 'www.atriabooks.com'),
(10, 'G.P.Putnam''s Sons', '3456 Green Street', 'New York', 'US', '635-658-5541', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'putnam@example.com', 'www.putnamsons.com'),
(11, 'Algonquin Books', 'P.O.Box 2226', 'Chapel Hill', 'US', '25-698-5268', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit', 'algonquin@example.com', 'www.algonquin.com'),
(12, 'Signet Books', '4566 Green Street', 'New York', 'US', '01-987-6521', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'signet@example.com', 'www.signetbooks.com'),
(13, 'Story Plant', '250 West 57th Street, 15th floor', 'New York', 'US', '01-9874-987', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.', 'thestoryplant@thestoryplant.com.', 'www.thestoryplant.com'),
(14, 'Penguin Books', 'Green St 67', 'London', 'GB', '01-84444-987', 'Penguin Books is a British publishing house. It was founded in 1935 by Sir Allen Lane and Allen''s brothers, Richard and John, although Allen was the dominant figure in the company.', 'penguinbooks@example.com', 'www.penguin.co.uk'),
(15, 'Hodder & Stoughton', '50 Victoria Embankment', 'London', 'GB', '01-9877', 'Hodder & Stoughton is a major publisher within Hachette UK, one of the UK’s biggest publishing groups.', 'hodder@example.com', 'www.hodder.co.uk'),
(16, 'Margaret K. McElderry Books', '1230 Avenue of the Americas', 'New York', 'US', '01-987-654', 'Founded by legendary editor Margaret K. McElderry in 1972, Margaret K. McElderry Books is a boutique imprint of Simon & Schuster’s Children’s Division.', 'margaret.k@example.com', NULL),
(17, 'Disney Hyperion Books', '114 Fifth Avenue ', 'New York', 'US', '212-633-4400', 'Hyperion Books for Children published its first book in August 1991. A unique collaboration between Miramax Books and Hyperion Books for Children has also proven extremely successfu', 'hyperion.d@example.com', NULL),
(18, 'Grand Central Publishing', 'Green St 678', 'New York', 'US', '01-98744-87', 'Grand Central Publishing is a publisher of children''s books and young adult books.', 'grand.c@example.com', NULL),
(19, 'Washington Square Press', '1230 Avenue of the Americas ', 'New York', 'US', '01-6998', 'Washington Square Press publishes literary fiction and topical non-fiction in trade paperbacks', 'square.p@example.com', NULL),
(20, 'Razorbill', '345 Hudson Street ', 'New York', 'US', '212 366-2792', 'Razorbill, which launched in Fall 2004, is dedicated to publishing teen and ''tween books for "kids who love to read, hate to read, want to read, need to read."', 'razorbill@example.com', NULL),
(21, 'St. Martin''s Griffin', '175 Fifth Avenue ', 'New York', 'US', '212-674-5151', 'Founded in 1952 by Macmillan Publishers Limited of England, St. Martin''s Press is now one of the largest publishers in America.', 'st.martin@example.com', NULL),
(22, 'HarperCollins', '10 East 53rd Street', 'New York', 'US', '212-207-7000', 'Quill (HarperCollins) is a book publisher.', 'harper.c@example.com', NULL),
(23, 'Broadway Books', '1745 Broadway', 'New York', 'US', '212-782-9000', 'Broadway is a publisher of children''s books. Some of the books published by Broadway include A Short History of Nearly Everything, Clear Your Clutter With Feng Shui.', 'broadway.books@example.com', NULL),
(24, 'Baen Books', 'P.O.Box 1188', 'New York', 'US', '01-253-3654', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor i', 'info@baen.com', 'http://www.baen.com');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `format_id` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `title` char(100) NOT NULL,
  `review` text NOT NULL,
  `approved` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  KEY `fk3` (`format_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- RELATIONS FOR TABLE `reviews`:
--   `format_id`
--       `formats` -> `format_id`
--   `user_id`
--       `users` -> `user_id`
--   `book_id`
--       `books` -> `book_id`
--

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `book_id`, `format_id`, `user_id`, `title`, `review`, `approved`, `date_created`) VALUES
(1, 14, 1, 10, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2015-08-27 13:41:54'),
(2, 7, 1, 10, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 1, '2015-08-27 14:49:52'),
(3, 5, 1, 10, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 1, '2015-08-27 14:51:07'),
(4, 9, 1, 10, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2015-08-27 15:03:15'),
(6, 7, 1, 22, 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 1, '2015-08-27 20:28:34'),
(9, 1, 1, 20, 'Lorem ipsum dolor sit amet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2015-09-09 17:01:26'),
(10, 1, 1, 10, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 0, '2015-09-14 08:39:36'),
(11, 10, 1, 1, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 0, '2015-09-14 08:46:40'),
(12, 7, 1, 9, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt', 0, '2015-09-14 09:20:48'),
(13, 14, 1, 1, 'Lorem ipsum dolor sit amet', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.', 1, '2015-09-14 18:00:48'),
(14, 5, 1, 1, 'Lorem ipsum dolor sit amet', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.', 1, '2015-09-14 18:04:47'),
(15, 11, 1, 1, 'Lorem ipsum dolor sit amet', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.', 1, '2015-09-14 18:07:20'),
(16, 7, 1, 20, 'Lorem ipsum dolor sit amet', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.', 1, '2015-09-14 19:38:32'),
(17, 6, 1, 1, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 1, '2015-09-23 19:54:04'),
(18, 8, 1, 1, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 1, '2015-09-23 19:55:26'),
(19, 8, 1, 20, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', 1, '2015-09-23 19:58:55'),
(20, 15, 1, 1, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt', 0, '2015-09-23 20:30:36'),
(21, 12, 1, 20, 'Lorem ipsum dolor sit amet', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', 1, '2015-09-25 14:49:15'),
(22, 33, 1, 28, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2015-10-15 18:54:31'),
(23, 10, 1, 28, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2015-10-15 18:55:47'),
(24, 43, 1, 16, 'Lorem Ipsum', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 1, '2015-10-17 14:51:26'),
(25, 50, 1, 26, 'Lorem Ipsum', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 1, '2015-10-29 11:40:06'),
(26, 8, 1, 26, 'Lorem Ipsum', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 1, '2015-10-29 11:45:03'),
(27, 5, 1, 26, 'Lorem Ipsum', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 0, '2015-10-29 11:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `review_ratings`
--

CREATE TABLE IF NOT EXISTS `review_ratings` (
  `review_rating_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `review_id` int(10) unsigned NOT NULL,
  `helpful` tinyint(1) unsigned NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_rating_id`),
  KEY `review_id` (`review_id`),
  KEY `fk_2` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- RELATIONS FOR TABLE `review_ratings`:
--   `user_id`
--       `users` -> `user_id`
--   `review_id`
--       `reviews` -> `review_id`
--

--
-- Dumping data for table `review_ratings`
--

INSERT INTO `review_ratings` (`review_rating_id`, `user_id`, `review_id`, `helpful`, `date_entered`) VALUES
(1, 1, 2, 1, '2015-08-27 20:44:52'),
(11, 1, 6, 1, '2015-09-09 20:15:31'),
(12, 20, 2, 1, '2015-09-09 20:23:14'),
(13, 20, 1, 1, '2015-09-10 13:34:36'),
(14, 20, 6, 1, '2015-09-13 15:14:40'),
(15, 1, 1, 1, '2015-09-14 17:58:13'),
(16, 1, 14, 1, '2015-09-14 18:09:50'),
(17, 1, 3, 1, '2015-09-14 18:09:54'),
(18, 20, 15, 1, '2015-09-14 19:41:20'),
(21, 25, 1, 1, '2015-09-24 19:45:32'),
(29, 25, 2, 1, '2015-09-24 20:02:35'),
(30, 25, 6, 0, '2015-09-24 20:02:39'),
(31, 25, 13, 0, '2015-09-24 20:05:51'),
(32, 25, 19, 1, '2015-09-25 15:07:53'),
(33, 25, 16, 1, '2015-10-17 11:24:44'),
(34, 16, 24, 1, '2015-10-17 14:52:03'),
(35, 28, 2, 1, '2015-10-21 18:55:55'),
(36, 26, 25, 1, '2015-10-29 11:41:00'),
(37, 26, 3, 1, '2015-10-29 11:48:00'),
(38, 26, 14, 0, '2015-10-29 11:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `state_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `state_abbrev` char(4) DEFAULT NULL,
  `state_name` varchar(250) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `state_abbrev`, `state_name`) VALUES
(1, 'AL', 'Alabama'),
(2, 'AK', 'Alaska'),
(3, 'AB', 'Alberta'),
(4, 'AS', 'American Samoa'),
(5, 'AZ', 'Arizona'),
(6, 'AR', 'Arkansas'),
(7, 'BC', 'British Columbia'),
(8, 'CA', 'California'),
(9, 'PW', 'Caroline Islands'),
(10, 'CO', 'Colorado'),
(11, 'CT', 'Conneticut'),
(12, 'DE', 'Delaware'),
(13, 'DC', 'District Of Columbia'),
(14, 'FM', 'Federated State'),
(15, 'FL', 'Florida'),
(16, 'GA', 'Georgia'),
(17, 'GU', 'GUAM'),
(18, 'HI', 'Hawaii'),
(19, 'ID', 'Idoha'),
(20, 'IL', 'Illinois'),
(21, 'IN', 'Indiana'),
(22, 'IA', 'Iowa'),
(23, 'KS', 'Kansas'),
(24, 'KY', 'Kentucky'),
(25, 'LA', 'Louisiana'),
(26, 'ME', 'Maine'),
(27, 'MB', 'Manitoba'),
(28, 'MP', 'Mariana Islands'),
(29, 'MH', 'Marshall Islands'),
(30, 'MD', 'Maryland'),
(31, 'MA', 'Massachusetts'),
(32, 'MI', 'Michigan'),
(33, 'MN', 'Minnesota'),
(34, 'MS', 'Mississippi'),
(35, 'MO', 'Missouri'),
(36, 'MT', 'Montana'),
(37, 'NE', 'Nebraska'),
(38, 'NV', 'Nevada'),
(39, 'NB', 'New Brunswick'),
(40, 'NH', 'New Hampshire'),
(41, 'NJ', 'New Jersey'),
(42, 'NM', 'New Mexico'),
(43, 'NY', 'New York'),
(44, 'NF', 'Newfoundland'),
(45, 'NC', 'North Carolina'),
(46, 'ND', 'North Dakota'),
(47, 'NT', 'Northwest Territories'),
(48, 'NS', 'Nova Scotia'),
(49, 'NU', 'Nunavut'),
(50, 'OH', 'Ohio'),
(51, 'OK', 'Oklahoma'),
(52, 'ON', 'Ontario'),
(53, 'OR', 'Oregon'),
(54, 'PA', 'Pennsylvania'),
(55, 'PE', 'Prince Edward Island'),
(56, 'PR', 'Puerto Rico'),
(57, 'PQ', 'Quebec'),
(58, 'RI', 'Rhode Island'),
(59, 'SK', 'Saskatchewan'),
(60, 'SC', 'South Carolina'),
(61, 'SD', 'South Dakota'),
(62, 'TN', 'Tennessee'),
(63, 'TX', 'Texas'),
(64, 'UT', 'Utah'),
(65, 'VT', 'Vermont'),
(66, 'VI', 'Virgin Islands'),
(67, 'VA', 'Virginia'),
(68, 'WA', 'Washington'),
(69, 'WV', 'West Virginia'),
(70, 'WI', 'Wisconsin'),
(71, 'WY', 'Wyoming'),
(72, 'YT', 'Yukon Territory'),
(73, 'AE', 'Armed Forces - Europe'),
(74, 'AA', 'Armed Forces - Americas'),
(75, 'AP', 'Armed Forces - Pacific'),
(76, NULL, 'SELECT');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `transaction_type` varchar(18) NOT NULL,
  `amount` int(10) unsigned NOT NULL,
  `response_code` tinyint(1) unsigned NOT NULL,
  `response_reason` tinytext,
  `transaction_id` bigint(20) unsigned NOT NULL,
  `response` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- RELATIONS FOR TABLE `transactions`:
--   `order_id`
--       `orders` -> `order_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `address` varchar(80) NOT NULL,
  `city` varchar(60) NOT NULL,
  `country` varchar(60) NOT NULL,
  `state` varchar(60) DEFAULT NULL,
  `zip` mediumint(5) unsigned zerofill NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` char(60) NOT NULL,
  `user_level` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active` char(32) DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `login` (`email`,`pass`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `address`, `city`, `country`, `state`, `zip`, `email`, `pass`, `user_level`, `active`, `registration_date`) VALUES
(1, 'Naomi', 'Matthews', '5478 Green Street', 'Barcelona', 'ES', NULL, 56987, 'naomi.mat@example.com', '$2y$10$ZxXThIVwXApFSjySWP3FwuMUNvPzWIoMS.FJi2gbMrR.IIzcRdcCe', 0, NULL, '2015-05-14 19:23:48'),
(9, 'Naomi', 'Fiesta', '2345 Yellow St', 'Madrid', 'ES', NULL, 65423, 'naomi.m@example.com', '$2y$10$5UX6y6Pc7b/mZXU9pSLbt.7k3pC7C2VkR0Z0FaMYdg/toenY26gae', 0, NULL, '2015-05-14 21:17:51'),
(10, 'Nicholas', 'Wallace', 'Brown St 4567', 'New Castle', 'GB', NULL, 40000, 'nicholas.w@example.com', '$2y$10$CXomJn36SO8Mq3nMOVBtpeGUW5MbsbbRoUH3GjYluILK0aX34hkue', 0, NULL, '2015-05-15 15:10:32'),
(16, 'Tony', 'Jehnsen', '1641 College Sr', 'New York', 'US', 'NY', 10000, 'tony.j@example.com', '$2y$10$M6U1t/uw1A4VsCtNTAvJJeiS4sNF3A/otd8SEJHbZDAxz4faheEAa', 0, NULL, '2015-05-12 21:24:54'),
(20, 'Alex', 'Morris', 'Hover St. 786', 'New York', 'US', 'NY', 10000, 'alex.m@example.com', '$2y$10$QyeOXjPZRDEbCsNP5Mlx2eGOaHntqiRsO/S0jxDbwBON/zETI5iRm', 0, NULL, '2015-06-23 18:08:55'),
(22, 'Logan', 'Lane', '567 Yellow St.', 'London', 'GB', NULL, 54789, 'logan.l@example.com', '$2y$10$F1dz6OLZzA4oiAApSF6RPuEV3j1gHiaOyhELlxW7EoFodQ8VjU06y', 0, NULL, '2015-06-23 18:31:49'),
(23, 'Kirk', 'Johnston', '1955 College St', 'Washington', 'US', 'DC', 12587, 'kirk.j@example.com', '$2y$10$bjFo0voGL7Wzwy3yy1lbguf77ia9fYHLMshrX0Ush/2nIk09.NDNm', 0, 'feaa6b6eab76dd911be1966eb30287bc', '2015-09-21 16:48:50'),
(24, 'Lori', 'Edwards', '3489 China Ave', 'Sydney', 'AU', NULL, 12587, 'lori.e@example.com', '$2y$10$MD8JEQMld0vMJySM9LXY5ekuJXpFPwMbR/rgh5xp2E1chRR5ceCwy', 0, 'ea0e938015c8433849464d2b924442ff', '2015-09-21 17:26:06'),
(25, 'Annie', 'Fleming', '567 Blue Street', 'Austin', 'US', 'TX', 10145, 'annie.f@example.com', '$2y$10$R6gyJFgPn/wwbutsrwAb9OXV10z7K/SegWX85D9wmLFX3NyP0TwgG', 0, NULL, '2015-09-22 23:55:18'),
(26, 'Roger', 'Hunt', '4251 Rudder Rd', 'Austin', 'US', 'TX', 52698, 'roger.h@example.com', '$2y$10$.glAFNcVQ1KxM7apTqtnDu7bdnzKwTEsxrWlWz6/KJHsaPyojSDku', 1, NULL, '2015-09-23 10:44:53'),
(28, 'Peggy', 'Gardner', '1234 Blue Street', 'New Castle', 'GB', NULL, 10000, 'peggy.g@example.com', '$2y$10$8ocOwIEHVrc1tqIR/RLDGOeqgpBwXx/Bt/OD0GXnk1Qlsgaa54Zo2', 0, NULL, '2015-10-15 20:42:37'),
(29, 'Sebastian', 'Woods', '8111 View Street', 'Miami', 'US', 'FL', 10000, 'sebastian.w@example.com', '$2y$10$NLwPfLfdF2HlNjDq1SfgcOD6DNNfskAtpA6W1l8s1vC4Ov14ydqWW', 0, NULL, '2015-10-15 20:45:48');

-- --------------------------------------------------------

--
-- Table structure for table `wish_lists`
--

CREATE TABLE IF NOT EXISTS `wish_lists` (
  `wish_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `book_id` int(10) unsigned NOT NULL,
  `quantity` tinyint(3) unsigned NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`wish_id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- RELATIONS FOR TABLE `wish_lists`:
--   `user_id`
--       `users` -> `user_id`
--   `book_id`
--       `books` -> `book_id`
--

--
-- Dumping data for table `wish_lists`
--

INSERT INTO `wish_lists` (`wish_id`, `user_id`, `book_id`, `quantity`, `date_created`, `date_modified`) VALUES
(1, 20, 11, 1, '2015-09-15 17:17:07', '0000-00-00 00:00:00'),
(2, 20, 7, 1, '2015-09-18 15:31:55', '0000-00-00 00:00:00'),
(7, 28, 10, 1, '2015-10-15 18:55:33', '0000-00-00 00:00:00'),
(9, 26, 2, 1, '2015-10-29 11:39:33', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `authors_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`);

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`publisher_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_05` FOREIGN KEY (`format_id`) REFERENCES `formats` (`format_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `book_authors`
--
ALTER TABLE `book_authors`
  ADD CONSTRAINT `ba_fk1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ba_fk2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_category`
--
ALTER TABLE `book_category`
  ADD CONSTRAINT `book_category_fk1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `book_category_fk2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_formats`
--
ALTER TABLE `book_formats`
  ADD CONSTRAINT `bf_fk1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bf_fk2` FOREIGN KEY (`format_id`) REFERENCES `formats` (`format_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `book_ratings`
--
ALTER TABLE `book_ratings`
  ADD CONSTRAINT `Fk1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `Fk2` FOREIGN KEY (`order_status`) REFERENCES `order_statuses` (`status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `order_contents`
--
ALTER TABLE `order_contents`
  ADD CONSTRAINT `order_contents_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `order_contents_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk3` FOREIGN KEY (`format_id`) REFERENCES `formats` (`format_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `review_ratings`
--
ALTER TABLE `review_ratings`
  ADD CONSTRAINT `fk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_ratings_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`review_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `wish_lists`
--
ALTER TABLE `wish_lists`
  ADD CONSTRAINT `wish_lists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `wish_lists_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `deleteOldCarts` ON SCHEDULE EVERY '1 0' DAY_HOUR STARTS '2015-09-14 19:53:31' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM `carts` WHERE `date_created` < DATE_SUB(NOW(), INTERVAL 14 DAY)$$

CREATE DEFINER=`root`@`localhost` EVENT `deleteNotApprovedReviews` ON SCHEDULE EVERY 1 DAY STARTS '2015-10-29 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO DELETE FROM `reviews` WHERE `date_created` < DATE_SUB(NOW(), INTERVAL 14 DAY) AND `approved` = 0$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

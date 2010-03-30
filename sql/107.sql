CREATE DATABASE `categorizer`;
USE `categorizer`
CREATE TABLE `knowledge_base` (
`ngram` varchar( 10 ) NOT NULL ,
`belongs` varchar( 10 ) NOT NULL ,
`repite` int( 11 ) NOT NULL ,
`percent` float NOT NULL ,
PRIMARY KEY ( `ngram` , `belongs` ) ,
KEY `repite` ( `repite` )
) ENGINE = InnoDB;
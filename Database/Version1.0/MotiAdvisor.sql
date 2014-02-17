drop database if exists MotiAdviser;
create database MotiAdviser;

use MotiAdviser;

DROP TABLE IF EXISTS Major;
CREATE TABLE Major
(
 `MID` int(4) NOT NULL auto_increment,
  `Major` char(30) default NULL,
  `Track` char(30) default NULL,
   PRIMARY KEY (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS User;
CREATE TABLE User 
( 
  `ID` int(5) NOT NULL auto_increment,
  `Email` char(30) NOT NULL,
  `PassWord` char(20) NOT NULL,
  `SQ` char(30) NOT NULL,
  `SA` char(30) NOT NULL,
  `MID` int(4) default NULL,
  PRIMARY KEY  (`ID`),
  KEY `MID` (`MID`),
  CONSTRAINT `User_FK1_MID` FOREIGN KEY (`MID`) REFERENCES `Major` (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Class;
CREATE TABLE Class 
(
  `CID` int(5) NOT NULL auto_increment,
  `CName` char(7) NOT NULL,
  `Description` char(200) NOT NULL,
   PRIMARY KEY  (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS ChosenClass;
CREATE TABLE ChosenClass
(
  `ID` int(5) NOT NULL ,
  `CID` int(5) NOT NULL,
  KEY `ID` (`ID`),
  KEY `CID` (`CID`),
  CONSTRAINT `CC_FK1_ID` FOREIGN KEY (`ID`) REFERENCES `User` (`ID`),
  CONSTRAINT `CC_FK1_CID` FOREIGN KEY (`CID`) REFERENCES `Class` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS DependentClass;
CREATE TABLE DependentClass
(
  `CID1` int(5) NOT NULL,
  `CID2` int(5) NOT NULL,
  KEY `CID1` (`CID1`),
  KEY `CID2` (`CID2`),
  CONSTRAINT `DC_FK1_CID1` FOREIGN KEY (`CID1`) REFERENCES `Class` (`CID`),
  CONSTRAINT `DC_FK1_CID2` FOREIGN KEY (`CID2`) REFERENCES `Class` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




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
  `Name` char(20) NOT NULL,
  `MID` int(4) default NULL,
  PRIMARY KEY  (`ID`,`Email`),
  KEY `MID` (`MID`),
  CONSTRAINT `User_FK1_MID` FOREIGN KEY (`MID`) REFERENCES `Major` (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS RequireType;
CREATE TABLE RequireType 
( 
  `RTID` int(5) NOT NULL auto_increment,
  `TypeName` char(30) NOT NULL,
  `TotalCridit` int(3) NOT NULL,
  PRIMARY KEY  (`RTID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS GraduateRule;
CREATE TABLE GraduateRule 
( 
  `MID` int(4) NOT NULL,
  `RTID` int(5) NOT NULL,
  KEY `MID` (`MID`),
  KEY `RTID` (`RTID`),
  CONSTRAINT `GR_FK1_MID` FOREIGN KEY (`MID`) REFERENCES `Major` (`MID`),
  CONSTRAINT `GR_FK1_RTID` FOREIGN KEY (`RTID`) REFERENCES `RequireType` (`RTID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS GroupsOfType;
CREATE TABLE GroupsOfType 
( 
  `GID` int(5) NOT NULL auto_increment,
  `RTID` int(5) NOT NULL,
  `GroupAlternetive` char(1) NOT NULL,
  PRIMARY KEY  (`GID`),
  KEY `RTID` (`RTID`),
  CONSTRAINT `GOT_FK1_CID1` FOREIGN KEY (`RTID`) REFERENCES `RequireType` (`RTID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Class;
CREATE TABLE Class 
(
  `CID` int(5) NOT NULL auto_increment,
  `CName` char(60) NOT NULL,
  `Description` char(200) NOT NULL,
  `Credit` int(1) NOT NULL,
  `EvaluationRate` float,
  `EvaluationNumber` int(4),
  PRIMARY KEY  (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ClassesOfGroup;
CREATE TABLE ClassesOfGroup 
( 
  `GID` int(5) NOT NULL,
  `CID` int(5) NOT NULL,
  `ClassAlternetive` char(1) NOT NULL,
  `Grade` char(1) NOT NULL,
  KEY `GID` (`GID`),
  KEY `CID` (`CID`),
  CONSTRAINT `COG_FK1_GID` FOREIGN KEY (`GID`) REFERENCES `GroupsOfType` (`GID`),
  CONSTRAINT `COG_FK2_CID` FOREIGN KEY (`CID`) REFERENCES `Class` (`CID`)
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
  `DCAlternetive` char(1) NOT NULL,
  KEY `CID1` (`CID1`),
  KEY `CID2` (`CID2`),
  CONSTRAINT `DC_FK1_CID1` FOREIGN KEY (`CID1`) REFERENCES `Class` (`CID`),
  CONSTRAINT `DC_FK2_CID2` FOREIGN KEY (`CID2`) REFERENCES `Class` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Term;
CREATE TABLE Term
(
  `TID` int(5) NOT NULL auto_increment,
  `TermName` char(60) NOT NULL,
  Primary KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ScheduleClass;
CREATE TABLE ScheduleClass
(
  `TID` int(5) NOT NULL,
  `CID` int(5) NOT NULL,
  KEY `TID` (`TID`),
  KEY `CID` (`CID`),
  CONSTRAINT `SC_FK1_TID` FOREIGN KEY (`TID`) REFERENCES `Term` (`TID`),
  CONSTRAINT `SC_FK2_CID` FOREIGN KEY (`CID`) REFERENCES `Class` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





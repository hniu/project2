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
  `MID` int(4) default 6,
  PRIMARY KEY  (`ID`,`Email`),
  KEY `MID` (`MID`),
  CONSTRAINT `User_FK1_MID` FOREIGN KEY (`MID`) REFERENCES `Major` (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS RequireType;
CREATE TABLE RequireType 
( 
  `RTID` int(5) NOT NULL auto_increment,
  `TypeName` char(30) NOT NULL,
  `TotalCredit` int(3) NOT NULL,
  PRIMARY KEY  (`RTID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS GraduateRule;
CREATE TABLE GraduateRule 
( 
  `MID` int(4) NOT NULL,
  `RTID` int(5) NOT NULL,
  PRIMARY KEY  (`MID`,`RTID`),
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
  `Graded` char(1) NOT NULL,
  PRIMARY KEY  (`GID`),
  KEY `RTID` (`RTID`),
  CONSTRAINT `GOT_FK1_CID1` FOREIGN KEY (`RTID`) REFERENCES `RequireType` (`RTID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Class;
CREATE TABLE Class 
(
  `CID` int(5) NOT NULL auto_increment,
  `CName` char(80) NOT NULL,
  `Description` text NOT NULL,
  `Credit` int(1) NOT NULL,
  `EvaluationRate` float,
  `EvaluationNumber` int(4),
  PRIMARY KEY  (`CID`,`CName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ClassesOfGroup;
CREATE TABLE ClassesOfGroup 
( 
  `GID` int(5) NOT NULL,
  `CID` int(5) NOT NULL,
  `ClassAlternetive` char(1) NOT NULL,
  PRIMARY KEY  (`GID`,`CID`),
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
  PRIMARY KEY  (`ID`,`CID`),
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
  PRIMARY KEY  (`CID1`,`CID2`),
  KEY `CID1` (`CID1`),
  KEY `CID2` (`CID2`),
  CONSTRAINT `DC_FK1_CID1` FOREIGN KEY (`CID1`) REFERENCES `Class` (`CID`),
  CONSTRAINT `DC_FK2_CID2` FOREIGN KEY (`CID2`) REFERENCES `Class` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS Term;
CREATE TABLE Term
(
  `TID` int(5) NOT NULL auto_increment,
  `TermName` char(20) NOT NULL,
  Primary KEY `TID` (`TID`,`TermName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ScheduleClass;
CREATE TABLE ScheduleClass
(
  `TID` int(5) NOT NULL,
  `CID` int(5) NOT NULL,
  PRIMARY KEY  (`TID`,`CID`),
  KEY `TID` (`TID`),
  KEY `CID` (`CID`),
  CONSTRAINT `SC_FK1_TID` FOREIGN KEY (`TID`) REFERENCES `Term` (`TID`),
  CONSTRAINT `SC_FK2_CID` FOREIGN KEY (`CID`) REFERENCES `Class` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS ClassComment;
CREATE TABLE ClassComment
(
  `CID` int(5) NOT NULL,
  `ID` int(5) NOT NULL,
  `Comment` text,
  `Time` datetime default now(),
  PRIMARY KEY  (`CID`,`ID`),
  KEY `CID` (`CID`),
  KEY `ID` (`ID`),
  CONSTRAINT `CC_FK1_TID` FOREIGN KEY (`CID`) REFERENCES `Class` (`CID`),
  CONSTRAINT `CC_FK2_CID` FOREIGN KEY (`ID`) REFERENCES `User` (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



Create view TrackClasses as 
select m.MID , rt.TypeName, rt.TotalCredit, gt.GID, gt.GroupAlternetive, gt.Graded, cg.ClassAlternetive, c.CID, c.CName, c.Credit from Major as m
left join GraduateRule as gr on m.MID=gr.MID
left join RequireType as rt on gr.RTID=rt.RTID
left join GroupsOfType as gt on rt.RTID=gt.RTID
left join ClassesOfGroup as cg on gt.GID=cg.GID
left join Class as c on cg.CID=c.CID;




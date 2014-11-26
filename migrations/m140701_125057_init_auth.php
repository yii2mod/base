<?php

use yii\db\Schema;

class m140701_125057_init_auth extends \yii\db\Migration
{
    public function up()
    {
        $this->execute("
     -- --------------------------------------------------------
-- Host:                         rabbit.zfort.net
-- Server version:               5.5.29-log - MySQL Community Server (GPL)
-- Server OS:                    Linux
-- HeidiSQL Version:             8.3.0.4780
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table semenov_dental.AuthAssignment
CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemName` varchar(64) NOT NULL,
  `userId` varchar(64) NOT NULL,
  `dateCreated` int(11) DEFAULT NULL,
  PRIMARY KEY (`itemName`,`userId`),
  CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemName`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table semenov_dental.AuthItem
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `ruleName` varchar(64) DEFAULT NULL,
  `data` text,
  `dateCreated` int(11) DEFAULT NULL,
  `dateUpdated` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`ruleName`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `AuthItem_ibfk_1` FOREIGN KEY (`ruleName`) REFERENCES `AuthRule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table semenov_dental.AuthItemChild
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table semenov_dental.AuthRule
CREATE TABLE IF NOT EXISTS `AuthRule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `dateCreated` int(11) DEFAULT NULL,
  `dateUpdated` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

        ");

    }

    public function down()
    {
     $this->dropTable('AuthAssignment');
     $this->dropTable('AuthItem');
     $this->dropTable('AuthItemChild');
     $this->dropTable('AuthRule');
     return false;
    }
}

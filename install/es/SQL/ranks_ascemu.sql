/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : fusion

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2012-07-30 19:07:26
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `ranks`
-- ----------------------------
DROP TABLE IF EXISTS `ranks`;
CREATE TABLE `ranks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rank_name` varchar(50) DEFAULT 'RANK',
  `access_id` varchar(10) DEFAULT '0',
  `is_gm` int(1) DEFAULT '0',
  `is_dev` int(1) DEFAULT '0',
  `is_admin` int(1) DEFAULT '0',
  `is_owner` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ranks
-- ----------------------------
INSERT INTO `ranks` VALUES ('1', 'Invitado', '-1', '0', '0', '0', '0');
INSERT INTO `ranks` VALUES ('2', 'Jugador', '0', '0', '0', '0', '0');
INSERT INTO `ranks` VALUES ('3', 'Maestro de Juego', '1', '1', '0', '0', '0');
INSERT INTO `ranks` VALUES ('4', 'Maestro de Juego Jefe', '2', '1', '1', '0', '0');
INSERT INTO `ranks` VALUES ('5', 'Desarrollador', '3', '1', '1', '0', '0');
INSERT INTO `ranks` VALUES ('6', 'Administrador', 'a', '1', '1', '1', '0');
INSERT INTO `ranks` VALUES ('7', 'Dios', 'az', '1', '1', '1', '1');

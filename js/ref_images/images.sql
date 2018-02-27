/*
Navicat MySQL Data Transfer

Source Server         : AnandaMahdar
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : db_atsb_demo_atis_v2

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2017-10-20 13:35:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for images
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(20) DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `tanggal_upload` date DEFAULT NULL,
  `directory` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES ('1', 'nice', '1', 'ananda', '2017-10-19', 'images/Pixiv/nice.jpg');
INSERT INTO `images` VALUES ('3', 'cool', '1', 'ananda', '2017-10-19', null);

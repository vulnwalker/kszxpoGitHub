/*
Navicat MySQL Data Transfer

Source Server         : AnandaMahdar
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : db_atsb_demo_atis_v2

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2017-10-20 13:35:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for images_kategori
-- ----------------------------
DROP TABLE IF EXISTS `images_kategori`;
CREATE TABLE `images_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of images_kategori
-- ----------------------------
INSERT INTO `images_kategori` VALUES ('1', 'Pixiv');
INSERT INTO `images_kategori` VALUES ('2', 'Google');
INSERT INTO `images_kategori` VALUES ('3', 'Free');
INSERT INTO `images_kategori` VALUES ('4', 'beas');
INSERT INTO `images_kategori` VALUES ('5', 'test');
INSERT INTO `images_kategori` VALUES ('6', 'taufan');

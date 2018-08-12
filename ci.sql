/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : ci

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-08-12 12:58:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_job
-- ----------------------------
DROP TABLE IF EXISTS `admin_job`;
CREATE TABLE `admin_job` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(24) DEFAULT NULL,
  `explain` varchar(120) DEFAULT NULL,
  `valid` int(1) NOT NULL DEFAULT '1',
  `insert_at` int(11) DEFAULT NULL,
  `update_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_job
-- ----------------------------
INSERT INTO `admin_job` VALUES ('5', '超级管理员', '111', '1', '1533997317', '1533997378');
INSERT INTO `admin_job` VALUES ('6', '管理员', '卢卡斯觉得', '1', '1533997414', '1533997414');

-- ----------------------------
-- Table structure for admin_job_auth
-- ----------------------------
DROP TABLE IF EXISTS `admin_job_auth`;
CREATE TABLE `admin_job_auth` (
  `admin_job_id` int(8) NOT NULL,
  `func_key` varchar(24) NOT NULL,
  `auth_key` varchar(24) NOT NULL,
  PRIMARY KEY (`admin_job_id`,`func_key`,`auth_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_job_auth
-- ----------------------------
INSERT INTO `admin_job_auth` VALUES ('5', 'admin', 'export');
INSERT INTO `admin_job_auth` VALUES ('5', 'article', 'add');
INSERT INTO `admin_job_auth` VALUES ('5', 'article', 'delete');
INSERT INTO `admin_job_auth` VALUES ('5', 'article', 'edit');
INSERT INTO `admin_job_auth` VALUES ('5', 'article', 'export');
INSERT INTO `admin_job_auth` VALUES ('5', 'front', 'export');
INSERT INTO `admin_job_auth` VALUES ('5', 'func', 'add');
INSERT INTO `admin_job_auth` VALUES ('5', 'func', 'delete');
INSERT INTO `admin_job_auth` VALUES ('5', 'func', 'edit');
INSERT INTO `admin_job_auth` VALUES ('5', 'func', 'export');
INSERT INTO `admin_job_auth` VALUES ('5', 'job', 'add');
INSERT INTO `admin_job_auth` VALUES ('5', 'job', 'delete');
INSERT INTO `admin_job_auth` VALUES ('5', 'job', 'edit');
INSERT INTO `admin_job_auth` VALUES ('5', 'job', 'export');
INSERT INTO `admin_job_auth` VALUES ('5', 'menu', 'add');
INSERT INTO `admin_job_auth` VALUES ('5', 'menu', 'delete');
INSERT INTO `admin_job_auth` VALUES ('5', 'menu', 'edit');
INSERT INTO `admin_job_auth` VALUES ('5', 'menu', 'export');
INSERT INTO `admin_job_auth` VALUES ('5', 'slide', 'add');
INSERT INTO `admin_job_auth` VALUES ('5', 'slide', 'delete');
INSERT INTO `admin_job_auth` VALUES ('5', 'slide', 'edit');
INSERT INTO `admin_job_auth` VALUES ('5', 'slide', 'export');
INSERT INTO `admin_job_auth` VALUES ('5', 'staff', 'add');
INSERT INTO `admin_job_auth` VALUES ('5', 'staff', 'delete');
INSERT INTO `admin_job_auth` VALUES ('5', 'staff', 'edit');
INSERT INTO `admin_job_auth` VALUES ('5', 'staff', 'export');
INSERT INTO `admin_job_auth` VALUES ('6', 'admin', 'export');
INSERT INTO `admin_job_auth` VALUES ('6', 'article', 'add');
INSERT INTO `admin_job_auth` VALUES ('6', 'article', 'delete');
INSERT INTO `admin_job_auth` VALUES ('6', 'article', 'edit');
INSERT INTO `admin_job_auth` VALUES ('6', 'article', 'export');
INSERT INTO `admin_job_auth` VALUES ('6', 'front', 'export');
INSERT INTO `admin_job_auth` VALUES ('6', 'func', 'add');
INSERT INTO `admin_job_auth` VALUES ('6', 'func', 'delete');
INSERT INTO `admin_job_auth` VALUES ('6', 'func', 'edit');
INSERT INTO `admin_job_auth` VALUES ('6', 'func', 'export');
INSERT INTO `admin_job_auth` VALUES ('6', 'job', 'edit');
INSERT INTO `admin_job_auth` VALUES ('6', 'job', 'export');
INSERT INTO `admin_job_auth` VALUES ('6', 'slide', 'add');
INSERT INTO `admin_job_auth` VALUES ('6', 'slide', 'export');

-- ----------------------------
-- Table structure for background_func
-- ----------------------------
DROP TABLE IF EXISTS `background_func`;
CREATE TABLE `background_func` (
  `key` varchar(24) NOT NULL,
  `func_name` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of background_func
-- ----------------------------
INSERT INTO `background_func` VALUES ('admin', '后台管理');
INSERT INTO `background_func` VALUES ('article', '文章管理');
INSERT INTO `background_func` VALUES ('front', '前端管理');
INSERT INTO `background_func` VALUES ('func', '功能管理');
INSERT INTO `background_func` VALUES ('job', '职位管理');
INSERT INTO `background_func` VALUES ('menu', '菜单管理');
INSERT INTO `background_func` VALUES ('slide', '幻灯片管理');
INSERT INTO `background_func` VALUES ('staff', '管理员管理');

-- ----------------------------
-- Table structure for func_auth
-- ----------------------------
DROP TABLE IF EXISTS `func_auth`;
CREATE TABLE `func_auth` (
  `func_key` varchar(24) NOT NULL,
  `key` varchar(24) NOT NULL,
  `auth_name` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`func_key`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of func_auth
-- ----------------------------
INSERT INTO `func_auth` VALUES ('article', 'add', '添加');
INSERT INTO `func_auth` VALUES ('article', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('article', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('func', 'add', '添加');
INSERT INTO `func_auth` VALUES ('func', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('func', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('job', 'add', '添加');
INSERT INTO `func_auth` VALUES ('job', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('job', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('menu', 'add', '添加');
INSERT INTO `func_auth` VALUES ('menu', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('menu', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('slide', 'add', '添加');
INSERT INTO `func_auth` VALUES ('slide', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('slide', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('staff', 'add', '添加');
INSERT INTO `func_auth` VALUES ('staff', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('staff', 'edit', '编辑');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `named` varchar(36) DEFAULT NULL,
  `icon` varchar(120) DEFAULT NULL,
  `url` varchar(120) DEFAULT NULL,
  `sort` int(3) DEFAULT '100',
  `level` int(2) DEFAULT '1',
  `parent` int(11) DEFAULT '0',
  `screen_auth` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('2', '后台管理', '', '', '100', '0', '0', '{\"admin\":[\"export\"]}');
INSERT INTO `menu` VALUES ('3', '功能管理', '', 'admin/func/index', '100', '1', '2', '{\"func\":[\"export\"]}');
INSERT INTO `menu` VALUES ('4', '职位管理', '', 'admin/job/index', '100', '1', '2', '{\"job\":[\"export\"]}');
INSERT INTO `menu` VALUES ('5', '管理员管理', '', 'admin/staff/index', '100', '1', '2', '{\"staff\":[\"export\"]}');
INSERT INTO `menu` VALUES ('6', '菜单管理', '', 'admin/menu/index', '100', '1', '2', '{\"menu\":[\"export\"]}');
INSERT INTO `menu` VALUES ('7', '前端管理', '', '', '100', '0', '0', '{\"front\":[\"export\"]}');
INSERT INTO `menu` VALUES ('8', '文章管理', '', 'admin/article/index', '100', '1', '7', '{\"article\":[\"export\"]}');
INSERT INTO `menu` VALUES ('9', '幻灯片管理', '', 'admin/slide/index', '100', '1', '7', '{\"slide\":[\"export\"]}');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(24) NOT NULL,
  `true_name` varchar(24) DEFAULT NULL,
  `header_img` varchar(120) DEFAULT NULL,
  `staff_num` varchar(16) DEFAULT NULL,
  `pwd` varchar(64) NOT NULL,
  `job` varchar(128) DEFAULT NULL,
  `insert_at` int(11) DEFAULT NULL,
  `update_at` int(11) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('1', 'admin', 'wx', '/resources/upload/427444797154772635.jpg', '001', 'e10adc3949ba59abbe56e057f20f883e', '[\"5\"]', '1527720245', '1533985762', '1');
INSERT INTO `staff` VALUES ('27', 'xiong', 'wxlk', '/resources/upload/1898-1062.jpg', '002', 'e10adc3949ba59abbe56e057f20f883e', '[\"6\"]', '1534003125', '1534003125', '1');

-- ----------------------------
-- Table structure for staff_job
-- ----------------------------
DROP TABLE IF EXISTS `staff_job`;
CREATE TABLE `staff_job` (
  `staff_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_id`,`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of staff_job
-- ----------------------------
INSERT INTO `staff_job` VALUES ('1', '5');
INSERT INTO `staff_job` VALUES ('27', '6');

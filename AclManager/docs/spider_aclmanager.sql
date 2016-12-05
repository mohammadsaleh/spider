/*
Navicat MySQL Data Transfer

Source Server         : Haghparast
Source Server Version : 50544
Source Host           : 192.168.1.85:3306
Source Database       : b2b

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-12-05 20:42:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for spider_aclmanager_acos
-- ----------------------------
DROP TABLE IF EXISTS `spider_aclmanager_acos`;
CREATE TABLE `spider_aclmanager_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=448 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spider_aclmanager_acos
-- ----------------------------
INSERT INTO `spider_aclmanager_acos` VALUES ('202', 'add_package', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('203', 'list_packages', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('369', 'Pages/display/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('370', 'plugin/Settings/Admin/Settings/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('371', 'plugin/Settings/Admin/Settings/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('372', 'plugin/Settings/Admin/Settings/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('373', 'plugin/Settings/Admin/Settings/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('374', 'plugin/Settings/Admin/Settings/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('375', 'plugin/AclManager/Admin/Permissions/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('376', 'plugin/AclManager/Admin/Permissions/sync/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('377', 'plugin/AclManager/Admin/Permissions/acoList/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('378', 'plugin/AclManager/Admin/Roles/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('379', 'plugin/AclManager/Admin/Roles/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('380', 'plugin/AclManager/Admin/Roles/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('381', 'plugin/AclManager/Admin/Roles/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('382', 'plugin/AclManager/Admin/Roles/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('383', 'plugin/PluginManager/Admin/Plugins/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('384', 'plugin/PluginManager/Admin/Plugins/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('385', 'plugin/PluginManager/Admin/Plugins/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('386', 'plugin/PluginManager/Admin/Plugins/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('387', 'plugin/PluginManager/Admin/Plugins/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('388', 'plugin/Users/Users/login/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('389', 'plugin/Users/Users/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('390', 'plugin/Users/Users/active/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('391', 'plugin/Users/Users/editPassword/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('392', 'plugin/Users/Users/checkEmail/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('393', 'plugin/Users/Users/forgetPass/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('394', 'plugin/Users/Users/logout/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('395', 'plugin/Users/Users/uploadAvatar/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('396', 'plugin/Users/Admin/Users/login/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('397', 'plugin/Users/Admin/Users/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('398', 'plugin/Users/Admin/Users/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('399', 'plugin/Users/Admin/Users/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('400', 'plugin/Users/Admin/Users/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('401', 'plugin/Users/Admin/Users/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('402', 'plugin/Solr/Solr/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('403', 'plugin/Captcha/Captcha/create/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('404', 'plugin/Audit/Admin/Audits/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('405', 'plugin/Audit/Admin/ExcludeLogs/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('406', 'plugin/Audit/Admin/ExcludeLogs/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('407', 'plugin/Audit/Admin/ExcludeLogs/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('408', 'plugin/Audit/Admin/ExcludeLogs/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('409', 'plugin/Bird/Admin/Roles/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('410', 'plugin/Bird/Admin/Roles/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('411', 'plugin/Bird/Admin/Roles/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('412', 'plugin/Bird/Admin/Roles/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('413', 'plugin/Bird/Admin/Roles/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('414', 'plugin/Messages/Messages/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('415', 'plugin/Messages/Messages/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('416', 'plugin/Messages/Messages/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('417', 'plugin/Messages/Messages/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('418', 'plugin/Messages/Admin/Messages/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('419', 'plugin/Messages/Admin/Messages/inbox/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('420', 'plugin/Messages/Admin/Messages/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('421', 'plugin/Messages/Admin/Messages/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('422', 'plugin/Messages/Admin/Messages/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('423', 'plugin/Messages/Admin/Messages/delete/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('424', 'plugin/B2b/B2b/registeredPanel/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('425', 'plugin/B2b/B2b/home/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('426', 'plugin/B2b/B2b/search/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('427', 'plugin/B2b/B2b/searchHotel/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('428', 'plugin/B2b/B2b/rule/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('429', 'plugin/B2b/B2b/registerRequest/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('430', 'plugin/B2b/B2b/hotelLink/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('431', 'plugin/B2b/B2b/getHotels/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('432', 'plugin/B2b/B2b/panelAddPackage/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('433', 'plugin/B2b/B2b/panelListPackage/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('434', 'plugin/B2b/B2b/panelDeletePackage/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('435', 'plugin/B2b/B2b/_applyAgencyCommission/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('436', 'plugin/B2b/Jobs/deleteOldTours/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('437', 'plugin/B2b/Jobs/hotelNameMaps/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('438', 'plugin/B2b/Jobs/hotelNameMapsRemoveExtra/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('439', 'plugin/B2b/Jobs/hotelNameSimilarity/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('440', 'plugin/B2b/Settings/uploadAgencyAvatar/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('441', 'plugin/B2b/Settings/profile/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('442', 'plugin/B2b/XmlOut/init/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('443', 'plugin/B2b/Admin/Agencies/index/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('444', 'plugin/B2b/Admin/Agencies/view/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('445', 'plugin/B2b/Admin/Agencies/add/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('446', 'plugin/B2b/Admin/Agencies/edit/', null, null, null, null);
INSERT INTO `spider_aclmanager_acos` VALUES ('447', 'plugin/B2b/Admin/Agencies/delete/', null, null, null, null);

-- ----------------------------
-- Table structure for spider_aclmanager_aros
-- ----------------------------
DROP TABLE IF EXISTS `spider_aclmanager_aros`;
CREATE TABLE `spider_aclmanager_aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spider_aclmanager_aros
-- ----------------------------
INSERT INTO `spider_aclmanager_aros` VALUES ('13', 'roles', '2');
INSERT INTO `spider_aclmanager_aros` VALUES ('14', 'roles', '3');
INSERT INTO `spider_aclmanager_aros` VALUES ('15', 'roles', '4');
INSERT INTO `spider_aclmanager_aros` VALUES ('16', 'roles', '5');
INSERT INTO `spider_aclmanager_aros` VALUES ('17', 'roles', '6');
INSERT INTO `spider_aclmanager_aros` VALUES ('18', 'users', '1');
INSERT INTO `spider_aclmanager_aros` VALUES ('19', 'users', '2');
INSERT INTO `spider_aclmanager_aros` VALUES ('20', 'users', '4');
INSERT INTO `spider_aclmanager_aros` VALUES ('21', 'users', '5');
INSERT INTO `spider_aclmanager_aros` VALUES ('22', 'roles', '1');
INSERT INTO `spider_aclmanager_aros` VALUES ('23', 'users', '3');
INSERT INTO `spider_aclmanager_aros` VALUES ('24', 'users', '6');
INSERT INTO `spider_aclmanager_aros` VALUES ('26', 'users', '8');
INSERT INTO `spider_aclmanager_aros` VALUES ('27', 'users', '9');
INSERT INTO `spider_aclmanager_aros` VALUES ('28', 'users', '10');
INSERT INTO `spider_aclmanager_aros` VALUES ('29', 'users', '11');
INSERT INTO `spider_aclmanager_aros` VALUES ('30', 'users', '12');
INSERT INTO `spider_aclmanager_aros` VALUES ('31', 'users', '13');
INSERT INTO `spider_aclmanager_aros` VALUES ('32', 'users', '14');
INSERT INTO `spider_aclmanager_aros` VALUES ('33', 'users', '15');
INSERT INTO `spider_aclmanager_aros` VALUES ('34', 'users', '16');
INSERT INTO `spider_aclmanager_aros` VALUES ('35', 'users', '17');
INSERT INTO `spider_aclmanager_aros` VALUES ('36', 'users', '18');
INSERT INTO `spider_aclmanager_aros` VALUES ('37', 'users', '19');
INSERT INTO `spider_aclmanager_aros` VALUES ('38', 'users', '20');
INSERT INTO `spider_aclmanager_aros` VALUES ('39', 'users', '21');
INSERT INTO `spider_aclmanager_aros` VALUES ('40', 'users', '22');
INSERT INTO `spider_aclmanager_aros` VALUES ('41', 'users', '23');
INSERT INTO `spider_aclmanager_aros` VALUES ('42', 'users', '24');
INSERT INTO `spider_aclmanager_aros` VALUES ('43', 'users', '25');
INSERT INTO `spider_aclmanager_aros` VALUES ('44', 'users', '26');
INSERT INTO `spider_aclmanager_aros` VALUES ('45', 'users', '27');
INSERT INTO `spider_aclmanager_aros` VALUES ('46', 'users', '28');
INSERT INTO `spider_aclmanager_aros` VALUES ('47', 'users', '29');
INSERT INTO `spider_aclmanager_aros` VALUES ('48', 'users', '30');
INSERT INTO `spider_aclmanager_aros` VALUES ('49', 'users', '31');
INSERT INTO `spider_aclmanager_aros` VALUES ('50', 'users', '32');
INSERT INTO `spider_aclmanager_aros` VALUES ('51', 'users', '33');
INSERT INTO `spider_aclmanager_aros` VALUES ('52', 'users', '7');
INSERT INTO `spider_aclmanager_aros` VALUES ('53', 'roles', '7');
INSERT INTO `spider_aclmanager_aros` VALUES ('54', 'users', '34');

-- ----------------------------
-- Table structure for spider_aclmanager_aros_acos
-- ----------------------------
DROP TABLE IF EXISTS `spider_aclmanager_aros_acos`;
CREATE TABLE `spider_aclmanager_aros_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) NOT NULL,
  `aco_id` int(11) NOT NULL,
  `deny` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aro_id` (`aro_id`,`aco_id`),
  KEY `aco_id` (`aco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=930 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of spider_aclmanager_aros_acos
-- ----------------------------
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('899', '22', '425', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('900', '22', '426', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('901', '22', '427', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('902', '14', '404', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('903', '14', '425', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('904', '14', '426', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('905', '14', '427', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('906', '14', '430', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('907', '22', '430', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('908', '53', '202', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('909', '53', '203', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('910', '53', '425', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('911', '53', '430', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('912', '53', '426', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('913', '53', '427', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('914', '53', '431', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('915', '53', '432', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('916', '53', '434', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('917', '53', '433', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('918', '53', '424', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('920', '53', '416', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('921', '53', '394', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('922', '22', '393', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('923', '22', '388', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('924', '22', '389', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('925', '22', '429', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('926', '22', '403', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('927', '22', '416', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('928', '14', '394', null);
INSERT INTO `spider_aclmanager_aros_acos` VALUES ('929', '53', '441', null);

-- ----------------------------
-- Table structure for spider_aclmanager_roles
-- ----------------------------
DROP TABLE IF EXISTS `spider_aclmanager_roles`;
CREATE TABLE `spider_aclmanager_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `spider_aclmanager_roles_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `spider_aclmanager_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of spider_aclmanager_roles
-- ----------------------------
INSERT INTO `spider_aclmanager_roles` VALUES ('1', null, 'public', 'کاربر عمومی', null, '1', '14');
INSERT INTO `spider_aclmanager_roles` VALUES ('2', '1', 'registered', 'کاربر ثبت نام شده', null, '2', '13');
INSERT INTO `spider_aclmanager_roles` VALUES ('3', '2', 'admin', 'مدیر', null, '3', '6');
INSERT INTO `spider_aclmanager_roles` VALUES ('4', '3', 'superadmin', 'مدیرکل', null, '4', '5');
INSERT INTO `spider_aclmanager_roles` VALUES ('5', '2', 'counter', 'کانتر', null, '7', '12');
INSERT INTO `spider_aclmanager_roles` VALUES ('6', '5', 'agency', 'آژانس', null, '8', '9');
INSERT INTO `spider_aclmanager_roles` VALUES ('7', '5', 'brokers', 'کارگزار', '', '10', '11');

-- ----------------------------
-- Table structure for spider_aclmanager_users_roles
-- ----------------------------
DROP TABLE IF EXISTS `spider_aclmanager_users_roles`;
CREATE TABLE `spider_aclmanager_users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of spider_aclmanager_users_roles
-- ----------------------------
INSERT INTO `spider_aclmanager_users_roles` VALUES ('1', '1', '4');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('2', '2', '3');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('3', '3', '2');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('4', '4', '5');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('5', '5', '6');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('7', '6', '5');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('8', '7', '5');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('9', '8', '6');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('10', '9', '6');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('11', '10', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('12', '11', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('13', '12', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('14', '13', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('15', '14', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('16', '15', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('17', '16', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('18', '17', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('19', '18', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('20', '19', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('21', '20', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('22', '21', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('23', '22', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('24', '23', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('25', '24', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('26', '25', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('27', '26', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('28', '27', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('29', '28', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('30', '29', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('31', '30', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('32', '31', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('33', '32', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('34', '33', '7');
INSERT INTO `spider_aclmanager_users_roles` VALUES ('35', '34', '7');

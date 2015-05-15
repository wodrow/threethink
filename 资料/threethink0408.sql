/*
Navicat MySQL Data Transfer

Source Server         : 116.255.217.235
Source Server Version : 50045
Source Host           : 116.255.217.235:3306
Source Database       : threethink

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2015-04-08 10:46:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tt_admin_module`
-- ----------------------------
DROP TABLE IF EXISTS `tt_admin_module`;
CREATE TABLE `tt_admin_module` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `url` varchar(50) NOT NULL default '',
  `description` varchar(50) NOT NULL default '',
  `visible` tinyint(4) NOT NULL default '0',
  `fasten` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_admin_module
-- ----------------------------
INSERT INTO `tt_admin_module` VALUES ('1', '首页模块', 'Admin', '首页模块', '0', '1');
INSERT INTO `tt_admin_module` VALUES ('2', '工作空间', 'Workspace', '工作空间', '1', '1');
INSERT INTO `tt_admin_module` VALUES ('3', '网站设置', 'Webset', '网站设置', '1', '1');
INSERT INTO `tt_admin_module` VALUES ('4', '后台成员', 'Member', '后台成员', '1', '1');
INSERT INTO `tt_admin_module` VALUES ('5', '用户管理', 'User', '用户管理', '1', '1');
INSERT INTO `tt_admin_module` VALUES ('6', '文档数据', 'Docdata', '文档数据', '1', '1');
INSERT INTO `tt_admin_module` VALUES ('7', '插件扩展', 'Plug', '插件扩展', '1', '1');

-- ----------------------------
-- Table structure for `tt_admin_module_menu`
-- ----------------------------
DROP TABLE IF EXISTS `tt_admin_module_menu`;
CREATE TABLE `tt_admin_module_menu` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL default '',
  `url` varchar(50) NOT NULL default '',
  `adminmodule_id` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_admin_module_menu
-- ----------------------------
INSERT INTO `tt_admin_module_menu` VALUES ('1', '0', '系统管理', 'xi_tong_guan_li', '3', 'glyphicon glyphicon-cog');
INSERT INTO `tt_admin_module_menu` VALUES ('2', '0', '配置管理', 'pei_zhi_guan_li', '3', 'glyphicon glyphicon-cog');
INSERT INTO `tt_admin_module_menu` VALUES ('3', '2', '自定义配置', 'zi_ding_yi', '3', 'glyphicon glyphicon-wrench');
INSERT INTO `tt_admin_module_menu` VALUES ('6', '1', '后台模块管理', 'hou_tai_mo_kuai', '3', 'glyphicon glyphicon-wrench');
INSERT INTO `tt_admin_module_menu` VALUES ('7', '1', '后台菜单管理', 'hou_tai_cai_dan', '3', 'glyphicon glyphicon-wrench');
INSERT INTO `tt_admin_module_menu` VALUES ('9', '1', '字段管理', 'zi_duan_guan_li', '3', 'glyphicon glyphicon-wrench');
INSERT INTO `tt_admin_module_menu` VALUES ('10', '0', '成员管理', 'cheng_yuan_guan_li', '4', 'glyphicon glyphicon-cog');
INSERT INTO `tt_admin_module_menu` VALUES ('11', '0', 'test', 'test', '2', 'glyphicon glyphicon-cog');

-- ----------------------------
-- Table structure for `tt_attributes`
-- ----------------------------
DROP TABLE IF EXISTS `tt_attributes`;
CREATE TABLE `tt_attributes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `decription` varchar(255) default '',
  `fasten` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_attributes
-- ----------------------------
INSERT INTO `tt_attributes` VALUES ('1', '别名', '数据字段的别名', '1');

-- ----------------------------
-- Table structure for `tt_config`
-- ----------------------------
DROP TABLE IF EXISTS `tt_config`;
CREATE TABLE `tt_config` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_config
-- ----------------------------
INSERT INTO `tt_config` VALUES ('1', 'APP_VERSION', '1.0', '应用版本号');
INSERT INTO `tt_config` VALUES ('2', 'TABLE_LIST_SHOW_COUNT', '10', '数据表格显示行数');

-- ----------------------------
-- Table structure for `tt_field_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `tt_field_attribute`;
CREATE TABLE `tt_field_attribute` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table_model_name` varchar(20) NOT NULL,
  `field_name` varchar(20) NOT NULL,
  `show_type` tinyint(4) NOT NULL default '1',
  `alias` varchar(255) NOT NULL default '',
  `type` varchar(20) NOT NULL,
  `is_null` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_field_attribute
-- ----------------------------
INSERT INTO `tt_field_attribute` VALUES ('1', 'AdminModule', 'id', '1', '编号', 'int', '0');
INSERT INTO `tt_field_attribute` VALUES ('2', 'AdminModule', 'name', '1', '模块名', 'varchar', '0');
INSERT INTO `tt_field_attribute` VALUES ('3', 'AdminModule', 'url', '1', '模块控制器url', 'varchar', '0');
INSERT INTO `tt_field_attribute` VALUES ('4', 'AdminModule', 'description', '1', '模块简介', 'varchar', '0');
INSERT INTO `tt_field_attribute` VALUES ('5', 'AdminModule', 'visible', '1', '后台列表可见', 'tinyint', '0');
INSERT INTO `tt_field_attribute` VALUES ('6', 'AdminModule', 'fasten', '1', '固定不可更改', 'tinyint', '0');
INSERT INTO `tt_field_attribute` VALUES ('7', 'FieldAttribute', 'id', '1', '编号', 'int', '0');
INSERT INTO `tt_field_attribute` VALUES ('8', 'FieldAttribute', 'table_model_name', '1', '表模型名', 'varchar', '0');
INSERT INTO `tt_field_attribute` VALUES ('9', 'FieldAttribute', 'field_name', '1', '字段名', 'varchar', '0');
INSERT INTO `tt_field_attribute` VALUES ('10', 'FieldAttribute', 'alias', '1', '字段别名', 'varchar', '0');
INSERT INTO `tt_field_attribute` VALUES ('11', 'FieldAttribute', 'type', '1', '数据类型', 'varchar', '0');
INSERT INTO `tt_field_attribute` VALUES ('15', 'FieldAttribute', 'is_null', '1', '是否必填', 'tinyint', '0');
INSERT INTO `tt_field_attribute` VALUES ('16', 'Test', 'id', '1', '编号', 'int', '1');
INSERT INTO `tt_field_attribute` VALUES ('17', 'Test', 'test_name', '1', '测试名称', 'varchar', '1');
INSERT INTO `tt_field_attribute` VALUES ('18', 'Test', 'test_image', '1', '测试图片', 'image', '0');
INSERT INTO `tt_field_attribute` VALUES ('19', 'Test', 'test_textarea', '0', '测试图文', 'text', '0');
INSERT INTO `tt_field_attribute` VALUES ('20', 'FieldAttribute', 'show_type', '1', '字段显示类型', 'varchar', '0');

-- ----------------------------
-- Table structure for `tt_member`
-- ----------------------------
DROP TABLE IF EXISTS `tt_member`;
CREATE TABLE `tt_member` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `role_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_member
-- ----------------------------
INSERT INTO `tt_member` VALUES ('1', '1', 'test', 'test');

-- ----------------------------
-- Table structure for `tt_operation`
-- ----------------------------
DROP TABLE IF EXISTS `tt_operation`;
CREATE TABLE `tt_operation` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `adminmeau_id` int(11) NOT NULL,
  `icon` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_operation
-- ----------------------------

-- ----------------------------
-- Table structure for `tt_operation_record`
-- ----------------------------
DROP TABLE IF EXISTS `tt_operation_record`;
CREATE TABLE `tt_operation_record` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mem_id` int(11) NOT NULL,
  `oper_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_operation_record
-- ----------------------------

-- ----------------------------
-- Table structure for `tt_permission`
-- ----------------------------
DROP TABLE IF EXISTS `tt_permission`;
CREATE TABLE `tt_permission` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `role_id` int(11) NOT NULL,
  `operation_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_permission
-- ----------------------------

-- ----------------------------
-- Table structure for `tt_role`
-- ----------------------------
DROP TABLE IF EXISTS `tt_role`;
CREATE TABLE `tt_role` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_role
-- ----------------------------

-- ----------------------------
-- Table structure for `tt_test`
-- ----------------------------
DROP TABLE IF EXISTS `tt_test`;
CREATE TABLE `tt_test` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `test_name` varchar(20) NOT NULL,
  `test_image` varchar(50) NOT NULL,
  `test_textarea` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tt_test
-- ----------------------------
INSERT INTO `tt_test` VALUES ('7', 'test1', '', '');
INSERT INTO `tt_test` VALUES ('6', 'test', '', '');
INSERT INTO `tt_test` VALUES ('8', 'gasdhasdf', '', 'hasdfasdg');
INSERT INTO `tt_test` VALUES ('9', 'dsgas', 'Test/2015-03-18/55091b1f185f1.png', '');
INSERT INTO `tt_test` VALUES ('10', '发的个', 'Test/2015-03-18/55091dfaecfbd.png', '');
INSERT INTO `tt_test` VALUES ('11', '嘎的', '', '噶哈说的哈');
INSERT INTO `tt_test` VALUES ('12', '按时到岗', '', '');
INSERT INTO `tt_test` VALUES ('13', '按时到岗a', '', '');

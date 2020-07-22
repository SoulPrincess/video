/*
Navicat MySQL Data Transfer

Source Server         : lhp
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : video

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-07-22 16:05:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `truename` varchar(20) DEFAULT NULL COMMENT '管理员真实姓名',
  `gid` int(11) DEFAULT NULL COMMENT '角色id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常   1禁用',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', 'a66abb5684c45962d887564f08346e8d', '张三', '1', '0', null);
INSERT INTO `admins` VALUES ('2', 's', '3691308f2a4c2f6983f2880d32e29c84', '李四', '1', '1', '1594025414');

-- ----------------------------
-- Table structure for `admin_groups`
-- ----------------------------
DROP TABLE IF EXISTS `admin_groups`;
CREATE TABLE `admin_groups` (
  `gid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '角色名称',
  `rights` text COMMENT '角色权限 json',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_groups
-- ----------------------------
INSERT INTO `admin_groups` VALUES ('1', '系统管理员', '[1,4,11,5,6,2,10,12,13,3,14,15,7,8,16,17,18,19,20,21,22,23,24,25]');
INSERT INTO `admin_groups` VALUES ('2', '开发人员', '[2,10]');

-- ----------------------------
-- Table structure for `admin_menus`
-- ----------------------------
DROP TABLE IF EXISTS `admin_menus`;
CREATE TABLE `admin_menus` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL COMMENT '菜单名称',
  `controller` varchar(20) DEFAULT NULL COMMENT '控制器名称',
  `method` varchar(20) DEFAULT NULL,
  `ishidden` tinyint(1) DEFAULT '0' COMMENT '是否隐藏  0正常  1隐藏',
  `status` tinyint(1) DEFAULT '0' COMMENT '0正常   1禁用',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `pid` int(11) DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_menus
-- ----------------------------
INSERT INTO `admin_menus` VALUES ('1', '管理员管理', '', '', '0', '0', '0', '0');
INSERT INTO `admin_menus` VALUES ('2', '权限管理', '', '', '0', '0', '0', '0');
INSERT INTO `admin_menus` VALUES ('3', '系统设置', '', '', '0', '0', '0', '0');
INSERT INTO `admin_menus` VALUES ('4', '管理员列表', 'Admin', 'index', '0', '0', '0', '1');
INSERT INTO `admin_menus` VALUES ('5', '管理员添加', 'Admin', 'add', '1', '0', '0', '1');
INSERT INTO `admin_menus` VALUES ('6', '管理员保存', 'Admin', 'save', '1', '0', '0', '1');
INSERT INTO `admin_menus` VALUES ('7', '标签管理', '', '', '0', '0', '0', '0');
INSERT INTO `admin_menus` VALUES ('8', '频道管理', 'Label', 'channel', '0', '0', '0', '7');
INSERT INTO `admin_menus` VALUES ('10', '菜单管理', 'Menu', 'index', '0', '0', '0', '2');
INSERT INTO `admin_menus` VALUES ('11', '测试', '', '', '0', '0', '0', '4');
INSERT INTO `admin_menus` VALUES ('12', '角色管理', 'Roles', 'index', '0', '0', '0', '2');
INSERT INTO `admin_menus` VALUES ('13', '菜单列表', 'Menu', 'add', '1', '0', '0', '2');
INSERT INTO `admin_menus` VALUES ('14', '网站设置', 'Site', 'index', '0', '0', '0', '3');
INSERT INTO `admin_menus` VALUES ('15', '网站保存', 'Site', 'save', '1', '0', '0', '3');
INSERT INTO `admin_menus` VALUES ('16', '资费管理', 'Label', 'charge', '0', '0', '0', '7');
INSERT INTO `admin_menus` VALUES ('17', '地区管理', 'Label', 'area', '0', '0', '0', '7');
INSERT INTO `admin_menus` VALUES ('18', '影片管理', '', '', '0', '0', '0', '0');
INSERT INTO `admin_menus` VALUES ('19', '影片列表', 'Video', 'index', '0', '0', '0', '18');
INSERT INTO `admin_menus` VALUES ('20', '影片添加', 'Video', 'add', '1', '0', '0', '18');
INSERT INTO `admin_menus` VALUES ('21', '影片保存', 'Video', 'save', '1', '0', '0', '18');
INSERT INTO `admin_menus` VALUES ('22', '图片上传', 'Video', 'upload_img', '1', '0', '0', '18');
INSERT INTO `admin_menus` VALUES ('23', '幻灯片管理', '', '', '0', '0', '0', '0');
INSERT INTO `admin_menus` VALUES ('24', '首页视频', 'Slide', 'index', '0', '0', '0', '23');
INSERT INTO `admin_menus` VALUES ('25', '幻灯片保存', 'Slide', 'save', '1', '0', '0', '23');

-- ----------------------------
-- Table structure for `sites`
-- ----------------------------
DROP TABLE IF EXISTS `sites`;
CREATE TABLE `sites` (
  `names` varchar(50) DEFAULT NULL,
  `values` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sites
-- ----------------------------
INSERT INTO `sites` VALUES ('tite', '\"\\u7535\\u5f71\"');

-- ----------------------------
-- Table structure for `slide`
-- ----------------------------
DROP TABLE IF EXISTS `slide`;
CREATE TABLE `slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL COMMENT '标题',
  `url` varchar(255) DEFAULT NULL COMMENT '地址',
  `img` varchar(255) DEFAULT NULL COMMENT '图片地址',
  `sort` tinyint(2) DEFAULT '0' COMMENT '排序',
  `type` tinyint(1) unsigned DEFAULT '0' COMMENT '0 首页  1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of slide
-- ----------------------------
INSERT INTO `slide` VALUES ('4', '喜欢你2：星晴CP崩溃痛哭', '//www.iqiyi.com/a_19rrhy6pvd.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p12', '/uploads/20200709\\2cbd4db2600c885352f7f1904a8a323b.jpg', '0', '0');
INSERT INTO `slide` VALUES ('3', '天舞纪：许凯吴佳怡校园爱情', '//www.iqiyi.com/v_2ffkwsp03k0.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p11', '/uploads/20200709\\26977b0ac26524f165bc1e8599bc38fa.jpg', '0', '0');
INSERT INTO `slide` VALUES ('5', '重启：铁三角合体重启冒险', 'https://www.iqiyi.com/v_2ffkwycne88.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p11', '/uploads/20200716\\c89d41cc99c2ee41e83850dcd70881f3.jpg', '0', '0');
INSERT INTO `slide` VALUES ('6', '独播专区：王牌大片独家放送', 'https://www.iqiyi.com/playlist408093702.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p19', '/uploads/20200716\\0c119f087a13d51189e3455c1a32a074.jpeg', '0', '0');
INSERT INTO `slide` VALUES ('7', '河神2：津门天团再闯连环谜案', '//www.iqiyi.com/v_19rzd1sn6c.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p14', '/uploads/20200716\\7311fbb8c753c025e90a5f0cd6d7f3da.jpg', '0', '0');
INSERT INTO `slide` VALUES ('8', '二十不惑：关晓彤诠释不惑青春', 'https://www.iqiyi.com/v_2ffkwyejnyo.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p15', '/uploads/20200716\\9906a7149732dd636c828aa8c09c92b6.jpg', '0', '0');
INSERT INTO `slide` VALUES ('9', '生活：马伯骞化身海洋馆讲解员', '//www.iqiyi.com/kszt/wyzyshpc.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p16', '/uploads/20200716\\23a6a2addbf100f88ac483a523224786.jpg', '0', '0');
INSERT INTO `slide` VALUES ('10', '腾空之约：胡冰卿范世錡人鱼恋', '//www.iqiyi.com/v_19rzc9e36w.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p17', '/uploads/20200716\\f410cfceeb2c07cb9f55c82d4f43ed5f.jpg', '0', '0');
INSERT INTO `slide` VALUES ('11', '花千骨：神装庆典 洪荒再现', 'https://ads.game.iqiyi.com/nt/jw5v23bxlb.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p20', '/uploads/20200716\\2ca32a9499c03beb6a0fc2609b27cbed.jpg', '0', '0');
INSERT INTO `slide` VALUES ('12', '辣子曰：夏日宵夜秘制功夫烤肉', '//www.iqiyi.com/v_2ffkws09th0.html?vfrm=pcw_home&vfrmblk=B&vfrmrst=fcs_0_p18', '/uploads/20200716\\9d7ecaf67844fbfb97324013bb06d1de.jpg', '0', '0');

-- ----------------------------
-- Table structure for `video`
-- ----------------------------
DROP TABLE IF EXISTS `video`;
CREATE TABLE `video` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '影片名称',
  `keyword` varchar(255) DEFAULT NULL COMMENT '关键字',
  `desc` varchar(255) DEFAULT NULL COMMENT '描述',
  `img` varchar(255) DEFAULT NULL COMMENT '首页图',
  `url` varchar(255) DEFAULT NULL COMMENT '地址',
  `status` tinyint(1) DEFAULT '0' COMMENT '0正常  1下线',
  `pv` int(11) DEFAULT '0' COMMENT '播放量',
  `add_time` int(11) DEFAULT NULL,
  `score` int(3) DEFAULT '0' COMMENT '评分',
  `is_vip` tinyint(1) DEFAULT '0' COMMENT '0 否  1是',
  `channel_id` int(11) DEFAULT NULL COMMENT '频道',
  `charge_id` int(11) DEFAULT NULL COMMENT '资费',
  `area_id` int(11) DEFAULT NULL COMMENT '地区',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of video
-- ----------------------------
INSERT INTO `video` VALUES ('1', '神秘的角落', '角落', 'sss', '/uploads/20200708\\47b9a247116f305196c234e2993b2740.jpg', 'http://www.qifujie.cn/', '1', null, '1594200172', null, '0', '1', '11', '13');
INSERT INTO `video` VALUES ('2', '向往的生活', '综艺', '慢性生活', '/uploads/20200721\\758ca1a573d9339c844f805699403a7c.jpg', '//www.iqiyi.com/v_19rzgqtmz4.html?vfrm=pcw_home&vfrmblk=G&vfrmrst=712211_zongyi_image3', '1', '0', '1594259909', '0', '0', '3', '11', '13');
INSERT INTO `video` VALUES ('4', '极限挑战6', '真人秀', '雷佳音直言想把邓伦“炸掉”', '/uploads/20200716\\9717eb9c79c11095eb48f023539f625d.jpg', '//www.iqiyi.com/v_19rzgqtmz4.html?vfrm=pcw_home&vfrmblk=G&vfrmrst=712211_zongyi_image3', '1', '0', '1594871928', '0', '0', '3', '11', '13');
INSERT INTO `video` VALUES ('5', '青春环游记第2季', '真人秀', '范丞丞聊童年暴击80后组合', '/uploads/20200716\\6c6aaed734581604755918c403f449cc.jpg', '//www.iqiyi.com/v_19rzkqjl4s.html?vfrm=pcw_home&vfrmblk=G&vfrmrst=712211_zongyi_image4', '1', '0', '1594872101', '0', '0', '3', '11', '13');
INSERT INTO `video` VALUES ('6', '跨界歌王第5季', '真人秀', '郑恺李小萌玩转复古disco', '/uploads/20200716\\d39d553e7b7de89c88cdf4728924a0c9.jpg', '//www.iqiyi.com/v_19rzkqi38k.html?vfrm=pcw_home&vfrmblk=G&vfrmrst=712211_zongyi_image8', '1', '0', '1594876419', '0', '0', '3', '11', '13');

-- ----------------------------
-- Table structure for `video_label`
-- ----------------------------
DROP TABLE IF EXISTS `video_label`;
CREATE TABLE `video_label` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL COMMENT '标签标题',
  `status` tinyint(1) DEFAULT '0' COMMENT '0 正常  1禁用',
  `flag` varchar(50) DEFAULT NULL COMMENT '标签分类标识',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of video_label
-- ----------------------------
INSERT INTO `video_label` VALUES ('1', '电视剧', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('2', '电影', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('3', '综艺', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('4', '动漫', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('5', '纪录片', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('6', '游戏', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('7', '资讯', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('8', '娱乐', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('9', '财经', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('10', '网络电影', '0', 'channel', '0');
INSERT INTO `video_label` VALUES ('11', '免费', '0', 'charge', '0');
INSERT INTO `video_label` VALUES ('12', '付费', '0', 'charge', '0');
INSERT INTO `video_label` VALUES ('13', '华语', '0', 'area', '0');
INSERT INTO `video_label` VALUES ('14', '香港', '0', 'area', '0');
INSERT INTO `video_label` VALUES ('15', '美国', '0', 'area', '0');
INSERT INTO `video_label` VALUES ('16', '欧洲', '0', 'area', '0');
INSERT INTO `video_label` VALUES ('17', '韩国', '0', 'area', '0');
INSERT INTO `video_label` VALUES ('18', '日本', '0', 'area', '0');
INSERT INTO `video_label` VALUES ('19', '泰国', '0', 'area', '0');
INSERT INTO `video_label` VALUES ('20', '其他', '0', 'area', '0');

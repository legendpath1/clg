-- phpMyAdmin SQL Dump
-- version 2.11.10.1
-- http://www.phpmyadmin.net
--
-- 主机: 
-- 生成日期: 2015 年 07 月 20 日 10:55
-- 服务器版本: 5.1.73
-- PHP 版本: 5.2.17p1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wlsxsql`
--

-- --------------------------------------------------------

--
-- 表的结构 `ed_admin`
--

CREATE TABLE IF NOT EXISTS `ed_admin` (
  `admin_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(16) NOT NULL DEFAULT '',
  `password` varchar(36) NOT NULL DEFAULT '',
  `full_name` varchar(20) NOT NULL DEFAULT '',
  `add_time` varchar(12) NOT NULL DEFAULT '',
  `last_time` varchar(12) NOT NULL DEFAULT '',
  `add_ip` varchar(15) NOT NULL DEFAULT '',
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `admin_mobile` varchar(11) NOT NULL DEFAULT '',
  `admin_email` varchar(50) NOT NULL DEFAULT '',
  `admin_power` text NOT NULL,
  `isshow` tinyint(1) unsigned DEFAULT '1',
  `issuper` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `ed_admin`
--

INSERT INTO `ed_admin` (`admin_id`, `admin_name`, `password`, `full_name`, `add_time`, `last_time`, `add_ip`, `last_ip`, `admin_mobile`, `admin_email`, `admin_power`, `isshow`, `issuper`) VALUES
(1, 'admin', '2c0559f88b377245212ceb85f4cfc100f817', 'admin', '1300354310', '1437358641', '121.33.97.227', '74.14.20.66', '', '', 'all', 1, 0),
(2, 'gzseo', '4515d36409cdee96cfbcf927be3de9645ab3', 'gzseo', '1300069235', '1408520061', '121.33.97.97', '192.168.0.13', '', '', 'all', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ed_admin_log`
--

CREATE TABLE IF NOT EXISTS `ed_admin_log` (
  `log_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `admin_user` varchar(50) NOT NULL DEFAULT '',
  `log_time` varchar(12) NOT NULL DEFAULT '',
  `log_info` varchar(255) NOT NULL DEFAULT '',
  `log_ip` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ed_admin_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `ed_admin_power`
--

CREATE TABLE IF NOT EXISTS `ed_admin_power` (
  `power_id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(3) unsigned NOT NULL DEFAULT '0',
  `power_name_cn` varchar(20) NOT NULL DEFAULT '',
  `power_name_en` varchar(20) NOT NULL DEFAULT '',
  `power_filename` varchar(200) DEFAULT NULL,
  `stor` tinyint(5) unsigned NOT NULL DEFAULT '1',
  `isshow` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `display` varchar(10) DEFAULT 'none',
  PRIMARY KEY (`power_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=287 ;

--
-- 导出表中的数据 `ed_admin_power`
--

INSERT INTO `ed_admin_power` (`power_id`, `parent_id`, `power_name_cn`, `power_name_en`, `power_filename`, `stor`, `isshow`, `display`) VALUES
(1, 0, '基本设置', 'company_manager', '', 1, 1, 'block'),
(25, 0, '权限管理', 'power_manager', '', 25, 1, 'none'),
(27, 0, '数据库管理', 'database_manager', '', 26, 1, 'none'),
(28, 0, '系统管理', 'system_manager', '', 27, 1, 'block'),
(43, 25, '管理员列表', 'admin_list', 'adminList.php', 1, 1, 'none'),
(49, 25, '权限列表', 'power_list', 'powerList.php', 1, 1, 'none'),
(51, 28, '系统环境', 'phpinfo', 'phpinfo.php', 9, 1, 'none'),
(54, 27, '数据库优化', 'database_opt', 'database_opt.php', 3, 1, 'none'),
(55, 1, '网站配置', 'systemConfig', 'systemConfig.php', 2, 1, 'none'),
(74, 25, '添加管理员', 'admin_add', 'adminEdit.php', 3, 1, 'none'),
(107, 1, '优化栏目', 'seo', 'seoList.php', 1, 1, 'none'),
(26, 1, '网站统计', 'site_cnzz', 'http://www.cnzz.com/stat/website.php?web_id=5572128', 5, 1, 'none'),
(266, 0, '首页设置', 'indexset', NULL, 2, 1, 'none'),
(282, 266, '首页活动', '', 'syhdList.php', 4, 1, 'none'),
(283, 266, '网站介绍', 'wzjs', 'wzjsList.php', 1, 1, 'none'),
(284, 0, '游戏页面设置', '', NULL, 3, 1, 'none'),
(285, 284, '五仙宫设置', '', 'wxgszList.php', 2, 1, 'none'),
(286, 284, '游戏页面链接', '', 'gamelinkList.php', 7, 1, 'none');

-- --------------------------------------------------------

--
-- 表的结构 `ed_config`
--

CREATE TABLE IF NOT EXISTS `ed_config` (
  `option_name` text NOT NULL,
  `option_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `ed_config`
--

INSERT INTO `ed_config` (`option_name`, `option_value`) VALUES
('site_name', '奥威亚'),
('site_url', 'awy2015@qq.com'),
('service_address', '广州市白云区太和大源黄庄华达街15号4楼'),
('service_phone', '020-37885228 '),
('service_email', ''),
('service_bottom_qq', ''),
('service_qq', '564911223,564911223'),
('service_qq_nickname', ''),
('copyright', 'Copyright © 2005-2012 AVA ELECTRONICS Co.,Ltd. All Rights Reserved'),
('site_icp', '粤ICP备34654665号'),
('article_author', '金丽阳'),
('article_from', '金丽阳'),
('site_baidu', ''),
('fax', ''),
('post_code', 'Jin Liyang Guangzhou Optoelectronic Technology Co., Ltd'),
('service_qq_name', ''),
('site_foot1', '400-818-5228 '),
('site_foot2', 'Dayuan Huang Baiyun District Tai Guangzhou Huada Street No. 15 4 floor'),
('site_foot3', 'service@ava.com.cn'),
('site_foot4', ''),
('site_logo', ''),
('site_cnzz', '<script src="http://s95.cnzz.com/stat.php?id=5344407&web_id=5344407&show=pic" language="JavaScript"></script>'),
('top_phone', '400-818-5228'),
('service_cz', '020-36521217');

-- --------------------------------------------------------

--
-- 表的结构 `ed_gamelink`
--

CREATE TABLE IF NOT EXISTS `ed_gamelink` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` tinyint(5) unsigned NOT NULL DEFAULT '0',
  `media_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ad_name` varchar(100) NOT NULL DEFAULT '',
  `en_name` varchar(100) NOT NULL,
  `ad_url` varchar(100) NOT NULL DEFAULT '',
  `ad_code` varchar(200) NOT NULL DEFAULT '',
  `index_pic` varchar(200) NOT NULL,
  `ad_alt` varchar(200) DEFAULT NULL,
  `stor` tinyint(5) unsigned NOT NULL DEFAULT '0',
  `jianjie` text NOT NULL,
  `en_jianjie` text NOT NULL,
  `hd_index` tinyint(1) NOT NULL DEFAULT '0',
  `tj_index` tinyint(1) NOT NULL DEFAULT '0',
  `issue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0',
  `hit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `starttime` date NOT NULL DEFAULT '0000-00-00',
  `stoptime` date NOT NULL DEFAULT '0000-00-00',
  `bz_id` varchar(5) NOT NULL,
  `content` text NOT NULL,
  `en_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 导出表中的数据 `ed_gamelink`
--

INSERT INTO `ed_gamelink` (`id`, `catid`, `media_type`, `ad_name`, `en_name`, `ad_url`, `ad_code`, `index_pic`, `ad_alt`, `stor`, `jianjie`, `en_jianjie`, `hd_index`, `tj_index`, `issue`, `addtime`, `hit`, `starttime`, `stoptime`, `bz_id`, `content`, `en_content`) VALUES
(0, 0, 0, '', 'SDA DCSS FWEF', 'eee', '', '', '', 1, '', 'When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.', 0, 0, 0, 1435678626, 89, '0000-00-00', '0000-00-00', '', '', '<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<br />\r\n<p>\r\n	<br />\r\n</p>'),
(1, 0, 0, '', 'FGRSFERR', '', '', 'images/wzjs/143555197730287.png', '', 2, '', 'When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.', 0, 0, 0, 1435551977, 0, '0000-00-00', '0000-00-00', '', '', '<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;"><span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span></span> \r\n</p>\r\n<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;"><span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span></span> \r\n</p>\r\n<p>\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;"><span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;white-space:normal;background-color:#FFFFFF;"> </span></span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-family:tahoma, arial, 宋体;font-size:14px;line-height:25px;background-color:#FFFFFF;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<br />\r\n<p>\r\n	<br />\r\n</p>'),
(2, 0, 0, '', '', '', '', 'images/wzjs/143555221310362.png', '', 3, '', '', 0, 0, 0, 1435552213, 0, '0000-00-00', '0000-00-00', '', '', ''),
(3, 0, 0, '', '', '', '', 'images/wzjs/14355522259921.png', '', 4, '', '', 0, 0, 0, 1435552225, 0, '0000-00-00', '0000-00-00', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `ed_index_pic`
--

CREATE TABLE IF NOT EXISTS `ed_index_pic` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` tinyint(5) unsigned NOT NULL DEFAULT '0',
  `where_id` tinyint(5) NOT NULL,
  `media_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ad_name` varchar(100) NOT NULL DEFAULT '',
  `ad_url` varchar(100) NOT NULL DEFAULT '',
  `ad_code` varchar(200) NOT NULL DEFAULT '',
  `ad_alt` varchar(200) DEFAULT NULL,
  `ad_content` varchar(200) DEFAULT NULL,
  `stor` tinyint(5) unsigned NOT NULL DEFAULT '0',
  `issue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0',
  `hit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `starttime` date NOT NULL DEFAULT '0000-00-00',
  `stoptime` date NOT NULL DEFAULT '0000-00-00',
  `bz_id` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- 导出表中的数据 `ed_index_pic`
--

INSERT INTO `ed_index_pic` (`id`, `catid`, `where_id`, `media_type`, `ad_name`, `ad_url`, `ad_code`, `ad_alt`, `ad_content`, `stor`, `issue`, `addtime`, `hit`, `starttime`, `stoptime`, `bz_id`) VALUES
(78, 11, 0, 0, '领先行业的高度集成嵌入式架构2', '', 'images/advimg/142865308813765.png', '安全稳定的完美架构设计，极致性能引领业界变革2', NULL, 2, 1, 1428653857, 0, '0000-00-00', '0000-00-00', ''),
(77, 11, 0, 0, '领先行业的高度集成嵌入式架构1', '', 'images/advimg/142865308813765.png', '安全稳定的完美架构设计，极致性能引领业界变革1', NULL, 1, 1, 1428980706, 0, '0000-00-00', '0000-00-00', ''),
(81, 11, 0, 0, '领先行业的高度集成嵌入式架构3', '', 'images/advimg/142865308813765.png', '安全稳定的完美架构设计，极致性能引领业界变革3', NULL, 3, 1, 1434467115, 0, '0000-00-00', '0000-00-00', ''),
(82, 11, 0, 0, '领先行业的高度集成嵌入式架构4', '', 'images/advimg/142865308813765.png', '安全稳定的完美架构设计，极致性能引领业界变革4', NULL, 4, 1, 1434467191, 0, '0000-00-00', '0000-00-00', ''),
(84, 13, 0, 0, '顶级极致性能02', '', 'images/advimg/143450943310522.jpg', '率先推出全高清嵌入式一体机\r\n极致稳定', '内置1TB/2TB存储硬盘，保证用户的视频存储需求，2路HDMI环出接口具独立处理能力，灵活输出多类视频首家通过1080@60Hz测试，支持2路到6路的全高清视频信号输入。\r\n国际标准接口，支持HDMI、YPbPr、DVI、VGA、CVBS、HD-SDI、3G-SDI\r\n视频输入嵌入式一体机 稳定+极致性能。', 2, 1, 1434511450, 0, '0000-00-00', '0000-00-00', ''),
(85, 13, 0, 0, '顶级极致性能01', '', 'images/advimg/143450929615301.jpg', '率先推出全高清嵌入式一体机\r\n极致稳定', '内置1TB/2TB存储硬盘，保证用户的视频存储需求，2路HDMI环出接口具独立处理能力，灵活输出多类视频首家通过1080@60Hz测试，支持2路到6路的全高清视频信号输入。\r\n国际标准接口，支持HDMI、YPbPr、DVI、VGA、CVBS、HD-SDI、3G-SDI\r\n视频输入嵌入式一体机 稳定+极致性能。', 1, 1, 1434526061, 0, '0000-00-00', '0000-00-00', ''),
(86, 13, 0, 0, '顶级极致性能03', '', 'images/advimg/143450948928692.jpg', '率先推出全高清嵌入式一体机\r\n极致稳定', '内置1TB/2TB存储硬盘，保证用户的视频存储需求，2路HDMI环出接口具独立处理能力，灵活输出多类视频首家通过1080@60Hz测试，支持2路到6路的全高清视频信号输入。\r\n国际标准接口，支持HDMI、YPbPr、DVI、VGA、CVBS、HD-SDI、3G-SDI\r\n视频输入嵌入式一体机 稳定+极致性能。', 3, 1, 1434511743, 0, '0000-00-00', '0000-00-00', ''),
(88, 15, 0, 0, '录播系统', '', 'images/advimg/1434522956240.png', '02嵌入式系统架构，高度集成视频直播、实时导播、同步录制 \r\n在线点播、远程交互等功能 , 全面适用于学校课堂实况、培训会议、微课实训和各类校园文体活动场合\r\n', NULL, 1, 1, 1434522956, 0, '0000-00-00', '0000-00-00', ''),
(89, 15, 0, 0, '图像跟踪系统', '', 'images/advimg/14345231059928.png', '02嵌入式系统架构，高度集成视频直播、实时导播、同步录制 \r\n在线点播、远程交互等功能 , 全面适用于学校课堂实况、培训会议、微课实训和各类校园文体活动场合', NULL, 2, 1, 1434523105, 0, '0000-00-00', '0000-00-00', ''),
(99, 15, 0, 0, '庭审/审讯系统', '', 'images/advimg/143452615922766.png', '03嵌入式系统架构，高度集成视频直播、实时导播、同步录制 \r\n在线点播、远程交互等功能 , 全面适用于学校课堂实况、培训会议、微课实训和各类校园文体活动场合', NULL, 3, 1, 1434526159, 0, '0000-00-00', '0000-00-00', ''),
(100, 15, 0, 0, '视频应用软件', '', 'images/advimg/14345261874495.png', '04嵌入式系统架构，高度集成视频直播、实时导播、同步录制 \r\n在线点播、远程交互等功能 , 全面适用于学校课堂实况、培训会议、微课实训和各类校园文体活动场合', NULL, 4, 1, 1434526187, 0, '0000-00-00', '0000-00-00', '');

-- --------------------------------------------------------

--
-- 表的结构 `ed_index_picclass`
--

CREATE TABLE IF NOT EXISTS `ed_index_picclass` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `adv_postion` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(200) NOT NULL DEFAULT '',
  `adv_width` varchar(10) NOT NULL DEFAULT '',
  `adv_height` varchar(10) NOT NULL DEFAULT '',
  `content` varchar(255) NOT NULL DEFAULT '',
  `stor` tinyint(5) unsigned NOT NULL DEFAULT '99',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 导出表中的数据 `ed_index_picclass`
--

INSERT INTO `ed_index_picclass` (`id`, `adv_postion`, `title`, `adv_width`, `adv_height`, `content`, `stor`) VALUES
(11, '首页滚动大图', '首页滚动大图', '1600', '639', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `ed_jjfa`
--

CREATE TABLE IF NOT EXISTS `ed_jjfa` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL DEFAULT '',
  `s_title` varchar(200) DEFAULT NULL,
  `en_title` varchar(200) DEFAULT NULL,
  `pic` varchar(100) NOT NULL DEFAULT '',
  `filefrom` varchar(100) NOT NULL DEFAULT '',
  `fileurl` varchar(200) NOT NULL DEFAULT '',
  `hit` mediumint(8) unsigned DEFAULT '0',
  `summary` text,
  `content` text NOT NULL,
  `hots` tinyint(1) unsigned DEFAULT NULL,
  `issue` char(1) DEFAULT '1',
  `isnew` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `istop` char(1) DEFAULT '0',
  `stor` mediumint(8) DEFAULT NULL,
  `seotitle` varchar(255) NOT NULL DEFAULT '',
  `seodesc` varchar(255) NOT NULL DEFAULT '',
  `seokey` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL,
  `ispic` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 导出表中的数据 `ed_jjfa`
--

INSERT INTO `ed_jjfa` (`id`, `title`, `s_title`, `en_title`, `pic`, `filefrom`, `fileurl`, `hit`, `summary`, `content`, `hots`, `issue`, `isnew`, `istop`, `stor`, `seotitle`, `seodesc`, `seokey`, `addtime`, `ispic`) VALUES
(11, '微格教室', '教育行业', 'Education', 'xy', '', '', 0, NULL, '', NULL, '1', 0, '0', 1, '', '', '', 1435302056, '0'),
(36, '精品课程', '教育行业', 'Education', 'xy', '', '', 0, NULL, '', NULL, '1', 0, '0', 2, '', '', '', 1428981896, '0'),
(37, '手术示教', '医疗行业', 'Medical', 'yy', '', '', 0, NULL, '', NULL, '1', 0, '0', 3, '', '', '', 1428982250, '0'),
(38, '数字法庭', '公检法行业', 'Public security', 'fl', '', '', 0, NULL, '', NULL, '1', 0, '0', 4, '', '', '', 1428981875, '0'),
(39, '审讯系统', '公检法行业', 'Public security', 'fl', '', '', 0, NULL, '', NULL, '1', 0, '0', 5, '', '', '', 1428982004, '0'),
(41, '学术报告', '政企行业', 'Gov and enterprise', 'xs', '', '', 0, NULL, '', NULL, '1', 0, '0', 6, '', '', '', 1430128860, '0'),
(42, '学术报告', '政企行业', 'Gov and enterprise', 'xs', '', '', 0, NULL, '', NULL, '1', 0, '0', 7, '', '', '', 1430128865, '0'),
(43, '学术报告', '政企行业', 'Gov and enterprise', 'xs', '', '', 0, NULL, '', NULL, '1', 0, '0', 8, '', '', '', 1430128870, '0');

-- --------------------------------------------------------

--
-- 表的结构 `ed_pages`
--

CREATE TABLE IF NOT EXISTS `ed_pages` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(200) DEFAULT NULL,
  `fileurl` varchar(255) NOT NULL DEFAULT '',
  `jianjie` text NOT NULL,
  `content` text NOT NULL,
  `en_content` text NOT NULL,
  `stor` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `pic` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `seotitle` varchar(255) NOT NULL DEFAULT '',
  `seokey` varchar(255) NOT NULL DEFAULT '',
  `seodesc` varchar(255) NOT NULL DEFAULT '',
  `issue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 导出表中的数据 `ed_pages`
--

INSERT INTO `ed_pages` (`id`, `title`, `name`, `fileurl`, `jianjie`, `content`, `en_content`, `stor`, `pic`, `addtime`, `seotitle`, `seokey`, `seodesc`, `issue`) VALUES
(6, '', NULL, 'images/advimg/142865589813375.jpg', '', '<p>\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;广州市奥威亚电子科技有限公司（简称\r\n                                AVA）是全球视音频采集与传输、图像识别等领域处于领先地位的软件研发及产品制造商之一。主要产品包括：录播系统、跟踪系统、多媒体接线面板、庭审及审讯系统等视音频采集与传输设备。AVA凭着公司雄厚的技术力量及优质完善的服务网络，产品遍及世界各地，得到业界的广泛认可，众多核心技术成为业界的标准。\r\n</p>\r\n<p>\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AVA一直奉行"客户为先、技术为先"的原则。本着"诚信、优质、专业"的服务理念，能根据不同行业的应用特点为广大用户提供针对性极强的行业解决方案。目前，AVA已取得软件企业认证、ISO9001:2008认证、CCC认证、CE认证、实用新型专利证书、外观设计专利证书等多项产品品质认证。AVA愿和广大合作伙伴携手并肩，共同推进视音频产品的数字化、网络化、集成化和智能化。\r\n</p>', '<p>\r\n	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Maanshan mingguang automobile professional cleaning service Co., LTD was founded in March 2011, the company address located in maanshan central avenue and rain the junction of the mountain, and overseas sea hongtai hotel near holiday hotel is north road, to the west of hunan is a lake HuDong road, west to east road, is now south is rain. Through our continuous efforts to innovation, formed to specialized is engaged in the car maintenance, cleaning, and automotive products sales comprehensive enterprise. We have diploma and above management personnel account for 80%, it has the national advanced management mode, the company for timely adjust internal organization set up department, engineering department, the finance department, the propaganda department and the logistics department, a number of other departments. Since its establishment, we have insisted on automobile cleaning specialization, advocated edt, and strive to create a new era of automobile cleaning management new mode. Therefore, we fully confident, and customer commitment: we converged on professional management technology, the most sincere service and culture management pattern reached the maintenance and appreciation of the car.\r\nOur tenet: professional is our survival foundation, quality is our existence of security, reputation is the bridge of communication with our customers.\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<img style="margin-right:32px;" src="/jly/images/about01.jpg" /><img src="/jly/images/about02.jpg" /> \r\n</p>', 1, '', 0, '联系我们', '联系我们', '联系我们', 1);

-- --------------------------------------------------------

--
-- 表的结构 `ed_personnel`
--

CREATE TABLE IF NOT EXISTS `ed_personnel` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `big_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `small_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `three_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `catid` mediumint(8) unsigned DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `en_title` varchar(200) DEFAULT NULL,
  `pic` varchar(100) NOT NULL DEFAULT '',
  `alt` varchar(50) DEFAULT NULL,
  `author` varchar(50) NOT NULL DEFAULT '',
  `filefrom` varchar(100) NOT NULL DEFAULT '',
  `fileurl` varchar(200) NOT NULL DEFAULT '',
  `hit` mediumint(8) unsigned DEFAULT '0',
  `summary` text,
  `content` text NOT NULL,
  `hots` tinyint(1) unsigned DEFAULT NULL,
  `issue` char(1) DEFAULT '1',
  `isnew` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `istop` char(1) DEFAULT '0',
  `stor` mediumint(8) DEFAULT NULL,
  `seotitle` varchar(255) NOT NULL DEFAULT '',
  `seodesc` varchar(255) NOT NULL DEFAULT '',
  `seokey` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL,
  `ispic` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- 导出表中的数据 `ed_personnel`
--

INSERT INTO `ed_personnel` (`id`, `big_id`, `small_id`, `three_id`, `catid`, `title`, `en_title`, `pic`, `alt`, `author`, `filefrom`, `fileurl`, `hit`, `summary`, `content`, `hots`, `issue`, `isnew`, `istop`, `stor`, `seotitle`, `seodesc`, `seokey`, `addtime`, `ispic`) VALUES
(11, 1, 2, 0, 0, '职业规划', NULL, '', NULL, '', '', '', 0, NULL, '公司一直都非常重视员工的个人职业规划，公司鼓励员工按照现有的管理和技术双通道的发展模型来规划职业发展，鼓励员工设定短期/长期的职业目标，通过对发展所需要资质的强项/差距做自我评价以及和经理的资质面谈，促进员工资质的发展进而实现自我的发展。', NULL, '1', 0, '0', 1, '', '', '', 1435033237, '0'),
(32, 1, 3, 0, 0, '职业规划', NULL, '', NULL, '', '', '', 0, NULL, '公司一直都非常重视员工的个人职业规划，公司鼓励员工按照现有的管理和技术双通道的发展模型来规划职业发展，鼓励员工设定短期/长期的职业目标，通过对发展所需要资质的强项/差距做自我评价以及和经理的资质面谈，促进员工资质的发展进而实现自我的发展。', NULL, '1', 0, '0', 1, '', '', '', 1435033280, '0'),
(33, 1, 2, 0, 0, '竞聘制度', NULL, '', NULL, '', '', '', 0, NULL, '为了保证员工在公司得到更大的发展空间，公司还推行中基层管理岗位的竞聘制度，鼓励员工通过竞聘的方式展示自己，多方面发展自己的工作能力。', NULL, '1', 0, '0', 2, '', '', '', 1435033257, '0'),
(34, 1, 1, 0, 0, '职业规划', NULL, '', NULL, '', '', '', 0, NULL, '公司一直都非常重视员工的个人职业规划，公司鼓励员工按照现有的管理和技术双通道的发展模型来规划职业发展，鼓励员工设定短期/长期的职业目标，通过对发展所需要资质的强项/差距做自我评价以及和经理的资质面谈，促进员工资质的发展进而实现自我的发展。', NULL, '1', 0, '0', 1, '', '', '', 1435032635, '0'),
(39, 2, 0, 0, 0, '张三', NULL, 'images/product/142900278830364.jpg', NULL, '业务经理', '', '', 0, NULL, '<p>\r\n	客户至上\r\n</p>\r\n<p>\r\n	我们是最佳合作伙伴\r\n</p>\r\n<p>\r\n	我们尊重我们的员工，重视员工的发展规划\r\n</p>\r\n<p>\r\n	我们坚持以诚为本、以信立市，肩负社会责任感\r\n</p>\r\n<p>\r\n	我们信奉“简单、精细、快速\r\n</p>', NULL, '1', 0, '0', 1, '', '', '', 1429002788, '0'),
(40, 2, 0, 0, 0, '李四', NULL, 'images/product/142900388421746.jpg', NULL, '人事部经理', '', '', 0, NULL, '<p>\r\n	客户至上\r\n</p>\r\n<p>\r\n	我们是最佳合作伙伴\r\n</p>\r\n<p>\r\n	我们尊重我们的员工，重视员工的发展规划\r\n</p>\r\n<p>\r\n	我们坚持以诚为本、以信立市，肩负社会责任感\r\n</p>\r\n<p>\r\n	我们信奉“简单、精细、快速\r\n</p>', NULL, '1', 0, '0', 2, '', '', '', 1429003884, '0'),
(41, 2, 0, 0, 0, '陈五', NULL, 'images/product/142900397814501.jpg', NULL, '市场经理', '', '', 0, NULL, '<p>\r\n	客户至上\r\n</p>\r\n<p>\r\n	我们是最佳合作伙伴\r\n</p>\r\n<p>\r\n	我们尊重我们的员工，重视员工的发展规划\r\n</p>\r\n<p>\r\n	我们坚持以诚为本、以信立市，肩负社会责任感\r\n</p>\r\n<p>\r\n	我们信奉“简单、精细、快速\r\n</p>', NULL, '1', 0, '0', 3, '', '', '', 1429003978, '0'),
(42, 1, 1, 0, 0, '竞聘制度', NULL, '', NULL, '', '', '', 0, NULL, '为了保证员工在公司得到更大的发展空间，公司还推行中基层管理岗位的竞聘制度，鼓励员工通过竞聘的方式展示自己，多方面发展自己的工作能力。', NULL, '1', 0, '0', 2, '', '', '', 1435032854, '0'),
(47, 1, 3, 0, 0, '竞聘制度', NULL, '', NULL, '', '', '', 0, NULL, '为了保证员工在公司得到更大的发展空间，公司还推行中基层管理岗位的竞聘制度，鼓励员工通过竞聘的方式展示自己，多方面发展自己的工作能力。', NULL, '1', 0, '0', 2, '', '', '', 1435033301, '0'),
(52, 3, 0, 0, 0, '薪酬待遇', NULL, '', NULL, '', '', '', 0, NULL, '工资结构＝基本工资＋绩效工资＋加班费+其他福利收入\r\nAVA在每月10日准时发放当月工资\r\nAVA实行每周五天，每天8小时工作制（9：00----17：30）\r\nAVA在春节、五一、中秋等佳节时为AVA人提供不定期礼品', NULL, '1', 1, '0', 1, '', '', '', 1430186664, '0'),
(53, 3, 0, 0, 0, '社保公积金', NULL, '', NULL, '', '', '', 0, NULL, 'AVA拥有完善的社会保障体系，严格按照国家规定为每位员工缴纳五大社会保险（养老\\工伤\\医疗\\失业\\生育保险）', NULL, '1', 1, '0', 2, '', '', '', 1430186664, '0'),
(54, 3, 0, 0, 0, '休闲假期', NULL, '', NULL, '', '', '', 0, NULL, 'AVA人累计工作期限一年以上即可享受5--14天的带薪年休假，除此之外AVA人还可以享受婚假、产假、哺乳假，护理假、丧假等。', NULL, '1', 1, '0', 3, '', '', '', 1430186664, '0'),
(55, 3, 0, 0, 0, '营养午餐', NULL, '', NULL, '', '', '', 0, NULL, 'AVA关注员工的健康，全年订制韶关精选大米，来自于AVA农庄的瓜菜鸡鸭一应俱全，有机蔬菜和放心肉在地道的烹调下，别有一番风味，你还担心你的午餐不健康吗？', NULL, '1', 1, '0', 4, '', '', '', 1430186664, '0'),
(56, 3, 0, 0, 0, '定点班车', NULL, '', NULL, '', '', '', 0, NULL, 'AVA已开通两条线路的商务班车\r\n华师线：http://j.map.baidu.com/jbURt\r\n黄村线：http://j.map.baidu.com/wJWRt\r\n负责接送AVA人上下班', NULL, '1', 1, '0', 5, '', '', '', 1430186664, '0'),
(50, 2, 0, 0, 0, '亚明', NULL, 'images/product/142900388421746.jpg', NULL, '推销员', '', '', 0, NULL, '<p style="white-space:normal;">\r\n	客户至上\r\n</p>\r\n<p style="white-space:normal;">\r\n	我们是最佳合作伙伴\r\n</p>\r\n<p style="white-space:normal;">\r\n	我们尊重我们的员工，重视员工的发展规划\r\n</p>\r\n<p style="white-space:normal;">\r\n	我们坚持以诚为本、以信立市，肩负社会责任感\r\n</p>\r\n<p style="white-space:normal;">\r\n	我们信奉“简单、精细、快速\r\n</p>', NULL, '1', 0, '0', 4, '', '', '', 1430186664, '0');

-- --------------------------------------------------------

--
-- 表的结构 `ed_seo`
--

CREATE TABLE IF NOT EXISTS `ed_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webname` varchar(50) NOT NULL DEFAULT '',
  `seotitle` varchar(200) DEFAULT NULL,
  `en_seotitle` varchar(200) DEFAULT NULL,
  `seodesc` varchar(200) DEFAULT NULL,
  `en_seodesc` varchar(200) DEFAULT NULL,
  `seokey` varchar(200) DEFAULT NULL,
  `en_seokey` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 导出表中的数据 `ed_seo`
--

INSERT INTO `ed_seo` (`id`, `webname`, `seotitle`, `en_seotitle`, `seodesc`, `en_seodesc`, `seokey`, `en_seokey`) VALUES
(1, '首页', '首页', 'HOME', '奥威亚', 'Kin-LiYang,Light', '奥威亚', 'Kin-LiYang'),
(2, '关于我们', '关于我们', 'BUSINESS', '奥威亚,关于我们', 'Kin-LiYang,Light', '奥威亚,关于', 'BUSINESS'),
(5, '服务与支持', '服务与支持', 'CHAIN BUSINESS', '奥威亚，服务与支持', 'CHAIN BUSINESS,Business', '奥威亚，服务与支持', 'CHAIN BUSINESS'),
(3, '产品中心', '产品中心', 'TRAFFIC HUB', '奥威亚，产品中心', 'TRAFFIC HUB,Light', '奥威亚，产品中心', 'TRAFFIC HUB'),
(4, '应用解决方案', '应用解决方案', 'MUNICIPAL', '奥威亚，应用解决方案', 'MUNICIPAL,Puplic', '奥威亚，应用解决方案', 'MUNICIPAL'),
(6, '新闻中心', '新闻中心', 'PRODUCT', '奥威亚，公司新闻，行业新闻', 'PRODUCT,Seriess', '奥威亚，公司新闻，行业新闻', 'PRODUCT'),
(7, 'AVA大学', 'AVA大学', 'NEWS', '奥威亚，AVA大学', 'NEWS,ACTIVITIES,INDUSTRY', '奥威亚，AVA大学', 'NEWS,ACTIVITIES,INDUSTRY');

-- --------------------------------------------------------

--
-- 表的结构 `ed_spzxtype`
--

CREATE TABLE IF NOT EXISTS `ed_spzxtype` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `adv_postion` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(200) NOT NULL DEFAULT '',
  `adv_width` varchar(10) NOT NULL DEFAULT '',
  `adv_height` varchar(10) NOT NULL DEFAULT '',
  `content` varchar(255) NOT NULL DEFAULT '',
  `stor` tinyint(5) unsigned NOT NULL DEFAULT '99',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `ed_spzxtype`
--

INSERT INTO `ed_spzxtype` (`id`, `adv_postion`, `title`, `adv_width`, `adv_height`, `content`, `stor`) VALUES
(11, '首页视频', '首页视频', '510', '338', '', 1),
(12, '招聘视频', '招聘视频', '480', '317', '', 2);

-- --------------------------------------------------------

--
-- 表的结构 `ed_syhd`
--

CREATE TABLE IF NOT EXISTS `ed_syhd` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `big_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `small_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `three_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `catid` mediumint(8) unsigned DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `en_title` varchar(200) DEFAULT NULL,
  `pic` varchar(100) NOT NULL DEFAULT '',
  `alt` varchar(50) DEFAULT NULL,
  `author` varchar(50) NOT NULL DEFAULT '',
  `filefrom` varchar(100) NOT NULL DEFAULT '',
  `fileurl` varchar(200) NOT NULL DEFAULT '',
  `hit` mediumint(8) unsigned DEFAULT '0',
  `summary` text,
  `content` text NOT NULL,
  `hots` tinyint(1) unsigned DEFAULT NULL,
  `issue` char(1) DEFAULT '1',
  `isnew` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `istop` char(1) DEFAULT '0',
  `stor` mediumint(8) DEFAULT NULL,
  `seotitle` varchar(255) NOT NULL DEFAULT '',
  `seodesc` varchar(255) NOT NULL DEFAULT '',
  `seokey` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL,
  `ispic` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- 导出表中的数据 `ed_syhd`
--

INSERT INTO `ed_syhd` (`id`, `big_id`, `small_id`, `three_id`, `catid`, `title`, `en_title`, `pic`, `alt`, `author`, `filefrom`, `fileurl`, `hit`, `summary`, `content`, `hots`, `issue`, `isnew`, `istop`, `stor`, `seotitle`, `seodesc`, `seokey`, `addtime`, `ispic`) VALUES
(55, 0, 0, 0, 0, 'images/syhd/143531278311696.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531063727621.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 7, '', '', '', 1435312783, '0'),
(54, 0, 0, 0, 0, 'images/syhd/143531277715603.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531061621079.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 6, '', '', '', 1435312777, '0'),
(53, 0, 0, 0, 0, 'images/syhd/1437089064247223281.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们http://wlsx.eidea.net.cn/images/syhd/14353123006507.png的PK秘笈哦！', 'images/syhd/1437089065405363906.png', NULL, '', '', 'http://www.baidu.com', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 4, '', '', '', 1437089065, '0'),
(56, 0, 0, 0, 0, 'images/syhd/143531279017449.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531067316708.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 10, '', '', '', 1435312790, '0'),
(57, 0, 0, 0, 0, 'images/syhd/143531279613230.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/14353107154296.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 13, '', '', '', 1435312796, '0'),
(58, 0, 0, 0, 0, 'images/syhd/143531280213647.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531074219024.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 14, '', '', '', 1435312802, '0'),
(59, 0, 0, 0, 0, 'images/syhd/143531280929916.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531077713385.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 16, '', '', '', 1435312809, '0'),
(62, 0, 0, 0, 0, 'images/syhd/143531282914927.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531088512622.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 26, '', '', '', 1435312829, '0'),
(61, 0, 0, 0, 0, 'images/syhd/14353128157368.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531084012845.png', NULL, '', '', '', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '1', 0, '0', 20, '', '', '', 1435312815, '0'),
(63, 0, 0, 0, 0, 'images/syhd/143531282211438.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531101226298.png', NULL, '', '', '', 0, NULL, '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', NULL, '1', 0, '0', 25, '', '', '', 1435312822, '0'),
(64, 0, 0, 0, 0, 'images/syhd/143531283529295.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531102617250.png', NULL, '', '', '', 0, NULL, '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', NULL, '1', 0, '0', 27, '', '', '', 1435312835, '0'),
(65, 0, 0, 0, 0, 'images/syhd/143531284015228.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/1435311071297.png', NULL, '', '', '', 0, NULL, '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', NULL, '1', 0, '0', 28, '', '', '', 1435312840, '0'),
(66, 0, 0, 0, 0, 'images/syhd/143531284725927.png', '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', 'images/syhd/143531108518566.png', NULL, '', '', '', 0, NULL, '身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！', NULL, '1', 0, '0', 32, '', '', '', 1435312847, '0');

-- --------------------------------------------------------

--
-- 表的结构 `ed_wxgsz`
--

CREATE TABLE IF NOT EXISTS `ed_wxgsz` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `big_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `small_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `three_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `catid` mediumint(8) unsigned DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `en_title` varchar(200) DEFAULT NULL,
  `pic` varchar(100) NOT NULL DEFAULT '',
  `alt` varchar(50) DEFAULT NULL,
  `author` varchar(50) NOT NULL DEFAULT '',
  `filefrom` varchar(100) NOT NULL DEFAULT '',
  `fileurl` varchar(200) NOT NULL DEFAULT '',
  `hit` mediumint(8) unsigned DEFAULT '0',
  `summary` text,
  `content` text NOT NULL,
  `hots` tinyint(1) unsigned DEFAULT NULL,
  `issue` char(1) DEFAULT '1',
  `isnew` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `istop` char(1) DEFAULT '0',
  `stor` mediumint(8) DEFAULT NULL,
  `seotitle` varchar(255) NOT NULL DEFAULT '',
  `seodesc` varchar(255) NOT NULL DEFAULT '',
  `seokey` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL,
  `ispic` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- 导出表中的数据 `ed_wxgsz`
--

INSERT INTO `ed_wxgsz` (`id`, `big_id`, `small_id`, `three_id`, `catid`, `title`, `en_title`, `pic`, `alt`, `author`, `filefrom`, `fileurl`, `hit`, `summary`, `content`, `hots`, `issue`, `isnew`, `istop`, `stor`, `seotitle`, `seodesc`, `seokey`, `addtime`, `ispic`) VALUES
(5, 0, 0, 0, 0, 'images/wxgsz/143556632817754.png', '棋牌宫', 'images/syhd/143531063727621.png', NULL, '', '', 'http://www.qipaigong.com', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '0', 0, '0', 1, '', '', '', 1435716937, '0'),
(1, 0, 0, 0, 0, 'images/wxgsz/143556637032358.png', '互娱宫', 'images/syhd/143531061621079.png', NULL, '', '', 'http://www.huyugong.com', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '0', 0, '0', 2, '', '', '', 1435716948, '0'),
(2, 0, 0, 0, 0, 'images/wxgsz/14355663829099.png', '充提中心', 'images/syhd/143531041132726.png', NULL, '', '', 'http://www.chongzhizhongxin.com', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '0', 0, '0', 3, '', '', '', 1435716960, '0'),
(3, 0, 0, 0, 0, 'images/wxgsz/143556638911368.png', '竞赛宫', 'images/syhd/143531067316708.png', NULL, '', '', 'http://www.jingsaigong.com', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '0', 0, '0', 4, '', '', '', 1435716971, '0'),
(4, 0, 0, 0, 0, 'images/wxgsz/14355663955543.png', '娱乐宫', 'images/syhd/14353107154296.png', NULL, '', '', 'http://www.wulegong.com', 0, NULL, '第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡 第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。 第三阶：在论坛活动贴上传自己的游戏截图。 我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）', NULL, '0', 0, '0', 5, '', '', '', 1435716979, '0');

-- --------------------------------------------------------

--
-- 表的结构 `ed_wzjs`
--

CREATE TABLE IF NOT EXISTS `ed_wzjs` (
  `id` tinyint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` tinyint(5) unsigned NOT NULL DEFAULT '0',
  `media_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ad_name` varchar(100) NOT NULL DEFAULT '',
  `en_name` varchar(100) NOT NULL,
  `ad_url` varchar(100) NOT NULL DEFAULT '',
  `ad_code` varchar(200) NOT NULL DEFAULT '',
  `index_pic` varchar(200) NOT NULL,
  `ad_alt` varchar(200) DEFAULT NULL,
  `stor` tinyint(5) unsigned NOT NULL DEFAULT '0',
  `jianjie` text NOT NULL,
  `en_jianjie` text NOT NULL,
  `hd_index` tinyint(1) NOT NULL DEFAULT '0',
  `tj_index` tinyint(1) NOT NULL DEFAULT '0',
  `issue` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0',
  `hit` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `starttime` date NOT NULL DEFAULT '0000-00-00',
  `stoptime` date NOT NULL DEFAULT '0000-00-00',
  `bz_id` varchar(5) NOT NULL,
  `content` text NOT NULL,
  `en_content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- 导出表中的数据 `ed_wzjs`
--

INSERT INTO `ed_wzjs` (`id`, `catid`, `media_type`, `ad_name`, `en_name`, `ad_url`, `ad_code`, `index_pic`, `ad_alt`, `stor`, `jianjie`, `en_jianjie`, `hd_index`, `tj_index`, `issue`, `addtime`, `hit`, `starttime`, `stoptime`, `bz_id`, `content`, `en_content`) VALUES
(0, 0, 0, '', 'SDA DCSS FWEF', '', '', 'images/wzjs/14371424401798604108.png', '', 1, '', 'When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.', 0, 0, 0, 1437142440, 89, '0000-00-00', '0000-00-00', '', '', '<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<br />\r\n<p>\r\n	<br />\r\n</p>'),
(1, 0, 0, '', 'FGRSFERR', '', '', 'images/wzjs/14370887871638173868.png', '', 2, '', 'When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.', 0, 0, 0, 1437088787, 0, '0000-00-00', '0000-00-00', '', '', '<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;"><span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;"><span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span></span> \r\n</p>\r\n<p>\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;"><span style="font-size:14px;font-family:tahoma, arial, 宋体;white-space:normal;line-height:25px;background-color:#ffffff;"></span></span>\r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<p style="white-space:normal;">\r\n	<span style="font-size:14px;font-family:tahoma, arial, 宋体;line-height:25px;background-color:#ffffff;">When I was small, my mother told me that apple was good for my health, because it contained so many vitamins. Since then, I almost eat an apple a day, I fall in love with apple. The apple not only tastes sweet, but also makes my skin look good, there is a saying that once an apple a day, keeps the doctor away. It really happens to me.</span> \r\n</p>\r\n<br />\r\n<p>\r\n	<br />\r\n</p>'),
(2, 0, 0, '', '', '', '', 'images/wzjs/143555221310362.png', '', 3, '', '', 0, 0, 0, 1435552213, 0, '0000-00-00', '0000-00-00', '', '', ''),
(3, 0, 0, '', '', '', '', 'images/wzjs/14355522259921.png', '', 4, '', '', 0, 0, 0, 1435552225, 0, '0000-00-00', '0000-00-00', '', '', '');

INSERT INTO `@cmsprefix@models_field` VALUES
(null, '@modelid@', 'title', '标题', '', 'text', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";}', '1', '1'),
(null, '@modelid@', 'keywords', '关键词', '', 'text', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";}', '1', '2'),
(null, '@modelid@', 'tags', 'TAGS', '', 'text', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";}', '1', '3'),
(null, '@modelid@', 'description', '摘要', '', 'textarea', 'a:2:{s:6:\"height\";s:3:\"100\";s:12:\"defaultvalue\";s:0:\"\";}', '1', '4'),
(null, '@modelid@', 'thumb', '缩略图', '', 'image', 'a:1:{s:8:\"allowext\";s:15:\"gif|jpg|png|bmp\";}', '1', '5'),
(null, '@modelid@', 'username', '用户名', '', 'text', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";}', '1', '6'),
(null, '@modelid@', 'inputtime', '发布时间', '', 'datetime', 'a:1:{s:9:\"fieldtype\";s:8:\"datetime\";}', '1', '7'),
(null, '@modelid@', 'url', 'URL', '', 'text', 'a:2:{s:12:\"defaultvalue\";s:0:\"\";s:10:\"ispassword\";s:1:\"0\";}', '1', '8'),
(null, '@modelid@', 'status', '状态', '', 'box', 'a:4:{s:7:\"options\";s:27:\"审核通过|1\r\n待审核|0\";s:7:\"boxtype\";s:5:\"radio\";s:9:\"fieldtype\";s:3:\"int\";s:12:\"defaultvalue\";s:1:\"1\";}', '1', '9'),
(null, '@modelid@', 'views', '浏览量', '', 'number', 'a:1:{s:12:\"defaultvalue\";s:1:\"0\";}', '1', '10'),
(null, '@modelid@', 'listorder', '排序', '', 'number', 'a:1:{s:12:\"defaultvalue\";s:1:\"0\";}', '1', '11');
--
DROP TABLE IF EXISTS `@cmsprefix@@cmstablename@`;
--
CREATE TABLE `@cmsprefix@@cmstablename@` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `catid` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键词',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT 'TAGS',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `inputtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间',
  `url` varchar(100) NOT NULL DEFAULT '' COMMENT 'URL',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `listorder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

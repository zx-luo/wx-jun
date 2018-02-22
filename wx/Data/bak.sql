-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `haokuai_checkin`;
CREATE TABLE `haokuai_checkin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bonus` float NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 - 获得；2 - 提现。',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `param` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_fenxiao`;
CREATE TABLE `haokuai_fenxiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fjine1` int(11) DEFAULT NULL,
  `fjine2` int(11) DEFAULT NULL,
  `fjine3` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_fenxiao` (`id`, `fjine1`, `fjine2`, `fjine3`) VALUES
(1,	50,	50,	50);

DROP TABLE IF EXISTS `haokuai_hb`;
CREATE TABLE `haokuai_hb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hzhifue` int(11) DEFAULT NULL,
  `hminmoney` int(11) DEFAULT NULL,
  `hmaxmoney` int(11) DEFAULT NULL,
  `hgeshu` int(11) DEFAULT NULL,
  `hbianhua` int(11) DEFAULT NULL,
  `hlastbian` int(11) DEFAULT NULL,
  `hpaixu` int(11) DEFAULT NULL,
  `hb` varchar(300) NOT NULL DEFAULT '1',
  `hcode` int(2) NOT NULL DEFAULT '1',
  `htype` int(2) NOT NULL DEFAULT '1',
  `htime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hbianhua` (`hbianhua`),
  KEY `hcode` (`hcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_hb` (`id`, `hzhifue`, `hminmoney`, `hmaxmoney`, `hgeshu`, `hbianhua`, `hlastbian`, `hpaixu`, `hb`, `hcode`, `htype`, `htime`) VALUES
(1,	1500,	100,	26600,	15,	0,	1491898372,	0,	'16387,12215,24120,11434,5230,19768,336,2889,157,1402,7624,2120,289,1546,14684',	1,	1,	1490245245),
(2,	10000,	0,	0,	0,	0,	0,	0,	'1',	1,	2,	1490245300),
(3,	1000,	0,	0,	0,	0,	0,	0,	'1',	1,	3,	1490245540),
(4,	2000,	100,	38800,	15,	0,	1491889547,	0,	'2350,18324,256,24702,27845,1291,25568,4595,5734,32617,19091,198,365,5094,31472',	1,	1,	1490602402),
(5,	3000,	100,	56600,	15,	0,	1491853058,	0,	'51926,25012,22338,3362,52541,38243,39644,27993,238,34642,444,25841,3897,376,7868',	1,	1,	1490773039),
(6,	5000,	100,	68800,	15,	0,	1491723571,	0,	'538,42301,47172,137,60431,58438,21461,351,36045,7921,6568,31983,59463,6886,27649',	1,	1,	1490774331),
(7,	1000,	100,	9900,	15,	0,	1491896702,	1,	'8591,2145,1607,1524,143,3195,572,194,5363,9722,225,8530,2634,9835,579',	1,	1,	1490778808),
(8,	10000,	100,	99900,	15,	0,	1491908923,	0,	'62706,538,30301,30157,21479,97900,12570,991,56199,71463,67694,79228,1348,51704,13446',	1,	1,	1490778814);

DROP TABLE IF EXISTS `haokuai_hb_gailv`;
CREATE TABLE `haokuai_hb_gailv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hbid` int(11) DEFAULT NULL,
  `hmin` int(11) DEFAULT NULL,
  `hmax` int(11) DEFAULT NULL,
  `hgailv` int(11) DEFAULT NULL,
  `hjiaodu` int(11) DEFAULT NULL,
  `hcishu` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hbid` (`hbid`),
  KEY `hcishu` (`hcishu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_hb_gailv` (`id`, `hbid`, `hmin`, `hmax`, `hgailv`, `hjiaodu`, `hcishu`) VALUES
(40,	1,	100,	200,	200,	0,	0),
(41,	1,	200,	300,	60,	0,	0),
(42,	1,	300,	400,	30,	0,	0),
(43,	2,	1000,	2000,	600,	22,	1),
(44,	2,	500,	600,	1,	67,	2),
(45,	2,	1300,	3800,	1,	112,	3),
(46,	2,	1000,	2000,	1,	157,	0),
(47,	2,	1000,	3000,	1,	202,	0),
(48,	2,	2000,	5000,	1,	248,	0),
(49,	2,	3000,	6000,	1,	292,	0),
(50,	2,	4000,	8000,	1,	338,	0),
(51,	3,	500,	600,	0,	0,	1),
(52,	3,	100,	200,	300,	0,	0),
(53,	4,	100,	200,	200,	0,	0),
(54,	4,	200,	300,	90,	0,	0),
(55,	5,	100,	300,	200,	NULL,	0),
(56,	6,	100,	300,	200,	NULL,	0),
(57,	7,	100,	200,	200,	NULL,	0),
(58,	8,	500,	600,	200,	NULL,	0),
(59,	1,	1300,	1600,	10,	NULL,	6),
(60,	4,	300,	400,	70,	NULL,	0),
(61,	4,	2000,	3000,	0,	NULL,	2),
(62,	1,	2000,	2200,	8,	NULL,	3),
(72,	5,	300,	400,	90,	NULL,	0),
(73,	5,	400,	500,	60,	NULL,	0),
(74,	5,	3000,	3500,	0,	NULL,	2),
(75,	5,	3500,	4500,	0,	NULL,	8),
(80,	6,	300,	500,	90,	NULL,	0),
(81,	6,	500,	600,	70,	NULL,	0),
(82,	6,	6000,	7000,	0,	NULL,	2),
(83,	6,	6000,	7000,	0,	NULL,	10),
(89,	7,	500,	800,	100,	NULL,	3),
(90,	7,	1600,	2000,	0,	NULL,	9),
(125,	7,	2000,	2800,	0,	NULL,	15),
(98,	8,	800,	1000,	90,	NULL,	0),
(99,	8,	1000,	1500,	70,	NULL,	0),
(100,	8,	12000,	13000,	0,	NULL,	2),
(101,	8,	13000,	14000,	0,	NULL,	15),
(112,	3,	300,	400,	1,	NULL,	0),
(113,	3,	600,	700,	1,	NULL,	0),
(114,	3,	1000,	1200,	0,	NULL,	3);

DROP TABLE IF EXISTS `haokuai_invite_log`;
CREATE TABLE `haokuai_invite_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `task_id` int(11) NOT NULL,
  `invitee_id` int(11) NOT NULL,
  `yongjin_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_invite_log` (`id`, `user_id`, `type`, `task_id`, `invitee_id`, `yongjin_id`, `timestamp`, `memo`) VALUES
(8,	2,	's2s',	-1,	15,	-1,	'2017-03-27 18:58:43',	'0.038041351724815264');

DROP TABLE IF EXISTS `haokuai_news`;
CREATE TABLE `haokuai_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ncontent` text NOT NULL,
  `ntype` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ntype` (`ntype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_news` (`id`, `ncontent`, `ntype`) VALUES
(1,	'',	1),
(2,	'&lt;p&gt;&lt;img src=&quot;/Uploads/2017/04/1491652679313115.png&quot; title=&quot;1491652679313115.png&quot; alt=&quot;blob.png&quot;/&gt;&lt;/p&gt;',	2);

DROP TABLE IF EXISTS `haokuai_saolei_hbset`;
CREATE TABLE `haokuai_saolei_hbset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hbzhifu` int(11) DEFAULT NULL,
  `hgeshu` int(11) DEFAULT NULL,
  `hweiduo` int(11) DEFAULT NULL,
  `hweishao` int(11) DEFAULT NULL,
  `hpaixu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_saolei_hbset` (`id`, `hbzhifu`, `hgeshu`, `hweiduo`, `hweishao`, `hpaixu`) VALUES
(1,	1000,	5,	10,	10,	0),
(2,	2000,	4,	10,	10,	0),
(3,	3000,	5,	10,	10,	0),
(4,	5000,	6,	10,	10,	0),
(5,	8000,	7,	10,	10,	0),
(7,	10000,	12,	10,	10,	0);

DROP TABLE IF EXISTS `haokuai_saolei_linghb`;
CREATE TABLE `haokuai_saolei_linghb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `hblistid` int(11) DEFAULT NULL,
  `hbe` int(11) DEFAULT NULL,
  `hcode` int(2) NOT NULL DEFAULT '1',
  `ttime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hblistid` (`hblistid`),
  KEY `hcode` (`hcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_saolei_linghb` (`id`, `userid`, `hblistid`, `hbe`, `hcode`, `ttime`) VALUES
(1,	-1,	5,	146,	2,	1491658662),
(2,	-1,	10,	130,	2,	1491723457),
(3,	297,	6,	270,	2,	1491723467),
(4,	297,	7,	230,	2,	1491723474),
(5,	297,	8,	141,	2,	1491723478),
(6,	297,	9,	229,	2,	1491723485),
(7,	-1,	15,	249,	2,	1491746664),
(8,	-1,	20,	105,	2,	1491807940);

DROP TABLE IF EXISTS `haokuai_saolei_peifu`;
CREATE TABLE `haokuai_saolei_peifu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `fauserid` int(11) DEFAULT NULL,
  `hblistid` int(11) DEFAULT NULL,
  `hpeie` int(11) DEFAULT NULL,
  `ttime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hblistid` (`hblistid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_saolei_userfa`;
CREATE TABLE `haokuai_saolei_userfa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `hbid` int(11) DEFAULT NULL,
  `hzhifue` int(11) DEFAULT NULL,
  `hgeshu` int(11) DEFAULT NULL,
  `hweishu` int(2) DEFAULT NULL,
  `htime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hbid` (`hbid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_saolei_userfa` (`id`, `userid`, `hbid`, `hzhifue`, `hgeshu`, `hweishu`, `htime`) VALUES
(1,	146,	1,	1000,	5,	1,	1491658662),
(2,	297,	1,	1000,	5,	8,	1491723457),
(3,	353,	1,	1000,	5,	4,	1491746664),
(4,	76,	1,	1000,	5,	2,	1491807940);

DROP TABLE IF EXISTS `haokuai_saolei_userfalist`;
CREATE TABLE `haokuai_saolei_userfalist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faid` int(11) DEFAULT NULL,
  `hmoney` int(11) DEFAULT NULL,
  `hweishu` int(11) DEFAULT NULL,
  `hcode` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `faid` (`faid`),
  KEY `hcode` (`hcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_saolei_userfalist` (`id`, `faid`, `hmoney`, `hweishu`, `hcode`) VALUES
(1,	1,	363,	3,	2),
(2,	1,	183,	3,	2),
(3,	1,	151,	1,	2),
(4,	1,	157,	7,	2),
(5,	1,	146,	6,	2),
(6,	2,	270,	0,	2),
(7,	2,	230,	0,	2),
(8,	2,	141,	1,	2),
(9,	2,	229,	9,	2),
(10,	2,	130,	0,	2),
(11,	3,	204,	4,	2),
(12,	3,	161,	1,	2),
(13,	3,	248,	8,	2),
(14,	3,	138,	8,	2),
(15,	3,	249,	9,	2),
(16,	4,	292,	2,	2),
(17,	4,	291,	1,	2),
(18,	4,	152,	2,	2),
(19,	4,	160,	0,	2),
(20,	4,	105,	5,	2);

DROP TABLE IF EXISTS `haokuai_sys_config`;
CREATE TABLE `haokuai_sys_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cduanlianjie` int(2) NOT NULL DEFAULT '1',
  `ctongzhi` varchar(500) NOT NULL DEFAULT '1',
  `cwxchoutxt` varchar(500) NOT NULL DEFAULT '1',
  `cbeicode` int(2) NOT NULL DEFAULT '2',
  `cbeipay` int(11) DEFAULT '1',
  `cbeimchid` varchar(50) DEFAULT '1',
  `cbeiappkey` varchar(50) DEFAULT '1',
  `cbeiurl` varchar(150) DEFAULT '1',
  `cbeiappid` varchar(50) DEFAULT '1',
  `cbeiappsecret` varchar(50) DEFAULT '1',
  `cwxappid` varchar(50) NOT NULL DEFAULT '1',
  `cwxappsecret` varchar(50) NOT NULL DEFAULT '1',
  `cwxappkey` varchar(40) NOT NULL DEFAULT '1',
  `cwxmchid` varchar(30) NOT NULL DEFAULT '1',
  `ckouliang` int(3) DEFAULT NULL,
  `cyongjinfa` int(2) NOT NULL DEFAULT '1',
  `cyongjine` int(11) DEFAULT NULL,
  `cdenglucode` int(3) NOT NULL DEFAULT '1',
  `cdailishengji` int(2) NOT NULL DEFAULT '1',
  `cdailicode` int(2) NOT NULL DEFAULT '1',
  `cmaurl` varchar(150) NOT NULL DEFAULT '1',
  `cfaurl` varchar(150) NOT NULL DEFAULT '1',
  `cpingbie` int(11) DEFAULT NULL,
  `cchongzong` int(11) DEFAULT NULL,
  `cgundong` int(4) NOT NULL DEFAULT '1',
  `adminid` int(11) DEFAULT NULL,
  `sitetitle` varchar(150) DEFAULT NULL,
  `checkin_mode` text NOT NULL COMMENT '0 - 不开启；1 - 固定模式；2 - 递增模式',
  `task2_descr` text NOT NULL,
  `share_title` text NOT NULL,
  `share_descr` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_sys_config` (`id`, `cduanlianjie`, `ctongzhi`, `cwxchoutxt`, `cbeicode`, `cbeipay`, `cbeimchid`, `cbeiappkey`, `cbeiurl`, `cbeiappid`, `cbeiappsecret`, `cwxappid`, `cwxappsecret`, `cwxappkey`, `cwxmchid`, `ckouliang`, `cyongjinfa`, `cyongjine`, `cdenglucode`, `cdailishengji`, `cdailicode`, `cmaurl`, `cfaurl`, `cpingbie`, `cchongzong`, `cgundong`, `adminid`, `sitetitle`, `checkin_mode`, `task2_descr`, `share_title`, `share_descr`) VALUES
(1,	1,	'点“我”充值，充200送80 充500送200普【每天凌晨两点统一结算佣金点提现即可入账】',	'biaobiao 10元拆出67元红包, L-lin 100元拆出523元红包, 阿俊 10元拆出68元红包,A大表哥 100元拆出213元红包,军创科技 50元拆出82元红包,爱人知己 10元拆出34元红包,宝宝京 10元拆出48元红包,月下独酌 20元拆出56元红包,李蛋 100元拆出386元红包,BOSS 10元拆出33元红包,不完美 50元拆出189元红包,曹 10元拆出30元红包,valent °10元拆出34元红包,记忆、深处。10元拆出32红包,噯情佷徦 20元拆出43,姐的霸气够气质i 100元拆出383元红包,我来啦 50元拆出98元红包, 刺眼的白 20元拆出54红包,曾经心痛 20元拆出36元红包,貓怨 10元拆出32元红包,微风里暖到心の光 10元拆出24元红包,鎏咣異彩  50元拆出72元红包,巴黎下的小情绪° 30元拆出72元红包,友谊碎片 100元拆出162元红包,冬寂。 10元拆出25元红包,无敌小金刚 10元拆出45元红包,e幸福地圖 20元拆出80元红包,七级床震 20元拆出99元红包,日光独自倾城 100元拆出141元红包,',	2,	1,	'',	'',	'',	'',	'',	'',	'',	'',	'',	4,	1,	100,	2,	1,	2,	'http://www.baidu.com',	'http://www.baidu.com',	100000,	10000000,	2,	1,	'全民娱乐大系统',	'0|0.1|0.2|3|2',	'分享到朋友圈成为代理返佣赚钱',	'我刚刚拆出了186元红包',	'快来一起全民拆红包');

DROP TABLE IF EXISTS `haokuai_sys_log`;
CREATE TABLE `haokuai_sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lbiaoshi` varchar(50) NOT NULL DEFAULT '1',
  `lcon` text,
  `ltime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_sys_maset`;
CREATE TABLE `haokuai_sys_maset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mleft` int(11) DEFAULT NULL,
  `mtop` int(11) DEFAULT NULL,
  `msize` int(11) NOT NULL DEFAULT '5',
  `midcolor` varchar(50) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_sys_maset` (`id`, `mleft`, `mtop`, `msize`, `midcolor`) VALUES
(1,	175,	300,	8,	'#FFFFFF');

DROP TABLE IF EXISTS `haokuai_sys_user`;
CREATE TABLE `haokuai_sys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL,
  `upass` varchar(50) NOT NULL DEFAULT '1',
  `tran_upass` varchar(50) DEFAULT NULL,
  `utype` int(2) NOT NULL DEFAULT '1',
  `utime` int(11) DEFAULT NULL,
  `permission` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_user_chongzhi`;
CREATE TABLE `haokuai_user_chongzhi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `ddanhao` varchar(50) NOT NULL DEFAULT '1',
  `djine` int(11) DEFAULT NULL,
  `dutid` int(11) DEFAULT NULL,
  `dcode` int(3) NOT NULL DEFAULT '1',
  `djisuan` int(2) NOT NULL DEFAULT '1',
  `dtime` int(11) DEFAULT NULL,
  `extra_money` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ddanhao` (`ddanhao`),
  KEY `userid` (`userid`),
  KEY `dcode` (`dcode`),
  KEY `dtime` (`dtime`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;


DROP TABLE IF EXISTS `haokuai_user_duizhang`;
CREATE TABLE `haokuai_user_duizhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `paynum` int(11) DEFAULT NULL,
  `wxnum` int(11) DEFAULT NULL,
  `dcode` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_user_hb`;
CREATE TABLE `haokuai_user_hb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `hbid` int(11) DEFAULT NULL,
  `hbe` int(11) DEFAULT NULL,
  `tcode` int(2) NOT NULL DEFAULT '1',
  `ttime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hbid` (`hbid`),
  KEY `tcode` (`tcode`),
  KEY `ttime` (`ttime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_user_list`;
CREATE TABLE `haokuai_user_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utid` int(11) DEFAULT NULL,
  `uopenid` varchar(50) NOT NULL DEFAULT '1',
  `ubeiopenid` varchar(50) DEFAULT '1',
  `uickname` varchar(80) DEFAULT '1',
  `uheadimgurl` varchar(160) DEFAULT '1',
  `usex` int(2) DEFAULT NULL,
  `udizhi` varchar(40) DEFAULT '1',
  `uvip` int(5) DEFAULT NULL,
  `uhbcon` varchar(300) NOT NULL DEFAULT '1',
  `ufacishu` int(5) DEFAULT NULL,
  `ugengxin` int(11) DEFAULT NULL,
  `ustate` int(11) NOT NULL DEFAULT '1',
  `ulogintime` int(11) DEFAULT NULL,
  `uregtime` int(11) DEFAULT NULL,
  `wxsubsc_counter` int(11) DEFAULT NULL,
  `share_counter` int(11) DEFAULT NULL,
  `share_counter_used` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utid` (`utid`),
  KEY `uopenid` (`uopenid`),
  KEY `uvip` (`uvip`),
  KEY `ubeiopenid` (`ubeiopenid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_user_tixian`;
CREATE TABLE `haokuai_user_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `tixiane` int(11) DEFAULT NULL,
  `ttime` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tixiane` (`tixiane`),
  KEY `userid` (`userid`),
  KEY `ttime` (`ttime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_user_wxexcel`;
CREATE TABLE `haokuai_user_wxexcel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `uopenid` varchar(50) DEFAULT '1',
  `wxdanhao` varchar(50) DEFAULT '1',
  `wxjine` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `uopenid` (`uopenid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_user_yongjin`;
CREATE TABLE `haokuai_user_yongjin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `uchong` int(11) DEFAULT NULL,
  `tixiane` int(11) DEFAULT NULL,
  `tcode` int(2) NOT NULL DEFAULT '1',
  `tjisuan` int(2) NOT NULL DEFAULT '1',
  `ttime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `tcode` (`tcode`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;


DROP TABLE IF EXISTS `haokuai_user_zhanghu`;
CREATE TABLE `haokuai_user_zhanghu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `uhbqian` int(11) DEFAULT NULL,
  `uqianzheng` int(11) DEFAULT NULL,
  `uqianfa` int(11) DEFAULT NULL,
  `uzhengzong` int(11) DEFAULT NULL,
  `uqianchong` int(11) DEFAULT NULL,
  `uchongzong` int(11) DEFAULT NULL,
  `ucheckin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `uqianchong` (`uqianzheng`),
  KEY `uchongzong` (`uchongzong`),
  KEY `uzhengzong` (`uzhengzong`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_weixin_caidan`;
CREATE TABLE `haokuai_weixin_caidan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `cname` varchar(50) NOT NULL DEFAULT '1',
  `ckey` varchar(50) NOT NULL DEFAULT '1',
  `curl` varchar(150) NOT NULL DEFAULT '1',
  `ctype` int(11) DEFAULT NULL,
  `cnum` int(2) NOT NULL DEFAULT '1',
  `adminid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_weixin_mobanid`;
CREATE TABLE `haokuai_weixin_mobanid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mbianhao` varchar(150) NOT NULL DEFAULT '1',
  `mid` varchar(150) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_weixin_sendcon`;
CREATE TABLE `haokuai_weixin_sendcon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kid` int(11) DEFAULT NULL,
  `sname` varchar(100) NOT NULL DEFAULT '1',
  `sdec` varchar(500) NOT NULL DEFAULT '1',
  `spic` varchar(50) NOT NULL DEFAULT '1',
  `surl` varchar(150) NOT NULL DEFAULT '1',
  `snum` int(2) NOT NULL DEFAULT '1',
  `stime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_weixin_sendkey`;
CREATE TABLE `haokuai_weixin_sendkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) DEFAULT NULL,
  `sname` varchar(100) NOT NULL DEFAULT '1',
  `stype` int(2) NOT NULL DEFAULT '1',
  `kcode` int(2) NOT NULL DEFAULT '1',
  `stime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `haokuai_yongjin_set`;
CREATE TABLE `haokuai_yongjin_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ydengji` int(11) DEFAULT NULL,
  `ybaifenbi` int(11) DEFAULT NULL,
  `yjine` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ydengji` (`ydengji`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `haokuai_yongjin_set` (`id`, `ydengji`, `ybaifenbi`, `yjine`) VALUES
(1,	1,	5,	20000),
(2,	2,	8,	500000),
(3,	3,	10,	5000000);

-- 2017-04-11 11:38:43

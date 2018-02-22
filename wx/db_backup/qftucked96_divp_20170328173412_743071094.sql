/* This file is created by MySQLReback 2017-03-28 17:34:12 */
 /* 创建表结构 `haokuai_checkin`  */
 DROP TABLE IF EXISTS `haokuai_checkin`;/* MySQLReback Separation */ CREATE TABLE `haokuai_checkin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bonus` float NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 - 获得；2 - 提现。',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `param` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_checkin` */
 INSERT INTO `haokuai_checkin` VALUES ('1','1','0.1','1','2017-03-26 23:24:28',null),('2','1','0.3','1','2017-03-27 05:32:10',null),('3','2','0.1','1','2017-03-27 16:55:09',null),('4','3','0.1','1','2017-03-27 20:27:23',null),('5','1','0.5','1','2017-03-28 00:43:16',null),('6','2','0.3','1','2017-03-28 01:27:01',null);/* MySQLReback Separation */
 /* 创建表结构 `haokuai_fenxiao`  */
 DROP TABLE IF EXISTS `haokuai_fenxiao`;/* MySQLReback Separation */ CREATE TABLE `haokuai_fenxiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fjine1` int(11) NOT NULL DEFAULT '0',
  `fjine2` int(11) NOT NULL DEFAULT '0',
  `fjine3` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_fenxiao` */
 INSERT INTO `haokuai_fenxiao` VALUES ('1','100','200','300');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_hb`  */
 DROP TABLE IF EXISTS `haokuai_hb`;/* MySQLReback Separation */ CREATE TABLE `haokuai_hb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hzhifue` int(11) NOT NULL DEFAULT '0',
  `hminmoney` int(11) NOT NULL DEFAULT '0',
  `hmaxmoney` int(11) NOT NULL DEFAULT '0',
  `hgeshu` int(11) NOT NULL DEFAULT '0',
  `hbianhua` int(11) NOT NULL DEFAULT '0',
  `hlastbian` int(11) NOT NULL DEFAULT '0',
  `hpaixu` int(11) NOT NULL DEFAULT '0',
  `hb` varchar(300) NOT NULL DEFAULT '1',
  `hcode` int(2) NOT NULL DEFAULT '1',
  `htype` int(2) NOT NULL DEFAULT '1',
  `htime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `hbianhua` (`hbianhua`),
  KEY `hcode` (`hcode`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_hb` */
 INSERT INTO `haokuai_hb` VALUES ('1','1000','100','900','5','0','1490603260','0','352,678,176,421,209','1','1','1490245245'),('2','600','0','0','0','0','0','0','1','1','2','1490245300'),('3','600','0','0','0','0','0','0','1','1','3','1490245540'),('4','2000','100','3000','10','0','0','0','1','1','1','1490602402');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_hb_gailv`  */
 DROP TABLE IF EXISTS `haokuai_hb_gailv`;/* MySQLReback Separation */ CREATE TABLE `haokuai_hb_gailv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hbid` int(11) NOT NULL DEFAULT '0',
  `hmin` int(11) NOT NULL DEFAULT '0',
  `hmax` int(11) NOT NULL DEFAULT '0',
  `hgailv` int(11) NOT NULL DEFAULT '0',
  `hjiaodu` int(11) NOT NULL DEFAULT '0',
  `hcishu` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `hbid` (`hbid`),
  KEY `hcishu` (`hcishu`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_hb_gailv` */
 INSERT INTO `haokuai_hb_gailv` VALUES ('40','1','100','200','70','0','0'),('41','1','200','300','10','0','0'),('42','1','300','400','20','0','1'),('43','2','400','500','10','22','0'),('44','2','100','200','20','67','0'),('45','2','200','300','10','112','0'),('46','2','300','400','10','157','0'),('47','2','100','200','20','202','0'),('48','2','200','300','10','248','0'),('49','2','300','400','10','292','0'),('50','2','400','500','10','338','0'),('51','3','100','200','80','0','0'),('52','3','200','300','20','0','0'),('53','4','1500','1800','80','0','1'),('54','4','1000','1500','20','0','0');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_invite_log`  */
 DROP TABLE IF EXISTS `haokuai_invite_log`;/* MySQLReback Separation */ CREATE TABLE `haokuai_invite_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `task_id` int(11) NOT NULL,
  `invitee_id` int(11) NOT NULL,
  `yongjin_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_invite_log` */
 INSERT INTO `haokuai_invite_log` VALUES ('8','2','s2s','-1','15','-1','2017-03-28 02:58:43','0.038041351724815264');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_news`  */
 DROP TABLE IF EXISTS `haokuai_news`;/* MySQLReback Separation */ CREATE TABLE `haokuai_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ncontent` text NOT NULL,
  `ntype` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ntype` (`ntype`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_news` */
 INSERT INTO `haokuai_news` VALUES ('1','&lt;p&gt;添加客服微信号，购买源码，请备注购买程序。&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/Uploads/2017/03/1490197066462574.jpg&quot; title=&quot;1490197066462574.jpg&quot; alt=&quot;67091089437979335.jpg&quot; width=&quot;269&quot; height=&quot;279&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;','1'),('2','&lt;p&gt;本平台支持双佣金，拉新和会员充值均可以获得奖励。&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1484011440423002.jpg&quot; alt=&quot;33666.jpg&quot; src=&quot;/Uploads/2017/01/1484011440423002.jpg&quot;/&gt;&lt;/p&gt;','2');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_saolei_hbset`  */
 DROP TABLE IF EXISTS `haokuai_saolei_hbset`;/* MySQLReback Separation */ CREATE TABLE `haokuai_saolei_hbset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hbzhifu` int(11) NOT NULL DEFAULT '0',
  `hgeshu` int(11) NOT NULL DEFAULT '0',
  `hweiduo` int(11) NOT NULL DEFAULT '0',
  `hweishao` int(11) NOT NULL DEFAULT '0',
  `hpaixu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_saolei_hbset` */
 INSERT INTO `haokuai_saolei_hbset` VALUES ('1','1000','5','10','10','0'),('2','2000','4','10','10','0'),('3','3000','5','10','10','0'),('4','5000','6','10','10','0'),('5','8000','7','10','10','0'),('7','10000','12','10','10','0');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_saolei_linghb`  */
 DROP TABLE IF EXISTS `haokuai_saolei_linghb`;/* MySQLReback Separation */ CREATE TABLE `haokuai_saolei_linghb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `hblistid` int(11) NOT NULL DEFAULT '0',
  `hbe` int(11) NOT NULL DEFAULT '0',
  `hcode` int(2) NOT NULL DEFAULT '1',
  `ttime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hblistid` (`hblistid`),
  KEY `hcode` (`hcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_saolei_peifu`  */
 DROP TABLE IF EXISTS `haokuai_saolei_peifu`;/* MySQLReback Separation */ CREATE TABLE `haokuai_saolei_peifu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `fauserid` int(11) NOT NULL DEFAULT '0',
  `hblistid` int(11) NOT NULL DEFAULT '0',
  `hpeie` int(11) NOT NULL DEFAULT '0',
  `ttime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hblistid` (`hblistid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_saolei_userfa`  */
 DROP TABLE IF EXISTS `haokuai_saolei_userfa`;/* MySQLReback Separation */ CREATE TABLE `haokuai_saolei_userfa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `hbid` int(11) NOT NULL DEFAULT '0',
  `hzhifue` int(11) NOT NULL DEFAULT '0',
  `hgeshu` int(11) NOT NULL DEFAULT '0',
  `hweishu` int(2) NOT NULL DEFAULT '0',
  `htime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hbid` (`hbid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_saolei_userfalist`  */
 DROP TABLE IF EXISTS `haokuai_saolei_userfalist`;/* MySQLReback Separation */ CREATE TABLE `haokuai_saolei_userfalist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faid` int(11) NOT NULL DEFAULT '0',
  `hmoney` int(11) NOT NULL DEFAULT '0',
  `hweishu` int(11) NOT NULL DEFAULT '0',
  `hcode` int(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `faid` (`faid`),
  KEY `hcode` (`hcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_sys_config`  */
 DROP TABLE IF EXISTS `haokuai_sys_config`;/* MySQLReback Separation */ CREATE TABLE `haokuai_sys_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cduanlianjie` int(2) NOT NULL DEFAULT '1',
  `ctongzhi` varchar(500) NOT NULL DEFAULT '1',
  `cwxchoutxt` varchar(500) NOT NULL DEFAULT '1',
  `cbeicode` int(2) NOT NULL DEFAULT '2',
  `cbeipay` int(11) NOT NULL DEFAULT '1',
  `cbeimchid` varchar(50) DEFAULT '1',
  `cbeiappkey` varchar(50) DEFAULT '1',
  `cbeiurl` varchar(150) NOT NULL DEFAULT '1',
  `cbeiappid` varchar(50) NOT NULL DEFAULT '1',
  `cbeiappsecret` varchar(50) NOT NULL DEFAULT '1',
  `cwxappid` varchar(50) NOT NULL DEFAULT '1',
  `cwxappsecret` varchar(50) NOT NULL DEFAULT '1',
  `cwxappkey` varchar(40) NOT NULL DEFAULT '1',
  `cwxmchid` varchar(30) NOT NULL DEFAULT '1',
  `ckouliang` int(3) NOT NULL DEFAULT '0',
  `cyongjinfa` int(2) NOT NULL DEFAULT '1',
  `cyongjine` int(11) NOT NULL DEFAULT '0',
  `cdenglucode` int(3) NOT NULL DEFAULT '1',
  `cdailishengji` int(2) NOT NULL DEFAULT '1',
  `cdailicode` int(2) NOT NULL DEFAULT '1',
  `cmaurl` varchar(150) NOT NULL DEFAULT '1',
  `cfaurl` varchar(150) NOT NULL DEFAULT '1',
  `cpingbie` int(11) NOT NULL DEFAULT '0',
  `cchongzong` int(11) NOT NULL DEFAULT '0',
  `cgundong` int(4) NOT NULL DEFAULT '1',
  `adminid` int(11) NOT NULL DEFAULT '0',
  `sitetitle` varchar(150) DEFAULT NULL,
  `checkin_mode` text NOT NULL COMMENT '0 - 不开启；1 - 固定模式；2 - 递增模式',
  `task2_descr` text NOT NULL,
  `share_title` text NOT NULL,
  `share_descr` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_sys_config` */
 INSERT INTO `haokuai_sys_config` VALUES ('1','2','演示站点，请勿充值，购买请联系palmyun2013','本站仅供测试,请勿实际充值,源码购买联系微信palmyun2013','2','1',null,null,null,null,null,'wx2dced9ac32e5867c','f98e4d441497038bd7e83a32b39f331f','a898741af700e21ea114a10ae29eb6ae','1452066502','0','2','2000','2','1','2','http://1.zhangshangweixin.com','http://1.zhangshangweixin.com','50000','1000','2','1','2017全新起航','1|0.1|0.2|3|0.1','分享到朋友圈赚佣金','早起的鸟儿有红包拆','快来一起拆红包');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_sys_log`  */
 DROP TABLE IF EXISTS `haokuai_sys_log`;/* MySQLReback Separation */ CREATE TABLE `haokuai_sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lbiaoshi` varchar(50) NOT NULL DEFAULT '1',
  `lcon` text,
  `ltime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_sys_maset`  */
 DROP TABLE IF EXISTS `haokuai_sys_maset`;/* MySQLReback Separation */ CREATE TABLE `haokuai_sys_maset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mleft` int(11) NOT NULL DEFAULT '0',
  `mtop` int(11) NOT NULL DEFAULT '0',
  `msize` int(11) NOT NULL DEFAULT '5',
  `midcolor` varchar(50) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_sys_maset` */
 INSERT INTO `haokuai_sys_maset` VALUES ('1','140','260','5','#FFFFFF');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_sys_user`  */
 DROP TABLE IF EXISTS `haokuai_sys_user`;/* MySQLReback Separation */ CREATE TABLE `haokuai_sys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(20) NOT NULL,
  `upass` varchar(50) NOT NULL DEFAULT '1',
  `tran_upass` varchar(50) DEFAULT NULL,
  `utype` int(2) NOT NULL DEFAULT '1',
  `utime` int(11) NOT NULL DEFAULT '0',
  `permission` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_sys_user` */
 INSERT INTO `haokuai_sys_user` VALUES ('1','admin','2313b30a0543ac329858594c59d010b9','2313b30a0543ac329858594c59d010b9','1','1490681255',null);/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_chongzhi`  */
 DROP TABLE IF EXISTS `haokuai_user_chongzhi`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_chongzhi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `ddanhao` varchar(50) NOT NULL DEFAULT '1',
  `djine` int(11) NOT NULL DEFAULT '0',
  `dutid` int(11) NOT NULL DEFAULT '0',
  `dcode` int(3) NOT NULL DEFAULT '1',
  `djisuan` int(2) NOT NULL DEFAULT '1',
  `dtime` int(11) NOT NULL DEFAULT '0',
  `extra_money` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ddanhao` (`ddanhao`),
  KEY `userid` (`userid`),
  KEY `dcode` (`dcode`),
  KEY `dtime` (`dtime`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=gbk;/* MySQLReback Separation */
 /* 插入数据 `haokuai_user_chongzhi` */
 INSERT INTO `haokuai_user_chongzhi` VALUES ('1','1','10020170326230212','500','0','2','2','1490540532','0'),('2','1','20170326230212257047','1000','0','1','1','1490540532','0'),('3','1','20170326230219984382','1000','0','1','1','1490540539','0'),('4','1','20170326232408856874','1000','0','1','1','1490541848','0'),('5','1','20170326232414486278','1000','0','1','1','1490541854','0'),('6','1','20170326232449968801','600','0','1','1','1490541889','0'),('7','1','20170326232507868949','1000','0','2','2','1490541907','0'),('8','1','20170326232519858751','1000','0','1','1','1490541919','0'),('9','1','20170327053123402175','1000','0','1','1','1490563883','0'),('10','1','20170327053127161129','1000','0','1','1','1490563887','0'),('11','1','20170327084259198642','1000','0','1','1','1490575379','0'),('12','1','20170327084818582481','1000','0','1','1','1490575698','0'),('13','1','20170327084917410692','600','0','1','1','1490575757','0'),('14','1','20170327084917535245','600','0','1','1','1490575757','0'),('15','1','20170327084918400307','600','0','1','1','1490575758','0'),('16','1','20170327084918675925','600','0','1','1','1490575758','0'),('17','2','10020170327142216','500','0','2','2','1490595736','0'),('18','2','20170327142217307196','1000','0','1','1','1490595737','0'),('19','2','20170327142226534060','1000','0','1','1','1490595746','0'),('20','2','20170327142234666306','600','0','1','1','1490595754','0'),('21','2','20170327142302433263','1000','0','1','1','1490595782','0'),('22','2','20170327142325508974','600','0','1','1','1490595805','0'),('23','2','20170327142452331095','1000','0','1','1','1490595892','0'),('24','2','20170327142755621707','1000','0','1','1','1490596075','0'),('25','2','20170327145137771204','1000','0','1','1','1490597497','0'),('26','2','20170327145143121793','600','0','1','1','1490597503','0'),('27','2','20170327145147630915','1000','0','1','1','1490597507','0'),('28','2','20170327154447926369','1000','0','1','1','1490600687','0'),('29','2','20170327154522861185','600','0','1','1','1490600722','0'),('30','2','20170327154524913372','600','0','1','1','1490600724','0'),('31','2','20170327154527865135','1000','0','1','1','1490600727','0'),('32','2','20170327154533788359','1000','0','1','1','1490600733','0'),('33','2','20170327154740254398','600','0','1','1','1490600860','0'),('34','2','20170327154745496102','1000','0','1','1','1490600865','0'),('35','1','20170327160510526272','1000','0','1','1','1490601910','0'),('36','1','20170327160537357264','1000','0','1','1','1490601937','0'),('37','1','20170327160549100615','1000','0','1','1','1490601949','0'),('38','1','20170327160552621935','1000','0','1','1','1490601952','0'),('39','1','20170327162730578542','1000','0','2','2','1490603250','0'),('40','2','20170327165523408553','600','0','1','1','1490604923','0'),('41','3','10020170327202711','500','0','2','2','1490617631','0'),('42','2','20170327234540106081','600','0','1','1','1490629540','0'),('43','2','20170327234550130434','600','0','1','1','1490629550','0'),('44','1','20170328004344396013','1000','0','1','1','1490633024','0'),('45','2','20170328004516328335','600','0','1','1','1490633116','0'),('46','4','10020170328012737','500','0','2','2','1490635657','0'),('47','5','10020170328012920','500','0','2','2','1490635760','0'),('48','6','10020170328013047','500','0','2','2','1490635847','0'),('49','7','10020170328013914','500','0','2','2','1490636354','0'),('50','8','10020170328014037','500','0','2','2','1490636437','0'),('51','9','10020170328014959','500','0','2','2','1490636999','0'),('52','10','10020170328015104','500','0','2','2','1490637064','0'),('53','11','10020170328022814','500','0','2','2','1490639294','0'),('54','12','10020170328025625','500','0','2','2','1490640985','0'),('55','13','10020170328025657','500','0','2','2','1490641017','0'),('56','14','10020170328025803','500','0','2','2','1490641083','0'),('57','15','10020170328025843','500','0','2','2','1490641123','0'),('58','15','20170328025857164695','2000','0','1','1','1490641137','0'),('59','15','20170328025857990539','2000','0','1','1','1490641137','0'),('60','15','20170328025857810755','2000','0','1','1','1490641137','0'),('61','16','10020170328170801','500','0','2','2','1490692081','0');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_duizhang`  */
 DROP TABLE IF EXISTS `haokuai_user_duizhang`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_duizhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `paynum` int(11) NOT NULL DEFAULT '0',
  `wxnum` int(11) NOT NULL DEFAULT '0',
  `dcode` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_hb`  */
 DROP TABLE IF EXISTS `haokuai_user_hb`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_hb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `hbid` int(11) NOT NULL DEFAULT '0',
  `hbe` int(11) NOT NULL DEFAULT '0',
  `tcode` int(2) NOT NULL DEFAULT '1',
  `ttime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `hbid` (`hbid`),
  KEY `tcode` (`tcode`),
  KEY `ttime` (`ttime`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_user_hb` */
 INSERT INTO `haokuai_user_hb` VALUES ('1','1','3','104','2','1490575738'),('2','1','1','352','2','1490603263');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_list`  */
 DROP TABLE IF EXISTS `haokuai_user_list`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utid` int(11) NOT NULL DEFAULT '0',
  `uopenid` varchar(50) NOT NULL DEFAULT '1',
  `ubeiopenid` varchar(50) DEFAULT '1',
  `uickname` varchar(80) DEFAULT '1',
  `uheadimgurl` varchar(160) DEFAULT '1',
  `usex` int(2) NOT NULL DEFAULT '0',
  `udizhi` varchar(40) DEFAULT '1',
  `uvip` int(5) NOT NULL DEFAULT '0',
  `uhbcon` varchar(300) NOT NULL DEFAULT '1',
  `ufacishu` int(5) NOT NULL DEFAULT '0',
  `ugengxin` int(11) NOT NULL DEFAULT '0',
  `ustate` int(11) NOT NULL DEFAULT '1',
  `ulogintime` int(11) NOT NULL DEFAULT '0',
  `uregtime` int(11) NOT NULL DEFAULT '0',
  `wxsubsc_counter` int(11) NOT NULL DEFAULT '0',
  `share_counter` int(11) NOT NULL DEFAULT '0',
  `share_counter_used` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `utid` (`utid`),
  KEY `uopenid` (`uopenid`),
  KEY `uvip` (`uvip`),
  KEY `ubeiopenid` (`ubeiopenid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_user_list` */
 INSERT INTO `haokuai_user_list` VALUES ('1','0','owvoZ1qzrr2Rto4LnTkSOakVt0jU','oTxONvzsapCMLhno6jzv6XPKvM5k','Mr.孙','http://wx.qlogo.cn/mmopen/8Lm51VhXtHgKkfhjzDWCjoM9Le5hNSSTPBeZVCZ2hib9Xz6LsPt9Yibo1zjB8FF5lRkRyScGVOHmfhVPHaz59MObZHKrcgZBNh/0','1',null,'1','352,678,176,421,209','0','1490630466','1','1490540532','1490540532','2','0','0'),('2','0','owvoZ1onAuNDkP5KqliSWeuUyB7c','oTxONv7jqyljuvjcaKSpiD9m7Vkg','霍霍霍东东','http://wx.qlogo.cn/mmopen/ajNVdqHZLLDbRPMC1AnNxibLkJfeX1gQ5qBNicicbsBmZXptT9HEGPBRh9ZLfbCxcEVWfST1phrclqVxTWJlmCe8A/0','1',null,'1','291,343,167,361,211','0','1490630704','1','1490595736','1490595736','2','4','0'),('3','0','owvoZ1ldqAJF5nflQd8b6wsMDHPE','oTxONv-JQ68l9jSAvKgJIFr6MKOY','','http://wx.qlogo.cn/mmopen/Szib8ySqErWIFdFyJlfsrdvEvWlErH8qgmgxRTLb6jYGbzVSL0AdDsWic8yAOx03oArjHBKiczzNDcR0GeWGdkP4w/0','1',null,'1','1','0','1490617632','1','1490617631','1490617631','2','0','0'),('16','0','owvoZ1uvlxTrNjhUMQ9waDvIbaJM','oTxONvx0cXFrYwudaoSGFwqnlf3U','Sheila','http://wx.qlogo.cn/mmopen/8Lm51VhXtHhvL5awAe6YniavhCFibD9nf0ULsxGagvhw86os2vGWRdZ68flmZkPsbNX9y6VcicNg76oSWuAdWGWDBydDpvV424E/0','2','重庆','1','1','0','1490692082','1','1490692081','1490692081','2','0','0'),('15','2','owvoZ1tMhghDZJxr0LmMoBsuB2lc','oTxONv7TrJ2k6rsqFq1e-oM7oM_w','Emitial 东','http://wx.qlogo.cn/mmopen/WqePdw25ST99NTfZzwxqYbDrIZkqqmFwLrXZibVaGomVRd3TgLnl6T7AhmI95ozCwRegNTntBvtQekfvKIbTBnQfv7xibfVgzb/0','0',null,'1','1','0','1490641136','1','1490641123','1490641123','2','0','0');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_tixian`  */
 DROP TABLE IF EXISTS `haokuai_user_tixian`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_tixian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `tixiane` int(11) NOT NULL DEFAULT '0',
  `ttime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tixiane` (`tixiane`),
  KEY `userid` (`userid`),
  KEY `ttime` (`ttime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_wxexcel`  */
 DROP TABLE IF EXISTS `haokuai_user_wxexcel`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_wxexcel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `uopenid` varchar(50) DEFAULT '1',
  `wxdanhao` varchar(50) DEFAULT '1',
  `wxjine` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `uopenid` (`uopenid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_yongjin`  */
 DROP TABLE IF EXISTS `haokuai_user_yongjin`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_yongjin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `uchong` int(11) NOT NULL DEFAULT '0',
  `tixiane` int(11) NOT NULL DEFAULT '0',
  `tcode` int(2) NOT NULL DEFAULT '1',
  `tjisuan` int(2) NOT NULL DEFAULT '1',
  `ttime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `tcode` (`tcode`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_user_zhanghu`  */
 DROP TABLE IF EXISTS `haokuai_user_zhanghu`;/* MySQLReback Separation */ CREATE TABLE `haokuai_user_zhanghu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `uhbqian` int(11) NOT NULL DEFAULT '0',
  `uqianzheng` int(11) NOT NULL DEFAULT '0',
  `uqianfa` int(11) NOT NULL DEFAULT '0',
  `uzhengzong` int(11) NOT NULL DEFAULT '0',
  `uqianchong` int(11) NOT NULL DEFAULT '0',
  `uchongzong` int(11) NOT NULL DEFAULT '0',
  `ucheckin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `uqianchong` (`uqianzheng`),
  KEY `uchongzong` (`uchongzong`),
  KEY `uzhengzong` (`uzhengzong`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_user_zhanghu` */
 INSERT INTO `haokuai_user_zhanghu` VALUES ('1','1','0','0','0','0','2500','2000','90'),('2','2','0','0','0','0','500','0','40'),('3','3','0','0','0','0','500','0','10'),('4','4','0','0','0','0','500','0','0'),('5','5','0','0','0','0','500','0','0'),('6','6','0','0','0','0','500','0','0'),('7','7','0','0','0','0','500','0','0'),('8','8','0','0','0','0','500','0','0'),('9','9','0','0','0','0','500','0','0'),('10','10','0','0','0','0','500','0','0'),('11','11','0','0','0','0','500','0','0'),('12','12','0','0','0','0','500','0','0'),('13','13','0','0','0','0','500','0','0'),('14','14','0','0','0','0','500','0','0'),('15','15','0','0','0','0','500','0','0'),('16','16','0','0','0','0','500','0','0');/* MySQLReback Separation */
 /* 创建表结构 `haokuai_weixin_caidan`  */
 DROP TABLE IF EXISTS `haokuai_weixin_caidan`;/* MySQLReback Separation */ CREATE TABLE `haokuai_weixin_caidan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `cname` varchar(50) NOT NULL DEFAULT '1',
  `ckey` varchar(50) NOT NULL DEFAULT '1',
  `curl` varchar(150) NOT NULL DEFAULT '1',
  `ctype` int(11) NOT NULL DEFAULT '0',
  `cnum` int(2) NOT NULL DEFAULT '1',
  `adminid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_weixin_mobanid`  */
 DROP TABLE IF EXISTS `haokuai_weixin_mobanid`;/* MySQLReback Separation */ CREATE TABLE `haokuai_weixin_mobanid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mbianhao` varchar(150) NOT NULL DEFAULT '1',
  `mid` varchar(150) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_weixin_sendcon`  */
 DROP TABLE IF EXISTS `haokuai_weixin_sendcon`;/* MySQLReback Separation */ CREATE TABLE `haokuai_weixin_sendcon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kid` int(11) NOT NULL DEFAULT '0',
  `sname` varchar(100) NOT NULL DEFAULT '1',
  `sdec` varchar(500) NOT NULL DEFAULT '1',
  `spic` varchar(50) NOT NULL DEFAULT '1',
  `surl` varchar(150) NOT NULL DEFAULT '1',
  `snum` int(2) NOT NULL DEFAULT '1',
  `stime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_weixin_sendkey`  */
 DROP TABLE IF EXISTS `haokuai_weixin_sendkey`;/* MySQLReback Separation */ CREATE TABLE `haokuai_weixin_sendkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adminid` int(11) NOT NULL DEFAULT '0',
  `sname` varchar(100) NOT NULL DEFAULT '1',
  `stype` int(2) NOT NULL DEFAULT '1',
  `kcode` int(2) NOT NULL DEFAULT '1',
  `stime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 创建表结构 `haokuai_yongjin_set`  */
 DROP TABLE IF EXISTS `haokuai_yongjin_set`;/* MySQLReback Separation */ CREATE TABLE `haokuai_yongjin_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ydengji` int(11) NOT NULL DEFAULT '0',
  `ybaifenbi` int(11) NOT NULL DEFAULT '0',
  `yjine` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ydengji` (`ydengji`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;/* MySQLReback Separation */
 /* 插入数据 `haokuai_yongjin_set` */
 INSERT INTO `haokuai_yongjin_set` VALUES ('1','1','5','5000'),('2','2','8','10000'),('3','3','10','30000');/* MySQLReback Separation */
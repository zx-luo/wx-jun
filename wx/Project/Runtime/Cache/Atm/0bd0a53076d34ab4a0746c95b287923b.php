<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/index.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="#">欢迎页</a></li>
  </ul>
</div>

<div class="mainindex">
  <div class="welinfo"><img src="/Public/Admin/image/sun.png" alt="天气" /><b><?php echo ($_SESSION['uname']); ?>，欢迎使用信息管理系统。</b>  </div>  
  <div class="welinfo">
    <span><img src="/Public/Admin/image/time.png" alt="时间" /></span>
    <i>您上次登录时间：<?php echo (date('Y-m-d H:i:s',$_SESSION['utime'])); ?></i>
    </div>
    <div class="xline"></div>
    
    <ul class="iconlist">
    
    <li><img src="/Public/Admin/image/ico01.png" /><p><a href="<?php echo U('Sysconfig/index');?>">系统设置</a></p></li>
    <li><img src="/Public/Admin/image/ico02.png" /><p><a href="<?php echo U('Chouzhong/edit');?>">滚动公告</a></p></li>
    <li><img src="/Public/Admin/image/ico03.png" /><p><a href="<?php echo U('Shuju/index');?>">数据统计</a></p></li>
    <li><img src="/Public/Admin/image/ico04.png" /><p><a href="<?php echo U('User/chongzhi');?>">充值记录</a></p></li>
    <li><img src="/Public/Admin/image/ico05.png" /><p><a href="<?php echo U('User/hb');?>">红包记录</a></p></li>
    <li><img src="/Public/Admin/image/ico06.png" /><p><a href="<?php echo U('User/yongjin');?>">佣金查询</a></p></li> 
            
    </ul>
    

  
    <div class="xline"></div>
    <div class="box"></div>
    
    <div class="welinfo">
    <span><img src="/Public/Admin/image/dp.png" alt="提醒" /></span>
    <b>信息管理系统使用指南</b>
    </div>
    
    <ul class="infolist">
    <li><span>您可以快速微信接口管理操作</span><a href="<?php echo U('Index/jiekou');?>" class="ibtn">微信接口</a></li>
    <li><span>您可以快速佣金设置</span><a href="<?php echo U('Yongjin/fenxiao');?>" class="ibtn">佣金设置</a></li>
    <li><span>您可以进编辑会员添加充值,减少充值</span><a href="<?php echo U('User/index');?>" class="ibtn">会员账户余额 + -</a></li>
    </ul>
    
    <div class="xline"></div>
    
    <div class="uimakerinfo"><b>网站使用指南</b></div>
    
    <ul class="umlist">
    <li><a href="<?php echo U('News/newsedit?ntype=1');?>">客服设置</a></li>
    <li><a href="<?php echo U('News/newsedit?ntype=2');?>">佣金说明</a></li>
    <li><a href="<?php echo U('Yongjin/index');?>">代理等级</a></li>
    <li><a href="<?php echo U('sysma/index');?>">二维码设置</a></li>
    <li><a href="<?php echo U('Sysuser/userlist');?>">网站管理员</a></li>
    </ul>
    
    
    </div>
</div>
</body>
</html>
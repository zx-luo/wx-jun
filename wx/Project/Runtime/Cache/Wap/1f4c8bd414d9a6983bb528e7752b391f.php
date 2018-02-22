<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>扫雷</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<script src="/Public/js/jquery-2.1.1.min.js"></script>
<link href="/Public/css/base.css" rel="stylesheet" type="text/css">
<link href="/Public/Weixin/css/index.css?v=<?php echo rand(0,99);?>" rel="stylesheet" type="text/css">
<link href="/Public/Weixin/css/head.css?v=<?php echo rand(0,99);?>" rel="stylesheet" type="text/css">
<style></style>
<script>
$(document).ready(function () {  });
</script>
</head>
<body>
<section class="container">
  <div class="container-hd">
    <figrue class="figure"><img src="/Public/Weixin/img/banner-index112.jpg" alt="" /></figrue>
    <div class="container-hd_text"> <i class="i i-text i-text_left"></i> <i class="i i-text i-text_right"></i> </div>
    <i class="i-lantern i-lantern_left"></i> <i class="i-lantern i-lantern_right"></i>
    <div class="fireworks"> <i class="i-firework"></i> <i class="i-firework"></i> </div>
    <!-- removed by skyrim -->
    <i class="i i-character bounceIn floatUpDown"></i> </div>
    <!-- removed end -->
    <!-- added by skyrim -->
    <i id="floating-person" class="i i-character bounceIn floatUpDown"></i> </div>
    <script>
        $(document).ready(function(){
            $('#floating-person').click(function(){
                //alert('haha'+"<?php echo U('checkIn/index');?>");
                <?php if($sysinfo['checkin_mode'][0]=='0'){ ?>
                <?php } else { ?>
                    window.location.href = "<?php echo U('checkin/index');?>";
                <?php } ?>
            });
        });
    </script>
    <!-- added end -->
</section>

<div class="index1 clearfix">
  <div class="hblist">
    <ul>
      <?php if(is_array($hb)): foreach($hb as $key=>$v): ?><a href="<?php echo U('hb?hbid='.$v[id]);?>">
      <li><img src="/Public/Weixin/img/2.png">
        <p><font class="price"><?php echo ($v[hbzhifu]/100); ?>元区</font><br>
          <font color="#ffdd56">扫雷</font></p>
      </li>
      </a><?php endforeach; endif; ?>
    </ul>
  </div>
  <!--
  <div class="headtitle">我的佣金</div>
  <div style=" line-height:23px; color:#333; text-indent:2em;"></div>
  -->
</div>
<script>
$(document).ready(function () { 
   var zhanshiboxsetInterval;
   $(function(){	
      /*   
	   if( String(location).indexOf("Wap&c=Index&a=index") == -1 && String(location).indexOf("Wap&c=Index&a=hb") == -1 ){
		    $.post("<?php echo U('Ajax/checkzhanghu');?>",{},function(res){
				if(res.code==1){
					 alert('请先拆红包');
					 $.post("<?php echo U('Ajax/gethbid');?>",{hbid:<?php echo (intval($hb[id])); ?>},function(res){
					     location.href='<?php echo U("hb?hbid=");?>'+res.hbid;
					 },'json');
				}
			},'json');
	   }
	   */
	   $.post("<?php echo U('Ajax/getfaqiancishu');?>",{},function(res){});
	   $.post('<?php echo U("Ajax/fayongjin");?>',{},function(){	});
	   $.post('<?php echo U("Ajax/checkuserhb");?>',{},function(){	});
	   zhanshiboxsetInterval = setInterval(zhanshibox, 10000);
	   zhanshibox();
   });
   $('#qianghongbao').click(function(){
	   $.post("<?php echo U('Ajax/gethbid');?>",{hbid:<?php echo (intval($hbid)); ?>},function(res){
			location.href='<?php echo U("Index/hb?hbid=");?>'+res.hbid;
	   },'json');
   });
   $('#checkdaili').click(function(){
	   $.post("<?php echo U('Ajax/checkdaili');?>",{},function(res){
		   if(res.code == 0){
			   location.href='<?php echo U("Index/kefu");?>';
		   } else {
			   location.href='<?php echo U("Index/daili");?>';
		   }
	   },'json');
   });
   $('.msgbox .but').click(function(){
	    var msgbox = $("input[name='msgbox']").val();
		if(msgbox == 1){
            $.post("<?php echo U('Ajax/checkzhanghu');?>",{hbid:<?php echo (intval($hbid)); ?>},function(res){
				if(res.code==1){
					location.href = "<?php echo U('Index/hb?hbid='.$hbid);?>";
				} else {
				    location.href = "<?php echo U('Chongzhi/chong?ctype=1&hbid='.$hbid);?>";
				}
			},'json');
			return false;
		}
		if(msgbox == 2){
            $.post("<?php echo U('Ajax/checkzhanghu');?>",{hbid:<?php echo (intval($hbid)); ?>},function(res){
				if(res.code==1){
					location.href = "<?php echo U('Zhuanpan/index');?>";
				} else {
				    location.href = "<?php echo U('Chongzhi/chong?ctype=2&hbid='.$hbid);?>";
				}
			},'json');
			return false;
		}
		if(msgbox == 3){
            $.post("<?php echo U('Ajax/checkzhanghu');?>",{hbid:<?php echo (intval($hbid)); ?>},function(res){
				if(res.code==1){
					location.href = "<?php echo U('Guaguale/index');?>";
				} else {
				    location.href = "<?php echo U('Chongzhi/chong?ctype=4&hbid='.$hbid);?>";
				}
			},'json');
			return false;
		}
		if(msgbox == 4){
			location.href = "<?php echo U('Ucenter/index');?>";	
			return false;
		}
		$('.msgbox').hide();
   });   
});
function zhanshibox(){
	$.post("<?php echo U('Ajax/zhanshibox');?>",{},function(res){	 
	    $('.zhanshibox').show(500);
	    if(res.code == 1){
		    $('.zhanshibox').hide();
			clearInterval(zhanshiboxsetInterval);
		}   
		$('.zhanshibox p').html(res.html);
		$('.zhanshibox p').fadeIn(500);
	},'json');
	setTimeout(function(){$('.zhanshibox p').fadeOut(500);}, 8000);
}
</script>
<style>
.zhanshibox { position: fixed; top: 0; left: 0; right: 0; height: 24px; background-color: rgba(0,0,0,0.3); text-align: center; font-size: 12px; line-height: 24px; color: #FFF; display: none; z-index: 9; }
.zhanshibox p { display: none; }
.zhanshibox span { color: #3F0; border: #3F0 1px solid; padding-left: 2px; padding-right: 2px; border-radius: 2px; }
</style>
<div class="msgbox">
  <input type="hidden" value="0" name="msgbox">
  <!--
      0无跳转 
      1拆红包 
      2转盘 
      3刮刮卡
      4个人中心
  -->
  <div class="box">
    <p class="title">提示</p>
    <p class="txt">恭喜您获得0元红包</p>
    <p class="but">确定</p>
  </div>
</div>
<div class="zhanshibox">
  <p></p>
</div>
<div id="dengdai">
    <div class="loading">
           <span></span>
           <span></span>
           <span></span>
           <span></span>
           <span></span>
    </div>
</div>
<div style="height:60px;"></div>
<script>
$(document).ready(function(){
    $('.toggle-sub-menu').click(function(){
        //alert(JSON.stringify(this.dataset));
        var selector = '#' + this.dataset.subMenuId;
        
        $('.sub-menu').hide();
        $(selector).fadeIn();
    })
});
</script>
<style>
.sub-menu {
	background: #333333;
    /* height: 50px; */
	position: fixed;
    /* left: 0; *//* bottom: 0; *//* right: 0; */
	padding: 9px 3px;
	width: 20%;
	/*font-size: 0.8em;*/
	
	display: none;
}

.sub-menu li:first-child {
	padding: 1px 0 6px 0;
}
.sub-menu li {
	/*width: 25%;*/
	text-align: center;
	/* float: left; */
	color: #FFF;
	/*border-right: #FFF 1px solid;*/
	border-bottom: darkgrey 1px solid;
	line-height: 14px;
	padding: 6px 0;
}

.sub-menu li:last-child {
	border: none;
	padding: 6px 0 0 0;
}

.sub-menu li a {
	color: #FFF;
}

</style>
<div id="sub-menu-more-game" class="sub-menu" style="bottom: 50px; left: 26%;">
  <ul>
    <li><a href="<?php echo U('Zhuanpan/index?randres='.rand(100,999));?>">转盘</a></li>
    <li><a href="<?php echo U('Guaguale/index?randres='.rand(100,999));?>">刮刮乐</a></li>
    <li><a href="<?php echo U('Saolei/index?randres='.rand(100,999));?>">扫雷</a></li>
  </ul>
</div>
<div id="sub-menu-free-game" class="sub-menu" style="bottom: 50px; left: 20%">
  <ul>
    <li><a href="<?php echo U('Checkin/index?randres='.rand(100,999));?>">签到</a></li>
    <li><a href="<?php echo U('Appraise/scoreboard?randres='.rand(100,999));?>">分享有奖</a></li>
  </ul>
</div>
<div class="footer">
  <ul>
      <!-- 拆福包 免费玩  更多游戏  代理   我 -->
    <li style="width: 25%"><a href="<?php echo U('Index/index?randres='.rand(100,999));?>">拆福包</a></li>
    <!--<li style="width: 20%" class="toggle-sub-menu" data-sub-menu-id="sub-menu-free-game">免费玩</li>-->
    <li style="width: 25%" class="toggle-sub-menu" data-sub-menu-id="sub-menu-more-game">更多游戏</li>
    <li style="width: 25%" id="checkdaili">代理</li>
    <li style="width: 25%"><a href="<?php echo U('Ucenter/index?randres='.rand(100,999));?>">我</a></li>
      <!--
    <li><a href="<?php echo U('Index/index?randres='.rand(100,999));?>">拆福包</a></li>
    <li><a href="<?php echo U('Zhuanpan/index?randres='.rand(100,999));?>">转盘</a></li>
    <li><a href="<?php echo U('Guaguale/index?randres='.rand(100,999));?>">刮卡</a></li>
    -->
    <!--<li><a href="<?php echo U('Index/yongjin');?>">佣金</a></li>-->
      <!--
    <li><a href="<?php echo U('Saolei/index?randres='.rand(100,999));?>">扫雷</a></li>
    <li id="checkdaili">代理</li>
    <li><a href="<?php echo U('Ucenter/index?randres='.rand(100,999));?>">我</a></li>
      <!--
  </ul>
</div>

</body>
</html>
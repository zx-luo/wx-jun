<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>精彩转盘</title>
<?php $srconfig = include(getcwd().'/Project/Common/Conf/srconfig.php'); $items = $srconfig['zhuanpan_items']; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<script src="/Public/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="/Public/js/jQueryRotate.2.2.js"></script>
<script type="text/javascript" src="/Public/js/jquery.easing.min.js"></script>
<link href="/Public/css/base.css" rel="stylesheet" type="text/css">
<link href="/Public/Weixin/css/index.css?v=<?php echo rand(0,99);?>" rel="stylesheet" type="text/css">
<link href="/Public/Weixin/css/head.css?v=<?php echo rand(0,99);?>" rel="stylesheet" type="text/css">
<style>
.rotate .rotate-bg { width: 300px; margin: 0 auto; position: relative }
#lotteryBtn { width: 130px; position: absolute; top: 84px; left: 85px; }
.zhuanpanbut { border-radius: 5px; color: #FFF; width: 200px; line-height: 40px; margin: 0 auto; text-align: center; background: #d84e43; margin-top: 10px }
</style>
<script>
    var rotateFunc = function(angle) { //awards:奖值ID，angle:奖项对应的角度
    $('#lotteryBtn').stopRotate();
    $("#lotteryBtn").rotate({
      angle: 0,
      duration: 5000,
      animateTo: angle + 1440,
      //angle是图片上各奖项对应的角度，1440是我要让指针旋转4圈。所以最后的结束的角度就是这样子^^
      callback: function() {
        $.post("<?php echo U('ajaxchai');?>", {},function(res) {
          if (res.code == 2) {
			$("input[name='chaiact']").val(1); 
            $('.msgbox .txt').text('恭喜您获得 ' + res.hbe + ' 元，已转存到账户余额!');
            $('.msgbox').show();
			$("input[name='msgbox']").val(2);
          }
          if (res.code == 3) {
            $("input[name='chaiact']").val(1);
            $('.msgbox .txt').text('系统频繁，请稍候再试');
            $('.msgbox').show();
          }
          if (res.code == 4) {
            $("input[name='chaiact']").val(1);
            $('.msgbox .txt').text('今天次数已经没有了，请明天再来！');
            $('.msgbox').show();
          }
        },'json');
      }
    });
  };

  $(document).ready(function() {
    $("#lotteryBtn").rotate({
      bind: {
        click: function() {
          var chaiact = $("input[name='chaiact']").val();
          if (chaiact == 2) {
              return false;
          }
          $("input[name='chaiact']").val(2);
          //$.post("<?php echo U('ajaxzhuan');?>", {},function(res) {
          //    alert(res);
          //}, 'text');
          $.post("<?php echo U('ajaxzhuan');?>", {},function(res) {
              if (res.code == 1) {
                  $("input[name='chaiact']").val(1);
                  $('.msgbox .txt').text('请先支付！');
                  $('.msgbox').show();
                  $("input[name='msgbox']").val(2);
                  return false;
               }
               if (res.code == 5) {
                  $("input[name='chaiact']").val(1);
                  $('.msgbox .txt').text('操作太快，请歇歇再玩！');
                  $('.msgbox').show();
                  return false;
               }
               //alert(JSON.stringify(res));
			   <?php if(is_array($zhuanpan)): foreach($zhuanpan as $key=>$v): ?>if (res.gailvid == <?php echo ($v[id]); ?>) {
                     rotateFunc(<?php echo (intval($v[hjiaodu])); ?>);
                  }<?php endforeach; endif; ?>
			},'json');
		 }
	  }
	});
	
   $('.zhuanpanbut').click(function(){
	   location.href='<?php echo U("Chongzhi/chong?ctype=2&hbid=".$hbid);?>';
   });
	
});
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

<input type="hidden" value="1" name="chaiact">
<!--1可拆2锁定-->
<div class="rotate w100">
  <div class="rotate-bg"> <img src="/Public/Weixin/img/3-3.png" width="300" />
  
  <!--
<canvas id="myCanvas" width="300" height="300" style="position:absolute;left:0;top:0">your browser does not support the canvas tag </canvas>

<script type="text/javascript">

    var canvas=document.getElementById('myCanvas');
    var ctx=canvas.getContext('2d');
    ctx.fillStyle='#FF0000';
    ctx.fillRect(0,0,300,300);

</script>
-->

<?php $hbgailv = M('hb_gailv')->where(array('hbid'=>$hbid,'hgailv'=>array('gt', 0)))->select(); ?>

<table style="position:absolute; left:0; top:0; height: 290px; width: 290px; margin: 5px; padding: 0px;font-family:'Times New Roman'; font-size: 12px; text-align: center; border: none;text-shadow:0 0 5px #ff6600; color: yellow;text-stroke: 1px red;">
<tr style="height:25%">
<td style=""></td>
<td style="width: 25%; transform: rotate(337.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==157){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
<td style="width: 25%; transform: rotate(22.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==202){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
<td style=""></td>
</tr>
<tr style="height:25%">
<td style="transform: rotate(292.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==112){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
<td style=""></td>
<td style=""></td>
<td style="width: 25%; transform: rotate(67.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==248){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
</tr>
<tr style="height:25%">
<td style="width: 25%; transform: rotate(247.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==67){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
<td></td>
<td></td>
<td style="transform: rotate(112.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==292){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
</tr>
<tr style="height:25%">
<td></td>
<td style="transform: rotate(202.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==22){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
<td style="transform: rotate(157.5deg);"><?php foreach($hbgailv as $gailv){ if(intval($gailv['hjiaodu'])==338){echo '¥' . ($gailv['hmin']/100) . '-¥' . ($gailv['hmax']/100); break;}} ?></td>
<td></td>
</tr>
</table>
  <img src="/Public/Weixin/img/7.png" id="lotteryBtn"> </div>
</div>
<div class="zhuanpanbut">获得转盘机会(<?php echo ($zhuanpan[0][hzhifue]/100); ?>元)</div>
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
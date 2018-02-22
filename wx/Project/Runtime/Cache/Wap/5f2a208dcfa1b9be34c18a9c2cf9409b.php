<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>个人中心</title>
<?php $srconfig = include(getcwd().'/Project/Common/Conf/srconfig.php'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<script src="/Public/js/jquery-2.1.1.min.js"></script>
<link href="/Public/css/base.css?v=<?php echo rand(0,99);?>" rel="stylesheet" type="text/css">
<link href="/Public/Weixin/css/index.css?v=<?php echo rand(0,99);?>" rel="stylesheet" type="text/css">
<link href="/Public/Weixin/css/head.css?v=<?php echo rand(0,99);?>" rel="stylesheet" type="text/css">
<style></style>
<script>
$(document).ready(function () { 
   $('.chongzhi').click(function(){
	   $.post("<?php echo U('Ajax/getchongnum');?>",{},function(res){
		   if(res.code==1){
	          var djine = parseFloat($('input[name="djine"]').val());
	          if(!djine){
	            djine = parseFloat($('select[name="djine"]').val());
	          }
	          if(isNaN(djine) || djine < 0){
			     $('.msgbox .txt').text('请输入金额！');
			     $('.msgbox').show();
			     return false;
	          }
	          location.href = "<?php echo U('Chongzhi/chong?ctype=3&djine=');?>"+djine;
		   } else {
			     $('.msgbox .txt').text('今天充值上限，请明天再来！');
			     $('.msgbox').show();
			     return false;
		   }
	   },'json');
   });
   //checkin-balance
   $('.tixian').click(function(){
       $('.tixian').unbind();
	   $(this).unbind();
       //alert('系统维护！请稍侯再试。'); return;
    //==alert('ok');
       <?php if( $userzhanghu['uqianchong'] < intval($srconfig['lowest_withdraw_limit'])*100){ ?>
		    $('.msgbox .txt').text('最少<?php echo $srconfig['lowest_withdraw_limit']; ?>元才能提现！');
		    $('.msgbox').show();
			return false;
       <?php } else { ?>
	   $(this).unbind();
	   var djine = parseFloat($('#yue').val());
	   //alert(djine);
	   if(!djine){
	       
	   }
	   //alert(djine);return;
	   if(djine < 1){
		    $('.msgbox .txt').text('最少一元才能提现哦！');
		    $('.msgbox').show();
			return false;
	   }
	   //alert('ajax');
	   //alert(djine);return;
	   $.post("<?php echo U('Ajax/getfaqiancishu');?>",{},function(res){
	       //alert(JSON.stringify(res));
		   if(res.cishu < 99){
			    $.post("<?php echo U('Tixian/wxtixian');?>",{
			        jine: parseFloat($('#yue').val())
			    },function(jes){
			        //alert(jes);
			        $('#ccddeeff').html(jes);
			    }, 'text');
	       //alert(JSON.stringify({jine: parseFloat($('#yue').val())}));
			    $.post("<?php echo U('Tixian/wxtixian');?>",{jine: parseFloat($('#yue').val())},function(jes){
	       //alert(JSON.stringify(jes));
				    if(jes.code == 1){
			           $('.msgbox .txt').text('提现成功！');
		               $('.msgbox').show();
					   $('#yue').text(0);
					}
				    if(jes.code == 2){
			           $('.msgbox .txt').text('系统繁忙，稍后再试！');
		               $('.msgbox').show();
					}
				    if(jes.code == 3){
			           $('.msgbox .txt').text('最少一元才能提现！');
		               $('.msgbox').show();
					}	
				    if(jes.code == 4){
			           $('.msgbox .txt').text('已提交申请！请等待管理员审核通过后可到账');
		               $('.msgbox').show();
					   $('#yue').text(0);
					}
				},'json');
		   } else {
			    $('.msgbox .txt').text('今天超过上限，请明天再来！');
		        $('.msgbox').show();
		   }
	   },'json');   
       <?php } ?>
   });
   
   
    $('#checkin-draw').click(function(){
        //alert('ok');
    	$(this).unbind();
    	var djine = parseFloat($('#checkin-balance').text());
    	if(!djine){
    	    djine = parseFloat($('#checkin-balance').val());
    	}
    	if(djine < 1){
    		$('.msgbox .txt').text('最少一元才能提现！');
    		$('.msgbox').show();
    		return false;
    	}
    	$.post("<?php echo U('checkin/checkinDrawCount');?>",{},function(res){
            //alert(JSON.stringify(res));
    		if(res.cishu < 99){
    			$.post("<?php echo U('checkin/checkinDraw');?>",{},function(jes){
            //alert(JSON.stringify(jes));
    				if(jes.code == 1){
    					$('.msgbox .txt').text('提现成功！');
    					$('.msgbox').show();
    					$('#checkin-balance').text(0);
    				}
    				if(jes.code == 2){
    					$('.msgbox .txt').text('系统繁忙，稍后再试！');
    					$('.msgbox').show();
    				}
    				if(jes.code == 3){
    					$('.msgbox .txt').text('最少一元才能提现！');
    					$('.msgbox').show();
    				}	
    			},'json');
    		} else {
    			$('.msgbox .txt').text('今天超过上限，请明天再来！');
    			$('.msgbox').show();
    		}
    	},'json');   
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
 
<!--
<ul class="ucenter-index member publickuang ul1">
  <li>
    <h3><?php echo ($userzhanghu[uhbqian]/100+$userzhanghu[uqianzheng]/100); ?></h3>
    <p>可提现</p>
  </li>
  <li>
    <h3><?php echo ($userzhanghu['uqianchong']/100); ?></h3>
    <p>账户余额</p>
  </li>
  <li>
    <h3><?php echo ($userzhanghu['uchongzong']/100); ?></h3>
    <p>总充值</p>
  </li>
</ul>
-->
<ul class="ucenter-index member publickuang">
  <li>
    <h3><?php echo (intval($jiazunum)); ?></h3>
    <p>推广人数</p>
  </li>
  <li>
    <h3><?php echo ($userzhanghu['uzhengzong']/100); ?></h3>
    <p>总佣金</p>
  </li>
  <li>
    <h3><?php echo ($userzhanghu['uqianzheng']/100); ?></h3>
    <p>待发佣金</p>
  </li>
</ul>
<ul class="ucenter-index nav publickuang">
  <li>充值额:
  <?php if(count($srconfig['topup_candi']) == 1){ ?><font color="#ff2c4c">￥</font>
    <input name="djine" style="border:1px solid #fff; height:26px; width:50px; padding-left:3px;" value="<?php echo $srconfig['topup_candi'][0];?>" type="number">
    <?php } else { ?>
        <select name="djine">
            <?php
 foreach($srconfig['topup_candi'] as $k=>$djine){ echo "<option value ='" . $djine . "'>¥" . $djine . "</option>"; } ?>
        </select>
    <?php } ?>
    <span class="current chongzhi">充值</span> </li>
  <li>可提现: (总:¥<?php echo $userzhanghu['uqianchong']/100; ?>)
    <?php
 $srconfig['withdraw_multiple'] = intval($srconfig['withdraw_multiple']); $max_item = floor(intval($userzhanghu['uqianchong'])/100/$srconfig['withdraw_multiple']); if($srconfig['withdraw_multiple']){ ?>
        <script>$(document).ready(function(){
            $('#checkin-balance').val(<?php echo '<?'; ?>
 echo $max_item;?>);
        });</script>
        <select id="yue" name="yue" <?php if($max_item<1){ echo ' style="display: none;"'; }?>>
            <?php
 $srconfig['lowest_withdraw_limit'] = intval($srconfig['lowest_withdraw_limit']); for(;$max_item>0;$max_item--){ if(($max_item*$srconfig['withdraw_multiple'])<$srconfig['lowest_withdraw_limit']){ break; } echo "<option value ='".($max_item*$srconfig['withdraw_multiple'])."'>¥".($max_item*$srconfig['withdraw_multiple'])."</option>"; } ?>
        </select>
        
    <?php } else { ?>
        <font color="#ff2c4c">￥<font id="yue"><?php echo $userzhanghu['uqianchong']/100; ?></font></font>
    <?php } ?>
  
  <span class="current tixian">提现</span></li>

  <li><a href="<?php echo U('Index/kefu');?>"> <img src="/Public/Weixin/img/i1.png" class="imgico"> 联系客服 <img src="/Public/Weixin/img/1.png" class="imgstart"></a></li>
  <li> <a href="<?php echo U('Ucenter/hblist');?>"> <img src="/Public/Weixin/img/i2.png" class="imgico"> 红包记录 <img src="/Public/Weixin/img/1.png" class="imgstart"></a> </li>
  <li><a href="<?php echo U('Ucenter/saoleihb');?>"> <img src="/Public/Weixin/img/i2.png" class="imgico"> 扫雷记录 <img src="/Public/Weixin/img/1.png" class="imgstart"></a></li>
  <li><a href="<?php echo U('Ucenter/chonglist');?>"> <img src="/Public/Weixin/img/i3.png" class="imgico"> 充值记录 <img src="/Public/Weixin/img/1.png" class="imgstart"></a> </li>
  <li><a href="<?php echo U('Index/yongjin');?>"> <img src="/Public/Weixin/img/i2.png" class="imgico"> 佣金记录 <img src="/Public/Weixin/img/1.png" class="imgstart"></a></li>

  <li><a href="<?php echo U('Index/dailixq');?>"> <img src="/Public/Weixin/img/i2.png" class="imgico"> 佣金详情 <img src="/Public/Weixin/img/1.png" class="imgstart"></a></li>
  <li><a href="<?php echo U('Index/drawlist');?>"> <img src="/Public/Weixin/img/i2.png" class="imgico"> 提现详情 <img src="/Public/Weixin/img/1.png" class="imgstart"></a></li>
</ul>
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
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<link href="/Public/Admin/css/select.css" rel="stylesheet" type="text/css">

<script src="/Public/js/jquery-2.1.1.min.js"></script>
<script src="/Public/js/select-ui.min.js"></script>

<script>
$(document).ready(function(){	
   $(".select1").uedSelect({
		width : 345		  
   });
   $("#gailvadd").click(function(){
	   $("#gailvgen").before("<li><label>&nbsp;</label><input name='hmin[]' type='text' style='width:80px;' class='dfinput' > 元 -  <input name='hmax[]' type='text' style='width:80px;' class='dfinput' > 元，概率  <input name='hgailv[]' type='text' style='width:80px;' class='dfinput' >&nbsp;&nbsp;第 <input name='hcishu[]' type='text' style='width:80px;' class='dfinput' > 次抽中<i><img src='/Public/Admin/image/t03.png' style='vertical-align:middle; cursor:pointer' onclick='removeFile(this);' /></i></li>");
   });
   $('#monisub').click(function(){
	   $('#dengdai').show();
	   var options = {
              url: '<?php echo U("ajaxmoni");?>',
              type: 'post',
              dataType: 'html',
              data: $("#fadd").serialize(),
              success: function (data) {
				  $('.install').show();
				  $('.install').html(data);
				  $('#dengdai').hide();
              }
            };
        $.ajax(options);
		return false;
   });
});
function removeFile(e){	$(e).parent().parent().remove();}
</script>
<style>
#dengdai{ position:fixed; top:0; left:0; right:0; bottom:0;background-color: rgba(0,0,0,0.5); z-index:99999;display: none;}
#dengdai .loading { width: 80px; height: 40px; margin: 0 auto; margin-top: 20%; }
#dengdai .loading span { display: inline-block; width: 8px; height: 100%; border-radius: 4px; background: lightgreen; -webkit-animation: load 1s ease infinite; }
 @-webkit-keyframes load {  0%, 100% {
 height: 40px;
 background: lightgreen;
}
 50% {
 height: 70px;
 margin: -15px 0;
 background: lightblue;
}
}
#dengdai .loading span:nth-child(2) { -webkit-animation-delay: 0.2s; }
#dengdai .loading span:nth-child(3) { -webkit-animation-delay: 0.4s; }
#dengdai .loading span:nth-child(4) { -webkit-animation-delay: 0.6s; }
#dengdai .loading span:nth-child(5) { -webkit-animation-delay: 0.8s; }
.install { box-shadow: 5px 5px 5px #f7f7f7 inset; border: 1px solid #bdbcbc; width: 530px; height: 200px; overflow: hidden; display: block; overflow-y: scroll; margin-left:123px; font-size: 12px; margin-bottom: 22px; outline: none; display:none; line-height:30px; word-break:break-all; padding:5px; }
</style>
</head>
<body>
<div id="dengdai">
    <div class="loading">
           <span></span>
           <span></span>
           <span></span>
           <span></span>
           <span></span>
    </div>
</div>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li><a href="<?php echo U('show');?>">管理红包</a></li>
    <li>编辑</li>
  </ul>
</div>
<div class="formbody">
  <div class="formtitle"><span>基本信息</span></div>
  <form id="fadd" name="fadd" method="post" action="<?php echo U('save?id='.$seldata[id]);?>">
    <input type="hidden" name="htime" value="<?php echo ($seldata['htime'] ? $seldata['htime']:time()); ?>">
   <ul class="forminfo">   
    <li>
      <label>红包价格</label>
      <input name="hzhifue" type="text" value="<?php echo ($seldata['hzhifue']/100); ?>" class="dfinput" >
      <i>元</i></li>
    <li>
      <label>排序</label>
      <input name="hpaixu" type="text" value="<?php echo ($seldata['hpaixu']); ?>" class="dfinput" >
      <i>数字越大越靠前</i></li>
    <li>
      <label>生成红包范围</label>
      <input name="hminmoney" type="text" value="<?php echo ($seldata['hminmoney']/100); ?>" style="width:80px" class="dfinput" > 元 -
      <input name="hmaxmoney" type="text" value="<?php echo ($seldata['hmaxmoney']/100); ?>" style="width:80px" class="dfinput" > 元
      <i>红包会在范围内随机生成，值不能小于1</i></li>
    <li>
      <label>抽红包概率</label>
      <input name="hmin[]" type="text" value="<?php echo ($hbgailv[0][hmin]/100); ?>" style="width:80px;" class="dfinput" > 元 -
      <input name="hmax[]" type="text" value="<?php echo ($hbgailv[0][hmax]/100); ?>" style="width:80px;" class="dfinput" > 元，概率
      <input name="hgailv[]" type="text" value="<?php echo (intval($hbgailv[0][hgailv])); ?>" style="width:80px;" class="dfinput" >&nbsp;&nbsp;第
      <input name="hcishu[]" type="text" value="<?php echo (intval($hbgailv[0][hcishu])); ?>" style="width:80px;" class="dfinput" > 次抽中   
      <i><img src="/Public/Admin/image/t01.png" style="vertical-align:middle; cursor:pointer" id="gailvadd" />所有概率的和为分母，填写的值为分子计算概率，第几次可以不填</i></li>
    <?php if(is_array($hbgailv)): foreach($hbgailv as $k=>$v): if(($k) > "0"): ?><li>
         <label>&nbsp;</label>
         <input name="hmin[]" type="text" value="<?php echo ($v[hmin]/100); ?>" style="width:80px;" class="dfinput" > 元 -
         <input name="hmax[]" type="text" value="<?php echo ($v[hmax]/100); ?>" style="width:80px;" class="dfinput" > 元，概率
         <input name="hgailv[]" type="text" value="<?php echo (intval($v[hgailv])); ?>" style="width:80px;" class="dfinput" >&nbsp;&nbsp;第
         <input name="hcishu[]" type="text" value="<?php echo (intval($v[hcishu])); ?>" style="width:80px;" class="dfinput" > 次抽中      
         <i><img src="/Public/Admin/image/t03.png" style="vertical-align:middle; cursor:pointer" onclick='removeFile(this);' /></i></li><?php endif; endforeach; endif; ?>
    <li id="gailvgen">
      <label>红包个数</label>
      <input name="hgeshu" type="text" value="<?php echo ($seldata['hgeshu']); ?>" class="dfinput" >
      <i></i></li>
    <li>
      <label>&nbsp;</label>
      <input type="submit" name="button" class="btn" value="确认保存" />&nbsp;&nbsp;&nbsp;<input id="monisub" type="button" name="button" class="btn" value="模拟抽红包" style="background-image:url(); background-color:#390; border-radius:5px;" />
    </li>
  </ul>
  </form>
</div>
<div class="install"></div>
</body>
</html>
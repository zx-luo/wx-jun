<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<link href="/Public/Admin/css/select.css" rel="stylesheet"  type="text/css">
<script language="JavaScript" src="/Public/js/jquery-2.1.1.min.js"></script>
<script language="JavaScript" src="/Public/js/select-ui.min.js"></script>
<script type=text/javascript src="/Public/ueditor/ueditor.config.js"></script>
<script type=text/javascript src="/Public/ueditor/ueditor.all.js"></script>
<link rel="stylesheet" href="/Public/ueditor/themes/default/css/ueditor.css"/>
<script>
$(document).ready(function(){
   $(function(){
   });
   $(".select1").uedSelect({
		width : 345			  
   });
});
</script>
</head>

<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li><?php switch($ntype): case "1": ?>客服设置<?php break;?>
    <?php case "2": ?>佣金说明<?php break; endswitch;?></li>
  </ul>
</div>
<div class="formbody">
      <form name="fadd" method="post" action="<?php echo U('newssave?ntype='.$ntype);?>">
        <ul class="forminfo">
          <li>
            <label>内容</label>
            <textarea name="ncontent" id="myEditor" class="textinput" style="width:700px; height:320px;"><?php echo ($news[ncontent]); ?></textarea>
            <i></i> </li>
          <li>
            <label>&nbsp;</label>
            <input name="submit" type="submit" class="btn" value="保存" />
          </li>
        </ul>
      </form>
</div>
<script type="text/javascript"> 
   UE.getEditor('myEditor', {
		theme:"default", //皮肤
		lang:"zh-cn", //语言
		initialFrameWidth:700,  //初始化编辑器宽度,默认800
		initialFrameHeight:320
	});
</script>
</body>
</html>
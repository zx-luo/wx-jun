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
    <li>中奖信息</li>
  </ul>
</div>
<div class="formbody">
  <form name="fadd" method="post" action="<?php echo U('save');?>">
    <ul class="forminfo">
      <li>
        <label>内容</label>
        <textarea name="cwxchoutxt" class="textinput" style="width:400px; height:220px;"><?php echo ($news[cwxchoutxt]); ?></textarea>
        <i>多条信息逗号隔开</i> </li>
      <li>
        <label>&nbsp;</label>
        <input name="submit" type="submit" class="btn" value="保存" />
      </li>
    </ul>
  </form>
</div>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<link href="/Public/css/page.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/Public/js/jquery-2.1.1.min.js"></script>
<script src="/Public/js/datejs/laydate.js"></script>
<script>
$(document).ready(function(){
   $(function(){
      $('.rightinfo tbody tr:odd').addClass('odd')
   });
   $(".imgact2").click(function(){
	   var id=$(this).parent().find("input[name='id']").val();
	   var img=($(this).attr("src")=='/Public/Admin/image/no.gif') ? "/Public/Admin/image/yes.gif":"/Public/Admin/image/no.gif";
	   $(this).attr("src",img);
	   $.post("<?php echo U('ajaxuserstate');?>",{id:id},function(data){});
   });
});
function del(){ if(confirm("确定要删除吗？")) {   return true;  }  else  {  return false;  } }
</script>
</head>

<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li>红包记录</li>
  </ul>
</div>
<div class="rightinfo">
  <div class="tools">
    <ul class="toolbar">
      <li style="background:#FFF; text-indent:1em; border:0">
        <form name="fsoso1" method="post" action="<?php echo U('hb');?>">
          用户ID <input name="sci" type="text" class="dfinput" style="width:100px" >
          开始时间 <input name="sktime" type="text" value="<?php echo ($sktime); ?>" class="dfinput" style="width:140px" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
          结束时间 <input name="sjtime" type="text" value="<?php echo ($sjtime); ?>" class="dfinput" style="width:140px" onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
          <input name="submit" class="btn" value="查询" type="submit">      
        </form>        
      </li>
    </ul>
  </div>
  <table class="tablelist">
    <thead>
      <tr>
        <th>用户ID[可点击]</th>
        <th>昵称</th>
        <th>头像</th>
        <th>专区</th>
        <th>金额(元)</th>
        <th>黑名单</th>
        <th>时间</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($hb)): foreach($hb as $key=>$v): ?><tr height="40" align="center">
          <td><a href="<?php echo U('hb?sci='.$v[userid]);?>"><?php echo ($v['userid']); ?></a></td>
          <td><?php echo ($v['uickname']); ?></td>
          <td><?php if(!empty($v[uheadimgurl])): ?><img src="<?php echo ($v['uheadimgurl']); ?>" height="54" width="54"/><?php endif; ?></td>
          <td><?php echo ($v['hzhifue']/100); ?>元区【ID:<?php echo ($v[hbid]); ?>】</td>
          <td><?php echo ($v['hbe']/100); ?></td>
          <td>
            <input type="hidden" name="id" value="<?php echo ($v[userid]); ?>" />
            <?php if(($v[ustate]) == "2"): ?><img src="/Public/Admin/image/yes.gif" style="cursor:pointer;vertical-align:middle" class="imgact2" />
            <?php else: ?>
            <img src="/Public/Admin/image/no.gif" style="cursor:pointer;vertical-align:middle" class="imgact2" /><?php endif; ?>
          </td>
          <td><?php echo (date("Y-m-d H:i:s",$v[ttime])); ?></td>
        </tr><?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
<div class="pages"> <?php echo ($page); ?>
  <?php if(empty($hb)): ?><font color='#ff0000'>暂无数据</font><?php endif; ?>
</div>
<script>
!function(){
	laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
}();
</script>
</body>
</html>
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
<script type="text/javascript">
$(document).ready(function(){
  $(".click").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".sure").click(function(){
  $(".tip").fadeOut(100);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>


</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">数据表</a></li>
    <li><a href="#">基本内容</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div style="line-height:35px; text-align:right; margin-bottom:5px;">
       <input name="" type="submit" class="btn" value="备份数据库" onclick="back_all();">
       <br/>
    </div>
    <script>
       function back_all(){
	      if(confirm('您确定备份数据库吗？')){
		      location.href="/index.php?m=Atm&c=Baksql&a=backall";
		  }
	   }
    </script>
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th>名称</th>
        <th>时间 </th>
        <th>大小</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody>
		
		<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
		 <td><?php echo ($v["name"]); ?></td>
		 <td><?php echo ($v["time"]); ?></td>
		  <td> 
		  <?php echo ($v["size"]); ?>	  
		  </td>
	      <td> <a href="/index.php?m=Atm&c=Baksql&a=downloadBak&file=<?php echo ($v["name"]); ?>" class="tablelink">下载</a>   <a onClick="javascript:if(!confirm('确定删除？'))  return  false; " href="/index.php?m=Atm&c=Baksql&a=deletebak&file=<?php echo ($v["name"]); ?>" >删除</a>   <a onClick="javascript:if(!confirm('确定还原？'))  return  false; " href="/index.php?m=Atm&c=Baksql&a=recover&file=<?php echo ($v["name"]); ?>" >还原</a> </td>
        </tr><?php endforeach; endif; ?>
        </tbody>
    </table>
    <style>.pages a,.pages span {
    display:inline-block;
    padding:2px 5px;
    margin:0 1px;
    border:1px solid #f0f0f0;
    -webkit-border-radius:3px;
    -moz-border-radius:3px;
    border-radius:3px;
}
.pages a,.pages li {
    display:inline-block;
    list-style: none;
    text-decoration:none; color:#58A0D3;
}
.pages a.first,.pages a.prev,.pages a.next,.pages a.end{
    margin:0;
}
.pages a:hover{
    border-color:#50A8E6;
}
.pages span.current{
    background:#50A8E6;
    color:#FFF;
    font-weight:700;
    border-color:#50A8E6;
}</style>
   
   <div class="pages"><br />

                        <div align="right"><?php echo ($page); ?>
                        </div>
   </div>
    
    
    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
      </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
    
    
    
    
    </div>
    
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

</body>

</html>
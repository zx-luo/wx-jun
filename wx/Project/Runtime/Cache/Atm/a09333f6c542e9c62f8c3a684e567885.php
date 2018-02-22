<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>欢迎登录后台管理系统</title>
<link href="/Public/Admin/css/base.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/css/right.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="/Public/js/jquery-2.1.1.min.js"></script>
<script>
$(document).ready(function(){	
   $(function(){
      $('.rightinfo tbody tr:odd').css("backgroundColor","#f5f8fa");	
   })
   $("#picadd").click(function(){
	   $("#picgen").after("<li><label>&nbsp;</label><input name='file[]' type='file' class='dfinput'><i><img src='/Public/Admin/image/t03.png' style='vertical-align:middle; cursor:pointer' onclick='removeFile(this);' /></i></li>");
   });
   $("input[name='cbeicode']").click(function(){
	   if($(this).prop("checked")){
		   $('.beifen').show();
	   } else {
	      $('.beifen').hide();  
	   }
   });
});
function removeFile(e){
	$(e).parent().parent().remove();
}
</script>
<style>
<?php if(($sysconfig[cbeicode] == 2) OR ($sysconfig[cbeicode] == '') ): ?>.beifen{ display:none;}<?php endif; ?>
</style>
</head>
<body>
<div class="place"> <span>位置：</span>
  <ul class="placeul">
    <li><a href="<?php echo U('Index/center');?>">首页</a></li>
    <li>系统配置</li>
  </ul>
</div>
<div class="formbody">
  <form name="fadd" method="post" action="<?php echo U('save');?>" enctype="multipart/form-data">
    <ul class="forminfo">
      <li>
        <label>获取头像</label>
        <cite> <input name="cdenglucode" type="checkbox" value="2" <?php if(($sysconfig['cdenglucode']) == "2"): ?>checked<?php endif; ?> > 
        <i>勾选，带登陆框,可以获取用户信息</i></cite></li>
      <li>
        <label>自动结算佣金</label>
        <cite> <input name="cyongjinfa" type="checkbox" value="1" <?php if(($sysconfig['cyongjinfa']) == "1"): ?>checked<?php endif; ?> > 
        <i>勾选，自动发放代理佣金  <a href="<?php echo U('Yongjin/index');?>"><font color="#FF0000"><strong>点击设置佣金</strong></font></a> </i></cite></li>
        <!-- added by skyrim -->
      <?php $params = explode('|', $sysconfig['checkin_mode']); ?>
      <li>
        <label>发放签到奖励</label>
        <cite> <input name="enable-check-in" type="checkbox" value="1" <?php if($params[0] != '0'){ ?>checked<?php } ?> > 
        <i>勾选，允许用户签到以得到奖励</i></cite></li>
      <style>
          input.blank_input{
              width: 5em;
              border-width: medium medium 1px;
              border-style: none none solid;
              border-color: -moz-use-text-color -moz-use-text-color black;
              border-top-colors: none;
              border-right-colors: none;
              border-bottom-colors: none;
              border-left-colors: none;
              border-image: none;
              margin: 0.2em 0.2em 0.5em;
              height: 2em;
          }
          .item-selected {
              border: 2px blue solid;
          }
      </style>
      <input name="checkin_mode[0]" value="" style="display: none;" ?>
      <li class="checkinModeItem" id="constantMode">
        <label>&nbsp;</label>
        <div class="mode-content <?php if($params[0]=='1') {?>item-selected<?php } ?>">
          <cite>
            <input name="checkin-mode" class="checkin-mode" data-mode="constantMode" value="1" type="radio" <?php if($params[0]=='1') {?>checked<?php } ?>>
            <i>累积签到奖励模式<br>首次签到奖励<input name="checkin_mode[1]" class="dfinput blank_input" type="text" value="<?php echo $params[1]; ?>">元，连续签到每日额外增加奖励<input name="checkin_mode[2]" class="dfinput blank_input" type="text" value="<?php echo $params[2]; ?>">元，连续签到上限<input name="checkin_mode[3]" class="dfinput blank_input" type="text" value="<?php echo $params[3]; ?>">元。<br>比如：第一天签到得到5元，第二天签到5+5元，持续7天，则第7天为5+6*5=35元，后续天数保持每天35天，不会再增加。 一旦中断连续签到，则从第一天重新计算。 </i>
          </cite>
        </div></li>
      <li class="checkinModeItem" id="additiveMode">
        <label>&nbsp;</label>
        <div class="mode-content <?php if($params[0]=='2') {?>item-selected<?php } ?>">
          <cite>
            <input name="checkin-mode" class="checkin-mode" data-mode="additiveMode" value="2" type="radio" <?php if($params[0]=='2') {?>checked<?php } ?>>
            <i>每日固定奖励模式<br>
              开启后，每次签到都可以获得现金奖励<input name="checkin_mode[4]" class="dfinput blank_input" type="text" value="<?php echo $params[4]; ?>">元
            </i>
          </cite>
        </div></li>
      <script>
          $('.checkinModeItem').toggle();
          $(document).ready(function(){
              var initFunc = null, initFunc2 = null;
              $('input[name=enable-check-in]').click(initFunc = function(){
                  $('.checkinModeItem').toggle();
                  //alert($('input[name=enable-check-in]').attr("checked"));
                  //$('input[name=enable-check-in]').is(":checked")
                  if($('input[name=enable-check-in]').is(":checked")){
                      $('.checkinModeItem').fadeIn();
                  } else {
                      $('.checkinModeItem').fadeOut();
                  }
              });
              
              //alert('here_not_implemented!');
              //$('input[name=checkin-mode]').click(initFunc2 = function(){
              $('input.checkin-mode').click(initFunc2 = function(){
                  //console.log(this);
                  //console.log(this.dataset.mode);
                  var selector = '.mode-content', mode = '';
                  //$(selector).css('border', '2px white solid');
                  console.log(selector);
                  $(selector).removeClass('item-selected');
                  console.log($(selector).attr("class"));
                  //if(<?php echo $params[1]; ?> == 1){
                  //if(this.dataset.mode == 1){
                   //   mode = 'constantMode';
                  //} else if(<?php echo $params[1]; ?> == 2) {
                  //} else if(this.dataset.mode == 2) {
                  //    mode = 'additiveMode';
                  //}
                  //c/onsole.log(mode);
                  //console.log(this.dataset.mode);
                  //var selector = '#' + mode + ' > .mode-content';
                  if(this.dataset==undefined){
                      if(<?php echo $params[1]; ?> == 1){
                          mode = 'constantMode';
                      } else if(<?php echo $params[1]; ?> == 2) {
                          mode = 'additiveMode';
                      }
                    var selector = '#' + mode + ' > .mode-content';
                  } else {
                    var selector = '#' + this.dataset.mode + ' > .mode-content';
                  }
                  console.log(selector);
                  //$(selector).css('border', '2px blue solid');
                  $(selector).addClass('item-selected');
                  //console.log($(selector));
                  //console.log($(selector).attr("class"));
              })
              <?php if($params[0] != '0'){ ?>
                
              <?php } ?>
              //$('input[name=enable-check-in]').click();
              initFunc();
              initFunc2();
              //alert('here_not_implemented!');
          });
      </script>
      <li>
        <label>任务二描述</label>
        <input name="task2_descr" type="text" value="<?php echo ($sysconfig['task2_descr']); ?>" class="dfinput" />
        <i>「分享给朋友」后的标题</i></cite></li>
      <li>
        <label>签到分享标题</label>
        <input name="share_title" type="text" value="<?php echo ($sysconfig['share_title']); ?>" class="dfinput" />
        <i>「分享给朋友」、「分享到朋友圈」后的标题</i></cite></li>
      <li>
        <label>签到分享描述</label>
        <input name="share_descr" type="text" value="<?php echo ($sysconfig['share_descr']); ?>" class="dfinput" />
        <i>「分享给朋友」、「分享到朋友圈」后的描述</i></cite></li>
        <!-- added ends -->
      <li>
        <label>自动成为代理</label>
        <cite> <input name="cdailicode" type="checkbox" value="2" <?php if(($sysconfig['cdailicode']) == "2"): ?>checked<?php endif; ?> > 
        <i>勾选，用户自动会成为代理</i></cite></li>
      <li>
        <label>代理自动升级</label>
        <cite> <input name="cdailishengji" type="checkbox" value="1" <?php if(($sysconfig['cdailishengji']) == "1"): ?>checked<?php endif; ?> > 
        <i>勾选，代理自动升级</i></cite></li>
      <li>
        <label>抽中红包展示</label>
        <cite> <input name="cgundong" type="checkbox" value="2" <?php if(($sysconfig['cgundong']) == "2"): ?>checked<?php endif; ?> > 
        <i>勾选，后台设置的中奖信息会顶部轮播显示</i></cite></li>
      <li>
        <label>开启短链接</label>
        <cite> <input name="cduanlianjie" type="checkbox" value="1" <?php if(($sysconfig['cduanlianjie']) == "1"): ?>checked<?php endif; ?> > 
        <i>勾选，带登陆框,可以获取用户信息</i></cite></li>
      <li>
        <label>每天充值</label>
        <input name="cchongzong" type="text" value="<?php echo ($sysconfig['cchongzong']/100); ?>" class="dfinput" />
        <i>元，限制用户每天充值多少</i></cite></li>
      <li>
        <label>黑名单</label>
        <input name="cpingbie" type="text" value="<?php echo ($sysconfig['cpingbie']/100); ?>" class="dfinput" />
        <i>元，用户赚到多少元加入黑名单（黑名单用户充值不会到帐）</i></cite></li>
      <li>
        <label>推广域名</label>
        <input name="cmaurl" type="text" value="<?php if(empty($sysconfig[cmaurl])): ?>http://<?php echo ($_SERVER[HTTP_HOST]); else: echo ($sysconfig['cmaurl']); endif; ?>" class="dfinput" />
        <i>推广使用，绑定在推广二维码上，末尾不要带’/‘</i></li>
      <li>
        <label>微信域名</label>
        <input name="cfaurl" type="text" value="<?php if(empty($sysconfig[cfaurl])): ?>http://<?php echo ($_SERVER[HTTP_HOST]); else: echo ($sysconfig['cfaurl']); endif; ?>" class="dfinput" />
        <i>需要绑定在公众号上，授权登录和支付路径处，末尾不要带’/‘</i></li>
      <li>
        <label>最低结算佣金</label>
        <input name="cyongjine" type="text" value="<?php echo ($sysconfig['cyongjine']/100); ?>" class="dfinput" />
        <i>元，佣金够多少元才结算发放，自动发佣金有效</i></li>
      <li>
        <label>代理扣量</label>
        <input name="ckouliang" type="text" value="<?php echo (intval($sysconfig['ckouliang'])); ?>" class="dfinput" />
        <i>单位：十分之，比如，这里输入4，就是10个充值会扣掉4个</i></li>
      <li>
        <label>公众号Appid</label>
        <input name="cwxappid" type="text" value="<?php echo ($sysconfig['cwxappid']); ?>" class="dfinput" />
        <i>从公众号处获得</i></li>
      <li>
        <label>公众号secret</label>
        <input name="cwxappsecret" type="text" value="<?php echo ($sysconfig['cwxappsecret']); ?>" class="dfinput" />
        <i>从公众号处获得</i></li>
      <li>
        <label>微信商户号</label>
        <input name="cwxmchid" type="text" value="<?php echo ($sysconfig['cwxmchid']); ?>" class="dfinput" />
        <i></i></li>
      <li>
        <label>微信商户密钥</label>
        <input name="cwxappkey" type="text" value="<?php echo ($sysconfig['cwxappkey']); ?>" class="dfinput" />
        <i>商户后台获得</i></li>
      <li id="picgen">
        <label>微信商户证书</label>
        <input name="file[]" type="file" class="dfinput"><i><img src="/Public/Admin/image/t01.png" style="vertical-align:middle; cursor:pointer"  id="picadd" /> pem格式三个文件全部上传，商户后台下载的证书压缩包解压后获得</i> </li>
      <li>
        <label>站内通知</label>
        <textarea name="ctongzhi" class="textinput" style="width:325px; height:60px;"><?php echo ($sysconfig['ctongzhi']); ?></textarea>
        <i></i></li>
      <li>
        <label>开启数据备份</label>
        <cite> <input name="cbeicode" type="checkbox" value="1" <?php if(($sysconfig['cbeicode']) == "1"): ?>checked<?php endif; ?> > 
        <i>勾选，全息备份使用方法请联系技术客服：palmyun2013，配置后更换公众号不丢失玩家数据。</i></cite></li>

      <li>
        <label>&nbsp;</label>
        <input name="button" type="submit" class="btn" value="确认保存"/>
      </li>
    </ul>
  </form>
</div>
</body>
</html>
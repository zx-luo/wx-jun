<?php
namespace Api\Controller;
use Think\Controller;

class WechatController extends Controller {
	public function index(){
		if (isset($_GET['echostr'])) {
			$this->valid();
		} else {
			define('MYUID',I('get.aid/d'));
			$this->responseMsg();
		}
	}
	
	public function responseMsg(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)){			              	
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;//（用户OpenID） 
            $toUsername = $postObj->ToUserName;//开发者微信号
            $MsgType=$postObj->MsgType;//事件类型
			
			switch($MsgType){
				//事件
				case "event":
				     //菜单点击事件
				     if($postObj->Event == "CLICK"){
						 $keyword = trim($postObj->EventKey);
						 $this->getKeyContent($fromUsername,$toUsername,$keyword);
				     }
				     //第一次关注事件/扫描带参数二维码事件
				     if($postObj->Event == "subscribe"){
						 //如果是扫码关注
						 if(!empty($postObj->EventKey)){
							 $imgid = intval(substr($postObj->EventKey,8));
							 $this->maHongbao($imgid,$fromUsername,$toUsername);
						 } else {
						     $this->getKeyContent($fromUsername,$toUsername,'',0);
						 }
				     }
				     //扫描带参数二维码事件
				     if($postObj->Event == "SCAN"){
						 $imgid = intval($postObj->EventKey);
						 $this->maHongbao($imgid,$fromUsername,$toUsername);
				     }
				     //取消关注事件
				     if($postObj->Event == "unsubscribe"){
				     }
				break;
				//文本消息
				case "text":
				    $keyword = trim($postObj->Content);
					$this->getKeyContent($fromUsername,$toUsername,$keyword);
				break;
				default :
				  echo '';
				break;
			}
		} else {
		   echo '';	
		}
	}
	
	/**
	*扫码二维码处理
	*/
	private function maHongbao($imgid = 0,$fromUsername,$toUsername){
		    $this->checkUser($fromUsername);
			$huodongimg = M('huodong_img')->where(array('id' => $imgid))->find(); //$huodongimg = M('huodong_img')->where("id=$imgid")->find();
			$itemid = intval($huodongimg['itemid']);
			$huodong = M('huodong')->where(array('id' => $itemid))->find(); //$huodong = M('huodong')->where("id=$itemid")->find();
			$keyword = $huodong['hhuifu'];
			$this->getKeyContent($fromUsername,$toUsername,$keyword);
			
			//扫码结果
			$data = array ('imgid' => $imgid,'touser'=>$fromUsername);
			$urls = 'http://'.$_SERVER['HTTP_HOST'].U('Admin/Wxhongbao/Index');
			http_curl_post($urls,$data);
			
	}
	
	/**
	* $fromUsername 用户openid
	* $toUsername 公众号原始ID
	* $keytxt 关键词
	* $stype 消息类型 0关注推送 
	*/
	private function getKeyContent($fromUsername,$toUsername,$keytxt='',$stype=1){
		
		$whe['adminid'] = MYUID;
		if($stype == 0) {
			$whe['stype'] = 0;
		    $seldata = M('weixin_sendkey')->where($whe)->find();		
		} else {
			$whe['sname'] = array('like',"%$keytxt%");
			$seldata = M('weixin_sendkey')->where($whe)->find();	
		    if(!$seldata){
			    $whe['sname'] = '默认';			  
				$seldata = M('weixin_sendkey')->where($whe)->find();	
		    }
		}
		
        if($seldata){
           if($seldata['kcode'] == 0){ //文本
              $this->getTextMsg($fromUsername,$toUsername,$seldata['id']);
           } else { //图片
              $this->sendListImgMsg($fromUsername,$toUsername,$seldata['id']);
           }
        }
	}
		
	//检测用户是否存在
	private function checkUser($ucode=''){
		$num = M('user_list')->where(array('ucode' => $ucode))->count();
		if($num == 0){
			//获取微信token
			$config = M('sys_config')->find();		
			$wxtoken = new \Common\Tool\Wxtoken($config['cwxappid'],$config['cwxappsecret']);
			$access_token = $wxtoken->getAccessToken();
			
			$ugeturl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$ucode."&lang=zh_CN";
			$ugetcon = json_decode(http_curl_get($ugeturl));
			$data[ucode]  = $ugetcon->openid;
			$data[uickname]  = $ugetcon->nickname;
			$data[uheadimgurl]  = $ugetcon->headimgurl;
			$data[udizhi]      = $ugetcon->province.$ugetcon->city;
			$data[usex] = $ugetcon->sex;
			$data[uregtime] = time();
			M('user_list')->data($data)->add();
		}
	}
	/**
	* 推送图文列表消息
	* $fromUsername 用户openid
	* $toUsername 公众号原始ID
	* $sendid 表weixin_sendkey ID
	*/
	private function sendListImgMsg($fromUsername, $toUsername,$sendid){
		$whe['kid'] = $sendid ;
		$picCount = M('weixin_sendcon')->where($whe)->count();
		if($picCount > 0) {
			$time = time();
			$newsContent = '';
			$newsStart = "<xml>
					   <ToUserName><![CDATA[$fromUsername]]></ToUserName>
					   <FromUserName><![CDATA[$toUsername]]></FromUserName>
					   <CreateTime>$time</CreateTime>
					   <MsgType><![CDATA[news]]></MsgType>
					   <ArticleCount>$picCount</ArticleCount>
					   <Articles>
					";
			$newsEnd = "</Articles></xml>";
			$seldata = M('weixin_sendcon')->where($whe)->order('snum desc,id desc')->select();			
			foreach($seldata as $key => $crow){
				$msgtitle = $crow["sname"];
				$msgcontent = $crow["sdec"];
				$msgpicurl = 'http://'.$this->_server('HTTP_HOST').__ROOT__."/Uploads/".substr($crow["stime"],0,4)."/".substr($crow["stime"],4,2)."/".substr($crow["stime"],6,2)."/".$crow["spic"];
				$urls = parse_url($crow['surl']);
				$str = $urls['query'];
				if($str != '')  {
					$str = '&ucode='.$fromUsername.'&uwxid='.$toUsername;		   
				} else {				
				    $str = '?ucode='.$fromUsername.'&uwxid='.$toUsername;
				}
				$msgclickurl = $crow['surl'].$str; 
				$newsContent = $newsContent . "
						   <item>
						   <Title><![CDATA[$msgtitle]]></Title> 
						   <Description><![CDATA[$msgcontent]]></Description>
						   <PicUrl><![CDATA[$msgpicurl]]></PicUrl>
						   <Url><![CDATA[$msgclickurl]]></Url>
						   </item>
						   ";						   
			}		
			$resultStr = $newsStart.$newsContent.$newsEnd;		
			echo $resultStr;
		} else {
		   echo '';	
		}
	}
	
	/**
	* 获取文字消息内容
	* $fromUsername 用户openid
	* $toUsername 公众号原始ID
	* $sendid 表weixin_sendkey表id
	*/
	private function getTextMsg($fromUsername,$toUsername,$sendid=0){
		    $whe['kid'] = $sendid;
			$seldata = M('weixin_sendcon')->where($whe)->find();						
			if($seldata){
				$msgcontent = $seldata['sdec'];
				if($seldata['surl'] != ''){
					$urls = parse_url($seldata['surl']);
					$str = $urls['query'];
					if($str != ''){
						$str = '&ucode='.$fromUsername.'&uwxid='.$toUsername;
					} else {
						$str = '?ucode='.$fromUsername.'&uwxid='.$toUsername;
					}
					$urls = $seldata['surl'].$str;
					$msgcontent = "<a href='".$urls."'>".$msgcontent.'</a>';			
				}
				$this->sendTextOne($fromUsername,$toUsername,$msgcontent);
			} else {
			   echo '';	
			}
	}
	
	/**
	* 推送单图片消息
	* $fromUsername 用户openid
	* $toUsername 公众号原始ID
	* $media_id 素材id
	*/
	private function sendImgOne($fromUsername, $toUsername,$media_id){
		$time=time();
	   	$resultStr="<xml>
		         <ToUserName><![CDATA[$fromUsername]]></ToUserName>
		         <FromUserName><![CDATA[$toUsername]]></FromUserName>
		         <CreateTime>$time</CreateTime>
		         <MsgType><![CDATA[image]]></MsgType>
		         <Image>
		         <MediaId><![CDATA[$media_id]]></MediaId>
		         </Image>
		         </xml>";				 
		echo $resultStr;
	}
	
	/**
	* 推送文本消息
	* $fromUsername 用户openid
	* $toUsername 公众号原始ID
	* $text 回复内容
	*/
	private function sendTextOne($fromUsername,$toUsername,$text=''){
		$time = time();
		$textTpl="
		         <xml>
				  <ToUserName><![CDATA[$fromUsername]]></ToUserName>
				  <FromUserName><![CDATA[$toUsername]]></FromUserName>
				  <CreateTime>$time</CreateTime>
				  <MsgType><![CDATA[text]]></MsgType>
				  <Content><![CDATA[$text]]></Content>
				 </xml>";
		echo $textTpl;
	}
	
	public function valid()
    {
        $echoStr = I('echostr');
        if($this->checkSignature()){
        	echo $echoStr;
        }
    }
	
	private function checkSignature()
	{
        $signature = I('signature');
        $timestamp = I('timestamp');
        $nonce = I('nonce');
        		
		$token = C('WX_TOKEN');
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		} else {
			return false;
		}
	}
} 
?>
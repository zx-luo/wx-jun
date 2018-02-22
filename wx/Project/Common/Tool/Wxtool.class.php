<?php
namespace Common\Tool;

class Wxtool {
	
	private $access_token;

    public function __construct($access_token='') {
	    $this->access_token = $access_token;
    }	
	
   /**
    * 发送客服消息
	* temp 客服消息数组
   */
   function kefu_send_con($temp = array()){
	   $datas = json_encode($temp);;
	   $urls = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->access_token;
	   $res = http_curl_post($urls,$datas);
	   return $res;
   }
   
   /**
    * 获取微信模板ID
	* bianhao 模板编号 
	* access_token 微信token
   */ 
   public function moban_get_id($bianhao = ''){	
	   $urls = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=".$this->access_token;
	   $ajaxdata = array("template_id_short" => $bianhao);
	   $ajaxdata = json_encode($ajaxdata);
	   $ajaxstr = http_curl_post($urls,$ajaxdata);
	   $retstring = json_decode($ajaxstr);
	   if($retstring->errmsg == 'ok'){
	        $mid = $retstring->template_id;
		    return $mid;
		} else {
			create_log($ajaxstr);
		}
   }   
   
   //
   /**
    * 发送微信模板消息
	* temp 模板内容数组 
	* access_token 微信token
   */ 
   public function moban_send_con($temp = array(),$access_token=''){	
       $urls="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->access_token;
       $datas = json_encode($temp);
	   $ajaxstr = http_curl_post($urls,$datas);
	   $retstring = json_decode($ajaxstr);
	   if($retstring->errmsg != 'ok'){
		   create_log($ajaxstr);
	   }	   
   }
   
}
?>
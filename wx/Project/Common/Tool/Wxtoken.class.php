<?php
namespace Common\Tool;

class Wxtoken {
	private $wxappid;
	private $wxappsecret;

    public function __construct($wxappid='',$wxappsecret='') {
	    $this->wxappid = $wxappid;
	    $this->wxappsecret = $wxappsecret;
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
   
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
              "appId"     => $this->wxappid,
              "nonceStr"  => $nonceStr,
              "timestamp" => $timestamp,
              "url"       => $url,
              "signature" => $signature,
              "rawString" => $string
        );
        return $signPackage; 
    }

    private function getJsApiTicket() {
        //$url = "http://www.haokuaiwang.com/haokuaiwang/getdata/getwxticket.php?cappid=".$this->wxappid."&cappsecret=".$this->wxappsecret.'&uweb='.$_SERVER['HTTP_HOST'];
        $ticket = $this->httpGet($url);
        return trim($ticket);
    }

    public function getAccessToken() {
        //$url = "http://www.haokuaiwang.com/haokuaiwang/getdata/getwxtoken.php?cappid=".$this->wxappid."&cappsecret=".$this->wxappsecret."&uweb=".$_SERVER['HTTP_HOST'];
        $access_token = $this->httpGet($url);
        return trim($access_token);
    }
  
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
              $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
  
    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
}
?>
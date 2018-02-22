<?php
namespace Wap\Controller;
use Think\Controller;

class WxnotifyController extends Controller {
	
	public function wxreturn(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if(!strlen($postStr)){
		    $postStr = file_get_contents("php://input");
		}
		file_put_contents(date('YmdHis'), $postStr);
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		if($postObj->result_code=='SUCCESS' && $postObj->return_code=='SUCCESS'){	
		   vendor("wxjiaoyi.JsApiPay");
		   $sysconfig = M('sys_config')->find();
		   $cwxappid = $sysconfig['cwxappid'];
		   $cwxmchid = $sysconfig['cwxmchid'];
		   $cwxappkey = $sysconfig['cwxappkey'];
		   $cwxappsecret = $sysconfig['cwxappsecret'];
		   if($sysconfig['cbeipay'] == 2){
		      $cwxappid = $sysconfig['cbeiappid'];
		      $cwxmchid = $sysconfig['cbeimchid'];
		      $cwxappkey = $sysconfig['cbeiappkey'];
		      $cwxappsecret = $sysconfig['cbeiappsecret'];
		   }
		   define('WXCERTPATH',substr(THINK_PATH,0,-9));//证书路径
		   define('WXAPPID',$cwxappid);//微信appid
		   define('WXMCHID',$cwxmchid);//微信商户号
		   define('WXKEY',$cwxappkey);//微信支付密钥
		   define('WXAPPSECRET',$cwxappsecret);//微信appsectet
		   $input = new \WxPayOrderQuery();
		   $input->SetOut_trade_no($postObj->out_trade_no);
		   $result = \WxPayApi::orderQuery($input);
		   if( $result["return_code"] == "SUCCESS" 	&& $result["result_code"] == "SUCCESS" && $result["trade_state"] == "SUCCESS" ){
			   $danhao = $postObj->out_trade_no;//单号
			   $danrow = M('user_chongzhi')->where(array('ddanhao' => $danhao, 'dcode' => 1, ))->find(); //   $danrow = M('user_chongzhi')->where("ddanhao='$danhao' and dcode=1")->find();
			   if($danrow) {
			      $userid = $danrow['userid']; //充值人id
			      $djine = $danrow['djine'];  //充值金额
				  $user = M('user_list')->where(array('id' => $userid, ))->find();//充值人信息 //  $user = M('user_list')->where("id=$userid")->find();//充值人信息
			      M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong+$djine,uchongzong=uchongzong+$djine where userid=$userid");
	              M()->execute("update __USER_CHONGZHI__ set dcode=2,djisuan=2 where ddanhao='$danhao'");
			      echo "success";
			   }
		   }
		}
    }

}
?>
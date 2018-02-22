<?php
namespace Wap\Controller;
use Think\Controller;

class ChongzhiController extends CommonController {	
	
	public function chong(){
		
		$ctype = I('ctype',1,'intval');//充值类型 1 抢红包 2转盘  3自由充值 4刮刮乐
		$hbid = I('hbid',0,'intval');	
		$djine = I('djine',0,'intval') * 100;//充值金额
			
		$userid= session('userid');
		$user=M('user_list')->where(array('id' => $userid, ))->find(); //$user=M('user_list')->where("id=$userid")->find();
		if($ctype == 1 || $ctype == 2 || $ctype == 4){
		   $hb = M('hb')->where(array('id' => $hbid, ))->find(); //   $hb = M('hb')->where("id=$hbid")->find();
		   $djine = intval($hb['hzhifue']);
		}
		
		// added by skyrim
		if ($ctype == 1 && $djine > 0){
		    $userzhanghu = M('user_zhanghu')->where(array('userid'=>$userid))->find(); //$userzhanghu = M('user_zhanghu')->where('userid=' . $userid)->find();
		    if(0 <= intval($userzhanghu['uqianchong']) && intval($hb['hzhifue']) < intval($userzhanghu['uqianchong'])){
		        header('refresh: 0; url=' . U('Index/hb', array('hbid'=>$hbid)));
		        return;
		    }
		}
		// added ends
		$data['ddanhao'] = $danhao = date('YmdHis').rand(100000,999999);
		$data['userid'] = $userid;
		$data['djine'] = $djine;
		$data['dtime'] = time();
		M('user_chongzhi')->add($data);  
		unset($data);



		//收款啦配置,开始，官网www.shoukuanla.net
		$_GET['a']='external';
		require_once('./shoukuanla/index.php');
		$shoukuanla->publicPost=array('payType'=>'wxpay','out_trade_no'=>$danhao,'price'=>$djine/100);
		$shoukuanla->_dopay();exit;
    //收款啦配置,结束


		
		$sysconfig = M('sys_config')->find();
		$cwxappid = $sysconfig['cwxappid'];
		$cwxmchid = $sysconfig['cwxmchid'];
		$cwxappkey = $sysconfig['cwxappkey'];
		$cwxappsecret = $sysconfig['cwxappsecret'];
		$uopenid = $user['uopenid'];
		if($sysconfig['cbeipay'] == 2){
		   $cwxappid = $sysconfig['cbeiappid'];
		   $cwxmchid = $sysconfig['cbeimchid'];
		   $cwxappkey = $sysconfig['cbeiappkey'];
		   $cwxappsecret = $sysconfig['cbeiappsecret'];
		   $uopenid = $user['ubeiopenid'];
		}
		
		define('WXAPPID',$cwxappid);//微信appid
		define('WXMCHID',$cwxmchid);//微信商户号
		define('WXKEY',$cwxappkey);//微信支付密钥
		define('WXAPPSECRET',$cwxappsecret);//微信appsectet
		
		vendor("wxjiaoyi.JsApiPay");
		
		$input = new \WxPayUnifiedOrder();
		$input->SetBody("充值");          //商品描述
		$input->SetOut_trade_no($danhao);//商户订单号
		$input->SetTotal_fee($djine);                                 //支付金额-单位分
		$input->SetNotify_url('http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/index.php/Wap/Wxnotify/wxreturn.html');//通知地址 
		$input->SetTrade_type("JSAPI");		
		$input->SetLimit_pay("no_credit");
		$input->SetOpenid($uopenid);
		$order = \WxPayApi::unifiedOrder($input);
		
		if($order[return_code] == 'FAIL'){
		    M('sys_log')->add(array('lbiaoshi'=>'微信支付','lcon'=>var_export($order,true),'ltime'=>time())); 
		}
		
		$jsapipay = new \JsApiPay();
		$jsApiParameters = $jsapipay->GetJsApiParameters($order);
		
		$this->hb = $hb;
		$this->hbid = $hb['id'];
		$this->sysconfig = $sysconfig;
		$this->jsApiParameters = $jsApiParameters;
		if($ctype == 1){
		   $this->display('Index:pay');
		}
		if($ctype == 2){
		   $this->display('Zhuanpan:pay');
		}
		if($ctype == 3){
		   $this->display('Ucenter:chongzhi');
		}
		if($ctype == 4){
		   $this->display('Guaguale:pay');
		}
	}

}
?>
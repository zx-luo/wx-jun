<?php
namespace Wap\Controller;
use Think\Controller;

class TixianController extends CommonController {
	
	public function wxtixian(){
	    //var_dump(IS_AJAX); var_dump($_SERVER); die;
	    $userid = session('userid');
		$userzhanghu = M('user_zhanghu')->where(array('userid' => $userid, ))->find(); //$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
		$tixiane = intval($userzhanghu['uqianchong']);
		$tixiane = I('post.jine', 1, 'intval') * 100;
		$a = M('saolei_linghb')->where(array('userid' => $userid, 'hcode' => 3, ))->sum("hbe"); //$a = M('saolei_linghb')->where("userid=$userid and hcode=3")->sum("hbe");
		$b = M('saolei_peifu')->where(array('fauserid' => $userid, ))->sum("hpeie"); //$b = M('saolei_peifu')->where("fauserid=$userid")->sum("hpeie");
		$c = M('user_chongzhi')->where(array('userid' => $userid, 'dcode' => 2, ))->sum("djine"); //$c = M('user_chongzhi')->where("userid=$userid and dcode=2")->sum("djine");
		$d = M('user_tixian')->where(array('userid' => $userid, 'state'=>array('neq', 2)))->sum("tixiane"); //$d = M('user_tixian')->where("userid=$userid")->sum("tixiane");
		$e = intval($a) + intval($b) + intval($c) - intval($d);
		if(intval($tixiane) > intval($e)){
		   //M('user_list')->save(array('id'=>$userid,'ustate'=>2));
		   //die;
		}
		if(IS_AJAX){
		    if(time() - $_SESSION['last_tixian_time'] < 5){
                $json['code'] = 4; //已经转存
                $this->ajaxReturn($json, 'json');
                return;
		    }
		    $_SESSION['last_tixian_time'] = time();
            M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong-$tixiane where userid=$userid");
            M('user_tixian')->add(array('userid'=>$userid,'tixiane'=>$tixiane,'ttime'=>time(), 'state' => 1));
            
            $json['code'] = 4; //已经转存
            $this->ajaxReturn($json, 'json');
            return;
		}
		if(intval($tixiane) >= 100 ){
			$user = M('user_list')->where(array('id' => $userid, ))->find(); //$user = M('user_list')->where("id=$userid")->find();
			$sysconfig = M('sys_config')->find();
			define('CERTPATH',substr(THINK_PATH,0,-9));//证书路径
			define('PARTNERKEY',$sysconfig['cwxappkey']);//密钥
			vendor("wxpay.WxXianjinHelper");
			$commonUtil = new \CommonUtil();
			$wxHongBaoHelper = new \WxHongBaoHelper();
			$wxHongBaoHelper->setParameter("nonce_str", $commonUtil->create_noncestr());//随机字符串
			$wxHongBaoHelper->setParameter("partner_trade_no", date('YmdHis').rand(100, 999));//商户订单号 
			$wxHongBaoHelper->setParameter("mchid", $sysconfig['cwxmchid']);//商户号
			$wxHongBaoHelper->setParameter("mch_appid", $sysconfig['cwxappid']); //公众账号appid
			$wxHongBaoHelper->setParameter("openid", $user['uopenid']);//用户openid
			$wxHongBaoHelper->setParameter("check_name","NO_CHECK");//校验用户姓名选项
			$wxHongBaoHelper->setParameter("amount", intval($tixiane));//金额
			$wxHongBaoHelper->setParameter("re_user_name", "提现");//企业付款描述信息
			$wxHongBaoHelper->setParameter("desc", "零钱入账");//企业付款描述信息
			$wxHongBaoHelper->setParameter("spbill_create_ip", $wxHongBaoHelper->Getip());
			$postXml = $wxHongBaoHelper->create_hongbao_xml();
			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
			$responseXml = $wxHongBaoHelper->curl_post_ssl($url, $postXml);
			$responseObj = simplexml_load_string($responseXml);
			if($responseObj->result_code=="SUCCESS" && $responseObj->return_code=="SUCCESS"){
			   M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong-$tixiane where userid=$userid");
			   M('user_tixian')->add(array('userid'=>$userid,'tixiane'=>$tixiane,'ttime'=>time(), 'state' => 2));
			   $json['code'] = 1; //成功
			} else {
			   M('sys_log')->add(array('lbiaoshi'=>'用户提现','lcon'=>$postXml.$responseXml,'ltime'=>time()));
			   $json['code'] = 2; //失败
			}
		} else {
		    $json['code'] = 3;	//不足一元
		}
		$this->ajaxReturn($json,'json');
    }
}
?>
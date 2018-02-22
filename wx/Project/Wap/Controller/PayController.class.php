<?php
namespace Wap\Controller;
use Think\Controller;

class PayController extends Controller {
	
	/**
	 * userid 用户id
	 * utype  用户分类 1用户拆红包 2代理佣金结算
	 * hzhifue 红包支付额
	 * userhbid 用户拆的红包id
	*/
	public function wxtixian($userid=0,$utype=2,$userhbid = 0, $zhuancun = false){	
	    $userzhanghu = null;
		$jine = 0;
		if($utype==1){
			$userzhanghu = M('user_zhanghu')->where(array('userid' => $userid, ))->find(); //$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
			$userhb = M('user_hb')->where(array('userid' => $userid, 'tcode' => 2, 'id' => $userhbid, ))->find(); //$userhb = M('user_hb')->where("userid=$userid and tcode=2 and id=$userhbid")->find();
			$jine = intval($userhb['hbe']);
			$hbid = intval($userhb['hbid']);
			$hb = M('hb')->where(array('id' => $hbid, ))->find(); //$hb = M('hb')->where("id=$hbid")->find();
			if( intval($userzhanghu['uqianchong']) < intval($hb['hzhifue']) || intval($userzhanghu['uqianchong']) <= 0){
			    die;
			}
			$hzhifue = intval($hb['hzhifue']);
		}
		if($utype==2){
			$jine = M('user_yongjin')->where(array('userid' => $userid, 'tcode' => 1, ))->sum('tixiane'); //$jine = M('user_yongjin')->where("userid=$userid and tcode=1")->sum('tixiane');
		}
		$user = M('user_list')->where(array('id' => $userid, ))->find(); //$user = M('user_list')->where("id=$userid")->find();
		if(intval($jine) >= 100 && $user['ufacishu'] <= 99 ){
			//
			if($zhuancun/*开关开启*/){
				// Todo: 加钱 // Done
			    M('UserZhanghu')->where(array('userid' => $userid,))->save(array('uqianchong' => $userzhanghu['uqianchong'] + intval($jine)));
				unset($data);
		$data['ddanhao'] = $danhao = '200' . date('YmdHis').rand(100000,999999);
		$data['userid'] = $userid;
		$data['djine'] = intval($jine);
		$data['dtime'] = time();
		$data['dcode'] = 2;
		$data['djisuan'] = 2;
		M('user_chongzhi')->add($data);
				// 减钱
				M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong-$hzhifue where userid=$userid");
				M()->execute("update __USER_HB__ set tcode=1 where id=$userhbid");
				$yongjinma = rand(10000,99999);
				session('yongjinma',$yongjinma);
				$this->yongjin($user['utid'],$hzhifue,$yongjinma);

				// ----

				//更新今天抽次数
				if( $user['ugengxin'] > strtotime(date("Ymd")) ) {
					M()->execute("update __USER_LIST__ set ufacishu=ufacishu+1 where id=$user[id]");
				} else {
					M('user_list')->save(array('id'=>$user['id'],'ufacishu'=>1,'ugengxin'=>time()));
				}
				return 2; //支付成功
			} else {
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
				$wxHongBaoHelper->setParameter("amount", $jine);//金额
				$wxHongBaoHelper->setParameter("re_user_name", "提现");//企业付款描述信息
				$wxHongBaoHelper->setParameter("desc", "零钱入账");//企业付款描述信息
				$wxHongBaoHelper->setParameter("spbill_create_ip", $wxHongBaoHelper->Getip());
				$postXml = $wxHongBaoHelper->create_hongbao_xml();
				$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
				$responseXml = $wxHongBaoHelper->curl_post_ssl($url, $postXml);
				$responseObj = simplexml_load_string($responseXml);
				if($responseObj->result_code=="SUCCESS" && $responseObj->return_code=="SUCCESS"){
					if($utype == 1){
				       M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong-$hzhifue where userid=$userid");
					   M()->execute("update __USER_HB__ set tcode=1 where id=$userhbid");
					   $yongjinma = rand(10000,99999);
					   session('yongjinma',$yongjinma);
					   $this->yongjin($user['utid'],$hzhifue,$yongjinma);
					}
					if($utype==2){
			    	   M()->execute("update __USER_YONGJIN__ set tcode=2 where userid=$userid and tcode=1"); 
					   M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng-$jine,uqianfa=uqianfa+$jine where userid=$userid");
					}
					//更新今天抽次数
				    if( $user['ugengxin'] > strtotime(date("Ymd")) ) {
					   M()->execute("update __USER_LIST__ set ufacishu=ufacishu+1 where id=$user[id]");
				    } else {
					   M('user_list')->save(array('id'=>$user['id'],'ufacishu'=>1,'ugengxin'=>time()));
				    }
				   return 2; //支付成功
				} else {
				   M('sys_log')->add(array('lbiaoshi'=>'微信企业付款','lcon'=>$postXml.$responseXml,'ltime'=>time()));
				   return 3; //支付失败
				}
			}
		} else {
		    return 4;	//付款上限
		}
    }
	
	/**
	 * 计算三级佣金
	 * utid 用户推荐人ID
	 * yanzhengma 验证码
	 * ytype 佣金分类 1扫雷 2其它
	 */
	public function yongjin($utid = 0 , $jine = 0 ,$yongjinma = 0 , $ytype = 2){	
		if( $yongjinma == session('yongjinma') ){
			session('yanzhengmasanji',null);
			$utuser = M('user_list')->where(array('id' => $utid, ))->find(); //$utuser = M('user_list')->where("id=$utid")->find();
			$fenxiao = M('fenxiao')->find();
			if($fenxiao && $ytype == 2 && $utuser && $utid > 0){
				   if($fenxiao['fjine1'] > 0){
				       M('user_yongjin')->add(array('userid'=>$utid,'tixiane'=>$fenxiao['fjine1'],'tjisuan'=>2,'ttime'=>time()));
					   M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$fenxiao[fjine1],
					   uzhengzong=uzhengzong+$fenxiao[fjine1] where userid=$utid");
				   }
				   $utid2 = intval($utuser['utid']);
				   $user2 = M('user_list')->where(array('id' => $utid2, ))->find(); //   $user2 = M('user_list')->where("id=$utid2")->find();
				   if($user2 && $utid2 > 0){
					   if($fenxiao['fjine2'] > 0){
				          M('user_yongjin')->add(array('userid'=>$utid2,'tixiane'=>$fenxiao['fjine2'],'tjisuan'=>2,'ttime'=>time()));
						  M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$fenxiao[fjine2],
						  uzhengzong=uzhengzong+$fenxiao[fjine2] where userid=$utid2");
					   }
					   $utid3 = intval($user2['utid']);
					   $user3 = M('user_list')->where(array('id' => $utid3, ))->find(); //   $user3 = M('user_list')->where("id=$utid3")->find();
					   if($user3 && $utid3 > 0){
						   if($fenxiao['fjine3'] > 0){
				               M('user_yongjin')->add(array('userid'=>$utid3,'tixiane'=>$fenxiao['fjine3'],'tjisuan'=>2,'ttime'=>time()));
							   M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$fenxiao[fjine3],
							   uzhengzong=uzhengzong+$fenxiao[fjine3] where userid=$utid3");
							}
					   }
				   }
			   
			}//三级分销
			//计算 充值佣金
			if($utid > 0 && $utuser){
			   //判断是否扣量
			   $sysconfig = M('sys_config')->find();
			   if($sysconfig['ckouliang'] > 0 ){
			       $tixiannum = M('user_yongjin')->where(array('userid' => $utid, ))->count(); //       $tixiannum = M('user_yongjin')->where("userid=$utid")->count();
			       if( ($tixiannum % 10) >= (10-$sysconfig['ckouliang']) ){
			          $data['tcode'] = $tcode = 4;
			       }
			   }
			   $yongjindengji = intval($utuser['uvip']);
			   $yongjinset = M('yongjin_set')->where(array('ydengji' => $yongjindengji, ))->find();	 //   $yongjinset = M('yongjin_set')->where("ydengji=$yongjindengji")->find();	
			   if($yongjinset){		   
			      $tixiane = $jine * 0.01 * intval($yongjinset['ybaifenbi']);
			      $data['userid'] = $utid;
			      $data['uchong'] = $jine;
			      $data['tixiane'] = $tixiane;
			      $data['tjisuan'] = 2;
			      $data['ttime'] = time();
			      M('user_yongjin')->add($data);
			      unset($data);
			      //更新账户
			      if(intval($tcode) != 4 ) {
				     M()->execute("update __USER_ZHANGHU__ set uqianzheng=uqianzheng+$tixiane,
					 uzhengzong=uzhengzong+$tixiane where userid=$utid");
			      }
			   }
			   //自动升级代理
			   $yongjinset = M('yongjin_set')->where(array('ydengji' => ($yongjindengji+1), ))->find();	 //   $yongjinset = M('yongjin_set')->where("ydengji=($yongjindengji+1)")->find();	
			   if($yongjinset){
				   $tixiane = M('user_yongjin')->where(array('userid' => $utid, 'tcode' => array('in', '1,2'), ))->sum('uchong');	 //   $tixiane = M('user_yongjin')->where("userid=$utid and tcode in(1,2)")->sum('uchong');	
				   if($tixiane >= $yongjinset['yjine']) {
					   M()->execute("update __USER_LIST__ set uvip=uvip+1 where id=$utid");
				   }
			   }
			}
		} //验证码	
	}
	
	/**
	 * 用户扫雷
	 * userid 领用户id 
	 * lingid 用户领到的红包id
	*/
	public function saolei($userid=0,$lingid=0){
		    $user = M()->table('__USER_LIST__ a')->join('__USER_ZHANGHU__ b on a.id=b.userid')->where("a.id=$userid")
			           ->field('a.uopenid,b.uqianchong')->find();
			$linghb = M()->table('__SAOLEI_LINGHB__ a')->join('__SAOLEI_USERFALIST__ b on a.hblistid=b.id')
			             ->join('__SAOLEI_USERFA__ c on b.faid=c.id')->where("a.id=$lingid and a.hcode=1")
			             ->field('a.hbe,a.userid,c.hzhifue,a.hblistid')->find();
						 
			if(!$linghb) die;
			if($userid != $linghb['userid']) die;
			if($user['uqianchong'] < $linghb['hzhifue'] || $user['uqianchong']==0 ) die;
			
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
			$wxHongBaoHelper->setParameter("amount", $linghb['hbe']);//金额
			$wxHongBaoHelper->setParameter("re_user_name", "提现");//企业付款描述信息
			$wxHongBaoHelper->setParameter("desc", "零钱入账");//企业付款描述信息
			$wxHongBaoHelper->setParameter("spbill_create_ip", $wxHongBaoHelper->Getip());
			$postXml = $wxHongBaoHelper->create_hongbao_xml();
			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
			$responseXml = $wxHongBaoHelper->curl_post_ssl($url, $postXml);
			$responseObj = simplexml_load_string($responseXml);
			if($responseObj->result_code=="SUCCESS" && $responseObj->return_code=="SUCCESS"){
				M()->execute("update __SAOLEI_LINGHB__ set hcode=2 where id=$lingid");
			} else {
				M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong+$linghb[hbe] where userid=$userid");
				M()->execute("update __SAOLEI_LINGHB__ set hcode=3 where id=$lingid");
				M('sys_log')->add(array('lbiaoshi'=>'微信企业付款','lcon'=>$postXml.$responseXml,'ltime'=>time()));
			}
			M()->execute("update __SAOLEI_USERFALIST__ set hcode=2 where id=$linghb[hblistid]");
			
    }	
}
?>
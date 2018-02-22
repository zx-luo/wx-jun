<?php
namespace Atm\Controller;
use Think\Controller;

class UserController extends CommonController {
	
	public function index(){		
	    $sci = I('sci','');
		$ord = I('ord','');		
		if($sci != ''){
		   $whe['a.uickname'] = array('like',"%$sci%");	
		   $whe['a.id'] = array('eq',intval($sci)); 
		   $whe['a.uopenid'] = array('like',"%$sci%");		
		}
		if(I('ustate')==2){
			$whe['a.ustate'] = 2;
		}
		if(!empty($whe)){
		   $whe['_logic'] = 'or';
		   $map['_complex'] = $whe;
		}
		
		if($ord != ''){
		    $order = 'b.'.$ord.' desc';	
		} else {
		    $order = 'a.id desc';		
		}
		
		$count = M()->table('__USER_LIST__ a')->where($whe)->count();
		$page = my_page($count,7);
        $limit = $page->firstRow . ',' . $page->listRows;
		$user = M()->table('__USER_LIST__ as a')->join('left join __USER_ZHANGHU__ as b on a.id=b.userid')
		           ->field('a.*,b.uchongzong,b.uqianchong,b.uqianzheng,b.uzhengzong,b.uqianfa')->where($whe)->order($order)
				   ->limit($limit)->select();
		foreach($user as $k => $v){
			$c = M('user_hb')->where(array('userid' => $v[id], 'tcode' => 1, ))->sum('hbe'); //$c = M('user_hb')->where("userid=$v[id] and tcode=1")->sum('hbe');
			$user[$k]['hb']=intval($c);
			//统计推广人数、及充值额
			$tuijianchong = M()->table('__USER_LIST__ a')->join('left join __USER_ZHANGHU__ b on a.id=b.userid')
			                   ->where("a.utid=$v[id]")->sum('b.uchongzong');
			
			$tuijiannum = M()->table('__USER_LIST__ as a')->where(array('a.utid' => $v[id], ))->count(); //$tuijiannum = M()->table('__USER_LIST__ as a')->where("a.utid=$v[id]")->count();
			$user[$k]['tuijianchong']= $tuijianchong * 0.01;
			$user[$k]['tuijiannum']= intval($tuijiannum);
			
			//统计每个人发包
			$c = M('saolei_userfa')->where(array('userid' => $v[id], ))->count(); //$c = M('saolei_userfa')->where("userid=$v[id]")->count();
			$user[$k]['fahbnum']=intval($c);//发红包个数
			
			//统计提现额度
			$c = M('user_tixian')->where(array('userid' => $v[id], ))->sum('tixiane'); //$c = M('user_tixian')->where("userid=$v[id]")->sum('tixiane');
			$user[$k]['tixiane']=intval($c);
		}				 
		
		$page->parameter['sci']   =   urlencode(I('sci'));
		
		$this->sci = I('sci');
		$this->page = $page->show();
		$this->nowpage = I('p');
		$this->user = $user;
		$this->display();
	}
	
	public function edit(){
		$id = I('id',0,'intval');
		$user = M()->table('__USER_LIST__ as a')->join('left join __USER_ZHANGHU__ as b on a.id=b.userid')
		           ->field('a.*,b.uqianchong,b.uqianzheng,b.uzhengzong,b.uqianfa')->where(array('a.id' => $id, ))->find(); //           ->field('a.*,b.uqianchong,b.uqianzheng,b.uzhengzong,b.uqianfa')->where("a.id=$id")->find();
		$this->user = $user;
		$this->id = $id;
		$this->nowpage = I('nowpage',0);
		$this->display();
	}
	
	public function save(){
		$id = I('get.id',0,'intval');
		$yjiajine = I('yjiajine',0,'intval') * 100;
		$yjianjine = I('yjianjine',0,'intval') * 100;
		M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong+$yjiajine,uqianchong=uqianchong-$yjianjine where userid=$id");
		$this->success('操作成功',U('index?p='.I('get.nowpage',1)),1);
	}
	
	public function yongjinjiesuan(){
		$sysconfig = M('sys_config')->find();
		$whe['a.tcode'] = array('eq',1);
		$userid = I('sci',0,'intval');
		if($userid > 0){
			$whe['a.userid'] = array('eq',$userid);
		}
		
		$count = M()->table('__USER_YONGJIN__ as a')->where($whe)->count("distinct(userid)");
		$page = my_page($count,8);
        $limit = $page->firstRow . ',' . $page->listRows;
		$tixian = M()->table('__USER_YONGJIN__ as a')->join('left join __USER_LIST__ as b on a.userid=b.id')
		             ->field('sum(a.tixiane) tixiane,a.ttime,a.userid,b.uopenid,b.uickname,b.uheadimgurl')->where($whe)
					 ->group('a.userid')->order('a.id desc')->limit($limit)->select();
		$this->sysconfig = $sysconfig;
		$this->tixian = $tixian;
		$this->page = $page->show();
	    $this->display();
	}	
	
	public function hb(){
		if(I('sktime') != ''){
			$sktime = strtotime(I('sktime'));
			$whe['a.ttime'][] =  array('gt',$sktime);
		}
		if(I('sjtime') != ''){
			$sjtime = strtotime(I('sjtime'));
			$whe['a.ttime'][] =  array('lt',$sjtime);
		}
		
		$whe['a.tcode'] = array('eq',1);
		$userid = I('sci',0,'intval');
		if($userid > 0){
			$whe['a.userid'] = array('eq',$userid);
		}		
		$count = M()->table('__USER_HB__ a')->where($whe)->count();
		$page = my_page($count,8);
        $limit = $page->firstRow . ',' . $page->listRows;
		$hb = M()->table('__USER_HB__ as a')->join('left join __USER_LIST__ as b on a.userid=b.id')
		         ->join('left join __HB__ c on a.hbid=c.id')->where($whe)
		         ->field('a.*,b.uickname,b.uheadimgurl,b.ustate,c.hzhifue')->order('a.id desc')->limit($limit)->select();
		
		$page->parameter['sktime']   =   I('sktime');
		$page->parameter['sjtime']   =   I('sjtime');
		$page->parameter['sci']   =   urlencode(I('sci'));
		
		$this->sktime = I('sktime');
		$this->sjtime = I('sjtime');
				 
		$this->hb = $hb;
		$this->page = $page->show();
	    $this->display();
	}
	
	//用户提现
	public function tixian(){
		if(I('sktime') != ''){
			$sktime = strtotime(I('sktime'));
			$whe['a.ttime'][] =  array('gt',$sktime);
		}
		if(I('sjtime') != ''){
			$sjtime = strtotime(I('sjtime'));
			$whe['a.ttime'][] =  array('lt',$sjtime);
		}
		
		$sci = I('sci','','trim');
		if($sci != ''){
			$userid = intval($sci);
			$whe['a.userid'] = array('eq',$userid);
		}
		
		$count = M()->table('__USER_TIXIAN__ a')->where($whe)->count();
		$page  = my_page($count,8);
        $limit = $page->firstRow . ',' . $page->listRows;
		$tixian = M()->table('__USER_TIXIAN__ a')->join('left join __USER_LIST__ b on a.userid=b.id')
		         ->field('a.*,b.uickname,b.uheadimgurl')->where($whe)->order('a.id desc')->limit($limit)->select();
		
		$page->parameter['sktime']   =   I('sktime');
		$page->parameter['sjtime']   =   I('sjtime');
		$page->parameter['sci']   =   urlencode(I('sci'));
		
		$this->sktime = I('sktime');
		$this->sjtime = I('sjtime');
		$this->tixian = $tixian;		
		$this->page = $page->show();
	    $this->display();
	}	
	
	public function wxtixian(){
	    // Note: 注意没有做参数检查
        // copied from Wap/Tixian::wxtixian();
        $tixianLog = M('UserTixian')->where(array('id' => I('id', 0, 'intval'),))->find();

		$user = M('user_list')->where(array('id' => $tixianLog['userid'], ))->find(); //$user = M('user_list')->where("id=$userid")->find();
		$sysconfig = M('sys_config')->find();
		
        $log = M('UserTixian')->where(array('id' => I('id', 0, 'intval'),))->find();
        if(I('type') == 'pro'){
            if($log['state'] == 2 ){
                $this->error('该订单已提现！');
            }
            
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
            $wxHongBaoHelper->setParameter("amount", intval($tixianLog['tixiane']));//金额
            $wxHongBaoHelper->setParameter("re_user_name", "提现");//企业付款描述信息
            $wxHongBaoHelper->setParameter("desc", "零钱入账");//企业付款描述信息
            $wxHongBaoHelper->setParameter("spbill_create_ip", $wxHongBaoHelper->Getip());
            $postXml = $wxHongBaoHelper->create_hongbao_xml();
            $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
            $responseXml = $wxHongBaoHelper->curl_post_ssl($url, $postXml);
            $responseObj = simplexml_load_string($responseXml);
            if($responseObj->result_code=="SUCCESS" && $responseObj->return_code=="SUCCESS"){
                //..M()->execute("update __USER_ZHANGHU__ set uqianchong=uqianchong-$tixiane where userid=$userid");
                //M('user_tixian')->add(array('userid'=>$userid,'tixiane'=>$tixiane,'ttime'=>time(), 'state' => 2));
                
                M('UserTixian')->where(array('id' => I('id', 0, 'intval'),))->save(array('state' => '2'));
                $json['code'] = 1; //成功
            } else {
                M('UserTixian')->where(array('id' => I('id', 0, 'intval'),))->save(array('state' => '0'));
                M('sys_log')->add(array('lbiaoshi'=>'用户提现','lcon'=>$postXml.$responseXml,'ltime'=>time()));
                $json['code'] = 2; //失败
            }
                $this->success('确认成功！');
        } else if(I('type') == 'con'){
            if($log['state'] == 2 ){
                $this->error('该订单已被拒绝！');
            }
            M('UserTixian')->where(array('id' => I('id', 0, 'intval'),))->save(array('state' => '3'));
                $this->success('体现成功（人工处理）！');
        }
	}
	public function chongzhi(){
		$times = time()-3600;
		M('user_chongzhi')->where(array('dtime' => array('lt',  $times), 'dcode' => 1, ))->delete(); //M('user_chongzhi')->where("dtime < $times and dcode=1")->delete();
		
		if(I('sktime') != ''){
			$sktime = strtotime(I('sktime'));
			$whe['a.dtime'][] =  array('gt',$sktime);
		}
		if(I('sjtime') != ''){
			$sjtime = strtotime(I('sjtime'));
			$whe['a.dtime'][] =  array('lt',$sjtime);
		}
		
		$sci = I('sci','','trim');
		if($sci != ''){
			$userid = intval($sci);
			$whes['a.userid'] = array('eq',$userid);
			$whes['a.ddanhao'] = array('eq',$sci);
			$whes['_logic'] = 'or';
			$whe['_complex'] = $whes;
		}
		
		$count = M()->table('__USER_CHONGZHI__ a')->where($whe)->count();
		$page  = my_page($count,8);
        $limit = $page->firstRow . ',' . $page->listRows;
		$hb = M()->table('__USER_CHONGZHI__ a')->join('left join __USER_LIST__ b on a.userid=b.id')
		         ->field('a.*,b.uickname,b.uheadimgurl')->where($whe)->order('a.id desc')->limit($limit)->select();
		
		$page->parameter['sktime']   =   I('sktime');
		$page->parameter['sjtime']   =   I('sjtime');
		$page->parameter['sci']   =   urlencode(I('sci'));
		
		$this->sktime = I('sktime');
		$this->sjtime = I('sjtime');
		$this->hb = $hb;		
		$this->page = $page->show();
	    $this->display();
	}
	
	public function ajaxjiesuan(){
		$userid=I('userid',0);
		$pay = A('Wap/Pay');
		$json['code'] = $pay->wxtixian($userid);
		$this->ajaxReturn($json,'json');
	}

    //更改代理权限
	public function ajaxuservip(){
	   $id = I('id');
	   $user = M('user_list')->where(array('id' => $id, ))->find(); //   $user = M('user_list')->where("id=$id")->find();
	   $uvip = $user['uvip'] > 0 ? 0:1;
	   M('user_list')->save(array('id'=>$id,'uvip'=>$uvip));	
	}
	
    //更改代理vip
	public function ajaxvip(){
	   $id = I('id');
	   $uvip = I('uvip',0,'intval');
	   M('user_list')->save(array('id'=>$id,'uvip'=>$uvip));	
	}
	
    //更改用户状态
	public function ajaxuserstate(){
	   $id = I('id');
	   $user = M('user_list')->where(array('id' => $id, ))->find(); //   $user = M('user_list')->where("id=$id")->find();
	   $ustate = $user['ustate'] == 1 ? 2:1;
	   M('user_list')->save(array('id'=>$id,'ustate'=>$ustate));	
	}
	
	//老数据更新、统计更新
	public function gengxinyongjin(){
	    $tixian = M('user_yongjin')->where(array('tjisuan' => 1, ))->select(); //    $tixian = M('user_yongjin')->where("tjisuan=1")->select();
		foreach($tixian as $k => $v){
			M()->execute("update __USER_YONGJIN__ set tjisuan=2 where id=$v[id]");			
			if($v['tcode'] == 1){
			   $e = $v['tixiane'];
			} else {
			   $e = 0;	
			}
			M()->execute("update __USER_ZHANGHU__ set uzhengzong=uzhengzong+$v[tixiane],uqianzheng=uqianzheng+$e where userid=$v[userid]");
		}
		
		$chongzhi = M('user_chongzhi')->where(array('djisuan' => 1, 'dcode' => 2, ))->select(); //$chongzhi = M('user_chongzhi')->where("djisuan=1 and dcode=2")->select();
		foreach($chongzhi as $k => $v){
			M()->execute("update __USER_ZHANGHU__ set uchongzong=uchongzong+$v[djine] where userid=$v[userid]");
			M()->execute("update __USER_CHONGZHI__ set djisuan=2 where id=$v[id]");	
		}
	}
	
	public function yongjin(){
		if(I('sktime') != ''){
			$sktime = strtotime(I('sktime'));
			$whe['a.ttime'][] =  array('gt',$sktime);
		}
		if(I('sjtime') != ''){
			$sjtime = strtotime(I('sjtime'));
			$whe['a.ttime'][] =  array('lt',$sjtime);
		}
		
		$userid = I('sci',0,'intval');
		if($userid > 0){
			$whe['a.userid'] = array('eq',$userid);
		}		
		
		$count = M()->table('__USER_YONGJIN__ a')->where($whe)->count();
		$page  = my_page($count,8);
        $limit = $page->firstRow . ',' . $page->listRows;
		$yongjin = M()->table('__USER_YONGJIN__ a')->join('left join __USER_LIST__ b on a.userid=b.id')
		         ->field('a.*,b.uickname,b.uheadimgurl')->where($whe)->order('a.id desc')->limit($limit)->select();
				 
		$page->parameter['sktime']   =   I('sktime');
		$page->parameter['sjtime']   =   I('sjtime'); 
		$page->parameter['sci']   =   urlencode(I('sci'));
		
		$this->sktime = I('sktime');
		$this->sjtime = I('sjtime');
		$this->yongjin = $yongjin;
		$this->page = $page->show();
	    $this->display();
	}
	
	public function fahb(){
		$userid = I('userid');
		$count = M('saolei_userfa')->where(array('userid' => $userid, ))->count(); //$count = M('saolei_userfa')->where("userid=$userid")->count();
		$page = my_page($count,10);
        $limit = $page->firstRow . ',' . $page->listRows;
		$fahb=M()->table('__SAOLEI_USERFA__ a')->join('left join __USER_LIST__ b on a.userid=b.id')->where("a.userid=$userid")
		         ->field('a.*,a.userid,b.uickname,b.uheadimgurl')->order('a.id desc')->limit($limit)->select();
		foreach($fahb as $k => $v){
			$fahb[$k]['weilingnum'] = M('saolei_userfalist')->where(array('faid' => $v[id], 'hcode' => 1, ))->count(); //$fahb[$k]['weilingnum'] = M('saolei_userfalist')->where("faid=$v[id] and hcode=1")->count();
			$fahb[$k]['yilingnum'] = M('saolei_userfalist')->where(array('faid' => $v[id], 'hcode' => 2, ))->count(); //$fahb[$k]['yilingnum'] = M('saolei_userfalist')->where("faid=$v[id] and hcode=2")->count();
		}
		$this->fahb=$fahb;
		$this->userid=$userid;
		$this->page = $page->show();
	    $this->display();
	}
	
	public function fahblist(){
		$userid = I('userid');
		$faid = I('faid',0,'intval');
		$fahblist = M('saolei_userfalist')->where(array('faid' => $faid, ))->field('id,hmoney,hcode')->select(); //$fahblist = M('saolei_userfalist')->where("faid=$faid")->field('id,hmoney,hcode')->select();
		foreach($fahblist as $k => $v){			
		    if($v['hcode']==2 ){
				$linghb = M('saolei_linghb')->where(array('hblistid' => $v[id], 'hcode' => array('in', '2,3')))->find(); //$linghb = M('saolei_linghb')->where("hblistid=$v[id] and hcode in(2,3)")->find();
			    if($linghb['userid'] > 0){
					$user = M('user_list')->where(array('id' => $linghb[userid], ))->find(); //$user = M('user_list')->where("id=$linghb[userid]")->find();
					$peifu = M('saolei_peifu')->where(array('hblistid' => $v[id], ))->find(); //$peifu = M('saolei_peifu')->where("hblistid=$v[id]")->find();
					$fahblist[$k]['uickname'] = $user['uickname'];
					$fahblist[$k]['hpeie'] = $peifu['hpeie'];
					unset($user);
				}
				$fahblist[$k]['userid']  = $linghb['userid'];
				$fahblist[$k]['ttime']  = $linghb['ttime'];
			}
		}
					
	   	$this->userid=$userid;
		$this->fahblist=$fahblist;
		$this->display();
	}	
	//佣金批量结算
	public function jiesuanall(){
		@set_time_limit(0);
		$this->display();
		$count = M('user_zhanghu')->where('uqianzheng>=100')->count();
		sp_show_msg('共'.$count.'个代理需要结算');
		$userzhanghu = M('user_zhanghu')->where('uqianzheng>=100')->select();
		foreach($userzhanghu as $v){
			$userid = intval($userzhanghu['userid']);
		    $pay = A('Wap/Pay');
		    $code = $pay->wxtixian($userid);
			if($code == 2){
			    $txt = 'ID：'.$userid.' 佣金结算成功！';	
			} else {
				$txt = 'ID：'.$userid.' 佣金结算<font color="#FF0000">失败！</font>';	
			}
			sp_show_msg($txt);
		}
		sp_show_msg('完成');
	}	
}
?>
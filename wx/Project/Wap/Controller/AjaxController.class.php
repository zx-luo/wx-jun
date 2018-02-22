<?php
namespace Wap\Controller;
use Think\Controller;

class AjaxController extends CommonController {	
	
	//查询并更新发钱次数
    public function getfaqiancishu(){
	    $userid = session('userid');
		$user = M('user_list')->where(array('id' => $userid, ))->find(); //$user = M('user_list')->where("id=$userid")->find();
		//检测今天更新次数了没有
		if( $user['ugengxin'] > strtotime(date("Ymd")) ) {
		    $json['cishu'] =  $user['ufacishu'];
		} else {
			M('user_list')->save(array('id'=>$user['id'],'ufacishu'=>0,'ugengxin'=>time()));
			$json['cishu'] = 0;
		}
		$this->ajaxReturn($json,'json');
	}
	
	//计算今天的充值额
	public function getchongnum(){
		$json['code'] = 1;
		$sysconfig = M('sys_config')->find();
		if($sysconfig['cchongzong'] > 0){
			$userid = session('userid');
			$times = strtotime(date("Y-m-d"));
		    $chong = M('user_chongzhi')->where(array('dcode' => 2, 'dtime' => array('gt',  $times), 'userid' => $userid, ))->sum('djine'); //    $chong = M('user_chongzhi')->where("dcode=2 and dtime > $times and userid=$userid")->sum('djine');
			if($chong >= $sysconfig['cchongzong']){
			    $json['code'] = 2;
			}
		}
		$this->ajaxReturn($json,'json');
	}
	
	//查询用户盈亏并自动加入黑名单
	public function checkuserhb(){
	    $userid = session('userid');
		$sysconfig = M('sys_config')->find();
		if($sysconfig['cpingbie']>0){
		    $totalhb = 	M('user_hb')->where(array('userid' =>  $userid, 'tcode' => array('in', '1'), ))->sum('hbe'); //    $totalhb = 	M('user_hb')->where("userid = $userid and tcode in(1)")->sum('hbe');
			$userzhanghu = M('user_zhanghu')->where(array('userid' => $userid, ))->find(); //$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
			if( (intval($totalhb) - $userzhanghu['uchongzong']) >= $sysconfig['cpingbie']){
				M('user_list')->save(array('id'=>$userid,'ustate'=>2));
			}
		}
	}
	
    //获得红包ID
	public function gethbid(){
		$hbid = I('hbid',0,'intval');
		if($hbid == 0){
		    $hb = M('hb')->where(array('hcode' => 1, 'htype' => 1, ))->order('hzhifue asc')->find(); //    $hb = M('hb')->where("hcode=1 and htype=1")->order('hzhifue asc')->find();
			$hbid = intval($hb['id']);
		}
		$json['hbid'] = $hbid;
		$this->ajaxReturn($json,'json');
	}		
	
	//检测代理资格及代理等级
	public function checkdaili(){
	   $userid = session('userid');	
	   $user = M('user_list')->where(array('id' => $userid, ))->find(); //   $user = M('user_list')->where("id=$userid")->find();
	   $json['code']    = $user['uvip'];
	   $this->ajaxReturn($json,'json');
	}
	
	//自动发放佣金
    public function fayongjin(){
        $last_time = $_SESSION['last_yongjin_time'];
        if(time() - $last_time < 1){
            return;
        }
        $_SESSION['last_yongjin_time'] = time();
		  $userid = session('userid');
		  $user = M('user_list')->where(array('id' => $userid, ))->find(); //  $user = M('user_list')->where("id=$userid")->find();
		  $sysconfig = M('sys_config')->find();
		  if($sysconfig['cyongjinfa']==1){
				$jine = M('user_yongjin')->where(array('userid' => $user[utid], 'tcode' => 1, ))->sum('tixiane'); //$jine = M('user_yongjin')->where("userid=$user[utid] and tcode=1")->sum('tixiane');
				if( intval($jine) >= intval($sysconfig['cyongjine']) ){
					   $pay = A('Pay');
					   $pay->wxtixian($user['utid']);
				 }
		  }
	}
	
	//判断账户余额够不够拆红包
	public function checkzhanghu(){
	     $userid = session('userid');
		 $hbid = I('hbid',0,'intval');
		 $user = M('user_list')->where(array('id' => $userid, ))->find(); // $user = M('user_list')->where("id=$userid")->find();
		 $userzhanghu = M('user_zhanghu')->where(array('userid' => $userid, ))->find(); // $userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
		 $json['code'] = 0;//初始值
		 if($user['ufacishu'] < 99){
			 if($hbid == 0 ){
			    $hb = M('hb')->where(array('hcode' => 1, 'htype' => 1, ))->order('hzhifue asc')->find(); //    $hb = M('hb')->where('hcode=1 and htype=1')->order('hzhifue asc')->find();
		     } else {
				$hb = M('hb')->where(array('id' => $hbid, ))->find();  //$hb = M('hb')->where("id=$hbid")->find(); 
			 }
			 if($userzhanghu['uqianchong'] >= $hb['hzhifue']){
				 $json['code'] = 1;//余额充足
			 }
		 }
		 $this->ajaxReturn($json,'json');
	}
	
	public function chongzhi(){
		$page = I('page',0);
		$pagesize = 10;
		$limit = $page * $pagesize .','.$pagesize;				
		$userid = session('userid');
		$chongzhi = M('user_chongzhi')->where(array('userid' =>  $userid, 'dcode' => array('in', '2'), ))->limit($limit)->order("id desc")->select(); //$chongzhi = M('user_chongzhi')->where("userid = $userid and dcode in(2)")->limit($limit)->order("id desc")->select();
		foreach($chongzhi as $v){
		    $json['html'] .= '<li>'.($v['djine']*0.01).'元<span><font class="font12">充值成功</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d H:i",$v['dtime']).'</span></li>';
		}
		$this->ajaxReturn($json,'json');
	}
	
	public function hblist(){
		$page = I('page',0);
		$pagesize = 10;
		$limit = $page * $pagesize .','.$pagesize;				
		$userid = session('userid');
		$hblist = M('user_hb')->where(array('userid' =>  $userid, 'tcode' => array('in', '1'), ))->limit($limit)->order("id desc")->select(); //$hblist = M('user_hb')->where("userid = $userid and tcode in(1)")->limit($limit)->order("id desc")->select();
		foreach($hblist as $v){
		    $json['html'] .= '<li>'.($v['hbe']*0.01).'元<span><font class="font12">已领取</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("Y-m-d H:i",$v['ttime']).'</span></li>';
		}
		$this->ajaxReturn($json,'json');
	}
	
	//扫雷记录
	public function saoleihb(){
		$page = I('page',0);
		$pagesize = 10;
		$limit = $page * $pagesize .','.$pagesize;				
		$userid = session('userid');
		$hblist = M('saolei_linghb')->where(array('userid' =>  $userid, 'hcode' => array('in', '2,3'), ))->limit($limit)->order("id desc")->select(); //$hblist = M('saolei_linghb')->where("userid = $userid and hcode in(2,3)")->limit($limit)->order("id desc")->select();
		foreach($hblist as $v){
			$zhonglei = '';
			$peifu = M('saolei_peifu')->where(array('hblistid' => $v[hblistid], ))->find(); //$peifu = M('saolei_peifu')->where("hblistid=$v[hblistid]")->find();
			if($peifu){
				$zhonglei = '中雷&nbsp;&nbsp;'.($peifu['hpeie']*0.01);
			}
			
		    $json['html'] .= '<li>'.(number_format($v['hbe']*0.01,2)).'元<span><font class="font12">'.$zhonglei.'</font>&nbsp;&nbsp;&nbsp;'.date("m-d H:i:s",$v['ttime']).'</span></li>';
		}
		$this->ajaxReturn($json,'json');
	}
	
	public function zhanshibox(){
		//滚动抽中信息
		$sysconfig = M('sys_config')->find();
		$json['code'] = $sysconfig['cgundong'];
		$cwxchoutxt = explode(',',$sysconfig['cwxchoutxt']);
		array_filter($cwxchoutxt);
		$arr = array('好运','爆发','走大运','鸿运当头','天降洪福','时来运转','财运亨通','洪福齐天','天赐良机');
		if(count($cwxchoutxt) > 0){
		   $arrnum = rand(0,count($arr)-1);
		   $cwxchoutxtnum = rand(0,count($cwxchoutxt)-1);
		   $json['html'] ='<span>'.$arr[$arrnum].'</span>&nbsp;&nbsp;&nbsp;'. $cwxchoutxt[$cwxchoutxtnum];
		} else {
			$json['code'] = 1;
		}
		$this->ajaxReturn($json,'json');
	}	
		
}
?>
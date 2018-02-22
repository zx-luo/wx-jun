<?php
namespace Wap\Controller;
use Think\Controller;

class ZhuanpanController extends CommonController {	
	
	public function index(){
		$zhuanpan = M()->table('__HB_GAILV__ a')->join('__HB__ b on a.hbid=b.id')->where('b.htype=2')
		               ->field('a.*,b.hzhifue')->select();
		$this->hbid = $zhuanpan[0]['hbid'];
		$this->zhuanpan = $zhuanpan;
		$this->display();
	}
	
	public function ajaxzhuan(){
		if(IS_AJAX){
		   $userid = session('userid');
		   $user = M('user_list')->where(array('id' => $userid, ))->find(); //   $user = M('user_list')->where("id=$userid")->find();
		   $userzhanghu = M('user_zhanghu')->where(array('userid' => $userid, ))->find(); //   $userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
		   $hb = M('hb')->where(array('htype' => 2, ))->find(); //   $hb = M('hb')->where("htype=2")->find();
		   if(!$hb){ die; }
		   $hbid = intval($hb['id']);
		   if( intval($userzhanghu['uqianchong']) < intval($hb['hzhifue']) || intval($userzhanghu['uqianchong']) <= 0){
		      $json['code'] = 1;//余额不足	
		   } else {
			   $userhb = M('user_hb')->where(array('userid' => $userid, ))->order('id desc')->find(); //   $userhb = M('user_hb')->where("userid=$userid")->order('id desc')->find();
			   if( (time()-intval($userhb['ttime'])) > 15){
				  //判断有没有未拆完的红包
				  $daichaihb = M('user_hb')->where(array('hbid' => $hbid, 'userid' => $userid, 'tcode' => 2, ))->find(); //  $daichaihb = M('user_hb')->where("hbid=$hbid and userid=$userid and tcode=2")->find();
				  if(!$daichaihb){
			         //判断是第几次抽、然后获取概率数组的KEY
			         $chounum = M('user_hb')->where(array('hbid' => $hbid, 'userid' => $userid, 'tcode' => 1, ))->count(); //         $chounum = M('user_hb')->where("hbid=$hbid and userid=$userid and tcode=1")->count();
			         $chounum = $chounum + 1;
			         $hbgailv = M('hb_gailv')->where(array('hbid' => $hbid, 'hcishu' => $chounum, 'hgailv' => array('gt', 0), ))->select(); //         $hbgailv = M('hb_gailv')->where("hbid=$hbid and hcishu=$chounum and hgailv>0")->select();
			         if(!$hbgailv){
			            $hbgailv = M('hb_gailv')->where(array('hbid' => $hbid, 'hgailv' => array('gt', 0), ))->select(); //            $hbgailv = M('hb_gailv')->where("hbid=$hbid and hgailv>0")->select();
			         }
			         foreach($hbgailv as $k => $v){
			             $gailvarr[$k] = $v['hgailv'];
			         }
			         $gailvk = get_arr_rand($gailvarr);
				     $hbe = rand($hbgailv[$gailvk]['hmin'],$hbgailv[$gailvk]['hmax']);				   
			         $data = array('userid' => $userid,'hbid' => $hbid,'hbe' => $hbe,'ttime' => time(),'tcode'=>2);
			         $userhbid = M('user_hb')->add($data);
			         session('zhuanhbid',$userhbid);
				     $json['gailvid'] = $hbgailv[$gailvk]['id'];
				  } else {
					 $gailvid = 0;
					 $zhuanjine = $daichaihb['hbe'];
					 $hbgailv = M('hb_gailv')->where(array('hbid' => $hbid, 'hgailv' => array('gt', 0), ))->select(); // $hbgailv = M('hb_gailv')->where("hbid=$hbid and hgailv>0")->select();
					 foreach($hbgailv as $v){
						 if($zhuanjine >= $v['hmin'] && $zhuanjine <= $v['hmax']){
							 $gailvid = $v['id'];
							 break;
					     }
					 }					  
					 session('zhuanhbid',$daichaihb['id']);
					 $json['gailvid'] = $gailvid;
				  }
			      $json['code'] = 2;//正常	
			   } else {
				  $json['code'] = 5;//操作太频繁
			   }
		   }
		   $this->ajaxReturn($json,'json');
		}
	}
	
	//转盘获取红包
	public function ajaxchai(){
		   $userid = session('userid');
		   $userhbid = intval(session('zhuanhbid'));
		   session('zhuanhbid',null);
		   $userhb = M('user_hb')->where(array('userid' => $userid, 'tcode' => 2, 'id' => $userhbid, ))->find(); //   $userhb = M('user_hb')->where("userid=$userid and tcode=2 and id=$userhbid")->find();
		   if($userhb){
		      $pay = A('Pay');
		      $json['code'] = $pay->wxtixian($userid,1,$userhbid);
		      $json['hbe'] = $userhb['hbe'] * 0.01;
		   }
		   $this->ajaxReturn($json,'json');
	}

}
?>
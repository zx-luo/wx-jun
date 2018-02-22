<?php
namespace Wap\Controller;
use Think\Controller;

class UcenterController extends CommonController {	
	
	public function index(){
		$userid = session('userid');
		$userzhanghu = M('user_zhanghu')->where(array('userid' => $userid, ))->find(); //$userzhanghu = M('user_zhanghu')->where("userid=$userid")->find();
		$jiazunum = M('user_list')->where(array('utid' => $userid, ))->count(); //$jiazunum = M('user_list')->where("utid=$userid")->count();
		$this->jiazunum = $jiazunum;
		$this->userzhanghu = $userzhanghu;
		$this->display();
	}

}
?>
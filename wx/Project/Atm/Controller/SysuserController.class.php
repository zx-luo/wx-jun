<?php
namespace Atm\Controller;
use Think\Controller;

class SysuserController extends CommonController {

	public function passsave(){
		$upass1 = md5(md5(I('upass1').$_SERVER['HTTP_HOST']));
		$upass2 = md5(md5(I('upass2').$_SERVER['HTTP_HOST']));
		$tran_upass_old = md5(md5(I('tran_upass_old') . $_SERVER['HTTP_HOST']));
		$tran_upass = md5(md5(I('tran_upass') . $_SERVER['HTTP_HOST']));
		$uname =  session('uname');
		$user = M('sys_user')->where(array('uname' => $uname, ))->find(); //$user = M('sys_user')->where("uname='$uname'")->find();
		if($user && $user['upass'] == $upass1 && $user['tran_upass'] == $tran_upass_old){
		   $data['id'] = session('adminid');
		   $data['upass'] = $upass2;
		   $data['tran_upass'] = $tran_upass;
		   M('sys_user')->save($data);
		   $json['code'] = 2 ; //成功
		} else {
			$json['code'] = 1;//原密码输入错误
		}
		$this->ajaxReturn($json,'json');
	}
	
	public function userlist(){
		if(I('uname') != ''){
		   $whe['uname'] = array('like','%'.I('uname').'%');	
		}
		$whe['utype'] = array('eq',2);
		$count = M('sys_user')->where($whe)->count();
		$page = my_page($count,8);
		$limit = $page->firstRow . ',' . $page->listRows;
		$user =M('sys_user')->where($whe)->limit($limit)->select();
						   
		$this->page = $page->show();
		$this->nowpage = I('p');
		$this->user = $user;
		$this->display();
	}
	
	public function useredit(){
		$id = I('id',0,'intval');
		$user = M('sys_user')->where(array('id' => $id, ))->find(); //$user = M('sys_user')->where("id=$id")->find();
		$this->user = $user;
		$this->display();
	}
	
	public function usersave(){
		$id = I('id',0,'intval');
		$data['uname'] = I('uname');		
		$data['utype'] = I('utype');
		if(I('upass')!=''){
		   $data['upass'] = md5(md5(I('upass').$_SERVER['HTTP_HOST']));	
		}
		if(I('tran_upass') != '')
		{
			$data['tran_upass']  = md5(md5(I('tran_upass').$_SERVER['HTTP_HOST']));
		}
		$user = M('sys_user')->where(array('id' => $id, ))->find(); //$user = M('sys_user')->where("id=$id")->find();
		if($user){
		   	$data['id'] = $id;
			M('sys_user')->save($data);
			unset($data);
		} else {
			$checkuser = M('sys_user')->where(array('uname' => $data[uname], ))->find(); //$checkuser = M('sys_user')->where("uname='$data[uname]'")->find();
			if($checkuser){
			   echo 1;	
			} else {
			   	M('sys_user')->add($data);
			}
		}
	}
	
	public function userdel(){
		$id = I('id',0);
		M('sys_user')->where(array('id' => $id, ))->delete(); //M('sys_user')->where("id=$id")->delete();
		$this->success('操作成功',U('userlist'),1);
	}
	
}
?>
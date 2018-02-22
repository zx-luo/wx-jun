<?php
namespace Atm\Controller;
use Think\Controller;

class SysmaController extends CommonController {
	
	//显示
	public function index(){
		$mset = M('sys_maset')->find();
		$this->mset = $mset;
		$this->display();
	}
	
	//保存编辑
	public function masave(){		
		$data['mleft'] = I('mleft',159,'intval');
		$data['mtop'] = I('mtop',232,'intval') ;
		$data['msize'] = I('msize',5,'intval');
		$data['midcolor'] = I('midcolor','#FFFFFF','trim');
		$id = I('get.id',0,'intval');
		if($id > 0) {
			$data['id']=$id;
			M('sys_maset')->save($data);
		} else {
			$id = M('sys_maset')->add($data);
		}		
		$this->success('操作成功',U('index'),1);
	}	

}
?>
<?php
namespace Atm\Controller;
use Think\Controller;

class SysconfigController extends CommonController {

	public function index(){
		$adminid = session('adminid');
		$sysconfig = M('sys_config')->where(array('adm' => array('in', 'id=$adminid'), ))->find(); //$sysconfig = M('sys_config')->where("adminid=$adminid")->find();
		$this->sysconfig = $sysconfig;
		$this->display();
	}
	
	/**
	* 修改配置
	*/
	public function save(){	
		$checkin_mode = I('post.checkin_mode');
		$checkin_mode[0] = I('post.enable-check-in')=='1'? I('post.checkin-mode'): 0;
	    $adminid = session('adminid');	
		$data['cduanlianjie'] = I('cduanlianjie',2);
        $data['ctongzhi'] = I('ctongzhi');
		$data['ckouliang'] = I('ckouliang',0);
		$data['cwxappid'] = I('cwxappid','','trim');
		$data['cwxappsecret'] = I('cwxappsecret','','trim');
		$data['cwxmchid'] = I('cwxmchid','','trim');
		$data['cwxappkey'] = I('cwxappkey','','trim');
		$data['cdenglucode'] = I('cdenglucode',1);
		$data['cyongjinfa'] = I('cyongjinfa',2);
		$data['cdailicode'] = I('cdailicode',1);
		$data['cgundong'] = I('cgundong',1);
		$data['cmaurl'] = I('cmaurl','','trim');
		$data['cfaurl'] = I('cfaurl','','trim');
		$data['cyongjine'] = I('cyongjine',0) * 100; 
		$data['cchongzong'] = I('cchongzong') * 100;
		$data['cpingbie'] = I('cpingbie',0) * 100; 
		$data['cbeicode'] = I('cbeicode',2,'intval');
		$data['cbeiurl'] = I('cbeiurl','','trim');
		$data['cbeiappid'] = I('cbeiappid','','trim');
		$data['cbeiappsecret'] = I('cbeiappsecret','','trim');
		
		$data['cbeipay'] = I('cbeipay',1,'intval');
		$data['cbeimchid'] = I('cbeimchid','','trim');
		$data['cbeiappkey'] = I('cbeiappkey','','trim');
				
		$data['adminid'] = $adminid;
		$data['checkin_mode'] = implode('|', $checkin_mode);
		$data["task2_descr"] = I('task2_descr', '', 'trim');
		$data["share_title"] = I('share_title', '', 'trim');
		$data["share_descr"] = I('share_descr', '', 'trim');
		$sysconfig = M('sys_config')->where(array('adm' => array('in', 'id=$adminid'), ))->find(); //$sysconfig = M('sys_config')->where("adminid=$adminid")->find();
		// add counter
		if($sysconfig['cwxappid'] != I('cwxappid', '', 'trim')){
		    file_put_contents('./Project/Common/Conf/wxsubsc.counter', intval(file_get_contents('./Project/Common/Conf/wxsubsc.counter'))+1);
		    
		}
		// counter ends
		if(!$sysconfig){
			M('sys_config')->data($data)->add();
		} else {
			$data['id'] = $sysconfig['id'];
			M('sys_config')->save($data);
		}
		
		//上传证书
		if(!empty($_FILES['file']['name'][0])){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->savePath =  'wxcacert/'; //保存路径
			$upload->subName = '';  //子目录创建方式
			$upload->exts = array('pem') ; //允许上传的文件后缀
			$upload->saveName =  ''; //上传文件命名规则
			$upload->replace = true; //存在同名是否覆盖
			if(!$upload->upload()) {
				$this->error($upload->getError());
			}
		}
		
		$this->success('成功',U('index'),1);
	}
	
}
?>
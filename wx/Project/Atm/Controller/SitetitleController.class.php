<?php

 
namespace Atm\Controller;

class SitetitleController extends CommonController
{
	public function edit()
	{
		$adminid = session('adminid');
		$sysinfo = M('sys_config')->where('adminid=' . $adminid)->find();
		$this->sysinfo = $sysinfo;
		$this->display();
	}
	public function save()
	{
		$adminid = session('adminid');
		$data['sitetitle'] = str_replace('，', ',', I('sitetitle'));
		$sysconfig = M('sys_config')->where('adminid=' . $adminid)->find();
		if (!$sysconfig) {
			$data['adminid'] = $adminid;
			M('sys_config')->add($data);
		} else {
			$data['id'] = $sysconfig['id'];
			M('sys_config')->save($data);
		}
		$this->success('操作成功', U('edit'), 1);
	}
}
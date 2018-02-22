<?php
namespace Atm\Controller;
use Think\Controller;

class ZhuanpanController extends CommonController {
	
	//编辑
	public function add(){
		$seldata = M('hb')->where(array('htype' => 2, ))->find(); //$seldata = M('hb')->where("htype=2")->find();
		$id = intval($seldata['id']);
		$hbgailv = M('hb_gailv')->where(array('hbid' => $id, ))->select(); //$hbgailv = M('hb_gailv')->where("hbid=$id")->select();
		$this->seldata = $seldata;
		$this->hbgailv = $hbgailv;
		$this->display();
	}
	
	//保存编辑
	public function save(){		
		$data['hzhifue'] = I('hzhifue',0)*100;
		$data['htime'] = I('htime',0,'intval');
		$id = I('get.id',0,'intval');
		if($id > 0) {
			$data['id']=$id;
			M('hb')->save($data);
		} else {
			$data['htype'] = 2;
			$id = M('hb')->add($data);
		}		
		//更新概率
		$hjiaodu = I('hjiaodu');
		$hmin = I('hmin');//
		$hmax = I('hmax');//
		$hgailv = I('hgailv');//
		$hcishu = I('hcishu');
        $hbgailv = M('hb_gailv')->where(array('hbid' => $id, ))->select();	 //$hbgailv = M('hb_gailv')->where("hbid=$id")->select();	
		$gailvnum = ( count($hbgailv) >= count($hmin) ) ? count($hbgailv) : count($hmin);		
		for($i=0 ; $i < $gailvnum ; $i++){
			$data = array(
			      'hbid'      => $id,
				  'hjiaodu'   => intval($hjiaodu[$i]),
				  'hmin'      => intval($hmin[$i] * 100),
				  'hmax'      => intval($hmax[$i] * 100),
				  'hgailv'    => intval($hgailv[$i]),
				  'hcishu'    => intval($hcishu[$i])
			);
			//如果新设置的比数据库的少
			if(count($hbgailv) >= count($hmin)){
			    if($i <= count($hmin)-1){	
				   $data['id'] = $hbgailv[$i]['id'];
				   M('hb_gailv')->save($data);
				} else {
				   $gailvid = $hbgailv[$i]['id'];
				   M('hb_gailv')->where(array('id' => $gailvid, ))->delete();	 //   M('hb_gailv')->where("id=$gailvid")->delete();	
				}
			} else {
				if($i <= count($hbgailv)-1){
				   $data['id'] = $hbgailv[$i]['id'];
				   M('hb_gailv')->save($data);
				} else {
			       M('hb_gailv')->add($data);
				}
			}
			unset($data);
		}
		
		$this->success('操作成功',U('add'),1);
	}
}
?>
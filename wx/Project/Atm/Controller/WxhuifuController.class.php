<?php
namespace Atm\Controller;
use Think\Controller;

class WxhuifuController extends CommonController {	
	/**
	*关键词列表
	*/
	public function keylist(){
		
		$whe['stype'] = I('get.stype',0,'intval');		
		$whe['adminid'] = session('adminid');
		if( I('sname') != '' ) {
			$whe['sname'] = array('like','%'.I('sname').'%');
		}

		$count = M('weixin_sendkey')->where($whe)->count();

		$page = new \Think\Page($count,12);
		$limit = $page->firstRow . ',' . $page->listRows;
		$seldata = M('weixin_sendkey')->where($whe)->limit($limit)->select();

		$this->page = $page->show();
		$this->nowpage = I('p');
		$this->stype = $whe['stype'];
		$this->seldata = $seldata;
		$this->display();
	}
	/**
	* 关键词删除
	*/
	public function keydel(){
		$nowpage = I('nowpage',1,'intval');
		$stype = I('stype',0,'intval');
		$nid = I('nid',0,'intval');
		$adminid = $_SESSION['adminid'];
		M('weixin_sendkey')->where(array('id' =>  $nid, 'adminid' => $adminid, ))->delete();		 //M('weixin_sendkey')->where(" id = $nid and adminid=$adminid ")->delete();		
	   	$this->success('操作成功',U('Wxhuifu/keylist?stype='.$stype.'&p='.$nowpage),1);
	}
	/**
	* 关键词编辑、添加
	*/
	public function keyadd(){
		$nid = I('nid',0,'intval');
		$stype = I('stype',0,'intval');
		$seldata = M('weixin_sendkey')->where(array('id' => $nid, ))->find(); //$seldata = M('weixin_sendkey')->where("id=$nid")->find();
		$this->seldata = $seldata;
		$this->stype = $stype;
		$this->display();
	}
	/**
	* 关键词保存
	*/
	public function keysave(){
		$data['sname'] = I('sname');
		$data['kcode'] = I('kcode');
		$data['stype'] = I('get.stype',0,'intval');	
		$data['id'] = I('get.nid',0,'intval');
		if($data['id'] > 0) {
			M('weixin_sendkey')->save($data);
		} else {
			$data['adminid'] = $_SESSION['adminid'];
			$data['stime'] = time();
			M('weixin_sendkey')->data($data)->add();
		}		
		$this->success('操作成功',U('Wxhuifu/keylist?stype='.$data['stype']),1);
	}
	
	public function keyconlist(){
		$kid = I('kid',0,'intval');
		$stype = I('stype',0,'intval');
		$itemdata = M('weixin_sendkey')->where(array('id' =>  $kid, ))->find(); //$itemdata = M('weixin_sendkey')->where(" id = $kid ")->find();
		$seldata = M('weixin_sendcon')->where(array('kid' =>  $kid, ))->select(); //$seldata = M('weixin_sendcon')->where(" kid = $kid ")->select();
		$this->seldata = $seldata;
		$this->itemdata = $itemdata;
		$this->stype = $stype;
		$this->display();
	}
	
	public function keyconadd(){
		$kid = I('kid',0,'intval');
		$stype = I('stype',0,'intval');
		$id = I('id',0,'intval');		
		$itemdata = M('weixin_sendkey')->where(array('id' =>  $kid, ))->find(); //$itemdata = M('weixin_sendkey')->where(" id = $kid ")->find();
		$seldata = M('weixin_sendcon')->where(array('id' => $id, ))->find(); //$seldata = M('weixin_sendcon')->where("id=$id")->find();
		$this->stype = $stype;
		$this->seldata = $seldata;
		$this->itemdata = $itemdata;
		$this->display();
	}
	
	public function keyconsave(){
		
		$stype = I('get.stype',0,'intval');		
		$data['kid'] = I('get.kid',0,'intval');
		$data['snum'] = I('snum',1,'intval');
		$data['stime'] = I('stime',0,'intval');
		$data['spic'] = I('spic');
		$data['sname'] = I('sname');
		$data['surl'] = I('surl');
		$data['sdec'] = I('sdec');
		$data['id'] = I('get.id',0,'intval');
		$filepath = substr(date('Ymd',$data['stime']),0,4).'/'.substr(date('Ymd',$data['stime']),4,2).'/'.substr(date('Ymd',$data['stime']),6,2).'/';
		
		if(!empty($_FILES['file']['name'])){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->savePath =  $filepath;
			$upload->subName = '';  //子目录创建方式
			$upload->exts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			
			$info   =   $upload->upload();
			if(!$info) {// 上传错误提示错误信息
				$this->error($upload->getError());
			} else {// 上传成功 获取上传文件信息
				@unlink('./Uploads/'.$filepath.$data['spic']);
				$data['spic'] = $info['file']['savename'];
			}		
		}
		
		if($data['id'] > 0) {
			M('weixin_sendcon')->save($data);
		} else {
			M('weixin_sendcon')->data($data)->add();
		}
		$this->success('操作成功',U('Wxhuifu/keyconlist?stype='.$data['stype'].'&kid='.$data['kid']),1);
	}
	
	public function keycondel(){
		$stype = I('stype',0,'intval');
		$id = I('id',0,'intval');
		$data = M('weixin_sendcon')->where(array('id' => $id, ))->find(); //$data = M('weixin_sendcon')->where(" id=$id ")->find();
		$filepath = './Uploads/'.substr(date('Ymd',$data['stime']),0,4).'/'.substr(date('Ymd',$data['stime']),4,2).'/'.substr(date('Ymd',$data['stime']),6,2).'/';
		@unlink($filepath.$data['spic']);
		M('weixin_sendcon')->where(array('id' => $id, ))->delete(); //M('weixin_sendcon')->where("id=$id")->delete();
		$this->success('操作成功',U('Wxhuifu/keyconlist?stype='.$stype.'&kid='.$data['kid']),1);
	}
}
?>
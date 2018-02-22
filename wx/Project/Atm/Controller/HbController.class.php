<?php
namespace Atm\Controller;
use Think\Controller;

class HbController extends CommonController {
	
	//显示
	public function show(){
		$count = M('hb')->where(array('htype' => 1, ))->count(); //$count = M('hb')->where('htype=1')->count();
		$page = my_page($count,8);
		$limit = $page->firstRow . ',' . $page->listRows;
		$seldata = M('hb')->where(array('htype' => 1, ))->order('hpaixu desc,id asc')->limit($limit)->select(); //$seldata = M('hb')->where('htype=1')->order('hpaixu desc,id asc')->limit($limit)->select();
		foreach($seldata as $key => $val){
		}
		$this->page = $page->show();
		$this->nowpage = I('p');
		$this->seldata = $seldata;
		$this->display();

	}
	
	//编辑
	public function add(){
		$id = I('id',0,'intval');
		$seldata = M('hb')->where(array('id' => $id, ))->find(); //$seldata = M('hb')->where("id=$id")->find();
		$hbgailv = M('hb_gailv')->where(array('hbid' => $id, ))->select(); //$hbgailv = M('hb_gailv')->where("hbid=$id")->select();
		$this->seldata = $seldata;
		$this->hbgailv = $hbgailv;
		$this->display();
	}
	
	//删除
	public function del(){
		$id = I('id',0,'intval');
		M('hb')->where(array('id' => $id, ))->delete(); //M('hb')->where("id=$id")->delete();
		$this->success('操作成功',U('show'),1);
	}
	
	//保存编辑
	public function save(){		
		$data['hzhifue'] = I('hzhifue',0)*100;
		$data['hminmoney'] = I('hminmoney',0)*100 ;
		$data['hmaxmoney'] = I('hmaxmoney',0)*100 ;
		$data['hbianhua'] = 0;
		$data['hgeshu'] = I('hgeshu',0);
		$data['hpaixu'] = I('hpaixu',0);
		$data['htime'] = I('htime',0,'intval');
		$id = I('get.id',0,'intval');
		if($id > 0) {
			$data['id']=$id;
			M('hb')->save($data);
		} else {
			$data['htype'] = 1;
			$id = M('hb')->add($data);
		}		
		//更新概率
		$hmin = I('hmin');//
		$hmax = I('hmax');//
		$hgailv = I('hgailv');//
		$hcishu = I('hcishu');
        $hbgailv = M('hb_gailv')->where(array('hbid' => $id, ))->select(); //$hbgailv = M('hb_gailv')->where("hbid=$id")->select();
		$gailvnum = ( count($hbgailv) >= count($hmin) ) ? count($hbgailv) : count($hmin);		
		for($i=0 ; $i < $gailvnum ; $i++){
			$data = array(
			      'hbid'      => $id,
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
				   M('hb_gailv')->where(array('id' => $gailvid, ))->delete(); //M('hb_gailv')->where("id=$gailvid")->delete();
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
		
		$this->success('操作成功',U('show'),1);
	}	
	
	 //更改红包状态
	public function ajaxhbcode(){
	   $id=I('id');
	   $hb=M('hb')->where(array('id' => $id, ))->find(); //$hb=M('hb')->where("id=$id")->find();
	   $hcode = $hb['hcode'] == 2 ? 1:2;
	   M('hb')->save(array('id'=>$id,'hcode'=>$hcode));	
	}
		
	//模拟抽红包
	public function ajaxmoni(){
	    $hzhifue = I('hzhifue',0,'intval');
	    $hminmoney = I('hminmoney',0)*100 ;
	    $hmaxmoney = I('hmaxmoney',0)*100 ;
		$hgeshu = I('hgeshu',0);
		$hmin = I('hmin');//最小数组
		$hmax = I('hmax');//最大数组
		$hgailv = I('hgailv');//概率
		for($i=0 ; $i < 50 ; $i++){	
			for($j=0 ; $j < count($hgailv) ; $j++){
			    $hbarr[] = $this->checkhbjine($hmin[$j]*100,$hmax[$j]*100,$hbarr);
			}
			$hblist[] = $hbarr;
			unset($hbarr);
		}
		
		$huaqian = 0;
		$chouqian = 0;
		
		foreach($hblist as $v){
			for($i=0 ; $i < 2; $i++){
			    $key = get_arr_rand($hgailv);
				foreach($v as $s){
				   	if($s >= ($hmin[$key]*100) && $s <= ($hmax[$key]*100) ){
					    $huaqian = $huaqian + $hzhifue;
						$chouqian = $chouqian + $s;
						$chouarr[] = $s*0.01;
						break;
					}
				}
			} 
		}
		$html = '模拟<font color="#FF0000"><strong>100</strong></font>次，花费：<font color="#FF0000"><strong>'.$huaqian.'</strong></font>元，发出红包：<font color="#FF0000"><strong>'.($chouqian*0.01).'</strong></font>元，';
		$html .= '红包展示：';
		$html .= implode('|',$chouarr);
		echo $html;
	}
	
	//检测生成红包是否重复
	public function checkhbjine($a=0,$b=0,$c=array()){
		   $jine = 0;
		   $i=0;
		   while(true){
				$jine = rand($a,$b);
				$i++;
				if(!in_array($jine,$c) || $i==20 ){
					break;	
				}
		   }
		   return $jine;	
	}

}
?>
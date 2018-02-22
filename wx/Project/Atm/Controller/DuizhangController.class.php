<?php
namespace Atm\Controller;
use Think\Controller;

class DuizhangController extends CommonController {

	public function index(){
		$count = M('user_duizhang')->count();
		$page = my_page($count,7);
        $limit = $page->firstRow . ',' . $page->listRows;
		$duizhang = M('user_duizhang')->limit($limit)->select();
		
		$this->page = $page->show();
		$this->duizhang = $duizhang;
		$this->display();
	}
	
	public function jisuanzhangdan(){
	    $zhangdan = M('user_wxexcel')->group('uopenid')->field("count(id) wxnum,sum(wxjine) wxnum,uopenid")->select();
		foreach($zhangdan as $v){
		    $user = M('user_list')->where(array('uopenid' => $v[uopenid], ))->find(); //$user = M('user_list')->where("uopenid='$v[uopenid]'")->find();
			$userid = intval($user['id']);
			//计算用户的单数
			$fazong = M('user_hb')->where(array('tcode' => 1, 'userid' => $userid, ))->sum('hbe'); //$fazong = M('user_hb')->where("tcode=1 and userid=$userid")->sum('hbe');//拼手气红包
			$dailifa = M('user_yongjin')->where(array('tcode' => array('in', '2'), 'userid' => $userid, ))->sum('tixiane'); //$dailifa = M('user_yongjin')->where("tcode in(2) and userid=$userid")->sum('tixiane'); // 佣金
			$tixian = M('user_tixian')->where(array('userid' => $userid, ))->sum('tixiane'); //$tixian = M('user_tixian')->where("userid=$userid")->sum('tixiane'); // 提现
			$saoleie = M('saolei_linghb')->where(array('hcode' => 2, 'userid' =>  $userid, ))->sum('hbe'); //$saoleie = M('saolei_linghb')->where("hcode=2 and userid = $userid")->sum('hbe'); //扫雷
			
			$paynum = $fazong + $dailifa + $tixian + $saoleie;
			//if( ($v['wxnum'] - $paynum) < 0 ){
			    $userduizhang = M('user_duizhang')->where(array('userid' => $userid, ))->find(); //$userduizhang = M('user_duizhang')->where("userid=$userid")->find();
				if(!$userduizhang) {
				   M('user_duizhang')->add(array('userid'=>$userid,'paynum'=>$paynum,'wxnum'=>$v['wxnum']));
				} else {
				   M('user_duizhang')->save(array('id'=>$userduizhang[id],'paynum'=>$paynum,'wxnum'=>$v['wxnum']));
				}
			//}
		}
		
		$this->success('成功',U('index'),1);
	}
	
	/**
	 * 上传Excel
	*/
	public function saveexcel(){	
		//证书
		if(!empty($_FILES['filecsv']['name'])){
			$upload = new \Think\Upload();// 实例化上传类
			$upload->savePath =  'excel/'; //保存路径
			$upload->subName = '';  //子目录创建方式
			$upload->exts = array('xls') ; //允许上传的文件后缀
			$upload->saveName =  'duizhang'; //上传文件命名规则
			$upload->replace = true; //存在同名是否覆盖
			if(!$upload->upload()) {
				$this->error($upload->getError());
			} else {
				Vendor("PhpExcel.PHPExcel");
                $file_name='./Uploads/excel/duizhang.xls';
                $objReader = \PHPExcel_IOFactory::createReader('Excel5');
				$objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow(); //取得总行数
				for($i=2; $i<= $highestRow ; $i++){
					$data['uopenid'] = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
					$data['wxdanhao'] = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
					$wxjine = $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
					$wxjine = str_replace("'",'',$wxjine); 
					$data['wxjine'] = $wxjine * 100 ;
					M('user_wxexcel')->add($data);
					unset($data);
				}
			}
		}		
		$this->success('成功',U('index'),1);
	}
	
}
?>
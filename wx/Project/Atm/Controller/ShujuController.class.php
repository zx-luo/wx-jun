<?php
namespace Atm\Controller;
use Think\Controller;

class ShujuController extends CommonController {
	
	public function index(){
		
	     $chongzong = M('user_chongzhi')->where(array('dcode' => 2, ))->sum('djine'); //$chongzong = M('user_chongzhi')->where("dcode=2")->sum('djine');//充值总额
		 $fazong = M('user_hb')->where(array('tcode' => 1, ))->sum('hbe'); //$fazong = M('user_hb')->where('tcode=1')->sum('hbe');//发出总额
		 $dailifa = M('user_yongjin')->where(array('tcode' => array('in', '2'), ))->sum('tixiane'); //$dailifa = M('user_yongjin')->where('tcode in(2)')->sum('tixiane');
		 $dailiweifa = M('user_yongjin')->where(array('tcode' => array('in', '1'), ))->sum('tixiane'); //$dailiweifa = M('user_yongjin')->where('tcode in(1)')->sum('tixiane');
		 $dailikou = M('user_yongjin')->where(array('tcode' => array('in', '4'), ))->sum('tixiane'); //$dailikou = M('user_yongjin')->where('tcode in(4)')->sum('tixiane');
		 $tixian = M('user_tixian')->sum('tixiane');
		 $saoleie = M('saolei_linghb')->where(array('hcode' => 2, 'userid' => array('gt',  0), ))->sum('hbe'); //$saoleie = M('saolei_linghb')->where('hcode=2 and userid > 0')->sum('hbe');
		 
		 $this->saoleie = $saoleie;
		 $this->chongzong = $chongzong;
		 $this->dailikou = $dailikou;
		 $this->fazong   = $fazong;
		 $this->dailifa = $dailifa;
		 $this->dailiweifa = $dailiweifa;
		 $this->tixian = $tixian;
		
		$daipaichuqiandaojiangli = M('Checkin')->where('`type`=1')->field('SUM(`bonus`) as `paichu`')->find();
		$shijipaichuqiandaojiangli = M('Checkin')->where('`type`=2')->field('SUM(`bonus`) as `paichu`')->find();
		//var_dump($daipaichuqiandaojiangli);
		$this->assign('daipaichuqiandaojiangli', $daipaichuqiandaojiangli);
		$this->assign('shijipaichuqiandaojiangli', $shijipaichuqiandaojiangli);
		
	     $this->display();
	}
	
	public function ajaxtubiao(){
		$riqi = I('date',0,'intval');
		for($i=$riqi ; $i > 0 ; $i--){
		   	$xitem[] = date("m-d",time()-86400*$i);	
			$t = date("Y-m-d",time()-86400*$i);
			$sktime = strtotime($t);
			$sjtime = $sktime + 86400;
			$n = M('user_chongzhi')->where(array('dtime' => array('gt',  $sktime), 'dtime' => array('lt',  $sjtime), 'dcode' =>  2, ))->sum('djine'); //$n = M('user_chongzhi')->where("dtime > $sktime and dtime < $sjtime and dcode = 2")->sum('djine');
			$chongzhi[]= intval($n)*0.01;
			$a = M('user_hb')->where(array('ttime' => array('gt',  $sktime), 'ttime' => array('lt',  $sjtime), 'tcode' => 1, ))->sum('hbe'); //$a = M('user_hb')->where("ttime > $sktime and ttime < $sjtime and tcode=1")->sum('hbe');
			$b = M('user_tixian')->where(array('ttime' => array('gt',  $sktime), 'ttime' => array('lt',  $sjtime), ))->sum('tixiane'); //$b = M('user_tixian')->where("ttime > $sktime and ttime < $sjtime ")->sum('tixiane');
			$c = M('saolei_linghb')->where(array('ttime' => array('gt',  $sktime), 'ttime' => array('lt',  $sjtime), 'userid' => array('gt',  0), 'hcode' => 2, ))->sum('hbe'); //$c = M('saolei_linghb')->where("ttime > $sktime and ttime < $sjtime and userid > 0 and hcode=2")->sum('hbe');
			$d = M('user_yongjin')->where(array('ttime' => array('gt',  $sktime), 'ttime' => array('lt',  $sjtime), 'tcode' => array('in', '2'), ))->sum('tixiane'); //$d = M('user_yongjin')->where("ttime > $sktime and ttime < $sjtime and tcode in(2)")->sum('tixiane');			
			$n = $a + $b + $c + $d;
			$model =  M('Checkin');
			$daipaichuqiandaojiangli = $model->where('`type`=2 and `timestamp`>"'.date('Y-m-d', $sktime).' 0:0:0" and `timestamp`<"'.date('Y-m-d', $sktime+86400).' 0:0:0"')->field('SUM(`bonus`) as `paichu`')->find();
			$n = $a + $b + $c + $d + floatval($daipaichuqiandaojiangli['paichu'])*100;
			$fachu[]=intval($n)*0.01;
		}		
		$data = array(
		   'date' => $xitem,
		   'chongzhi' => $chongzhi,
		   'fachu' => $fachu
		);
		$this->ajaxReturn($data,'json');		
	}
	
}
?>
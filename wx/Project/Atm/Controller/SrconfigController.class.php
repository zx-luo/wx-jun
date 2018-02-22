<?php

 
namespace Atm\Controller;

class SrconfigController extends CommonController
{
	public function index()
	{
	    $srconfig = include(getcwd().'/Project/Common/Conf/srconfig.php');//return;
	    $srconfig['topup_candi'] = implode(',', $srconfig['topup_candi']);
	    //$srconfig['zhuanpan_items'] = json_encode($srconfig['zhuanpan_items']);
	    $zhuanpan_items = '';
	    foreach($srconfig['zhuanpan_items'] as $zhuanpan_item){
	        $zhuanpan_items .= ',' . $zhuanpan_item[0] . '-' . $zhuanpan_item[1];
	    }
	    $srconfig['zhuanpan_items'] = substr($zhuanpan_items, 1);
	    $this->assign('srconfig', $srconfig);
		$this->display();
	}
	public function save(){
	    //／／var_dump();
	    header('content-type: text/plain; charset=utf-8');
	    
	    $config = I('post.');
	    $config['topup_candi'] = preg_replace('/，|。|、/', ',', $config['topup_candi']);
	    $config['topup_candi'] = preg_replace('/[^\d,]/', '', $config['topup_candi']);
	    $config['topup_candi'] = explode(',', $config['topup_candi']);
	    sort($config['topup_candi']);
	    $config['topup_candi'] = array_unique($config['topup_candi']);
	    //$config['topup_candi'] = implode(',', $config['topup_candi']);
	    $config['lowest_withdraw_limit'] = intval($config['lowest_withdraw_limit']);
	    $config['withdraw_multiple'] = intval($config['withdraw_multiple']);
	    $config['newuser_gift'] = intval($config['newuser_gift']);
	    
	    $zhuanpan_items = array();
	    //echo $config['zhuanpan_items'] ."<br/>\n";
	    foreach(explode(',', $config['zhuanpan_items']) as $zhuanpan_item){
	        //echo $zhuanpan_item ."<br/>\n";
	        if(preg_match('/^([\d\.]+)-([\d\.]+)$/', $zhuanpan_item, $matches)){
	            $zhuanpan_items[] = array($matches[1], $matches[2]);
	            //var_dump($matches);
	        } //else {echo 'no';}
	        
	    }
	    //r//eturn;
	    $config['zhuanpan_items'] = $zhuanpan_items;
	    unset($config['button']);
	    $len = file_put_contents(getcwd().'/Project/Common/Conf/srconfig.php', '<?php return ' . var_export($config, true) . '; ?>');
	    if($len){
	        $this->success('保存成功', U('index'));
	    } else {
	        $this->error('保存失败', U('index'));
	        
	    }
	}
}
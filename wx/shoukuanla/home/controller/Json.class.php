<?php
/*
功能：查询是否有人充值。
作者：宇卓(QQ659915080)
官网：www.shoukuanla.net 
备用域名：www.chonty.com
版本号:1.0
*/
class Json extends ShoukuanlaBase{


//浏览器访问 /shoukuanla/index.php?c=Json
public function index(){

 $this->_newDb();
 $jsonArr=$this->db->select('shoukuanla',"`skl_paytype`,`skl_title`,`skl_rechargetime`","`skl_id`>0");
 if(empty($jsonArr)){ exit; }

 $echoArr=array();
 foreach($jsonArr as $v){   
	 $echoArr[$v['skl_paytype']]=array('title'=>$v['skl_title'],'rechargeTime'=>$v['skl_rechargetime']);
 }
 echo json_encode($echoArr);

 
}


}
?>
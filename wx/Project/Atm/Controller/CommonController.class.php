<?php
namespace Atm\Controller;
use Think\Controller;

class CommonController extends Controller {
	
	public function _initialize (){
		
		if(!isset($_SESSION['adminid'])){
			$this->redirect('Login/index');
		}
			//	session(null);
	}
	
}
?>
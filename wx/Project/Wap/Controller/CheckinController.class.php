<?php
namespace Wap\Controller;

class CheckinController extends CommonController{
	public function index(){
	    //header('Content-Type: text/plain; charset=utf-8;');
	    //var_dump($this->sysinfo['cwxappid']);
	    //var_dump($this->sysinfo['cwxappsecret']);
	    //var_dump($this->sysinfo['sitetitle']);return;
	    $access_token = S($this->sysinfo['cwxappid']."access_token");
	    if(!$access_token || !strlen($access_token)){
	        $url = "https://api.weixin.qq.com/cgi-bin/token?";
	        $url .= "grant_type=client_credential&appid={$this->sysinfo['cwxappid']}&secret={$this->sysinfo['cwxappsecret']}";
	        $json_str = file_get_contents($url);
	        $json_arr = json_decode($json_str, true);
	        
	        if(!isset($json_arr['access_token'])){
	            echo '内部错误';
	            exit();
	        }
	        
	        S($this->sysinfo['cwxappid']."access_token", $access_token = $json_arr['access_token'], $json_arr['expires_in'] - 1);
	    }
	    
	    $jsapi_ticket = S($this->sysinfo['cwxappid']."jsapi_ticket");
	    if(!$jsapi_ticket || !strlen($jsapi_ticket)){
	        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=jsapi";
	        $json_str = file_get_contents($url);
	        $json_arr = json_decode($json_str, true);
	        
	        if(isset($json_arr['errcode'])&&$json_arr['errcode'] != 0){
	            echo '内部错误';
	            exit();
	        }
	        
	        S($this->sysinfo['cwxappid']."jsapi_ticket", $jsapi_ticket = $json_arr['ticket'], $json_arr['expires_in'] - 1);
	    }
	    
        $nonceStr = '';
	    $nonceStrLen = 16;
	    $timestamp = time();
        $ajaxValidationStr = '';
        $candidates = 'abcdefghiABCDEFGHI123456789';
        while($nonceStrLen--){
            $nonceStr .= $candidates[rand(0, strlen($candidates)-1)];
            $ajaxValidationStr .= $candidates[rand(0, strlen($candidates)-1)];
        }
        $verify_raw_string = http_build_query(array(
            'jsapi_ticket' => $jsapi_ticket,
            'noncestr'     => $nonceStr,
            'timestamp'    => $timestamp,
            'url'          => 'http',
        )) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //dump($verify_raw_string); return;
        $signature = sha1($verify_raw_string);
        
        S(session('userid') . "ajaxValidationStr", $ajaxValidationStr);
        $checkin = M("checkin");
        $checkin_note = $checkin->where(array(
            "user_id" => session('userid'),
            'timestamp' => array(
                array('gt', date('Y-m-d 00:00:00', time())),
                array('lt', date('Y-m-d 23:59:59', time()))
            ),
        ))->limit(1)->select();
        
        $user_info = M('UserList')->where(array('id' => session('userid')))->limit(1)->select();
        
        $this->assign('appid', $this->sysinfo['cwxappid']);
        $this->assign('timestamp', $timestamp);
        $this->assign('nonceStr', $nonceStr);
        $this->assign('signature', $signature);
        $this->assign('ajaxValidationStr', $ajaxValidationStr);
        $this->assign('checkin_note', $checkin_note);
        $this->assign('user_info', $user_info[0]);
        
        $this->display();
	}
	
	public function invite(){
	    echo 'Not implemented!';
	}
	public function qrcode(){
	    //echo dirname(dirname(dirname(__FILE__))) . '/Library/phpqrcode-master/qrlib.php';
	    
	    
	    
	    
		$userid = session('userid');
		//$news = M('news')->where('ntype=2')->find();
		$drpath = './Uploads/daili';
		$imgma = 'pure_qrcode_' . $userid . '.png';
		$config = M('sys_config')->find();
		$hurl = $config['cmaurl'] . __ROOT__ . '/index.php/Wap/Wxlogin/mainfo/utid/' . $userid . '.html';
		if (!file_exists($drpath . '/' . $imgma)) {
			//$mleft = 0;
			//$mtop = 0;
			$msize = 5;
			//$midcolor = '#FFFFFF';
			sp_dir_create($drpath);
			vendor('phpqrcode.phpqrcode');
			$phpqrcode = new \QRcode();
			if ($config['cduanlianjie'] == 1) {
				$geturl = 'http://api.t.sina.com.cn/short_url/shorten.json?source=3271760578&url_long=' . $hurl;
				$json = json_decode(http_curl_get($geturl));
				if ($json->error_code != 400) {
					if ($json[0]->url_short != '') {
						$hurl = $json[0]->url_short;
					}
				}
			}
			$errorLevel = 'L';
			$phpqrcode->png($hurl, $drpath . '/' . $imgma, $errorLevel, $msize, 2);
		}
		//$this->news = $news;
		$qrcode_url = substr($drpath . '/' . $imgma, 1);
		$url_link = $hurl;
		
		$this->ajaxReturn(array(
		    'errcode' => 0,
		    'errmsg' => 'ok',
		    'data' => array(
		        'qrcode_url' => $qrcode_url,
		        'url_link'   => $hurl,
		    )
		));
	}
	public function checkin(){
        //echo I('post.rand') ."\n";
        //echo S(session('userid') . "ajaxValidationStr") . "\n";
        //echo "valided ok \n";
        //echo "sess:" . session('userid')."\n";
        
        
        /*if(I('post.rand') != S(session('userid') . "ajaxValidationStr")){
            $this->ajaxReturn(array(
                "errcode" => -1,
                "errmsg"  => "认证失败"
            ));
            
            return;
        }
        */
        S(session('userid') . "ajaxValidationStr", NULL);
        
        $checkin = M("checkin");
        $checkin_note = $checkin->where(array(
            "user_id"=>session('userid'),
            'timestamp' => array(
                array('gt', date('Y-m-d 00:00:00', time())),
                array('lt', date('Y-m-d 23:59:59', time()))
            ),
            "type" => 1,
        ))->limit(1)->select(); 
        if($checkin_note){
            $this->ajaxReturn(array(
                "errcode" => 1,
                "errmsg"  => "您今天已经领取过奖励了"
            ));
            
            return;
        }
        
        // Done: do something interesting...
        $bonus = 0;
        
        $sysinfo = M('sys_config')->find();
        $checkin_mode = explode('|', $sysinfo['checkin_mode']);
        //var_dump($checkin_mode);
        
        if($checkin_mode[0] == '2'){
            // 固定模式
            $bonus = floatval($checkin_mode[4]);
            
            //echo 'fixed bonus mode. ' . ($checkin_mode[4]) . ': ' . $bonus . "\n";
        } else if($checkin_mode[0] == '1'){
            // 连续模式
            //echo 'addictive' . "\n";
            $checkin = M("checkin");
            $checkin_logs = $checkin->where(array(
                "user_id" => session('userid'),
                "type" => 1,
            ))->select();
            
            $today_str = date("Y-m-d");
            //echo "days: " . count($checkin_logs) ."\n";
            for($i = 0; $i < count($checkin_logs); $i++){
                $day_str = date("Y-m-d", time() - 3600*24 * ($i + 1));
                //echo "[{$i}] {$day_str}";
                
                $hav_day = false;
                foreach($checkin_logs as $day_log){
                    if(is_int(strpos($day_log['timestamp'], $day_str))){
                        $hav_day = true; 
                        break; // of foreach $checkin_logs
                    }
                }
                if(!$hav_day){
                    break; // of for $i
                }
                ///if($hav_day){ echo "yes\n"; } else {echo "'no'\n";};
            }
            if(!$hav_day){
                $hav_day --;
            }
            //echo "connet dats conte: " . ($i+1) ."\n";
            //$checkin_mode
            $days = $i + 1;
            //echo "max day count{$checkin_mode[3]}";
            if($days>intval($checkin_mode[3])){
                $days = intval($checkin_mode[3]);
            }
            $bonus = floatval($checkin_mode[1]) + ($days - 1) * floatval($checkin_mode[2]);
            //echo "award = {$checkin_mode[1]} + ({$days} - 1)*{$checkin_mode[2]}\n";
            //echo "award: " . $bonus;
            //var_dump($checkin_logs);
            
        }
        
        $writeResult = M("checkin")->data(array(
            "user_id" => session('userid'),
            "bonus"   => $bonus,
            "type"    => 1,
        ))->add();
        
        M('UserZhanghu')->where(array('id' => session('userid')))->setInc('ucheckin', $bonus * 100);
        
        if(!$writeResult){
            $this->ajaxReturn(array(
                "errcode" => -2,
                "errmsg"  => "数据库访问失败"
            ));
            
            return;
        }
        
        $this->ajaxReturn(array(
            "errcode" => 0,
            "errmsg"  => "ok",
            
            "bonus"   => $bonus
        ));
	}
	public function checkinDrawCount()
	{
		$userid = session('userid');
		$model = M('checkin');
		$user_stat = $model->where(array(
            "user_id"=>session('userid'),
            'timestamp' => array(
                array('gt', date('Y-m-d 00:00:00', time())),
                array('lt', date('Y-m-d 23:59:59', time()))
            ),
            'type' => 2
        ))->field('count(`id`) as count')->find();
		//if (strtotime(date('Ymd')) < $user['ugengxin']) {
		//	$json['cishu'] = $user['ufacishu'];
		//} else {
		//	M('user_list')->save(array('id' => $user['id'], 'ufacishu' => 0, 'ugengxin' => time()));
		//	$json['cishu'] = 0;
		//}
		$json['cishu'] = $user_stat['count'];
		$this->ajaxReturn($json, 'json');
	}
	
	public function checkinDraw(){
		$userid = session('userid');
		$userzhanghu = M('user_zhanghu')->where(array('userid'=>$userid))->find(); //$userzhanghu = M('user_zhanghu')->where('userid=' . $userid)->find();
		$tixiane = intval($userzhanghu['ucheckin']);
		if (100 <= intval($tixiane)) {
			$user = M('user_list')->where(array('id'=>$userid))->find(); //$user = M('user_list')->where('id=' . $userid)->find();
			$sysconfig = M('sys_config')->find();
			define('CERTPATH', substr(THINK_PATH, 0, -9));
			define('PARTNERKEY', $sysconfig['cwxappkey']);
			vendor('wxpay.WxXianjinHelper');
			$commonUtil = new \CommonUtil();
			$wxHongBaoHelper = new \WxHongBaoHelper();
			$wxHongBaoHelper->setParameter('nonce_str', $commonUtil->create_noncestr());
			$wxHongBaoHelper->setParameter('partner_trade_no', date('YmdHis') . rand(100, 999));
			$wxHongBaoHelper->setParameter('mchid', $sysconfig['cwxmchid']);
			$wxHongBaoHelper->setParameter('mch_appid', $sysconfig['cwxappid']);
			$wxHongBaoHelper->setParameter('openid', $user['uopenid']);
			$wxHongBaoHelper->setParameter('check_name', 'NO_CHECK');
			$wxHongBaoHelper->setParameter('amount', $tixiane);
			$wxHongBaoHelper->setParameter('re_user_name', '提现');
			$wxHongBaoHelper->setParameter('desc', '零钱入账');
			$wxHongBaoHelper->setParameter('spbill_create_ip', $wxHongBaoHelper->Getip());
			$postXml = $wxHongBaoHelper->create_hongbao_xml();
			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
			$responseXml = $wxHongBaoHelper->curl_post_ssl($url, $postXml);
			$responseObj = simplexml_load_string($responseXml);
			if ($responseObj->result_code == 'SUCCESS' && $responseObj->return_code == 'SUCCESS') {
				M()->execute('update __USER_ZHANGHU__ set ucheckin=ucheckin-' . $tixiane . ' where userid=' . $userid);
				//M('user_tixian')->add(array('userid' => $userid, 'tixiane' => $tixiane, 'ttime' => time()));
				$model = M('checkin');
				$model->add(array(
					"user_id" => $userid,
					"bonus" => $tixiane / 100,
					"type" => 2
				));
				$json['code'] = 1;
			} else {
				M('sys_log')->add(array('lbiaoshi' => '用户签到提现' . ($tixiane / 100), 'lcon' => $postXml . $responseXml, 'ltime' => time()));
				$json['code'] = 2;
			}
		} else {
			$json['code'] = 3;
		}
		$this->ajaxReturn($json, 'json');
	}
	
	public function checkin_list(){
	    $this->display();
	}
	
	public function checkin_his(){
		$page = I('page', 0);
		$pagesize = 10;
		$limit = $page * $pagesize . ',' . $pagesize;
		$userid = session('userid');
		$hblist = M('checkin')->where(array('user_id'=>$userid))->limit($limit)->order('id desc')->select(); //$hblist = M('checkin')->where('user_id = ' . $userid)->limit($limit)->order('id desc')->select();
		foreach ($hblist as $v) {
			$json['html'] .= '<li>' . ($v['type']==2? '-': '') . $v['bonus'] . '元<span><font class="font12"> ' . ($v['type']==1? '奖励': ($v['type']==2? '提现': 'n/a')) . ' </font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $v['timestamp'] . '</span></li>';
		}
		$this->ajaxReturn($json, 'json');
	}
	
	public function ShareMessageSuccess(){
	    //echo 'ok';
	    $url_info = parse_url(I('post.url', '', 'trim'));
	    //var_dump($url_info);
	    parse_str($url_info['query'], $params);
	    //var_dump($params);
	    
		$userid = session('userid');
		$data = array(
            'user_id' => $userid,
            'type' => $params['type'],
            'task_id' => -1,
            'invitee_id' => -1,
            'yongjin_id' => -1,
            //'timestamp'
            'memo' => $params['memo'],
	    );
	    M('inviteLog')->add($data);
        //$user = M('user_list')->where(array('id' => $userid))->find();
        //$user = M('user_list')->where(array('id' => $userid))->save(array(
        //    'share_counter' => array('exp', '`share_counter`+1')
        //));
	}
}
<?php
namespace Wap\Controller;

class AppraiseController extends CommonController{
	public function scoreboard(){
        //$stat = 
        //SELECT COUNT(DISTINCT `invitee_id`) FROM `haokuai_invite_log` WHERE `timestamp` > '2017-03-27 00:00:00' AND `timestamp` < '2017-03-29 00:00:00' AND `user_id` = '2' LIMIT 50
        $time_to = time();
        $time_from = $time_to - 3600 * 24;
        
        $stat_data = array();
        foreach(array(array('eq', -1), array('neq', -1),) as $invitee_id){
            unset($select);
            unset($where);
            
            $where['user_id'] = session('userid');
            $where['timestamp'] = array(array('exp', "> FROM_UNIXTIME({$time_from})"), array('exp', "< FROM_UNIXTIME({$time_to})"));
            $where['invitee_id'] = $invitee_id;
            
            $select[] = '`type`';
            $select[] = 'COUNT(DISTINCT `invitee_id`) as `count`';
            
            $model = M('inviteLog');
            $stat = $model->field($select)->where($where)->group('type')->select();
            //var_dump($model->getLastSql());
            //var_dump($stat);
            foreach($stat as $stat_item){
                $stat_data[$invitee_id[0] == 'neq'? 'finished': 'unfinished'] = array();
                $stat_data[$invitee_id[0] == 'neq'? 'finished': 'unfinished'][$stat_item['type']] = intval($stat_item['count']);
            }
        }
        
        //$stat_data = 
        //var_dump($stat_data);
        //die;
        $this->assign('time_to', $time_to);
        $this->assign('time_from', $time_from);
        $this->assign('stat_data', $stat_data);
        
        $this->display();
	}
}
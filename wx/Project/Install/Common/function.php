<?php

  //测试文件夹是否可写
   function sp_testwrite($d) {
       $tfile = "_test.txt";
       $fp = @fopen($d . "/" . $tfile, "w");
       if (!$fp) {
           return false;
       }
       fclose($fp);
       $rs = @unlink($d . "/" . $tfile);
       if ($rs) {
            return true;
       }
       return false;
    }

   function sp_execute_sql($db,$tablepre){
	   $file = get_sql_file('./Data/');
       //读取SQL文件
       $sqlcon = file_get_contents('./Data/'.$file);
       $sql = str_replace("\r", "\n", $sqlcon);
       $sql = explode(";\n", $sql);
	
	   preg_match('/CREATE TABLE IF NOT EXISTS `([^ ]*)`/', $sqlcon, $matches);
       if(empty($matches)){
		   preg_match('/CREATE TABLE `([^ ]*)`/', $sqlcon, $matches);
	   }
	   $pre_arr =  explode('_',$matches[1]);
       //替换表前缀
       $default_tablepre = $pre_arr[0] . "_";
       $sql = str_replace(" `{$default_tablepre}", " `{$tablepre}", $sql);
       //开始安装
       sp_show_msg('开始安装数据库...');
       foreach ($sql as $item) {
           $item = trim($item);
           if(empty($item)) continue;
           preg_match('/CREATE TABLE IF NOT EXISTS `([^ ]*)`/', $item, $matches);	
		   if(empty($matches)){
		   	   preg_match('/CREATE TABLE `([^ ]*)`/', $item, $matches);
		   }
           if($matches) {
               $table_name = $matches[1];
               $msg  = "创建数据表{$table_name}";			
               if(false !== $db->execute($item)){
                   sp_show_msg($msg . ' 完成');
               } else {
                   sp_show_msg($msg . ' 失败！', 'error');
               }
           } else {
               $db->execute($item);
           }
       }
   }

   function sp_create_admin_account($db,$table_prefix){
	   $uweb = $_SERVER['HTTP_HOST'];
       $uname = I("post.manager");
       $upass = I("post.manager_pwd").$uweb;
	   $upass = md5(md5($upass));
	$tran_upass = I('post.manager_pwd2level') . $uweb;
	$tran_upass = md5(md5($tran_upass));
       $utime = time();
	$sql = 'INSERT INTO `' . $table_prefix . 'sys_user`(uname,upass,tran_upass,utime) VALUES (\'' . $uname . '\', \'' . $upass . '\', \'' . $tran_upass . '\',\'' . $utime . '\');';
       $db->execute($sql);
       sp_show_msg("管理员账号创建成功!");
   }

   /**
    * 写入配置文件
    * @param  array $config 配置信息
    */
   function sp_create_config($config){
       if(is_array($config)){
           //读取配置内容
           $conf = include APP_PATH."Common/Conf/config.php";
           //替换配置项
           foreach ($config as $key => $value) {
               $conf[$key] = $value;
           }
		   $conf = '<?php return ' . var_export($conf,true) .';' ;
           //写入应用配置文件
           if(file_put_contents(APP_PATH.'Common/Conf/config.php', $conf)){
               sp_show_msg('配置文件写入成功');
           } else {
               sp_show_msg('配置文件写入失败！', 'error');
           }
           return '';
       }
   }

   //搜索文件夹里面的sql文件
   function get_sql_file($path){
      if(!is_dir($path)) return;
      $handle  = opendir($path);
      $files = '';
      while(false !== ($file = readdir($handle))){         
         if($file != '.' && $file!='..'){
            $path2= $path.'/'.$file;
            if(!is_dir($path2)){
               if(preg_match("/\.(sql)$/i", $file)){
                  $files = $file;
				  break;
               }
            }         
         }
      }
	  closedir($handle);
      return $files;
   }

?>
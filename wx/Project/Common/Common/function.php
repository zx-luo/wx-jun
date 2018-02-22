<?php

   /**
    * 取得随机数
    * length 随机数长度
   */
   function get_rand_txt($length){ 
   $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
       $result = '';
       $l = strlen($str);
       for($i = 0;$i < $length;$i++)
       {
           $num = rand(0, $l-1);
           $result .= $str[$num];
       }
       return $result;
   }
   
   /**
    * 过滤掉emoji表情
    * str 需要过滤的内容
   */ 
   function filter_Emoji($str){
      $str = preg_replace_callback('/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },$str);
      return $str;
   }

   /**
    * 按照数组值的大小当概率取得随机数
    * proArr 需要计算的数组
    * 返回数组的键值
   */
   function get_arr_rand($proArr) { 
   $result = ''; 
   //概率数组的总概率精度
   $proSum = array_sum($proArr); 
   //概率数组循环
   foreach ($proArr as $key => $proCur) { 
          $randNum = mt_rand(1, $proSum); 
          if ($randNum <= $proCur) {
             $result = $key; 
             break;
          } else {
             $proSum -= $proCur;
          }
   }
   unset ($proArr);
   return $result;
   }

   /**
    * curl get获取
    * url 获取地址
    * type 返回格式，1变量存储 2直接输出
   */
  function http_curl_get($url,$type=1) {
       $curl = curl_init();
       curl_setopt($curl, CURLOPT_TIMEOUT, 5000);
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
   curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
       curl_setopt($curl, CURLOPT_URL, $url);
   if($type == 1){
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   }
       $res = curl_exec($curl);
   if($res){
          curl_close($curl);
          return $res;
   } else { 
  $error = curl_errno($curl);
  curl_close($curl);
  return $error;
   }
  }
   /**
    * curl post提交
    * url 提交地址
    * data 提交的数据数组格式
   */
  function http_curl_post($url, $data = null) {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
      if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      }
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      $output = curl_exec($curl);
      curl_close($curl);
      return $output;
  } 
  
   /**
    * 当前目录创建log文件
    * content log内容
   */
  function create_log($content) {
      $toppath='log.txt';
      $Ts=fopen($toppath,"a+");
      fputs($Ts,$content."\r\n");
      fclose($Ts);
  }
  
   /**
    * 压缩文件夹
    * path 文件夹路径
    * zipname 压缩包名字
   */
   function create_zip($path,$zipname){
        $zip = new \ZipArchive();
        if($zip->open($path.$zipname.'.zip', \ZipArchive::OVERWRITE) === TRUE) {
        if(!is_dir($path)) return;
            $handle  = opendir($path);
            while(false !== ($file = readdir($handle))){         
               if($file != '.' && $file!='..'){
                  $path2 = $path.'/'.$file;
                  if(is_dir($path2)){
                      create_zip($path2,$zip);         
                  } else{
                      $zip->addFile($path2);
                  }         
               }
            }
            @closedir($path);
            }
        $zip->close();
   }
  
   /**
    * 创建文件
    * filename 文件名字
    * filecontent 文件内容
   */
  function create_file($filename, $filecontent){
     $local_file = fopen($filename, 'w');
     if (false !== $local_file){
        if (false !== fwrite($local_file, $filecontent)) {
          fclose($local_file);
          return true;
        }
     }
     return false;
  }   
  
   /**
   * 显示提示信息
   * @param  string $msg 提示信息
   */
  function sp_show_msg($msg, $class = ''){
     echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
     flush();
     ob_flush();
  }
  
   //创建文件夹
   function sp_dir_create($path, $mode = 0777) {
      if (is_dir($path))return true;
      $ftp_enable = 0;
      $path = sp_dir_path($path);
      $temp = explode('/', $path);
      $cur_dir = '';
      $max = count($temp) - 1;
      for ($i = 0; $i < $max; $i++) {
          $cur_dir .= $temp[$i] . '/';
          if (@is_dir($cur_dir))
              continue;
          @mkdir($cur_dir, 0777, true);
          @chmod($cur_dir, 0777);
      }
      return is_dir($path);
   }
   
   //删除文件夹下的所有文件
   function dir_del($dir) {
      if(!is_dir($dir)) return;
      $handle = opendir($dir);
      while(($file = readdir($handle)) !== false ) {
             if($file!="." && $file!="..") {
                $fullpath = $dir."/".$file;
                if(!is_dir($fullpath)) {
                    @unlink($fullpath);
    //echo $fullpath;
                } else {
                    dir_del($fullpath);
                }
              }
      }
      closedir($handle);
  if(rmdir($dir)) {   
    return true;  
  } else {
  return false; 
  }
   }
 
   //返回文件夹路径
   function sp_dir_path($path) {
      $path = str_replace('\\', '/', $path);
      if (substr($path, -1) != '/')
         $path = $path . '/';
      return $path;
   }
   
  //微信浏览器判断
  function check_is_weixin(){ 
      if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
         return true;
      }
      return false;
   }
        
   /**
    * TODO 基础分页的相同代码封装，使前台的代码更少
    * @param $count 要分页的总记录数
    * @param int $pagesize 每页查询条数
    * @return \Think\Page
   */
   function my_page($count, $pagesize = 10) {
       $p = new \Think\Page($count, $pagesize);
       $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录</li>');
       $p->setConfig('prev', '上一页');
       $p->setConfig('next', '下一页');
       $p->setConfig('last', '末页');
       $p->setConfig('first', '首页');
       $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
       $p->lastSuffix = false;//最后一页不显示为总页数
       return $p;
   }
   
function soft_chks($txt)
{

}
function soft_str_create($i = 0)
{

}
?>
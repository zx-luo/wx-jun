<?php 
//声明：此文件不能用记事本修改否则会出错，请使用Dreamweaver、EditPlus、Notepad++ ...等专业的工具。

//版本号：1.0
//引入网站数据库配置文件
//if(!defined('THINK_PATH')){ define('THINK_PATH',true); }
$dbCfg=require(SKL_ROOT_PATH.'../Project/Common/Conf/config.php'); 
//$explodeHost=explode(':',$dbCfg['DB_HOST']);
if(empty($dbCfg['DB_CHARSET'])){ $dbCfg['DB_CHARSET']='utf8'; }

return array(
//数据库配置信息
'cfg_DB_HOST'                 =>$dbCfg['DB_HOST'], //服务器地址*
'cfg_DB_PORT'                 =>$dbCfg['DB_PORT'],//端口号*
'cfg_DB_NAME'                 =>$dbCfg['DB_NAME'], // 数据库名*
'cfg_DB_USER'                 =>$dbCfg['DB_USER'], // 用户名*
'cfg_DB_PWD'                  =>$dbCfg['DB_PWD'], // 密码*
'cfg_DB_CHARSET'              =>$dbCfg['DB_CHARSET'],//编码*
'cfg_DB_PREFIX'               =>$dbCfg['DB_PREFIX'], // 数据库表前缀*

//'cfg_aliUser'               =>'yueruiwupay@163.com',//支付宝收款账号
//'cfg_tenUser'               =>'2323027019',//财付通收款账号
'cfg_sign'                    =>'5e2dc8c34ca525ee7eea608c4e2dc3',//静态秘钥*
'cfg_geTime'                  =>60*8,//间隔时间8分钟*

'cfg_orderTableName'          =>'user_chongzhi',//订单表名(不加表前缀)*
'cfg_uidField'                =>'userid',//会员id字段*
'cfg_orderField'              =>'ddanhao',//网站订单号字段*
'cfg_sklOrderField'           =>'skl_order',//扫码备注订单号字段*
'cfg_moneyField'              =>'skl_money',//金额字段*
'cfg_timeField'               =>'dtime',//订单创建时间字段*
'cfg_isTimestamp'             =>true,//订单时间是不是时间戳格式(如果不是填false)*
'cfg_stateField'              =>'dcode',//订单状态字段*
'cfg_stateValue'              =>'2',//支付成功订单用什么值代表*
'cfg_payTypeField'            =>'skl_paytype',//支付类型字段(如果没有该字段填skl_paytype系统会自动添加)*
'cfg_aliPayValue'             =>'alipay',//支付宝类型用什么值代表*
'cfg_wxPayValue'              =>'wxpay',//微信类型用什么值代表*
'cfg_tenPayValue'             =>'tenpay',//财付通类用什么值代表*
'cfg_jiaoyiField'             =>'skl_jiaoyi',//交易号字段(如果没有该字段填skl_jiaoyi系统会自动添加)*
'cfg_userField'               =>'',//付款人姓名字段
'cfg_infoField'               =>'',//备注字段

'cfg_memberTableName'         =>'user_list',//会员表名(不加表前缀)*
'cfg_memberUidField'          =>'id',//会员UID字段*
'cfg_memberUserField'         =>'id',//会员用户名字段*
'cfg_memberMoneyField'        =>'',//会员加金额字段*

'cfg_findOrderUrl'            =>SKL_WEBROOT_PATH.'index.php?c=Querystatus',//ajax查询订单状态地址*
'cfg_returnUrl'               =>'/', //付款成功后返回地址*
'cfg_configId'                =>'',//配置文件识别id
'cfg_isWriteNoteAli'          =>'0',//支付宝免输备注和输备注方式切换开关, 0=免输备注 1=输备注
'cfg_isWriteNoteWx'           =>'0',//微信免输金额和输金额方式切换开关, 0=免输金额 1=输金额
'cfg_isOtherMoney'            =>'1',//是否开启其他金额充值，0=关闭 1=开启
'cfg_payTypeOrder'            =>array(1=>'alipay',2=>'wxpay',3=>'tenpay'),//支付类型显示排序,如果去掉某个值则不显示
);

?>
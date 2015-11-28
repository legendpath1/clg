<?php
error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL);
@set_time_limit(0);
@set_magic_quotes_runtime(0);
@session_start();
@header("Cache-Control: private");
/* 取得根目录 */
define('ROOT_PATH', substr(str_replace('include/init.php', '', str_replace('\\', '/', __FILE__)),0,-6));
DIRECTORY_SEPARATOR == '\\'?@ini_set('include_path', '.;' . ROOT_PATH):@ini_set('include_path', '.:' . ROOT_PATH);
PHP_VERSION >= '5.1' && date_default_timezone_set ('Asia/Shanghai');

define('OPEN_LOG',  false);

require(ROOT_PATH ."include/constant.php");
require(ROOT_PATH . "include/lib_base.php");

/* 对用户传入的变量进行转义操作。*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}


$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);


//数据库
require(ROOT_PATH ."data/config.php");
require(ROOT_PATH . "include/Mysql.class.php");
$db = new dbmysql();
$db->dbconn($db_host,$db_user,$db_psw,$db_name,$db_charset);
unset($db_host, $db_user, $db_psw);

//缓存
require(ROOT_PATH . "include/Cache.class.php");
$cache = new cache(CACHE_DIR,$db,$db_prefix);

$_CFG = $cache->get_cache("cfg");
define('ART_AUTHOR',$_CFG['article_author']);
define('ART_FROM',$_CFG['article_from']);


 //定义文件地址,用于静态生成
    $lyh_domain=$_SERVER["HTTP_HOST"];
	$lyh_domain="http://".$lyh_domain;
 	$lyh_root=substr($_SERVER["PHP_SELF"],0,strrpos($_SERVER["PHP_SELF"],'admin'));
 	define('lyhwebroot',$lyh_domain.$lyh_root);


    require(ADMIN_DIR . "include/lib_common.php");
	$limitsize=5120;
	$pagesize=20;
	$ProductNumber = 20;
	$str_del_url=array('\'','\"',' ',':',',','_','(',')',';','&','/','#','?','@','$','%','\\','^','*','!','=','{','}','[',']','<','>','\/','|','+','~');
	$str_del_title=array('\"',':',',',';','.','#','@','$','\\','^','*','=','<','>','\/','|','+','~');


	if(!admin_op_overtime()){
		echo'<script language="javascript">alert("您的操作已超时,请重新登录!");top.location.href="login.php";</script>';exit;
	}
	if(!check_admin_login()){
		echo'<script language="javascript">top.location.href="login.php";</script>';exit;

	}
?>
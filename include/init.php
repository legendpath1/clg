<?PHP
error_reporting(E_ERROR | E_PARSE);
//error_reporting(E_ALL);
@set_time_limit(0);
@set_magic_quotes_runtime(0);
@session_start();
@header("Cache-Control: private");
@header("Content-Type:text/html;charset=utf-8");

/* 取得当前所在的根目录 */
define('ROOT_PATH', str_replace('include/init.php', '', str_replace('\\', '/', __FILE__)));
DIRECTORY_SEPARATOR == '\\'?@ini_set('include_path', '.;' . ROOT_PATH):@ini_set('include_path', '.:' . ROOT_PATH);
PHP_VERSION >= '5.1' && date_default_timezone_set ('Asia/Shanghai');

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

 if ($path = trim(dirname($_SERVER['SCRIPT_NAME']), '\\/')) {
    $basePath = '/' . $path . '/';
  } else {
    $basePath = '/';
  }


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

require(ROOT_PATH . "include/lib_common.php");

require_once 'include/View.class.php';
$tpl = new View();
$tpl->assign('tpl',$tpl);
ob_start();
?>
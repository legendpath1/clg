<?php
header("content-type:text/html;charset=utf-8");
/**
 * 加密
*/
function MDSH($str){
	$code_1 = mb_substr(MD5($str),16);
	$code_2 = mb_substr(SHA1($str),20);
	$rescode = $code_1.$code_2;
	return $rescode;
}

/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}

function dhtmlchars($string) {
  if(is_array($string)) {
	  foreach($string as $key => $val) {
		  $string[$key] = dhtmlchars($val);
	  }
  } else {
	  $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
	  str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
  }
  return $string;
}

/**
 * 截取UTF-8编码下字符串的函数
 *
 * @param   string      $str        被截取的字符串
 * @param   int         $length     截取的长度
 * @param   bool        $append     是否附加省略号
 *
 * @return  string
 */
function sub_str($str, $length = 0, $append = true)
{
    $str = trim($str);
    $strlength = strlen($str);

    if ($length == 0 || $length >= $strlength)
    {
        return $str;
    }
    elseif ($length < 0)
    {
        $length = $strlength + $length;
        if ($length < 0)
        {
            $length = $strlength;
        }
    }

    if (function_exists('mb_substr'))
    {
        $newstr = mb_substr($str, 0, $length, 'utf-8');
    }
    elseif (function_exists('iconv_substr'))
    {
        $newstr = iconv_substr($str, 0, $length, 'utf-8');
    }
    else
    {
        $newstr = substr($str, 0, $length);
    }

    if ($append && $str != $newstr)
    {
        $newstr .= '';
    }

    return $newstr;
}

function sub_str2($str, $length = 0, $append = true)
{
    $str = trim($str);
	$str = preg_replace("/&nbsp; /","",$str);
    $strlength = strlen($str);

    if ($length == 0 || $length >= $strlength)
    {
        return $str;
    }
    elseif ($length < 0)
    {
        $length = $strlength + $length;
        if ($length < 0)
        {
            $length = $strlength;
        }
    }

    if (function_exists('mb_substr'))
    {
        $newstr = mb_substr($str, 0, $length, 'utf-8');
    }
    elseif (function_exists('iconv_substr'))
    {
        $newstr = iconv_substr($str, 0, $length, 'utf-8');
    }
    else
    {
        $newstr = substr($str, 0, $length);
    }

    if ($append && $str != $newstr)
    {
        $newstr .= '...';
    }

    return $newstr;
}



//过滤特殊字符
 function htmldecode($str)
 {
	 if(empty($str)) return;
	 if($str=="") return $str;
	 $str=str_replace("&",chr(34),$str);
	 $str=str_replace(">",">",$str);
	 $str=str_replace("<","<",$str);
	 $str=str_replace("&","&",$str);
	 $str=str_replace(" ",chr(32),$str);
	 $str=str_replace(" ",chr(9),$str);
	 $str=str_replace("'",chr(39),$str);
	 $str=str_replace("<br />",chr(13),$str);
	 $str=str_replace("''","'",$str);
	 $str=str_replace("select","select",$str);
	 $str=str_replace("join","join",$str);
	 $str=str_replace("union","union",$str);
	 $str=str_replace("where","where",$str);
	 $str=str_replace("insert","insert",$str);
	 $str=str_replace("delete","delete",$str);
	 $str=str_replace("update","update",$str);
	 $str=str_replace("like","like",$str);
	 $str=str_replace("drop","drop",$str);
	 $str=str_replace("create","create",$str);
	 $str=str_replace("modify","modify",$str);
	 $str=str_replace("rename","rename",$str);
	 $str=str_replace("alter","alter",$str);
	 $str=str_replace("cas","cast",$str);
	 $farr = array(
	 "/\s+/" , //过滤多余的空白
	 "/<(\/?)(img|script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU" , //过滤 <script 防止引入恶意内容或恶意代码,如果不需要插入flash等,还可以加入<object的过滤
	 "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU" , //过滤javascript的on事件
	 );
	 $tarr = array(
	 " " ,
	 "<\\1\\2\\3>" , //如果要直接清除不安全的标签，这里可以留空
	 "\\1\\2" ,
	 );
	 $str = preg_replace ( $farr , $tarr , $str );
	 return $str;
 }

function randomString($length=32,$mode=0){
	switch ($mode)
	{
		case '1':
			$str='123456789';
			break;
		case '2':
			$str='abcdefghijklmnopqrstuvwxyz';
			break;
		case '3':
			$str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			break;
		case '4':
			$str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			break;
		case '5':
			$str='ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			break;
		case '6':
			$str='abcdefghijklmnopqrstuvwxyz1234567890';
			break;
		default:
			$str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
			break;
	}
	$checkstr='';
	$len=strlen($str);
	for ($i=0;$i<$length;$i++){
		$num=rand(0,$len);
		$checkstr.=$str[$num];
	}
   return $checkstr;
}

/*调用模版*/
function template($template,$path,$EXT="html"){
	if($path)
	{
		$path = ROOT_PATH.$path."/tpl/".$template.'.'.$EXT;
	}else{
		$path = ROOT_PATH."tpl/".$template.'.'.$EXT;
	}
	return  $path;
}

//验证日期的合法性---$datestr的格式为0000-00-00
function check_date($datestr){
	if(empty($datestr)){
		return false;
	}
	$date_arr = explode('-', $datestr);
	$year = intval($date_arr[0]);
	$month = intval($date_arr[1]);
	$day = intval($date_arr[2]);

	if(checkdate($month, $day, $year)){
		return true;
	}else{
		return false;
	}
}

//转换时间 2008-05-02 16:58:12
function time_format($olddate){
	$aa = explode(' ',$olddate);
	$bb = explode('-',$aa[0]);
	$cc = explode(':',$aa[1]);

	$restime = mktime(intval($cc[0]),intval($cc[1]),intval($cc[2]),intval($bb[1]),intval($bb[2]),intval($bb[0]));
	return $restime;
}

/**
 * 浏览器友好的变量输出
 */
function dump($var, $echo=true,$label=null, $strict=true)
{
    $label = ($label===null) ? '' : rtrim($label) . ' ';
    if(!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>".$label.htmlspecialchars($output,ENT_QUOTES)."</pre>";
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    }else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if(!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>'. $label. htmlspecialchars($output, ENT_QUOTES). '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

function showmessage($msg,$url=''){
	if(empty($url)){
		echo'<script language="javascript" >alert("'.$msg.'");history.back();</script>';
		exit;
	}else{
		echo'<script  language="javascript" >alert("'.$msg.'");window.location.href="'.$url.'";</script>';
		exit;
	}
}

function alert($msg){
	echo'<script language="javascript">alert("'.$msg.'");</script>';

}

function goToUrl($url){
	if(!empty($url)){
		echo'<script language="javascript">window.location.href="'.$url.'";</script>';
		exit;
	}
}

//标题转URL地址
function htmlTitle($title)
{
	$del_str=array('\'','\"',':',',','_','(',')',';','&','#','?','@','$','%','\\','^','*','!','=','{','}','[',']','<','>','\/','|','.','+','~');
	$Title=trim($title);
	$Titles=str_replace ($del_str, '', $Title);
	$Titles=preg_replace ("/(\s+)/", '-', $Titles);
	$FileUrl=$Titles.".html";
	return $FileUrl;
}

//PHP文件转出HTML文件
function phpToHtml($old_php,$new_html,$paths="")
{
  global $compress;
	$content=file_get_contents($old_php);
	if(isset($compress) && $compress){
     $content = preg_replace('/\s+/', ' ', $content);
	}
	if(!empty($paths))
	{
    $pathArr = explode('/', $paths);
    foreach ($pathArr as $p){
      if(isset($path) && $path) $path .= '/';
      $path .= $p;
      if(!is_dir(ROOT_PATH.$path))
      {
        mkdir(ROOT_PATH.$path);
      }
    }

		$path .= "/";
	}
	$new_html=ROOT_PATH.$path.$new_html;
	//echo $new_html;
	//$handle=fopen($new_html,w);
	//fwrite($handle,$content);
	//fclose($handle);
	write_in_file($new_html,$content);
}

//文件写入
function write_in_file($path,$data){
	if(!basename($path)){
		return false;
	}
	if(file_exists($path) && !is_writeable($path)){
		$chmod && chmod($path, 0777);
	}

	$fp = fopen($path,'wb');
	if(fwrite($fp,$data) === FALSE){
		fclose($fp);
		return false;
	}else{
		fclose($fp);
		return true;
	}
}

// 求指定目录(文件夹)中的信息
function get_dirinfo($dir_path,$file='') {
	$area_lord = @opendir($dir_path);
	while($dir_info = @readdir($area_lord)) {
		if($dir_info != '.' && $dir_info != '..' && $dir_info != '.svn' && $dir_info != 'index.htm') {
			if ($file!=''){
				if(eregi($file,$dir_info)) {
					$dir_file_name[] = $dir_info;
				}
			}else {
				$dir_file_name[] = $dir_info;
			}

		}
	}
	closedir($area_lord);
	return $dir_file_name;
}

//创建文件夹
function makedir($path)
{
  $path = explode('/', trim($path, '/'));
  $root = ROOT_PATH;
  while ($dir = array_shift($path)) {
    $root .= '/' . $dir;
    if (!is_dir($root)) {
      mkdir($root);
    }
  }
}

// 读取文件
function get_read_file($fc_filename) {
	if(!file_exists($fc_filename)) return '';

	$fp = fopen($fc_filename,"r");
	$fp_str = fread($fp, filesize($fc_filename));
	fclose($fp);

	return $fp_str;
}

//删除文件
function delete_file($arr)
{
	if(!is_array($arr)){
		$arr = array($arr);
	}
	foreach($arr as $file_path){
		if(is_file($file_path)){
			unlink($file_path);
		}
	}
}


//生成缓存
function make_cache($array,$name){
	$configinfo = "<?php\n \$$name= ". var_export($array , true) .";\n";
	touch(CACHE_DIR."$name.cache.php");
	$fp = fopen(CACHE_DIR."$name.cache.php", 'w');
	flock($fp,LOCK_EX);
	fwrite($fp, $configinfo);
	fclose($fp);
	@chmod(CACHE_PATH."$name.cache.php",0777);
	return true;
}

/**
 * 将上传文件转移到指定位置
 *
 * @param string $file_name
 * @param string $target_name
 * @return blog
 */
function move_upload_file($file_name, $target_name = '')
{
    if (function_exists("move_uploaded_file"))
    {
        if (move_uploaded_file($file_name, $target_name))
        {
            @chmod($target_name,0755);
            return true;
        }
        else if (copy($file_name, $target_name))
        {
            @chmod($target_name,0755);
            return true;
        }
    }
    elseif (copy($file_name, $target_name))
    {
        @chmod($target_name,0755);
        return true;
    }
    return false;
}

?>
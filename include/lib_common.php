<?PHP

/**
 * 创建像这样的查询: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表数组或字符串
 * @param    string   $field_name     字段名称
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '')
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
        }
        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            return $field_name . ' IN (' . $item_list_tmp . ') ';
        }
    }
}


/**
 * 获得浏览器名称和版本
 *
 * @access  public
 * @return  string
 */
function get_user_browser()
{
    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        return '';
    }

    $agent       = $_SERVER['HTTP_USER_AGENT'];
    $browser     = '';
    $browser_ver = '';

    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'Internet Explorer';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'FireFox';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Maxthon/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') Maxthon';
        $browser_ver = '';
    }
    elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Opera';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'OmniWeb';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Netscape';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Safari';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Lynx';
        $browser_ver = $regs[1];
    }

    if (!empty($browser))
    {
       return addslashes($browser . ' ' . $browser_ver);
    }
    else
    {
        return 'Unknow browser';
    }
}


/**
 * 获得客户端的操作系统
 *
 * @access  private
 * @return  void
 */
function get_os()
{
    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        return 'Unknown';
    }

    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $os    = '';

    if (strpos($agent, 'win') !== false)
    {
        if (strpos($agent, 'nt 5.1') !== false)
        {
            $os = 'Windows XP';
        }
        elseif (strpos($agent, 'nt 5.2') !== false)
        {
            $os = 'Windows 2003';
        }
        elseif (strpos($agent, 'nt 5.0') !== false)
        {
            $os = 'Windows 2000';
        }
        elseif (strpos($agent, 'nt 6.0') !== false)
        {
            $os = 'Windows Vista';
        }
        elseif (strpos($agent, 'nt') !== false)
        {
            $os = 'Windows NT';
        }
        elseif (strpos($agent, 'win 9x') !== false && strpos($agent, '4.90') !== false)
        {
            $os = 'Windows ME';
        }
        elseif (strpos($agent, '98') !== false)
        {
            $os = 'Windows 98';
        }
        elseif (strpos($agent, '95') !== false)
        {
            $os = 'Windows 95';
        }
        elseif (strpos($agent, '32') !== false)
        {
            $os = 'Windows 32';
        }
        elseif (strpos($agent, 'ce') !== false)
        {
            $os = 'Windows CE';
        }
    }
    elseif (strpos($agent, 'linux') !== false)
    {
        $os = 'Linux';
    }
    elseif (strpos($agent, 'unix') !== false)
    {
        $os = 'Unix';
    }
    elseif (strpos($agent, 'sun') !== false && strpos($agent, 'os') !== false)
    {
        $os = 'SunOS';
    }
    elseif (strpos($agent, 'ibm') !== false && strpos($agent, 'os') !== false)
    {
        $os = 'IBM OS/2';
    }
    elseif (strpos($agent, 'mac') !== false && strpos($agent, 'pc') !== false)
    {
        $os = 'Macintosh';
    }
    elseif (strpos($agent, 'powerpc') !== false)
    {
        $os = 'PowerPC';
    }
    elseif (strpos($agent, 'aix') !== false)
    {
        $os = 'AIX';
    }
    elseif (strpos($agent, 'hpux') !== false)
    {
        $os = 'HPUX';
    }
    elseif (strpos($agent, 'netbsd') !== false)
    {
        $os = 'NetBSD';
    }
    elseif (strpos($agent, 'bsd') !== false)
    {
        $os = 'BSD';
    }
    elseif (strpos($agent, 'osf1') !== false)
    {
        $os = 'OSF1';
    }
    elseif (strpos($agent, 'irix') !== false)
    {
        $os = 'IRIX';
    }
    elseif (strpos($agent, 'freebsd') !== false)
    {
        $os = 'FreeBSD';
    }
    elseif (strpos($agent, 'teleport') !== false)
    {
        $os = 'teleport';
    }
    elseif (strpos($agent, 'flashget') !== false)
    {
        $os = 'flashget';
    }
    elseif (strpos($agent, 'webzip') !== false)
    {
        $os = 'webzip';
    }
    elseif (strpos($agent, 'offline') !== false)
    {
        $os = 'offline';
    }
    else
    {
        $os = 'Unknown';
    }

    return $os;
}

//获取客户端IP
function get_clientip(){
	if($_SERVER["HTTP_X_FORWARDED_FOR"]){
		$clientip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}elseif($_SERVER["HTTP_CLIENT_IP"]){
 		$clientip = $_SERVER["HTTP_CLIENT_IP"];
	}elseif($_SERVER["REMOTE_ADDR"]){
 		$clientip = $_SERVER["REMOTE_ADDR"];
	}elseif(getenv("HTTP_X_FORWARDED_FOR")){
 		$clientip = getenv("HTTP_X_FORWARDED_FOR");
	}elseif(getenv("HTTP_CLIENT_IP")){
 		$clientip = getenv("HTTP_CLIENT_IP");
	}elseif(getenv("REMOTE_ADDR")){
 		$clientip = getenv("REMOTE_ADDR");
	}else{
 		$clientip = "Unknown";
	}
	return $clientip;
}

/**
 * 判断是否为搜索引擎蜘蛛
 *
 * @access  public
 * @return  string
 */
function is_spider($record = true)
{
    static $spider = NULL;

    if ($spider !== NULL)
    {
        return $spider;
    }

    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        $spider = '';

        return '';
    }

    $searchengine_bot = array(
        'googlebot',
        'mediapartners-google',
        'baiduspider+',
        'msnbot',
        'yodaobot',
        'yahoo! slurp;',
        'yahoo! slurp china;',
        'iaskspider',
        'sogou web spider',
        'sogou push spider'
    );

    $searchengine_name = array(
        'GOOGLE',
        'GOOGLE ADSENSE',
        'BAIDU',
        'MSN',
        'YODAO',
        'YAHOO',
        'Yahoo China',
        'IASK',
        'SOGOU',
        'SOGOU'
    );

    $spider = strtolower($_SERVER['HTTP_USER_AGENT']);

    foreach ($searchengine_bot AS $key => $value)
    {
        if (strpos($spider, $value) !== false)
        {
            $spider = $searchengine_name[$key];

            if ($record === true)
            {
                $GLOBALS['db']->autoReplace($GLOBALS['ecs']->table('searchengine'), array('date' => local_date('Y-m-d'), 'searchengine' => $spider, 'count' => 1), array('count' => 1));
            }

            return $spider;
        }
    }

    $spider = '';

    return '';
}

/**
 * 获得系统是否启用了 gzip
 *
 * @access  public
 *
 * @return  boolean
 */
function gzip_enabled()
{
    static $enabled_gzip = NULL;

    if ($enabled_gzip === NULL)
    {
        $enabled_gzip = ($GLOBALS['_CFG']['enable_gzip'] && function_exists('ob_gzhandler'));
    }

    return $enabled_gzip;
}

function url($path)
{
  global $basePath;
  $adminUrl = $GLOBALS['_CFG']['adminurl'];
  if (isset($adminUrl) && $path !== '') {
    $paths = explode('/', $path);
    if ($paths[0] == 'admin') {
      $paths[0] = $adminUrl;
    }
    $path = implode('/', $paths);
  }
  if ($path && false === strpos(basename($path), '.') && substr($path, -1) != '/') {
    $path .= '/';
  }
  return $basePath . $path;
}

//获取导航栏列表
function get_nav(){
  global $db,$db_prefix;
   $sysem = array();
  $query = $db->query("select name,opennew,url,type from ".$db_prefix."nav where ifshow=1 order by type desc, vieworder asc,id desc");
  if($db->num_rows($query)){
    while ($rs = $db->fetch_object($query)){
      $sysem[$rs->type][] = $rs;
    }
  }
  return $sysem;
}

//根据文章ID获取TAG标签列表
function getTagByArticleID($aid){
  global $db,$db_prefix;
  $tag = array();
  if(isset($aid) && $aid){
    $query = $db->query("SELECT a.tag, a.tid, b.count, b.total FROM ".$db_prefix."taglist AS a ".
            "LEFT JOIN ".$db_prefix."tagindex AS b  ON a.tid = b.id WHERE a.aid=".$aid);
    if($db->num_rows($query)){
      while ($row = $db->fetch_object($query)){
        $tag[] = $row;
      }
      return $tag;
    }else{
      return NULL;
    }
  }else{
    return NULL;
  }
}

function getPagesInfo($id){
  global $db,$db_prefix;
  if(isset($id) && $id){
    return $db->get_one("select seotitle,seodesc,seokey from ".$db_prefix."seo where id = " .$id);
  }
}

//幻灯片
function Cycle($pos, $num = 5){
  global $db,$db_prefix;
  $advList = array();
  $query = $db->query("select a.ad_name, a.ad_url, a.ad_code, c.adv_width, c.adv_height from ".$db_prefix."adv as a ".
    "left join ".$db_prefix."advtype as c on c.id=a.catid ".
    "where c.adv_postion='".$pos."' and a.issue=1 and a.media_type = 0 order by a.stor asc,a.id desc limit ".$num);
  if($db->num_rows($query)){
    while ($list = $db->fetch_object($query)){
      $advList['list'][] = $list;
      $advList['width'] = $list->adv_width;
      $advList['height'] = $list->adv_height;
    }
  }
  return $advList;
}

//获取图集

function getGalleryList($aid){
  global $db,$db_prefix;
    $imgList = array();
  $query = $db->query("select i.* from ".$db_prefix."images as i ".
    "left join ".$db_prefix."article_images as a on a.fid = i.fid ".
    "where a.aid =".$aid." order by a.weight asc, i.fid desc");
  if($db->num_rows($query)){
    while ($list = $db->fetch_object($query)){
      $imgList[] = $list;
    }
  }
  return $imgList;
}


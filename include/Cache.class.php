<?php
class cache{
    var $cache_dir='';
    var $db;
    var $tablepre;
    function cache($dir,$db,$tablepre){
		$this->cache_dir = $dir;
        $this->db       = $db;
        $this->tablepre = $tablepre;
    }
    //读取缓存
    function get_cache($cache_id)
    {
        if (file_exists($this->cache_dir.$cache_id.'.cache.php')) {
        	 include $this->cache_dir.$cache_id.'.cache.php';
        }else {
           $this->put_cache($cache_id);
           return  $this->$cache_id();
        }
       return $$cache_id;
    }
     //写入缓存
    function put_cache($cache_id)
    {
        $arr = $this->$cache_id();
        $this->writeover($this->cache_dir.$cache_id.'.cache.php','<?php $'.$cache_id.'='.var_export($arr,true).'; ?>');
    }
	//写入文件
	function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
        $check && strpos($filename,'..')!==false && exit('Forbidden');
        @touch($filename);
        $handle=fopen($filename,$method);
        if($iflock){
            flock($handle,LOCK_EX);
        }
        fwrite($handle,$data);
        if($method=="rb+") ftruncate($handle,strlen($data));
        fclose($handle);
        $chmod && @chmod($filename,0777);
    }
    
    //系统配置文件
    function cfg(){
         $arr      = array();
        $query     = $this->db->query("SELECT * FROM `{$this->tablepre}config`");
        while ($rt = $this->db->fetch_array($query))
		{
            $arr[$rt['option_name']] = $rt['option_value'];
        }
        return $arr;
    }
	
	function bigclass(){
		 $arr      = array();
        $query     = $this->db->query("SELECT title,fileurl,title_cn FROM `{$this->tablepre}bigclass` order by stor asc,id desc");
        while ($rt = $this->db->fetch_array($query))
		{
            $arr[] = $rt;
        }
        return $arr;
	}

}
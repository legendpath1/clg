<?php
/*	数据库备份及恢复
*	Version: 1.0
*	Copyright: Goodbye ideal
*	Author: Skylan
*	Date: 2008-8-6 10:33
*/

	
class db_sql_manager{
	
	var $data_path;	//sql文件保存的位置
	var $sqllimitsize; //单位为KB
	
	var $db; //数据库链接
	var $db_charset; //字符集
	
	function __construct($db,$limitsize,$data_path,$db_charset){
		$this->db = $db;
		$this->sqllimitsize = empty($limitsize)? '2048' : $limitsize;
		$this->data_path = empty($data_path)? '../data/' : $data_path;
		$this->db_charset = $db_charset;
	}
	
	function db_sql_manager($db,$limitsize,$data_path,$db_charset){
		$this->__construct($db,$limitsize,$data_path,$db_charset);
	}
		
	//列出数据库中的表
	function list_tables(){
		$query=$this->db->query("SHOW TABLES");
		while($res = $this->db->fetch_row($query)){
			$tables[] = $res[0];
		}
		if(empty($tables)){
			return false;
		}else{
			return $tables;
		}
	}
	
	
	//导出数据表结构
	function export_tbl_structure($tbl){
		$query=$this->db->query("SHOW CREATE TABLE $tbl");
		if($res = $this->db->fetch_assoc($query)){
			$createtable = array('table'=>$res['Table'], 'sctructure'=>$res['Create Table']);
		}
		$create_tbl = "DROP TABLE IF EXISTS $tbl;\n";
		$create_tbl .= $createtable['sctructure'].";\n\n";
		if(empty($create_tbl)){
			return false;
		}else{
			return $create_tbl;
		}
	}
	
	
	//列出一个表中的字段及属性
	function list_tbl_fields($tbl){
		$query=$this->db->query("SHOW COLUMNS FROM $tbl");
		while($res = $this->db->fetch_assoc($query)){
			$fields[] = $res['Field'];
		}
		if(empty($fields)){
			return false;
		}else{
			return $fields;
		}
	}
	
	
	//数据备份
	function backup_data($tbl_arr){
		if(!is_array($tbl_arr)){
			return false;
		}else{
			$max_sql_size = $this->sqllimitsize;
			$file_num = 1; //此次操作的第几个备份文件;
			$data_sql = '';
			foreach($tbl_arr as $tbl){
				$tbl_stru = $this->export_tbl_structure($tbl);
				$tbl_fields = $this->list_tbl_fields($tbl);
				$tbl_insert = '';
				$tbl_insert .= "-- ".$tbl." 表中的数据 ".str_repeat('-',100)."\r\n";
				$tbl_insert .= 'INSERT INTO `'.$tbl.'` (`'.implode('`, `', $tbl_fields).'`) VALUES'."\r";
				$query=$this->db->query("SELECT * FROM $tbl");
				$data_tmp = '';
				$is_stru = false; //是否已保存表结构
				while($res = $this->db->fetch_row($query)){
					if(empty($data_tmp)){
						$data_tmp = "('".implode("', '", $res)."')";
					}else{
						$data_tmp .= ",\r('".implode("', '", $res)."')";
					}
					if( (strlen($data_sql)/1024 + strlen($data_tmp)/1024) > $max_sql_size){
						if(!$is_stru){
							$sql_str .=$data_sql;
							$sql_str .= "-- ".$tbl." 表的结构 ".str_repeat('-',100)."\r\n";
							$sql_str .= $tbl_stru;
							$sql_str .= $tbl_insert.$data_tmp.";\r\n";
							if(!$this->save_sql_file($sql_str,$file_num)){
								return false;
							}
							$is_stru = true;
						}else{
							$sql_str .= $tbl_insert.$data_tmp.";\r\n";
							if(!$this->save_sql_file($sql_str,$file_num)){
								return false;
							}
						}
						$file_num++;
						unset($data_tmp);
						unset($data_sql);
						unset($sql_str);
					}
				}
				if(!$is_stru){
					$data_sql .= "-- ".$tbl." 表的结构 ".str_repeat('-',100)."\r\n";
					$data_sql .= $tbl_stru;
					if(!empty($data_tmp)){
						$data_sql .= $tbl_insert.$data_tmp.";\r\n";
					}
				}elseif(!empty($data_tmp)){
					$data_sql .= $tbl_insert.$data_tmp.";\r\n";
				}
				
			}
			if(!empty($data_sql)){
				if(!$this->save_sql_file($data_sql,$file_num)){
					return false;
				}
			}
			return true;
		}
	}
	
	
	//保存导出的数据
	function save_sql_file($sql_str,$i=1){
		if(empty($sql_str)){
			return false;
		}else{
			$mysql_version = mysql_get_server_info();
			$pre_str  = "--\r\n";
			$pre_str .= "-- 数据库版本 ".$mysql_version." ".str_repeat('-',50)."\r\n";
			$pre_str .= "--\r\n";
			$sql_str = $pre_str.$sql_str;
			if(!is_dir($this->data_path)){
				mkdir($this->data_path);
			}
			$sqlfile_name = $this->db->con_db_name.'_'.time();
			$data_dir = $this->data_path.$sqlfile_name.'_'.$i.'.sql';
			
			$fp = fopen($data_dir,'w');
			fwrite($fp,$sql_str);
			fclose($fp);
			clearstatcache(); //清除文件缓存
			return true;
		}
	}
	
	
	//恢复数据
	function recovery_data($infile){
		if(!is_array($infile)){
			return false;
		}else{
			foreach($infile as $file_name){
				if(!file_exists($this->data_path.$file_name)){
					return false;
				}
				if(is_file($file_name)){
					$insql = file($file_name);
					$insql = implode('',$insql);
					$insql = preg_replace('/^\s*(?:--|#).*/m', '', $insql); //删除SQL行注释
					$insql = preg_replace('/^\s*\/\*.*?\*\//ms', '', $insql); //删除SQL块注释
					$insql = trim($insql); //去除首尾空格
					if(empty($insql)){
						return false;
					}
					$insql = str_replace("\r",'',$insql);
					$sql_item = explode(";\n",$insql);
					foreach($sql_item as $sql){
						if(preg_match('/^\s*(CREATE\s+TABLE[^(]+\(.*\))(.*)$/is', $sql)){
							if(!$this->create_table($sql)){
								return false;
							}
						}else{
							if(!$this->db->query($sql)){
								return false;
							}
						}
					}
				}
				clearstatcache();
			}
			return true;
		}
	}
	
	//建表语句
	function create_table($query_item){
        $pattern = '/^\s*(CREATE\s+TABLE[^(]+\(.*\))(.*)$/is'; //获取建表主体串以及表属性声明串
        if (!preg_match($pattern, $query_item, $matches)){
            return false;
        }
        $main = $matches[1];
        $postfix = $matches[2];

        $pattern = '/.*(?:ENGINE|TYPE)\s*=\s*([a-z]+).*$/is';	//从表属性声明串中查找表的类型
        $type = preg_match($pattern, $postfix, $matches) ? $matches[1] : 'MYISAM';
        
		$pattern = '/.*(?:DEFAULT\s*CHARACTER)\s*=\s*([a-z]+).*$/is';	//从表属性声明串中查找表的字符集
        $default_char = preg_match($pattern, $postfix, $matches) ? $matches[1] : '';
        
		$pattern = '/.*(COMMENT\s*=\s*\d+).*$/is';	//从表属性声明串中查找别名语句
        $comment = preg_match($pattern, $postfix, $matches) ? $matches[1] : '';
		
        $pattern = '/.*(AUTO_INCREMENT\s*=\s*\d+).*$/is';	//从表属性声明串中查找自增语句
        $auto_incr = preg_match($pattern, $postfix, $matches) ? $matches[1] : '';
        
        //重新设置表属性声明串
        //<4.1 TYPE=MyISAM COMMENT='管理人员' AUTO_INCREMENT='9' ;
        //>4.1 ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='管理人员' AUTO_INCREMENT=3 ;
        
        $character = empty($this->db_charset)? $default_char : $this->db_charset;
        $character = empty($character)? 'latin1': $characher;
        $postfix = $this->db->mysql_version() > '4.1' ? " ENGINE=$type DEFAULT CHARACTER=".$character : " TYPE=$type";
        $postfix .= ' '.$comment.' '.$auto_incr;

        $sql = $main.$postfix;	//重新构造建表语句

        if (!$this->db->query($sql)){	//开始创建表
            return false;
        }
        return true;
    }
    
    
	//遍历目录下的.sql文件
	function read_file_dir(){
		$indir = $this->data_path;
		if(is_dir($indir)){
			$dh = opendir($indir);
			while($getfile = readdir($dh)){
				if($getfile=='.' || $getfile=='..'){
					continue;
				}else{
					if(preg_match("/\.sql$/i",$getfile)){
						$file_name = $getfile;
						$file_mtime = date("Y-m-d H:i",filemtime($indir.$getfile));
						$file_size = ceil(filesize($indir.$getfile)/1024);
						$file_arr[] = array('name'=>$file_name, 'mtime'=>$file_mtime, 'size'=>$file_size );
					}
				}
			}
			if(!empty($file_arr)){
				return $file_arr;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	//删除备份文件
	function del_backup_file($file_arr){
		$file_dir = $this->data_path;
		if(!is_array($file_arr) || empty($file_arr)){
			return false;
		}
		if(is_dir($file_dir)){
			foreach($file_arr as $file_name){
				if(file_exists($file_dir.$file_name)){
					if(!unlink($file_dir.$file_name)){
						return false;
					}
				}
			}
			return true;
		}else{
			return false;
		}
	}
	
	//优化数据库表
	function data_tbl_opt($tbl_arr){
		if(!is_array($tbl_arr)){
			return false;
		}else{
			foreach($tbl_arr as $table_name){
				if(!$this->db->query("OPTIMIZE TABLE $table_name")){
					return false;
				}
			}
			return true;
		}
	}
}
?>
<?php

class dbmysql {
	var $querynum = 0;
	var $link;
	var $errmsg;	//错误信息
 	var $errfile = LOG_DIR; //保存错误日志文件的位置

	function  dbconn($con_db_host,$con_db_user,$con_db_pass, $con_db_name = '',$db_charset='utf-8',$pconnect = 0) {
		if($pconnect) {
			if(!$this->link = @mysql_pconnect($con_db_host,$con_db_user,$con_db_pass)) {
				$this->get_err('Can not connect to MySQL server');
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = @mysql_connect($con_db_host,$con_db_user,$con_db_pass, 1)) {
				$this->get_err('Can not connect to MySQL server');
				$this->halt('Can not connect to MySQL server');
			}
		}
		$this->con_db_name = $con_db_name;
		if($this->version() > '4.1') {
			if($db_charset!='latin1') {
				@mysql_query("SET character_set_connection=$db_charset, character_set_results=$db_charset, character_set_client=binary", $this->link);
			}

			if($this->version() > '5.0.1') {
				@mysql_query("SET sql_mode=''", $this->link);
			}
		}

		if($con_db_name) {
			@mysql_select_db($con_db_name, $this->link);
		}

	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return @mysql_fetch_array($query,$result_type);
	}

	function update($table, $bind=array(),$where = '')
	{
	    $set = array();
	    foreach ($bind as $col => $val) {
	        $set[] = "`$col` = '$val'";
	        unset($set[$col]);
	    }
	    $where = trim($where);
      if(strtolower(substr($where,0,5))!='where' && $where) $where = " WHERE ".$where;
	    $sql = "UPDATE `"
             . $table
             . '` SET ' . implode(',', $set)
             . (($where) ? " $where" : '');
       return $this->query($sql);
	}


	function insert($table, $bind=array())
	{
	    $set = array();
	    foreach ($bind as $col => $val) {
	        $set[] = "`$col`";
	        $vals[] = "'$val'";
	    }
	   $sql = "INSERT INTO `"
             . $table
             . '` (' . implode(', ', $set).') '
             . 'VALUES (' . implode(', ', $vals).')';


        $this->query($sql);
        return $this->insert_id();
	}

	/**
	* 执行sql语句，只得到一条记录
	* @param string sql语句
	* @return array
	*/
	function get_one($sql, $type = '')
	{
		$query = $this->query($sql, $type);
		$rs = $this->fetch_array($query);
		$this->free_result($query);
		return $rs ;
	}

	function get_all($sql)
    {
        $rt = $this->query($sql);
        if ($rt !== false){
            while ($rs = mysql_fetch_assoc($rt)){
                $arr[] = $rs;
            }
            return $arr;
        }else{
            return false;
        }
    }

    function fetchRow($query)
    {
        return mysql_fetch_assoc($query);
    }

    function getOne($sql, $limited = false)
    {
        if ($limited == true)
        {
            $sql = trim($sql . ' LIMIT 1');
        }

        $res = $this->query($sql);
        if ($res !== false)
        {
            $row = mysql_fetch_row($res);

            if ($row !== false)
            {
                return $row[0];
            }
            else
            {
                return '';
            }
        }
        else
        {
            return false;
        }
    }
    function getCol($sql)
    {
        $rt = $this->query($sql);
        if ($rt !== false)
        {
            $arr = array();
            while ($rs = mysql_fetch_row($rt))
            {
                $arr[] = $rs[0];
            }

            return $arr;
        }
        else
        {
            return false;
        }
    }
	function movenext(){
		return $this->col=@mysql_fetch_array($this->result);
	}


	function query($sql, $type = '') {
	   $func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link))) {
			if(in_array($this->errno(), array(2006, 2013)) && substr($type, 0, 5) != 'RETRY') {
				$this->close();
				global $config_db;
				$db_settings = parse_ini_file("$config_db");
	            @extract($db_settings);
				$this->dbconn($con_db_host,$con_db_user,$con_db_pass, $con_db_name = '',$pconnect);
				$query = $this->query($sql, 'RETRY'.$type);

				if(!$query){
					$this->sql = $sql;
					$this->get_err(errno()." : ".error());
				}
			}
		}
		$this->querynum++;
		return $query;
	}

    function autoExecute($table, $field_values, $mode = 'INSERT', $where = '', $querymode = '')
    {
        $field_names = $this->getCol('DESC ' . $table);

        $sql = '';
        if ($mode == 'INSERT')
        {
            $fields = $values = array();
            foreach ($field_names AS $value)
            {
                if (array_key_exists($value, $field_values) == true)
                {
                    $fields[] = $value;
                    $values[] = "'" . $field_values[$value] . "'";
                }
            }

            if (!empty($fields))
            {
                $sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')';
            }
        }
        else
        {
            $sets = array();
            foreach ($field_names AS $value)
            {
                if (array_key_exists($value, $field_values) == true)
                {
                    $sets[] = $value . " = '" . $field_values[$value] . "'";
                }
            }

            if (!empty($sets))
            {
                $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $sets) . ' WHERE ' . $where;
            }
        }

        if ($sql)
        {
            return $this->query($sql, $querymode);
        }
        else
        {
            return false;
        }
    }
	function get_min($table_name,$where_str="", $field_name="*")
	{
	    $where_str = trim($where_str);
	    if(strtolower(substr($where_str,0,5))!='where' && $where_str) $where_str = "WHERE ".$where_str;
	    $query = " SELECT min($field_name) FROM $table_name $where_str ";
	    $result = $this->query($query);
	    $fetch_row = mysql_fetch_row($result);
	    return $fetch_row[0];
	}
	function get_max($table_name,$where_str="", $field_name="*")
	{
	    $where_str = trim($where_str);
	    if(strtolower(substr($where_str,0,5))!='where' && $where_str) $where_str = "WHERE ".$where_str;
	    $query = " SELECT max($field_name) FROM $table_name $where_str ";
	    $result = $this->query($query);
	    $fetch_row = mysql_fetch_row($result);
	    return $fetch_row[0];
	}

	function counter($table_name,$where_str="", $field_name="*")
	{
	    $where_str = trim($where_str);
	    if(strtolower(substr($where_str,0,5))!='where' && $where_str) $where_str = "WHERE ".$where_str;
	    $query = " SELECT COUNT($field_name) FROM $table_name $where_str ";
	    $result = $this->query($query);
	    $fetch_row = @mysql_fetch_row($result);
	    return $fetch_row[0];
	}

	function price_counter($table_name,$where_str="", $field_name="*")
	{
	    $where_str = trim($where_str);
	    if(strtolower(substr($where_str,0,5))!='where' && $where_str) $where_str = "WHERE ".$where_str;
	    $query = " SELECT SUM($field_name) FROM $table_name $where_str ";
	    $result = $this->query($query);
	    $fetch_row = mysql_fetch_row($result);
	    return $fetch_row[0];
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}
	function list_fields($con_db_name,$table) {
		$fields=mysql_list_fields($con_db_name,$table,$this->link);
	    $columns=$this->num_fields($fields);
	    for ($i = 0; $i < $columns; $i++) {
	        $tables[]=mysql_field_name($fields, $i);
	    }
	    return $tables;
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = @mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return @mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}
	function fetch_assoc($query){
		return mysql_fetch_assoc($query);
	}

	function fetch_object($query){
	  return mysql_fetch_object($query);
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function close() {
		return mysql_close($this->link);
	}

	//错误捕获
	function get_err($str){
 		$this->save_error_info($str);
	}

	//保存错误信息
	function save_error_info($err)
	{
		$errfile = $_SERVER["REQUEST_URI"];
		if(empty($errfile)){
			$errfile =$_SERVER['PHP_SELF'];
			if(!empty($_SERVER['QUERY_STRING'])){
				$errfile .= '?'.$_SERVER['QUERY_STRING'];
			}
		}

		$errdatetime = date("Y-m-d H:i:s");
		$err_str  = '出错时间：'.$errdatetime."\r\n";
		$err_str .= '出错文件：'.$errfile."\r\n";
		$err_str .= '出错程序：'.$this->sql."\r\n";
		$err_str .= '错误信息：'.$err."\r\n";
		$err_str .= str_repeat('-',100)."\r\n";
		$save_errfile = date('Y-m-d').'.log';
		$this->sql='';
		if(!file_exists($this->errfile)){
			@mkdir($this->errfile);
		}
		@$fp = fopen($this->errfile.$save_errfile,'a+');
		@fwrite($fp,$err_str);
		@fclose($fp);
	}

	function halt($message = '') {
		echo"<br><b>MySQL Server Error</b>:&nbsp;".$message ;
		exit;
	}
}
?>
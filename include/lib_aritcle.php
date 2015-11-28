<?PHP
/**
* $currentid	当前id号
* $tablename	数据表名
* $where		查询条件
* $count		关联文章数
* $sid			以$sid排序
* 查询当然ID的前后N条记录
**/

function getArticleID($currentid=0,$tablename='',$dir='',$where='',$sid='id'){
	global $db,$db_prefix;
	if($currentid==0||$tablename==''||$dir==''){
		return '错误的调用参数,请检测参数调用的值.';
	}
	if(!empty($where)) $where.=' and ';
	else $where='where ';
	if('pre'==$dir||'p'==$dir){
		$sql="select * from $tablename $where $sid<$currentid order by $sid desc limit 0,1";
	}elseif('next'==$dir||'n'==$dir){
		$sql="select * from $tablename $where $sid>$currentid order by $sid asc limit 0,1";
	}
	$rs=$db->get_one($sql);
	return $rs;
}

/**
* $currentid	当前id号
* $tablename	数据表名
* $where		查询条件
* $count		关联文章数
* $sid			以$sid排序
* 查询当然ID的前后N条记录
**/
function getArticleMoreID($currentid=0,$tablename='',$filed,$where='',$count=0,$sid='id'){

	global $mysql,$db_prefix;
	if($currentid==0||$tablename==''||$count==0){
		echo'错误的调用参数,请检测参数调用的值.';
	}else{
		if(!empty($where)) $where.=' and ';
		else $where='where ';
		if(empty($filed)) $filed='*';

		$xg1=$mysql->select("select $filed from $tablename $where $sid<$currentid order by $sid desc limit 0,$count");
		$count1=count($xg1);
		$xg2=$mysql->select("select $filed from $tablename $where $sid>$currentid order by $sid asc limit 0,$count");
		$count2=count($xg2);
		//echo $count2.'--'.$count1;
		$half=intval($count/2);//一半
		$arr=array();

		if($count1==0) $arr=$xg2;
		elseif($count2==0) $arr=$xg1;
		elseif($count1>0){
			if($count1<=$half){//前面小于一半
				$count3=$count-$count1;
				$xg1=array_reverse($xg1);
				$xg2=$mysql->select("select $filed from $tablename $where $sid>$currentid order by $sid asc limit 0,$count3");
				$arr=array_merge($xg1,$xg2);
			}else{	//前面大于一半
				if($count2<($count-$half)){
					$count3=$count-$count2;
					$xg1=$mysql->select("select $filed from $tablename $where $sid<$currentid order by $sid desc limit 0,$count3");
					$xg1=array_reverse($xg1);
					$arr=array_merge($xg1,$xg2);
				}else{
					$count3=$count-$half;
					$xg1=$mysql->select("select $filed from $tablename $where $sid<$currentid order by $sid desc limit 0,$half");
					$xg2=$mysql->select("select $filed from $tablename $where $sid>$currentid order by $sid asc limit 0,$count3");
					$xg1=array_reverse($xg1);
					$arr=array_merge($xg1,$xg2);
				}
			}
		}
	}
	return $arr;
}
function getArticleList($filter = array(),$num = null){
  global $db,$db_prefix;
   $result = array();
   $file_path = $limit = '';
  $where = "where issue = 1";
  if(isset($filter) && $filter){
    foreach ($filter as $k => $v){
      $where .=" and ".$k." = '".$v."'";
    }
  }
  if(isset($num) && $num){
    $limit = "limit ".$num;
  }
  if(isset($filter['big_id'])){
    $big_file_path = $db->getOne("select fileurl from ".$db_prefix."newsclass where id=".$filter['big_id']);
    $big_file_path_1 = explode('.',$big_file_path);
    $file_path_b = $big_file_path_1[0].'/';
  }
  if(isset($filter['small_id'])){
    $big_file_path = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id=".$filter['small_id']);
    $big_file_path_1 = explode('.',$big_file_path);
    $file_path_s = $big_file_path_1[0].'/';
  }
  if(isset($filter['three_id'])){
    $big_file_path = $db->getOne("select fileurl from ".$db_prefix."newsthreeclass where id=".$filter['three_id']);
    $big_file_path_1 = explode('.',$big_file_path);
    $file_path_t = $big_file_path_1[0].'/';
  }

  $query = $db->query("select id,title,addtime,fileurl,big_id,small_id,three_id from ".$db_prefix."news ".$where." order by hit desc, id desc ".$limit);
  if($db->num_rows($query)){
    while ($rs = $db->fetch_object($query)){
     $rs->addtime = date('Y-m-d', $rs->addtime);
      $file_path = '';
     if(isset($filter['big_id'])){
        $file_path .= $file_path_b;
     }elseif($rs->big_id){
      $big_file_path = $db->getOne("select fileurl from ".$db_prefix."newsclass where id=".$rs->big_id);
      $big_file_path_1 = explode('.',$big_file_path);
      $file_path .= $big_file_path_1[0].'/';
     }
    if(isset($filter['small_id'])){
      $file_path .= $file_path_s;
    }elseif($rs->small_id){
      $big_file_path = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id=".$rs->small_id);
      $big_file_path_1 = explode('.',$big_file_path);
      $file_path .= $big_file_path_1[0].'/';
    }

    if(isset($filter['three_id'])){
      $file_path .= $file_path_t;
    }elseif($rs->three_id){
      $big_file_path = $db->getOne("select fileurl from ".$db_prefix."newsthreeclass where id=".$filter['three_id']);
      $big_file_path_1 = explode('.',$big_file_path);
      $file_path .= $big_file_path_1[0].'/';
    }

     $rs->url = $file_path.$rs->fileurl;
     $result[] = $rs;
    }
  }
  return $result;
}
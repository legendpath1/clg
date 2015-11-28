<?php

//提示信息
function admin_showmessage($message, $page_tag='易点提示', $url='', $staytime=5){
	$show_message = $message;
	$page_tag = empty($page_tag)? '易点提示': $page_tag;
	if($url==''){
		$target = $url=='login.php' || ($url=='index.php'||$url=='../index.php')? '_parent': 'main';
	}
	if($staytime<3){
		$staytime = 3;
	}
	echo"
	<html>
		<title>".$page_tag."</title>
		<link rel=\"stylesheet\" href=\"style.css\" type=\"text/css\">
		<body>
		 <table border=\"0\" cellspacing=\"1\" width=\"70%\" align=center style=\"margin-top:100px;\">
			<tr>
			  <td width=\"100%\"><table cellpadding=\"3\" cellspacing=\"1\" border=\"0\" width=\"100%\" class=\"tableBorder\" align=center>
			  <tr>
				  <th class=\"tableHeaderText\" colspan=2 height=25>".$page_tag."</th>
				</tr>
				<tr><td class=\"forumRow\" style=\"LINE-HEIGHT: 150%;padding-left:50px;\">".$show_message."</td></tr>
				<tr>
				  <td class=\"forumRow\" style=\"LINE-HEIGHT: 150%;padding-left:50px;\">";
					if($url==''){
						echo "<span class=\"linkcolororange\"><a href=\"#\" onclick=\"history.go(-1)\">如果您的浏览器没有自动跳转，请点击这里</a></span>";
					}else{
						echo"<span class=\"linkcolororange\"><a href=\"".$url."\" target=\"".$target."\" >如果您的浏览器没有自动跳转，请点击这里</a></span>";
					}
					echo"<script language=\"javascript\">
						var geturl = '".$url."';
						var staytime = ".$staytime."*1000;

						setTimeout(\"gotourl()\",staytime);

						function gotourl(){
							if(geturl == '' ){
								window.history.go(-1);
							}else{
								if(geturl == 'login.php' || geturl == 'index.php'){
									window.parent.location.href = geturl;
								}else{
									window.location.href = geturl;
								}
							}
						}
						</script>
				   </td>
			 	 </tr>
				</table>
				</td>
			</tr>
		</table>
		</body>
	</html>
	";
}


//程序运行时间计算
function program_run_time(){
	list($usec, $sec) = explode(" ", microtime());
   	return ((float)$usec + (float)$sec);
}


//检查管理员是否已经登录
function check_admin_login(){
	if(!isset($_SESSION['admin_name']) || !isset($_SESSION['admin_id'])){
		return false;
	}else{
		return true;
	}
}

//管理员登录超时
function admin_op_overtime(){
	global $admin_overtime;
	$admin_overtime = intval($admin_overtime);
	$admin_overtime = empty($admin_overtime)? '3000': $admin_overtime;
	if(isset($_SESSION['ap_overtime'])){
		if(time()-$_SESSION['ap_overtime'] < $admin_overtime){
			$_SESSION['ap_overtime'] = time();
		}else{
			@session_destroy();
			return false;
		}
	}else{
		$_SESSION['ap_overtime'] = time();
	}
	return true;
}

//检查管理员的权限($pid--该操作需要的权限)
function check_admin_power($powername){
	$power_arr = $_SESSION['admin_power'];
	$state = false;
	if(!isset($power_arr) || empty($power_arr)){
		$state = false;
	}else{
		if($power_arr == 'all'){
			$state = true;
		}else{
			if(!is_array($powername)){
				if(@in_array($powername, $power_arr)){
					$state = true;
				}
			}else{
				foreach($powername as $val){
					if(!in_array($val, $power_arr)){
						$state = false;
					}else{
						$state = true;
					}
				}
			}
		}
	}
	if(!$state){
		return false;
	}else{
		return true;
	}
}

function check_power($powername){
	global $db,$db_prefix;
	$ad_id = intval($_SESSION['admin_id']);
	$rs=$db->query("SELECT admin_power FROM ".$db_prefix."admin WHERE admin_id = '$ad_id'");
	if(count($rs)>0){
		$this_ad_power = @explode(',', $rs[0]['admin_power']);
	}else{
		$this_ad_power = array();
	}
	$this_ad_power=@explode(',',$_SESSION['admin_power']);
	if (!(in_array($powername, $this_ad_power)|| $this_ad_power==array('all'))){
	admin_showmessage("您无权进行此操作!",$page_tag,'admin.htm');	exit;
}

}

//管理员操作日志
function admin_op_log($action, $name='', $info=''){
  if( OPEN_LOG === false || $_SESSION['issuper']==1 ){return;}
		global $db,$db_prefix;
		switch($action){
			case 'add' : $log_info = '添加';break;
			case 'edit' : $log_info = '编辑';break;
			case 'del' : $log_info = '删除';break;
			default : 	 $log_info = '添加';
		}
		$info = empty($info) ? '' : ': '.$info;
		$row = array(
				'admin_id'		=> intval($_SESSION['admin_id']),
				'admin_user'	=> $_SESSION['admin_name'],
				'log_time'		=> time(),
				'log_ip'		=> $_SERVER['REMOTE_ADDR'],
				'log_info'		=> $log_info.$name.$info
			);
		$db->insert($db_prefix."admin_log",$row);
}

//开关图片
function editimg($int){
	if($int==1) $return='<img src="images/yes.gif" border="0">';
	else $return='<img src="images/no.gif" border="0">';
	return $return;
}

//编辑器调用
function showeditor($name, $val='',$height='300', $width='90%',  $bar='Default')
{
	$fck = new FCKeditor($name);
	$fck->BasePath ='../include/fckeditor/';
	$fck->ToolbarSet = $bar;
	$fck->Value = $val;
	$fck->Width = $width;
	$fck->Height = $height;
	echo  $fck->CreateHtml();
}


//清除缓存
function clear_cache()
{
	 $cache_list =get_dirinfo(CACHE_DIR);
     foreach ($cache_list as  $val)
	 {
        delete_file(CACHE_DIR."$val");
    }
}

//创建表单属性
function build_attr_html($bid,$sid,$tid,$gid)
{
	global $db,$db_prefix;
	$att_result = $db->query("select a.id,t.title,t.title_cn from ".$db_prefix."attribute as a ".
							 "left join ".$db_prefix."att_type as t on a.cat_id=t.id ".
							 "where big_id=$bid and small_id=$sid and three_id=$tid order by t.stor asc,a.id desc"
							);
	if($db->num_rows($att_result)){
		while($att = $db->fetch_array($att_result)){
			if($gid){
				$grs = $db->get_one("select * from ".$db_prefix."att_value where att_id=".$att['id']." and goods_id=".$gid);
			}
		$cont.='<tr>
				<td width="20%" class="right">'.$att['title'].':</td>
				<td width="19%" class="left"><input type="text" name="att_value['.$att['id'].']" value="'.$grs['att_value'].'"></td>
				<td width="17%" class="right">'.$att['title_cn'].'：</td>
				<td width="44%" class="left"><input type="text" name="att_value_cn['.$att['id'].']" value="'.$grs['att_value_cn'].'" /></td>
			</tr>';

		}
	}
	return $cont;
}

//系统导航栏内容
function get_sysnav()
{
  global $db,$db_prefix;

   $sysmain = array(
        array('-','-','-'),
        array('网站地图','sitemap.html','网站地图'),
        );

  //页面配置列表
  $query = $db->query("select title,fileurl from ".$db_prefix."pages where issue = 1 order by stor asc,id desc");
  if($db->num_rows($query)){
     $sysmain[] = array('-','-','-');
    while ($rs = $db->fetch_array($query)){
      $file_name = explode('.', $rs['fileurl']);
      $file_name_path = $file_name[0].'/';
      $sysmain[] = array($rs['title'],$file_name_path,$rs['title']);
    }
  }
  //文章分类列表
  $query = $db->query("select title,fileurl,id from ".$db_prefix."newsclass order by stor asc,id desc");
  if ($db->num_rows($query)){
    $sysmain[] = array('-','-','-');
    while ($rs = $db->fetch_array($query)){
      $file_name = explode('.', $rs['fileurl']);
      $file_name_path = $file_name[0].'/';
       $sysmain[] = array($rs['title'],$file_name_path,$rs['title']);
       //小类
       $squery = $db->query("select title,fileurl,id from ".$db_prefix."newssmallclass where big_id=".$rs['id']." order by stor asc,id desc");
      if ($db->num_rows($squery)){
        while ($srs = $db->fetch_array($squery)){
            $file_name_s = explode('.', $srs['fileurl']);
            $file_name_path_s = $file_name_path.$file_name_s[0].'/';
           $sysmain[] = array($srs['title'],$file_name_path_s,'&nbsp;&nbsp;&nbsp;&nbsp;' . $srs['title']);
        }
      }
      //第三类
     $tquery = $db->query("select title,fileurl from ".$db_prefix."newsthreeclass where big_id=".$rs['id']." and smaill_id=".$srs['id']." order by stor asc,id desc");
      if ($db->num_rows($tquery)){
        while ($trs = $db->fetch_array($tquery)){
           $file_name_t = explode('.', $trs['fileurl']);
           $file_name_path_t = $file_name_path_s.$file_name_t[0].'/';
           $sysmain[] = array($trs['title'],$file_name_path_t,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $trs['title']);
        }
      }
    }
  }
    return $sysmain;
}

/*
 * TAG标签操作
 * int $aid 文章ID号
 * string $tag 要操作的标签串
 * retrun null
 */
function addTagsList($aid, $tag = null){
  global $db,$db_prefix;
  $tags = array();
  if(isset($aid) && $aid){
    if(isset($tag) && $tag){
      $tags = explode(',', $tag);
     // dump($tags);exit;
      foreach ($tags as $key => $val){
        $count = $db->counter($db_prefix."taglist","where tag='".$val."' and aid=".$aid,'id');
        //如果该文章不存在此TAG标签
        if(!$count){
            $rst = $db->get_one("SELECT * FROM `".$db_prefix."tagindex` WHERE `tag` = '".$val."'");
            //如果TAG存在表tagindex中则总数加1
            if(count($rst)>0 && is_array($rst)){
              $tid = $rst['id'];
              $db->query("update `".$db_prefix."tagindex` set `total` = ".($rst['total']+1)." where `id` = ".$tid);
            }else {
              $tid = $db->insert($db_prefix.'tagindex', array('tag'=>$val, 'count'=>'1', 'total'=>'1', 'addtime'=>time()));
            }
            $db->query("insert into `".$db_prefix."taglist` (`tid`, `aid`, `tag`) values(".$tid.", ".$aid.", '".$val."')");
        }
      }
    }
    //如果$tag为空则删除
    else {
      $query = $db->query("select tid,id from `".$db_prefix."taglist` where `aid` = ".$aid);
      //如果该文章存在TAG标签则删除
      if($db->num_rows($query)){
        while ($row = $db->fetch_array($query)){
          //查询TAG是否在tagindex中,如果总数大于则减1,否则删除
          $rs = $db->get_One("select * from `".$db_prefix."tagindex` where `id` = ".$row['tid']);
          if(count($rs)){
            if($rs['total']>1){
              $db->update($db_prefix."tagindex", "total=".($rs['total']-1)," where id=".$row['tid']);
            }else{
              $db->query("delete from `".$db_prefix."tagindex` where `id` = ".$row['tid']);
            }
          }
          $db->query("delete from `".$db_prefix."taglist` where `id` = ".$row['id']);
        }
      }
    }
  }
}

//根据文章ID获取TAG标签列表
function getTagByArticleID($aid){
  global $db,$db_prefix;
  $tag = array();
  if(isset($aid) && $aid){
    $query = $db->query("SELECT tag FROM ".$db_prefix."taglist WHERE aid=".$aid);
    if($db->num_rows($query)){
      while ($row = $db->fetch_array($query)){
        $tag[] = $row['tag'];
      }
      return implode(',', $tag);
    }else{
      return NULL;
    }
  }else{
    return NULL;
  }
}

//文章图库操作
function updateArticleImages($aid, $files = null){
  global $db,$db_prefix;
  if(intval($aid) == 0){
    return '';
  }
  $files_info = strtr(stripcslashes($files), '\'', '"');
  $files_info = json_decode($files_info);
    if(isset($files_info) && $files_info){
        $files_id = array();
        foreach ($files_info as $f){
          $files_id[] = $f->fid;
        }
        //更新数据信息
        $query = $db->query("select fid from ".$db_prefix."article_images where aid = ". $aid);
        if($db->num_rows($query)){
          while ($rs = $db->fetch_array($query)){
            $fid = $rs['fid'];
            if(!in_array($fid, $files_id)){
              $img_name = $db->getOne("select filepath from ".$db_prefix."images where fid = " . $fid);
              @unlink(ROOT_PATH.$img_name);
              $db->query("delete from ".$db_prefix."images where fid = " . $fid);
              $db->query("delete from ".$db_prefix."article_images where aid = ". $aid ." and fid = " . $fid);
            }else{
              $db->update($db_prefix."article_images", array('weight' => $files_info->$fid->weight), "where aid = ".$aid." and fid = ".$fid);
              $db->update($db_prefix."images", array('alt' => $files_info->$fid->alt), "where fid = ".$fid);
            }
          }
        }
        // 插入新数据
        foreach ($files_info as $f){
          $count = $db->counter($db_prefix."article_images", "where aid=".$aid." and fid = ".$f->fid, "aid");
          if($count == 0){
            $db->insert($db_prefix."article_images", array('weight' => $f->weight, 'aid' => $aid , 'fid' => $f->fid));
            $db->update($db_prefix."images", array('alt' => $f->alt), "where fid = ".$f->fid);
          }
        }
      //当为空时清除所有相关数据
    }else{
      $query = $db->query("select * from ".$db_prefix."article_images where aid=".$aid);
      if($db->num_rows($query)){
        while ($rs = $db->fetch_array($query)){
          $img_name = $db->getOne("select filepath from ".$db_prefix."images where fid = " . $rs['fid']);
          @unlink(ROOT_PATH.$img_name);
          $db->query("delete from ".$db_prefix."images where fid = " . $rs['fid']);
          $db->query("delete from ".$db_prefix."article_images where aid = ". $aid ." and fid = " . $rs['fid']);
        }
      }
    }
}

function getArticleImageList($aid){
  global $db,$db_prefix;
  if(intval($aid) == 0){
    return array('ImageList' => '', 'filesInfo' => '{}');
  }else{
    $query = $db->query("select a.fid, a.weight,c.filename,c.filepath,c.alt from ".$db_prefix."article_images as a ".
      "left join ".$db_prefix."images as c ON a.fid = c.fid  where a.aid = ".$aid." order by a.weight asc ,c.fid asc ");
    if($db->num_rows($query)){
       $filesList = $files  = array();
         while ($list = $db->fetch_array($query)){
           $filesList[$list['fid']] = array('fid' => $list['fid'], 'alt' => $list['alt'], 'weight' => $list['weight'], 'filename' => $list['filename'], 'filepath' => $list['filepath']);
           $files[$list['fid']] = array('fid' => $list['fid'], 'alt' => $list['alt'], 'weight' => $list['weight']);
         }
         $files_info = json_encode($files);
         $files_info = strtr($files_info, '"', '\'');
         return array('ImageList' => $filesList, 'filesInfo' => $files_info);
    }else{
      return array('ImageList' => '', 'filesInfo' => '{}');
    }
  }
}
//后台分页
function page_list($ps_page, $total_page, $list_num, $file_name, $total_count, $page_num=10, $rewrite = false)
{
	if($rewrite){
    	$exc ='.html';
    }else {
    	$exc='';
    }
	$page_turn='页次&nbsp;'.$ps_page.'/'.$total_page.'&nbsp;&nbsp;共&nbsp;'.$total_count.'&nbsp;条记录&nbsp;&nbsp;';
	if ($total_count >0)
	{
		if($ps_page==1)
		{
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}
		else
		{
		if($ps_page==2){
			$page_pre=$ps_page-1;
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}else{
			$page_pre=$ps_page-1;
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.$page_pre.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}
	}

	$half = ceil($page_num/2);
	if ($ps_page<=$half and $total_page<=$page_num)
	{
		$page_small=1;
		$page_big=$total_page;
	}
	elseif ($ps_page<=$half and $total_page>$page_num)
	{
		$page_small=1;
		$page_big=$page_num;
	}
	elseif ($ps_page>=$half and $total_page<=$page_num)
	{
		$page_small=1;
		$page_big=$total_page;
	}
	else
	{
		if ($ps_page+$half>=$total_page)
		{
			$page_small=$total_page-$page_num+1;
			$page_big=$total_page;
		}
		else
		{
			$page_small=$ps_page-$half;
			$page_big=$ps_page+$half;
		}
	}

	for ($page_i=$page_small;$page_i<=$page_big;$page_i++)
	{
		if ($page_i!=$ps_page)
		{
			if($page_i==1){
				$page_count.="<a class=\"diany\" href='".$file_name.'1'.$exc."'>".$page_i."</a>";
			}else{
				$page_count.="<a class=\"diany\" href='".$file_name.$page_i.$exc."'>".$page_i."</a>";
			}
		}
		else
		{
			if($page_i==1){
				$page_count.="<a class=\"diany\" href='".$file_name.'1'.$exc."'><b><font color=#FF9933>".$page_i."</font></b></a>";
			}else{
				$page_count.="<a class=\"diany\" href='".$file_name.$page_i.$exc."'><b><font color=#FF9933>".$page_i."</font></b></a>";
			}
		}
	}

	$page_turn.=$page_count;
	if($ps_page==$total_page)
	{
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/next.jpg\" /></a>";
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/last.jpg\" /></a>";
	}else{
		$page_next=$ps_page+1;
		$page_turn.="<a href='".$file_name.$page_next.$exc."'><img src=\"images/next.jpg\" /></a>";
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/last.jpg\" /></a>";
	}

	}

	echo $page_turn;

}
?>
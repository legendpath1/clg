<?
include_once("include/init.php");


$search_start_time=$_REQUEST['search_start_time'];
$search_end_time=$_REQUEST['search_end_time'];
$log_ip=$_REQUEST['log_ip'];
$ad_id = intval($_REQUEST['adid']);
$act=$_REQUEST['act'];
if($act=='del_log')
{
	$log_id=implode(',',$_POST['log_id']);
	$id=explode(',',$log_id);
	while(list($key,$val)=each($id)){
		$db->query("delete  from ".$db_prefix."admin_log where log_id='$val'");
	}
	 admin_op_log('del','管理员日志');  //写入记录
}
elseif($act=='del_logs'){
	$del_log_time=$_POST['del_log_time'];
	switch ($del_log_time) {
    case 1:
       $del_time=strtotime('-7 day');
        break;
    case 2:
       $del_time=strtotime('-1 month');
        break;
	 case 3:
       $del_time=strtotime('-3 month');
        break;
	 case 4:
       $del_time=strtotime('-6 month');
        break;
	 case 5:
       $del_time=strtotime('-1 year');
        break;
	}
	$db->query("delete  from ".$db_prefix."admin_log where log_time<='$del_time'");
	admin_op_log('del','管理员日志');	//写入记录
}
?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script language="javascript" src="js/function.js"></script>
</head>
<body>
<script language="javascript" src="../js/calendar.js"></script>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="tableBorder">
  <tr>
    <td class="EAEAF3">
   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="bg1" height=25>管理员日志</th>
      </tr>
      <tr>
        <td height="5"></td>
        </tr>
    </table>
   	 <form id="form1" name="form1" method="get" action="adminLog.php" target="main">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr class="left EAEAF3">
            <td width="28" height="25"><input type="hidden" name="act" value="log"/></td>
			<td width="28" class="left EAEAF3"> <img src="images/search.gif" width="26" height="22" border="0" /></td>
			<td width="180" class="left EAEAF3">记录时间：
		    <input name="search_start_time" type="text" id="search_start_time" size="14" maxlength="12"  onClick="new Calendar().show(this);" value="<?=$search_start_time;?>" />
            </td>
			<td width="140" class="left EAEAF3">－
		    <input name="search_end_time"  type="text" id="search_end_time" size="14" maxlength="12"  onClick="new Calendar().show(this);" value="<?=$search_end_time?>"/></td>
			<td width="180" class="left EAEAF3">IP地址：
		    <input name="log_ip" type="text" id="log_ip" class="inputstyle" value="<?=$log_ip?>" size="18" maxlength="15" /></td>
			<td class="left EAEAF3"><input type="submit" name="Submit3" class="button" value="搜索" /></td>
          </tr>
        </table>
         </form>
		<form name="form2" method="post" action="adminLog.php?act=del_log" onSubmit="javascript:return chkbox(form2);">
        <table width="100%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
		  <tr class="bgc1">
		    <td width="10%" height="25">编号</td>
            <td width="12%">管理员</td>
            <td width="17%">操作时间</td>
            <td width="16%">IP地址</td>
			<td width="45%">操作记录</td>
          </tr>
		  <?
			$where = "WHERE 1=1";
			if(!empty($log_ip) && $log_ip!=0){
				$where .= " AND log_ip = '$log_ip'";
			}
			if($ad_id){
				$where .= " AND admin_id = '$ad_id'";
			}

			if(!empty($search_start_time) || !empty($search_end_time)){ //选择时间段
				if(empty($search_start_time)){
					$start_time = time();
					$end_time = $search_end_time.' 23:59:59';
					if(check_date($end_time)){
						$end_time = time_format($end_time);
						$where .= " AND log_time<='$end_time'";
					}else{
						showmessage('日期格式有误！','');
					}
				}elseif(empty($search_end_time)){
					$start_time = $search_start_time.' 00:00:00';
					if(check_date($start_time)){
						$start_time = time_format($start_time);
						$where.=" AND log_time>='$start_time'";
					}else{
						showmessage('日期格式有误！','');
					}
					$end_time = time();
				}else{
					$start_time = $search_start_time.' 00:00:00';
					$end_time = $search_end_time.' 23:59:59';

					if(check_date($start_time) && check_date($end_time)){
						$start_time = time_format($start_time);
						$end_time = time_format($end_time);
					}else{
						showmessage('日期格式有误！','');
					}
					if($start_time>$end_time){
						showmessage('您选择的日期不合法！','');
					}
					$where .= " AND log_time>='$start_time' AND log_time<='$end_time'";
				}

			}

			//echo $where;
			 $totals = $db->counter($db_prefix."admin_log",$where,'log_id');
		   	if($totals>0)
			{
				$page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
				$pagetotal=ceil($totals/$pagesize);
				$startpage=($page-1)*$pagesize;
				$result = $db->query("select * from ".$db_prefix."admin_log ".$where." order by log_id desc limit ".$startpage.",".$pagesize);
				if($db->num_rows($result))
				{
					 while($rs = $db->fetch_array($result))
					 {
		?>
          <tr>
            <td height="23" class="EAEAF3"><input type="checkbox" name="log_id[]" value="<?=$rs['log_id']?>" class="checkbox" />&nbsp;<?=$rs['log_id']?></td>
            <td class="EAEAF3"><?=$rs['admin_user']?></td>
            <td class="EAEAF3"><?=date("Y-m-d H:i:s",$rs['log_time'])?></td>
            <td class="EAEAF3"><?=$rs['log_ip'];?></td>
			 <td class="EAEAF3 left"><?=$rs['log_info']?></td>
          </tr>
        <?PHP
					}
				}
			}
		?>
		  <tr>
            <td height="1" colspan="8" bgcolor="#999999"></td>
          </tr>
      </table>
	  <?PHP if($totals>0){?>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
		 <tr><td class="EAEAF3 left" height="35">
		  <input type="checkbox" name="selectAll" onClick="javascript:checkAll(form2);" class="checkbox" /> 全选/反选 <input type="submit"  value="批量删除" name="submit" class="button">
		  </td>
          <td class="fengye"><div class="admin_pages">
			<?PHP
			page_list($page,$pagetotal,$pagesize,'adminLog.php?adid='.$ad_id.'&log_ip='.$log_ip.'&search_start_time='.$search_start_time.'&search_end_time='.$search_end_time.'&page=',$totals);
			?></div></td>
          </tr>
        </table>
		</form>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr><td class="EAEAF3 left" height="35">
			<form name="form3" method="post" action="adminLog.php?act=del_logs" >
				<select name="del_log_time" id="del_log_time">
					<option value='0'>选择清除日期...</option>
					<option value='1'>一周之前</option>
					<option value='2'>一个月之前</option>
					<option value='3'>三个月之前</option>
					<option value='4'>半年之前</option>
					<option value='5'>一年之前</option>
				</select>
				<input name="dellog" type="submit" id="dellog" class="button"  value="清除日志" />
			</form>
			</td></tr>
		</table>
		<?
		}else{
		?>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="45" align="center">暂无记录</td>
          </tr>
        </table>
        <? }?>
    </td>
  </tr>
</table>
</body>
</html>
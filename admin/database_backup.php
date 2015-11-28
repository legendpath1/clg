<?PHP
include_once("include/init.php");

include_once("include/db_sql_manager.cls.php");
$db_sql = new db_sql_manager($db,$limitsize,DATA_DIR,$db_charset);
$tables = $db_sql->list_tables();

$act=$_REQUEST['act'];
if($act=='backup'){
	$table_arr = $_POST['table_name'];
	//$limitsize=intval($_POST['limitsize']);
	//$table_arr=$tables;
	$limitsize=5120;
	if(empty($table_arr)){
		showmessage("请选择要备份的数据库表！");
	}
	//$limitsize = $_POST['limitsize'];
	if(!preg_match('/^[1-9]\d{0,4}$/',$limitsize)){
		showmessage("请输入正确的备份文件大小限制！");
	}
	$db_sql->sqllimitsize = $limitsize;
	if($db_sql->backup_data($table_arr)){
		showmessage("数据库表已成功备份！",'database_backup.php');
	}else{
		showmessage("系统错误，请联系管理员！");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="style.css" type="text/css"/>
<script language="javascript" src="js/function.js"></script>
</head>

<body>

<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="tableBorder">
  <tr>
    <td class="EAEAF3">
   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="bg1" height=25>数据库表列表</th>
      </tr>
      <tr>
        <td height="10" class="EAEAF3"></td>
        </tr>
    </table>
<form id="myform" name="myform" method="post" action="database_backup.php?act=backup" onsubmit="javascript:return chkbox(myform);">

        <table width="100%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC" id="ServiceListTable">
          <tr class="bgc1">
		    <td width="7%" height="25" align="left" valign="middle">选择</td>
			<td width="7%" height="25" align="left" valign="middle">序号</td>
			<td width="86%" height="25" align="left" valign="middle">数据库表</td>
          </tr>
          <?
		  	$i=0;
		   while(list($table_key,$table_name)=@each($tables)){
		   		$i=$i+1;
		  ?>

          <tr class="bgc2" onmouseover="rowOver(this)" onmouseout="rowOut(this)">
		    <td width="7%" height="30" align="left" valign="middle"><input type="checkbox" name="table_name[]" value="<?=$table_name?>" class="checkbox" />&nbsp;</td>
		    <td width="7%" height="30" align="left" valign="middle"><?=$i?>&nbsp;</td>
		    <td width="86%" height="30" align="left" valign="middle"  style="padding-left:40px;" class="left"><?=$table_name?>&nbsp;</td>
		 </tr>
          <? }?>

         <tr>
            <td height="1" colspan="8" bgcolor="#999999"></td>
          </tr>
      </table>

        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
		 <tr><td class="EAEAF3 left" height="35">
		<!-- <input type="text" name="limitsize" value="2048" size="10" maxlength="5" class="inputstyle" /> KB &nbsp;&nbsp;&nbsp;&nbsp;-->
   		 <input type="hidden" name="formact" value="1" checked="checked"/>
		 <input type="checkbox" name="selectAll" onclick="javascript:checkAll(myform);" class="checkbox" /> 全选/反选 <input type="submit" value="备份" name="submit" class="button" />
		  </td>
			</tr></table>
			</form>
    </td>
  </tr>
</table>

<table width="100%"  border="0" cellspacing="0" cellpadding="0"  style="display:none;">
  <tr>
    <td height="18"><a href="database_backup.php?act=backup">数据库备份</a></td>
  </tr>
</table>
</body>
</html>
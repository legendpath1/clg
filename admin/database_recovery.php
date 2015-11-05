<?PHP
include_once("include/init.php");
$data_path = '../data/';
include_once("include/db_sql_manager.cls.php");

$db_sql = new db_sql_manager($db,$limitsize,$data_path,$db_charset);
$files = $db_sql->read_file_dir();

$act=$_REQUEST['act'];
if($act=='recovery'){
	$secact = trim($_GET['secact']);
		$fn = trim($_GET['fn']);
		if($secact=='infn' && !empty($fn)){
			if($db_sql->recovery_data(array($fn))){
				showmessage("备份文件导入成功！",'database_recovery.php');
			}else{
				showmessage("数据恢复失败，请检查后重试！");
			}
		}

		if(isset($_POST['formact']) && intval($_POST['formact'])==1){
			$file_arr = $_POST['file_name'];
			if(empty($file_arr)){
				showmessage("请选择要删除的备份文件！");
			}

			if($db_sql->del_backup_file($file_arr)){
				showmessage("备份文件已成功删除！",'database_recovery.php');
			}else{
				showmessage("系统错误，请联系管理员！");
			}
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


   <table  width="98%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="tableBorder">
      <tr>
        <th class="bg1" height=25>数据库表恢复</th>
      </tr>
      <tr>
        <td height="10" class="EAEAF3"></td>
        </tr>
    </table>
<form id="myform" name="myform" method="post" action="database_recovery.php?act=recovery" onsubmit="javascript:return chkbox(myform);">
     <table width="98%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
          <tr class="bgc1">
    		  <td width="10%" height="25" align="left" valign="middle">选择</td>
    		  <td width="10%" height="25" align="left" valign="middle">序号</td>
    		  <td width="30%" height="25" align="left" valign="middle">文件名</td>
    		  <td width="20%" height="25" align="left" valign="middle">文件大小</td>
    		  <td width="20%" height="25" align="left" valign="middle">备份时间</td>
    		  <td width="10%" height="25" align="left" valign="middle">导入</td>
    		 </tr>
              <?
    		  	$i=0;
    			if(!empty($files)){
    		  	 while(list($file_key,$file_info)=each($files)){
    		   		$i=$i+1;
    		  ?>

         <tr class="EAEAF3">
      		  <td width="10%" height="25" align="left" valign="middle"><input type="checkbox" name="file_name[]" value="<?=$file_info['name']?>" class="checkbox" /></td>
      		  <td width="10%" height="30" align="left" valign="middle"><?=$i?>&nbsp;</td>
      		  <td width="30%" height="30" align="left" valign="middle"><?=$file_info['name']?>&nbsp;</td>
      		  <td width="20%" height="30" align="left" valign="middle"><?=$file_info['size']?> KB&nbsp;</td>
      		  <td width="20%" height="25" align="left" valign="middle"><?=$file_info['mtime']?>&nbsp;</td>
      		  <td width="10%" height="25" align="left" valign="middle"><a href="database_recovery.php?act=recovery&secact=infn&fn=<?=$file_info['name']?>">导入</a></td>
      		</tr>
          <? } }?>

         <tr>
            <td height="1" colspan="8" bgcolor="#999999"></td>
          </tr>
       </table>
        <table width="98%"  border="0" cellspacing="0" cellpadding="0">
    		 <tr>
    		  <td class="EAEAF3 left" height="35">
       		 <input type="hidden" name="formact" value="1"/>
    		    <input type="checkbox" name="selectAll" onclick="javascript:checkAll(myform);" class="checkbox" /> 全选/反选 <input type="submit" value="删除" name="submit" class="button" />
    		  </td>
			   </tr>
	     	</table>
	</form>
</body>
</html>
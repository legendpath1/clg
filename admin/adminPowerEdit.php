<?
include_once("include/init.php");


	$ad_id = intval($_GET['id']);

	if($ad_id == $_SESSION['admin_id']){
		showmessage("不能自己给自己分派权限！",'adminList.php');
	}
	if($ad_id == 1){
		showmessage("不能分派超级管理员的权限！",'adminList.php');
	}
	$admin_power=$db->getOne("SELECT admin_power FROM ".$db_prefix."admin WHERE admin_id = '$ad_id'");
	if(!empty($admin_power)){
		$this_ad_power = @explode(',', $admin_power);
	}else{
		$this_ad_power = array();
	}

	$act=$_REQUEST['act'];
	if($act=='edit')
	{
		$parent_power=implode(',',$_POST['parent_name']);
		$id=intval($_POST['id']);
		$db->query("update ".$db_prefix."admin set admin_power='$parent_power' where admin_id='$id'");

		admin_op_log('edit','管理员权限');	//写入记录

		showmessage("添加成功!",'adminList.php');
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

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="tableBorder">
  <tr>
    <td class="EAEAF3">
   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="bg1" height=25>编辑管理员权限</th>
      </tr>
      <tr>
        <td height="10"></td>
        </tr>
    </table>
	<form action="?act=edit" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">
	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
     <?
		$result=$db->query("select power_name_cn,power_name_en,power_id from ".$db_prefix."admin_power where parent_id=0 and isshow=1 order by stor asc,power_id desc");
		if($db->num_rows($result)){
			while($rs = $db->fetch_array($result)){
				if (in_array($rs['power_name_en'], $this_ad_power) || $this_ad_power==array('all')){
					$is_checked='checked';
				}else{
					$is_checked='';
				}
			$powerid=$rs['power_id'];
			$num = $db->counter($db_prefix."admin_power",'parent_id='.$powerid,'power_id');
	?>
          <tr class="EAEAF3">
            <td width="22%" height="25" class="left" style="padding-left:30px; color:#222222">

			<input type="checkbox" onClick="change_power_sort(this, <?=$powerid?>,<?=$num?>)" name="parent_name[]" value="<?=$rs['power_name_en']?>" <?=$is_checked ?> class="checkbox" /> <strong><?=$rs['power_name_cn']?></strong></td>
			 <td width="" height="25" class="left" style="padding-left:10px; color:#222222">

        <?PHP
				$result2=$db->query("select power_name_cn,power_name_en,power_id from ".$db_prefix."admin_power where parent_id=$powerid and isshow=1 order by stor asc,power_id desc");
				if($db->num_rows($result2)){
					$i=1;
					while($rs2 = $db->fetch_array($result2)){
						if (in_array($rs2['power_name_en'], $this_ad_power) || $this_ad_power==array('all')){
							$is_checked='checked';
						}else{
							$is_checked='';
						}
		?>

			<span style="width:120px; float:left; text-align:left;"><input type="checkbox" id="child_id_<?=$powerid.'_'.$i?>"  name="parent_name[]" value="<?=$rs2['power_name_en']?>" <?=$is_checked ?> class="checkbox" /> <strong><?=$rs2['power_name_cn']?></strong></span>
		<?PHP
					$i++;
				}
			}
			?>
			</td></tr>
	<?PHP
		  }
	  }

	  ?>

		  <tr>
            <td height="1" colspan="20" bgcolor="#999999"></td>
          </tr>

      </table>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
		  <tr><td class="EAEAF3 left" height="35">
		  <input name="id" type="hidden" value="<?=$ad_id?>" />
		  <input type="checkbox" name="selectAll"  id="powerall" value="all" onClick="javascript:checkAll(myform);" class="checkbox" /> 全选/反选 <input type="submit" value="添加权限" name="submit"  class="button">&nbsp;&nbsp;&nbsp;<input name="back" class="button" type="button" value=" 返回 " onClick="javascript:history.back();">
		  </td>
            <td class="fengye"></td>
          </tr>
        </table>
		</form>
    </td>
  </tr>
</table>
</body>
</html>
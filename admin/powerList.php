<?
include_once("include/init.php");


$act=$_REQUEST['act'];
$Result = $_REQUEST['Result'];
if(empty($Result)) $Result='add';
if($act=='edit'){
	include_once("include/check_form.php");
	$errmsg = check_form($_POST);
	if(!empty($errmsg)){
		admin_showmessage($errmsg,$page_tag);exit;
	}
	$formval = $_POST;
	if(empty($formval['ps_stor'])) $stor=1;
	else $stor=intval($formval['ps_stor']);
	$display=$_POST['display'];
	if(empty($display))	$display='none';

	$row = array(
			'power_name_cn'		=> $formval['new_ps_name_cn'],
			'power_name_en'		=> $formval['new_ps_name_en'],
			'power_filename'	=> $formval['power_filename'],
			'isshow'			=> intval($formval['ps_is_show']),
			'stor'				=> $stor,
			'parent_id'			=> $formval['main_stor'],
			'display'			=> $display
		);

	if($Result=='add'){

		$db->insert($db_prefix."admin_power",$row);
		echo showmessage("添加成功","powerList.php");
	}
	elseif($Result=='modify'){
		$db->update($db_prefix."admin_power",$row,'power_id='.$formval['ps_id']);
		echo showmessage("修改成功","powerList.php");
	}
}
elseif(empty($act)&&$Result=='modify'){
	$id=intval($_REQUEST['ps_id']);
	$rs=$db->get_One("select * from ".$db_prefix."admin_power where power_id='$id'");
	if(count($rs)>0){
		$stor=$rs['stor'];
		$power_name_cn=$rs['power_name_cn'];
		$power_name_en=$rs['power_name_en'];
		$power_file_name=$rs['power_filename'];
		$isshow=$rs['isshow'];
		$parentid=$rs['parent_id'];
		$ps_id=$rs['power_id'];
		$display=$rs['display'];
	}
}
?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<title></title>
<link href="dwz/themes/default/style.css" rel="stylesheet" type="text/css" />
<link href="dwz/themes/css/core.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="dwz/js/dwz.min.js" type="text/javascript"></script>
<script type="text/javascript">
//重载验证码
function fleshVerify(){
	$('#verifyImg').attr("src", '__APP__/Public/verify/'+new Date().getTime());
}
$(function(){
	DWZ.init("dwz/dwz.frag.xml", {
		//loginUrl:"__APP__/webAdmin/Index/login",	//跳到登录页面
		statusCode:{ok:1,error:0},
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"_order", orderDirection:"_sort"}, 
		debug:true,
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"dwz/themes"});
		}
	});
})

</script>
<link rel="stylesheet" href="style.css" type="text/css" />
<script language="javascript" src="js/function.js"></script>

</head>
<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab1">
			<li tabid="list" class="list"><a><span>权限列表 </span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：请谨慎使用此栏目功能，否则可能造成数据丢失的严重后果</div>

    <form action="?act=edit&Result=<?=$Result?>" method="post"  name="myform">
    
	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">

          <tr>
            <td width="12%" class="EAEAF3 right td1"><span class="red">* </span>上一级类别：</td>
            <td width="88%" class="EAEAF3 left td2">
			<select name="main_stor">
			<option value="0">请选择上一级分类</option>
				<?
					$result=$db->query("select * from ".$db_prefix."admin_power where parent_id=0 order by stor asc,power_id desc");
					if($db->num_rows($result)){
						while($rs = $db->fetch_array($result)){
				?>
				<option value="<?=$rs['power_id']?>" <? if($rs['power_id']==$parentid)echo'selected';?>><?=$rs['power_name_cn']?></option>
				<?
						}
					}
				?>
			</select>
			</td>
          </tr>
          
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>权限类别中文名：</td>
            <td class="EAEAF3 left td2"><input name="new_ps_name_cn" type="text"  style="width:250" value="<? echo $power_name_cn;?>"></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>权限类别英文名：</td>
            <td class="EAEAF3 left td2"><input name="new_ps_name_en" type="text"  style="width:250" value="<? echo $power_name_en;?>"></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1">相关文件名：</td>
            <td class="EAEAF3 left td2"><input name="power_filename" type="text" style="width:250" value="<? echo $power_file_name;?>"></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1">在管理菜单显示此项：</td>
            <td class="EAEAF3 left td2"><input name="ps_is_show" type="checkbox" value="1"<? if($isshow==1)echo'checked';?> style="border:none; margin:0px; padding:0px;">&nbsp;&nbsp;<font color="#FF8800">此项处于选中状态时表示其将显示于左边的功能菜单中 </font></td>
          </tr>
		   <tr>
            <td class="EAEAF3 right td1">排列顺序：</td>
            <td class="EAEAF3 left td2"><input name="ps_stor" type="text" value="<?=$stor;?>" style="width:100"  onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$stor;?>'}" onFocus="if (value == '<?=$stor;?>') {value =''}" >&nbsp;&nbsp;<font color="#FF8800">只能填写数字</font></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1">菜单收缩/展开：</td>
            <td class="EAEAF3 left td2"><input type="radio" name="display" value="none" class="checkbox" <? if($display=='none')echo"checked"?>>&nbsp;收缩&nbsp;&nbsp;<input type="radio" name="display" value="block" class="checkbox" <? if($display=='block')echo"checked"?>>&nbsp;展开&nbsp;&nbsp;&nbsp;<font color="#FF8800">用于菜单收缩、展开</font></td>
          </tr>

          <tr>
            <td class="EAEAF3 right td1"><input type="hidden" name="ps_id" value="<?=$ps_id?>">&nbsp;</td>
            <td class="EAEAF3 left td2"><input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;<a href="javascript:deldata('powerList',<? echo $ps_id;?>)" title="删除"><img align="absmiddle" src="images/admin_delete.jpg" border=0></a></td>
          </tr>
		   <tr>
        <td height="10" colspan="2"></td>
        </tr>
        </table>
		<div class="msgInfo left">本站功能列表</div>
      </form>
        <table width="100%"  border="0" cellpadding="2" cellspacing="0">
	    <?
		$result=$db->query("select * from ".$db_prefix."admin_power  where parent_id=0 order by stor asc,power_id desc");
		if($db->num_rows($result)){
			while($rs = $db->fetch_array($result)){
				$parent_id=$rs['power_id'];
		?>
          <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
            <td width="12%" class="right td1"><strong><a href="?Result=modify&ps_id=<?=$rs['power_id']?>"><?=$rs['power_name_cn'];?></a>&nbsp;</strong></td>
			 <?
				$childrs=$db->query("select * from ".$db_prefix."admin_power  where parent_id='$parent_id' order by stor asc,power_id desc");
			?>
			 <td width="88%" class="left td2">
			<?
				if($db->num_rows($childrs)){
						while($rs2 = $db->fetch_array($childrs)){
			?>
           <a href="?Result=modify&ps_id=<?=$rs2['power_id']?>"><?=$rs2['power_name_cn'];?></a>&nbsp;&nbsp;
			 <?
			 		}
				}
			 ?>			 </td>
          </tr>
        <?
		 	}
		}
		?>
      </table>
       
   
		</div>
	</div>
</div>
</body>
</html>
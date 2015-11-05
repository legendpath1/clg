<?
include_once("include/init.php");

$id = intval($_REQUEST['id']);
$act = $_REQUEST['act'];
$Result = $_REQUEST['Result'];
if(empty($Result)) $Result='add';
$rs['stor'] = 99;
if($act=='edit'){
	include("include/check_form.php");
	$errmsg = check_form($_POST);
	if(!empty($errmsg)){
		showmessage($errmsg);
	}
	$formval = $_POST;

	$row = array(
			'title'		=> $formval['title'],
	    'adv_postion' => $formval['adv_postion'],
			'stor'		=> $formval['stor'],
			'adv_width'	=> $formval['adv_width'],
			'adv_height'=> $formval['adv_height']
		);

	if($Result=='add')
	{
		$db->insert($db_prefix.'khjztype',$row);

		admin_op_log('add','banner分类',$row['title']);	//写入记录

		showmessage("添加成功",'khjzclass_List.php');
	}
	elseif($Result=='modify')
	{
		$flg = $db->update($db_prefix.'khjztype',$row,"id='$id'");
		if($flg){

			admin_op_log('edit','banner分类',$row['title']);	//写入记录
			showmessage("编辑成功！","khjzclass_List.php");
		 }else{
			 showmessage("编辑失败！","khjzclass_Edit.php?Result=modify&id=".$id);
		 }
	}
}
elseif($Result=='modify')
{
	$rs=$db->get_one("select * from ".$db_prefix."khjztype where id='$id'");
}

?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>

<table cellpadding="0" cellspacing="1" border="0" width="100%" class="tableBorder" align=center>
  <tr>
    <th class="bg1" colspan=2 height=25><? if($Result=='add')echo'添加';else echo'编辑'?>banner分类</th>
    </tr>
  <tr>
    <td colspan="2">
      <form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>" method="post" name="form" enctype="multipart/form-data" onSubmit="return chkForm();">
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
		      <tr>
            <td width="120" class="EAEAF3 right">标题：</td>
            <td class="EAEAF3 left"><input name="title" type="text" style="width:400px" value="<?=$rs['title'];?>"></td>
          </tr>
          <tr style="display:black;">
            <td width="120" class="EAEAF3 right">位置：</td>
            <td class="EAEAF3 left"><input name="adv_postion" type="text" style="width:100px" value="<?=$rs['adv_postion'];?>"></td>
          </tr>
          <tr style="display:black;">
            <td width="120" class="EAEAF3 right">宽度：</td>
            <td class="EAEAF3 left"><input name="adv_width" type="text" value="<?=$rs['adv_width'];?>">&nbsp;&nbsp;<span class="red">只能填写数字，单位：px</span>
            </td>
          </tr>
		      <tr style="display:black;">
            <td width="120" class="EAEAF3 right">高度：</td>
            <td class="EAEAF3 left"><input name="adv_height" type="text"  value="<?=$rs['adv_height'];?>">&nbsp;&nbsp;<span class="red">只能填写数字，单位：px</span>
            </td>
          </tr>
		      <tr>
            <td class="EAEAF3 right">序号：</td>
            <td class="EAEAF3 left"><input name="stor" type="text"  value="<?=$rs['stor']?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['stor'];?>'}" onFocus="if (value == '<?=$rs['stor'];?>') {value =''}" ></td>
          </tr>
           
          <tr>
            <td class="EAEAF3 right">&nbsp;</td>
            <td class="EAEAF3 left"  height="30"><input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;<input name="back" type="button" class="button"  value="返回" onClick="javascript:history.back();"></td>
          </tr>
        </table>
      </form>

	</td>
  </tr>
</table>
</body>
</html>
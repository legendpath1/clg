<?
include_once("include/init.php");


$act=$_REQUEST['act'];
$typer=intval($_REQUEST['typer']);
if($act=='edit')
{
	$id=intval($_REQUEST['id']);
	$issue=intval($_REQUEST['issue']);
	$issue = $issue ? 0 : 1;
	$db->query("update ".$db_prefix."khjz set issue=$issue where id='$id'");
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
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="tableBorder">
  <tr>
    <td class="EAEAF3">
   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th class="bg1" height=25>banner分类列表</th>
      </tr>
      <tr>
        <td height="25" style="text-align:left;"><a href="khjzclass_Edit.php?Result=add" style="padding-left:20px; padding-right:10px;">添加类型</a></td>
        </tr>
    </table>
        <table width="100%"  border="0" cellpadding="2" cellspacing="0">
          <tr class="bgc1">
            <td width="20%" height="25">分类名称</td>
            <td width="15%">位置</td>
      			<td width="10%">宽度</td>
      			<td width="10%">高度</td>
            <td width="8%">排序</td>
            <td width="8%">操 作</td>
          </tr>
          <?

		  $result=$db->query("select * from ".$db_prefix."khjztype ".$where." order by stor asc,id desc");
		  if($db->num_rows($result)){
		  	  while($rs = $db->fetch_array($result)){
		  		$id=$rs['id'];

		  ?>
          <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
            <td height="25" ><a href="khjzclass_Edit.php?Result=modify&id=<?=$rs['id'];?>"title="编辑"><?=$rs['title'];?></a></td>
            <td><?=$rs['adv_postion']?></td>
            <td><?=$rs['adv_width']?></td>
      			<td><?=$rs['adv_height']?></td>
            <td><?=$rs['stor']?></td>
            <td><a href="advClsEdit.php?Result=modify&id=<?=$rs['id'];?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;
            <a href="javascript:deldata('advtype',<?=$rs['id'];?>)"title="删除"><img src="images/icon_drop.gif" border=0></a></td>
          </tr>
          <? }?>
          <tr>
            <td height="1" colspan="9" class="bg999"></td>
          </tr>
      </table>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="fengye">&nbsp;</td>
          </tr>
        </table>
        <? }else{ ?>
        <table width="100%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
          <tr>
            <td height="45" align="center" class="DADAE9">暂无banner分类。</td>
          </tr>
      </table>
        <? }?>
    </td>
  </tr>
</table>

</body>
</html>
<?
include_once("include/init.php");

$act=$_REQUEST['act'];
if($act=='edit'){
	$id=intval($_REQUEST['id']);
	if($_SESSION['admin_id'] == $id)
	{
		alert('不能更改自己的状态');
	}else{
		$isshow=intval($_REQUEST['isshow']);
		$isshow = $isshow ? 0 : 1;
		$db->query("update ".$db_prefix."admin set isshow='$isshow' where admin_id='$id'");
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
			<li tabid="list" class="list"><a><span>管理员</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：请谨慎使用此栏目功能，否则可能造成数据丢失的严重后果</div>
		
        <table width="100%"  border="0" cellpadding="2" cellspacing="0">
		  <tr class="bgc1">
			<td width="20%" height="25" class="td1"><b>用户名</b></td>
            <td width="15%" class="td1"><b>姓名</b></td>
			<td width="15%" class="td1"><b>加入时间</b></td>
            <td width="15%" class="td1"><b>最后登录时间</b></td>
			<td width="10%" class="td1"><b>开通</b></td>
            <td width="25%" class="td2"><b>操作</b></td>
          </tr>

          <?PHP
          	if($_SESSION['issuper']==1){
				$rs = $db->get_one("select * from ".$db_prefix."admin where issuper=1");
		  ?>
           <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)" style="display:none;">
            <td class="td1"><?=$rs['admin_name'];?></td>
            <td class="td1"><?=$rs['full_name'];?></td>
			<td class="td1"><? if(empty($rs['add_time']))echo '未知';else echo date("Y-m-d H:i",$rs['add_time']);?></td>
			<td class="td1"><? if(empty($rs['last_time']))echo '未知';else echo date("Y-m-d H:i",$rs['last_time']);?></td>
			<td class="td1"><a href="?act=edit&id=<?=$rs['admin_id']?>&isshow=<?=$rs['isshow']?>"><? echo editimg($rs['isshow']);?></a></td>
            <td class="td2">
                <a href="adminEdit.php?Result=modify&id=<? echo $rs['admin_id']; ?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;
              <!--<a href="javascript:deldata('admin',<? echo $rs['admin_id'];?>)" title="删除"><img src="images/icon_drop.gif" border=0></a>-->
            </td>
          </tr>
		<?PHP
        }
		$result=$db->query("select * from ".$db_prefix."admin where issuper=0 and admin_name!='gzseo' order by admin_id asc");
		if($db->num_rows($result)){
			while( $rs = $db->fetch_array($result)){
		?>
          <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
            <td class="td1"><?=$rs['admin_name'];?></td>
            <td class="td1"><?=$rs['full_name'];?></td>
			<td class="td1"><? if(empty($rs['add_time']))echo '未知';else echo date("Y-m-d H:i",$rs['add_time']);?></td>
			<td class="td1"><? if(empty($rs['last_time']))echo '未知';else echo date("Y-m-d H:i",$rs['last_time']);?></td>
			<td class="td1"><a href="?act=edit&id=<?=$rs['admin_id']?>&isshow=<?=$rs['isshow']?>"><? echo editimg($rs['isshow']);?></a></td>
            <td class="td2"><?
				if($rs['admin_id']!=2 and $_SESSION['admin_id']!=$rs['admin_id']){
				?>
           			 <a href="adminPowerEdit.php?id=<? echo $rs['admin_id']; ?>"title="分派权限"><img src="images/icon_priv.gif" border=0></a>
           	 <? }
           	 if(OPEN_LOG){
           	 ?>
                &nbsp;&nbsp;<a href="adminLog.php?adid=<? echo $rs['admin_id']; ?>"title="查看日志"><img src="images/icon_view.gif" border=0></a>
             <?php }?>
                &nbsp;&nbsp;<a href="adminEdit.php?Result=modify&id=<? echo $rs['admin_id']; ?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>
               <?
				if($rs['admin_id']!=2 and $_SESSION['admin_id']!=$rs['admin_id']){
				?>
          			&nbsp;&nbsp;<a href="javascript:deldata('admin',<? echo $rs['admin_id'];?>)" title="删除"><img src="images/icon_drop.gif" border=0></a>
            <? }
			if($_SESSION['issuper'] or $rs['admin_id']!=2){ ?>
               &nbsp;&nbsp;<a href="resetUserPassword.php?id=<? echo $rs['admin_id']; ?>" title="重置密码"><img src="images/icon_change.gif" border="0" /></a>
                <?PHP }?>
            </td>
          </tr>
          <? }?>
		  
      </table>
        
        <? } ?>

		</div>
	</div>
</div>
</body>
</html>

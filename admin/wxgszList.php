<?
include_once("include/init.php");

$act=$_REQUEST['act'];
$big_id=intval($_REQUEST['Category_big']);
$sm_id=intval($_REQUEST['Category_small']);
$keywords=htmlspecialchars(trim($_REQUEST['keyword']), ENT_QUOTES);
$page=$_REQUEST['page'];
if($act=='edit')
{
  $res=intval($_REQUEST['res']);
  $id=intval($_REQUEST['id']);
  if($res==1){
    $isnew=intval($_REQUEST['isnew']);
     $isnew =  $isnew ? 0 : 1;
    $db->query("update ".$db_prefix."wxgsz set isnew='$isnew' where id='$id'");
  }elseif($res==2){
    $issue=intval($_REQUEST['issue']);
     $issue =  $issue ? 0 : 1;
    $db->query("update ".$db_prefix."wxgsz set issue='$issue' where id='$id'");
  }
}
elseif($act=='del')
{
	$fid=implode(',',$_POST['fid']);
	$db->query("delete from ".$db_prefix."wxgsz where id in($fid)");
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
				<li tabid="list" class="list"><a><span>五仙宫设置</span></a></li>
			  </ul>
			</div>
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）</div>
			
			<form action="?act=del&page=<?=$page?>" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">
			<table width="100%"  border="0" cellpadding="0" cellspacing="0">
				<tr class="bgc1">
	
					<td width="15%" class="td1"><b>标题</b></td>
					<td width="20%" class="td1"><b>标题图片</b></td>
					<td width="10%" class="td1"><b>仙宫图片</b></td>
					<td width="10%" class="td1"><b>排序</b></td>
					<td width="15%" class="td1"><b>发布时间</b></td>
					<td width="10%" class="td2"><b>操作</b></td>
				</tr>

				<?
					$where=" where 1=1 ";
					if($big_id > 0 ){
						$where .= " and big_id=$big_id ";
					}
					if($sm_id > 0 ){
						$where .= " and small_id=$sm_id ";
					}
					if(!empty($keywords)){ 
						$where.=" and (title like '%".$keywords."%' or content like '%".$keywords."%')";
					}
					$totals = $db->counter($db_prefix."wxgsz",$where,'id');

					if($totals>0)
					{
						$page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;

						$pagesize=12;
						$startpage=($page-1)*$pagesize;
						$pagetotal=ceil($totals/$pagesize);

						$result=$db->query("select * from ".$db_prefix."wxgsz ".$where." order by stor asc limit ".$startpage.",".$pagesize);
						if($db->num_rows($result)){
						while( $rs = $db->fetch_array($result)){

				?>
				<tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
					<td class='td1'><a href="wxgszEdit.php?Result=modify&id=<?=$rs['id'];?>&page=<?=$page?>"><?=$rs['en_title']; ?></a></td>
					<td height="23" class="paddingleft10 left td1"><img src="../<?php echo $rs['title']; ?>" height="28px" alt=""></td>
					<td class="td1"><a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(<?=$rs['id'];?>)" onMouseOut="hideImgDiv(<?=$rs['id'];?>)"><img src="<?='../images/gd'.$rs['id'].'.png';?>" height="40" /><span style="z-index:9999;" class="showimg" id="showimg_<?=$rs['id'];?>"><img src="<?='../images/gd'.$rs['id'].'.png';?>" width="300"/></span></a></td>
					<td class="td1"><?=$rs['stor'];?></td>									
					<td class="td1"><?=date('Y-m-d H:i:s',$rs['addtime']);?></td>
					<td class="td2"><a href="wxgszEdit.php?Result=modify&id=<?=$rs['id'];?>&page=<?=$page?>" title="编辑"><img src="images/icon_edit.gif" border=0></a></td>
				</tr>
				<? }?>
			</table>
		
				<?PHP
				}
				}else{
				?>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td height="45" align="center">未找到。</td>
				  </tr>
				</table>
				<? }?>
			</form>
		</div>
	</div>
</div>
</body>

</html>
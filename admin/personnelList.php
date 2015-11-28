<?
include_once("include/init.php");

$act=$_REQUEST['act'];
//$big_id=intval($_REQUEST['Category_big']);
$big_id=1;
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
		$db->query("update ".$db_prefix."personnel set isnew='$isnew' where id='$id'");
	}elseif($res==2){
		$issue=intval($_REQUEST['issue']);
		$issue =  $issue ? 0 : 1;
		$db->query("update ".$db_prefix."personnel set issue='$issue' where id='$id'");
	}
}
elseif($act=='del')
{
	$fid=implode(',',$_POST['fid']);
	$db->query("delete from ".$db_prefix."personnel where id in($fid)");
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
					<li tabid="list" class="list"><a><span>人才招聘</span></a></li>
				</ul>
			</div>       
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）→　<a href="personnelEdit.php?Result=add">添加内容</a></div>
			<form style="display:block;" name="form1" method="post" action="personnelList.php">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
					<tr>
						<td width="32" class="left EAEAF3"><img src="images/search.gif" width="26" height="22" border="0" /></td>
						<input type="hidden" name="act" value="search"/>
						<td width="" height="25" class="EAEAF3 left"> 
							关键词：
							<input name="keyword" type="text" id="keyword"  value="<?=$keywords?>" size="25" maxlength="30" />&nbsp;&nbsp;
							<input type="submit" name="Submit3" class="button" value="搜索" />
						</td>
					</tr>
				</table>
			</form>

			<form action="?act=del&page=<?=$page?>" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">

				<table width="100%"  border="0" cellpadding="0" cellspacing="0">
					<tr class="bgc1">
						<td width="5%" class="td1" height="25"><b>选择</b></td>
						<td width="30%" class="td1"><b>标题</b></td>
						<td width="10%" class="td1"><b>人才招聘类别</b></td>
						<td width="10%" class="td1"><b>是否发布</b></td>
						<!--<td width="10%" class="td1"><b>是否新品</b></td>-->
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
						$where.=" and (title like '%".$keywords."%')";
					}
					$totals = $db->counter($db_prefix."personnel",$where,'id');
					if($totals)
					{
						$page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
						$startpage=($page-1)*$pagesize;
						$pagetotal=ceil($totals/$pagesize);

						$result=$db->query("select * from ".$db_prefix."personnel ".$where." order by small_id asc,stor asc,id desc limit ".$startpage.",".$pagesize);
						if($db->num_rows($result)){
						while( $rs = $db->fetch_array($result)){

					?>
					<tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
						<td height="25" class="td1"><input type="checkbox" name="fid[]" value="<?=$rs['id'];?>" class="checkbox" /> </td>
						<td height="23" class="td1"><a href="personnelEdit.php?Result=modify&id=<?=$rs['id']; ?>&page=<?=$page?>"><?=$rs['title']?></a></td>
						<td class="td1">
							<?php if($rs['small_id']==1){
								echo '人才观点';
							}elseif($rs['small_id']==2){
								echo '培训体系';
							}elseif($rs['small_id']==3){
								echo '职业规划';
							}
							?>
						</td>
						<td class="td1"><a href="?act=edit&res=2&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td>
						<td class="td1"><?=$rs['stor'];?></td>
						<td class="td1"><?=date('Y-m-d H:i:s',$rs['addtime']);?></td>
						<td class="td2">
							<a href="personnelEdit.php?Result=modify&id=<?=$rs['id']; ?>&page=<?=$page?>" title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;&nbsp;
							<a href="javascript:deldata('personnel',<?=$rs['id'];?>,'<?=$page?>')" title="删除"><img src="images/icon_drop.gif" border=0></a>
						</td>
					</tr>
					 <? }?>
				</table>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="left2">
							<input type="checkbox" name="selectAll"  id="productall" value="all" onClick="javascript:checkAll(myform);" class="checkbox" /> 全选 <input type="submit" value=" 删除 " name="submit" class="button">
						</td>
						<td class="fengye">
							<div class="admin_pages">
							<?PHP
							page_list($page,$pagetotal,$pagesize,'personneList.php?keyword='.$keywords.'&page=',$totals);
							?>
							</div>
						</td>
					</tr>
				</table>
				<?PHP
				}
				}else{
				?>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="45" align="center">未找到内容。</td>
					</tr>
				</table>
				<? }?>
			</form>
		</div>
	</div>
</div>
</body>

</html>
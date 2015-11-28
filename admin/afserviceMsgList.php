<?
include_once("include/init.php");

$act=$_REQUEST['act'];
//$big_id=intval($_REQUEST['Category_big']);
$big_id=intval($_REQUEST['big_id']);

$page=$_REQUEST['page'];
if($act=='edit')
{
	
	$id=intval($_REQUEST['id']);

		$issue=intval($_REQUEST['issue']);
		$issue =  $issue ? 0 : 1;
		$db->query("update ".$db_prefix."afservice set issue='$issue' where id='$id'");
	
	}
elseif($act=='del')
{
	$fid=implode(',',$_POST['fid']);
	$db->query("delete from ".$db_prefix."afservice where id in($fid)");
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
					<li tabid="list" class="list"><a><span>售后服务条款</span></a></li>
				</ul>
			</div>       
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）→　<a href="afserviceMsgEdit.php?Result=add">添加条款</a></div>
			<form action="?act=del&page=<?=$page?>" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">

				<table width="100%"  border="0" cellpadding="0" cellspacing="0">
					<tr class="bgc1">
						<td width="5%" class="td1" height="25"><b>选择</b></td>
						<td width="30%" class="td1"><b>条款细则</b></td>
						<td width="10%" class="td1"><b>类别</b></td>
						<td width="10%" class="td1"><b>是否发布</b></td>
						<td width="10%" class="td1"><b>排序</b></td>
						<td width="10%" class="td2"><b>操作</b></td>
					</tr>

					<?
					$where=" where big_id=$big_id and small_id=1";
			
					
					/*if(!empty($keywords)){
						$where.=" and (title like '%".$keywords."%' or content like '%".$keywords."%')";
					}*/
					$totals = $db->counter($db_prefix."afservice",$where,'id');
					if($totals)
					{
						$page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
						$startpage=($page-1)*$pagesize;
						$pagetotal=ceil($totals/$pagesize);

						$result=$db->query("select * from ".$db_prefix."afservice ".$where." order by small_id asc,stor asc,id desc limit ".$startpage.",".$pagesize);
						if($db->num_rows($result)){
						while( $rs = $db->fetch_array($result)){

					?>
					<tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
						<td height="25" class="td1"><input type="checkbox" name="fid[]" value="<?=$rs['id'];?>" class="checkbox" /> </td>
						<td height="23" class="paddingleft10 left td1"><a href="afserviceMsgEdit.php?Result=modify&id=<?=$rs['id']; ?>&page=<?=$page?>"><?=sub_str2($rs['content'],30,true);?></a></td>
						<td class="td1">
							<?php switch($rs['big_id']){
										case 1: echo '投诉热线' ;break;
										case 2: echo '客户经理邮箱';break;
										case 3: echo '服务政策' ;break;
										default:echo 'the number is not in 1-3';break;
									} ?>
						</td>
						<td class="td1"><a href="?act=edit&res=2&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td>
						<td class="td1"><?=$rs['stor'];?></td>
						<!-- <td class="td1"><?=date('Y-m-d H:i:s',$rs['addtime']);?></td> -->
						<td class="td2">
							<a href="afserviceMsgEdit.php?Result=modify&id=<?=$rs['id']; ?>&page=<?=$page?>&big_id=<?=$big_id;?>" title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;&nbsp;
							<a href="javascript:deldata('afservice',<?=$rs['id'];?>,'<?=$page?>')" title="删除"><img src="images/icon_drop.gif" border=0></a>
						</td>
					</tr>
					 <? }?>
				</table>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td class="left2">
							<input type="checkbox" name="selectAll"  id="productall" value="all" onClick="javascript:checkAll(myform);" class="checkbox" /> 全选 <input type="submit" value=" 删除 " name="submit" class="button">
							<input name="back" type="button" class="button"  value=" 返回 " onClick="javascript:history.back();" ></td>
						</td>
						<td class="fengye">
							<div class="admin_pages">
							<?PHP
							page_list($page,$pagetotal,$pagesize,'afserviceMsgList.php?keyword='.$keywords.'&page=',$totals);
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
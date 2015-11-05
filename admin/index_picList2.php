<?
include_once("include/init.php");
$act=$_REQUEST['act'];
$page=$_REQUEST['page'];
if($act=='edit')
{
	$id=intval($_REQUEST['id']);
	$issue=intval($_REQUEST['issue']);
	$issue = $issue ? 0 : 1;
	$db->query("update ".$db_prefix."index_pic set issue=$issue where id='$id'");
}
elseif($act=='del')
{
	$fid=implode(',',$_POST['fid']);
	$db->query("delete from ".$db_prefix."index_pic where id in($fid)");
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
					<li tabid="list" class="list"><a><span>滚动图2列表</span></a></li>					
				</ul>
			</div>        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：必须有3个可发布的连接，否则页面出错→　<a href="index_picEdit2.php?Result=add">添加图片</a></div>
			<form action="?act=del" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">
				<table width="100%"  border="0" cellpadding="0" cellspacing="0" algin="center">
					<tr class="bgc1">
						<td width="5%" class="td1" height="25"><b>选择</b></td>
						<td width="20%" height="25" class="td1"><b>图片标题</b></td>
						<td width="20%" class="td1"><b>图片预览</b></td>
						<td width="15%" class="td1"><b>发布</b></td>
						<!--<td width="10%" class="td1"><b>图片位置</b></td>-->
						<td width="10%" class="td1"><b>分类</b></td>
						<td width="12%" class="td2"><b>操作</b></td>
					</tr>
					<?
					$where=" where catid=13";
					$ttal = $db->query("select * from ".$db_prefix."index_pic where catid=13");
					$totals = $db->num_rows($ttal);
					if($totals>0)
					{
					   $page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
						$startpage=($page-1)*$pagesize;
						$pagetotal=ceil($totals/$pagesize);
					  $result=$db->query("select c.adv_postion, a.* from ".$db_prefix."index_pic as a left join ".$db_prefix."index_picclass as c on c.id = a.catid ".$where." order by a.catid asc,a.stor asc,a.id asc limit ".$startpage.','.$pagesize);
					  if($db->num_rows($result)){
						  $i=1;
						  while($rs = $db->fetch_array($result)){
							$cat_name = $db->getOne('select title from '.$db_prefix.'index_picclass where id='.$rs['catid']);
							$where_id = $db->getOne('select title from '.$db_prefix.'inpicwhere where id='.$rs['where_id']);
					?>
					<tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
						<td class="td1" height="25"><input type="checkbox" name="fid[]" value="<?=$rs['id'];?>" class="checkbox" /> </td>
						<td height="23" class="paddingleft10 left td1">
							<a href="index_picEdit2.php?Result=modify&id=<?=$rs['id'];?>&page=<?=$page;?>" class="showimg_a" style="text-decoration:none;">
							<?=$rs['ad_name'];?><?php if($rs['media_type']==0){?><?php }?></a>
						</td>
						<td class="td1"><a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(<?=$rs['id'];?>)" onMouseOut="hideImgDiv(<?=$rs['id'];?>)"><img src="<?='../'.$rs['ad_code'];?>" height="40" /><span style="z-index:9999;" class="showimg" id="showimg_<?=$rs['id'];?>"><img src="<?='../'.$rs['ad_code'];?>" width="500"/></span></a></td>
						<!--<td class="td1"><?=$cat_name;?></td>-->
						<!--<td class="td1"><?=$where_id;?></td>-->
						<td class="td1"><a href="?act=edit&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td>  
						<td class="td1"><?php 
											switch($rs['stor']){
												case 1:echo'极致性能';
												break;
												case 2:echo'简单易用';break;
												case 3:echo '全能应用';break;
												default:echo'"请选择类型!"';
												break;

											}; ?>

						<!-- <td class="td1"><a href="?act=edit&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td> -->
						<td class="td2">
						<a href="index_picEdit2.php?Result=modify&id=<?=$rs['id'];?>&page=<?=$page;?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;<a href="javascript:deldata('index',<?=$rs['id'];?>,'<?=$page?>')" title="删除"><img src="images/icon_drop.gif" border=0></a>
						</td>
					</tr>
					<?PHP
						$i++;
						}
					?>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="left2">
								<input type="checkbox" name="selectAll"  id="productall" value="all" onClick="javascript:checkAll(myform);" class="checkbox" /> 全选 <input type="submit" value=" 删除 " name="submit" class="button">
							</td>
							<td class="fengye" colspan="6">
								<div class="admin_pages">
								<?PHP
								page_list($page,$pagetotal,$pagesize,'index_picList2.php?page=',$totals);
								?>
								</div>
							</td>
						</tr>
					</table>
					<?  }
					}else{ ?>
					<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
					  <tr>
						<td height="45" align="center" class="DADAE9">暂无图片。</td>
					  </tr>
					</table>
					<? }?>
			</form>
		</div>
	</div>
</div>	
</body>
</html>
<?
include_once("include/init.php");


$act=$_REQUEST['act'];
if($act=='edit')
{
	$id=intval($_REQUEST['id']);
/* 	$xw_index=intval($_REQUEST['xw_index']);
	$hd_index=intval($_REQUEST['hd_index']); */
	$issue=intval($_REQUEST['issue']);
	
/* 	$xw_index = $xw_index ? 0 : 1;
	$hd_index = $hd_index ? 0 : 1; */
	$issue = $issue ? 0 : 1;
	$db->query("update ".$db_prefix."news set issue=$issue where id='$id'");
}elseif($act=='del')
{
	$fid=implode(',',$_POST['fid']);
	$db->query("delete from ".$db_prefix."news where id in($fid)");
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
					<li tabid="list" class="list"><a><span>新闻列表</span></a></li>
				</ul>
			</div>      
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
				<form name="form1" method="post" action="newsList.php">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
						<tr>
							<td width="32" height="25"><input type="hidden" name="act" value="search"/></td>
							<td width="32" class="left EAEAF3"><img src="images/search.gif" width="26" height="22" border="0" /></td>
							<td width="" height="25" class="EAEAF3 left"> 
								<!--<select name="Category_big" size="1" onclick="submit">
								  <option value="0">---请选择类别---</option>
								  <?PHP
								   $result2 = $db->query("select id,title from ".$db_prefix."newstype order by stor asc,id desc");
								   if($db->num_rows($result2)){
								   while($brs = $db->fetch_array($result2)){
								  ?>
								<option value="<?=$brs["id"]?>" <? if ($brs["id"]==$rs['big_id']){echo "selected";}?> ><?=$brs["title"]?></option>
								 <?PHP }}?></select>
								&nbsp;&nbsp;-->关键词：
								<input name="keyword" type="text" id="keyword"  value="<?=$keywords?>" size="25" maxlength="30" />&nbsp;&nbsp;
								<input type="submit" name="Submit3" class="button" value="搜索" />
							</td>
						</tr>
					</table>
				</form>
				<form action="?act=del" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">
					<table width="100%"  border="0" cellpadding="0" cellspacing="0" algin="center">
						<tr class="bgc1">
							<td width="5%" class="td1" height="25"><b>选择</b></td>
							<td width="28%" height="25" class="td1"><b>中文标题</b></td>
							<td width="28%" height="25" class="td1"><b>英文标题</b></td>							
							<td width="12%" class="td1"><b>新闻类型</b></td>
							<td width="10%" class="td1"><b>顺序</b></td>
							<td width="10%" class="td1"><b>是否发布</b></td>
							<td width="12%" class="td2"><b>操作</b></td>
						</tr>
						<?
						$totals = $db->counter($db_prefix."news",'','id');
						if($totals>0)
						{
							$page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
							$startpage=($page-1)*$pagesize;
							$pagetotal=ceil($totals/$pagesize);
							$result=$db->query("select c.adv_postion, a.* from ".$db_prefix."news as a left join ".$db_prefix."zxdttype as c on c.id = a.catid ".$where." order by a.catid asc,a.stor asc,a.id desc limit ".$startpage.','.$pagesize);
							if($db->num_rows($result)){
							  $i=1;
							  while($rs = $db->fetch_array($result)){
								$cat_name = $db->getOne('select title from '.$db_prefix.'zxdttype where id='.$rs['catid']);
						?>
						<tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
							<td class="td1" height="25"><input type="checkbox" name="fid[]" value="<?=$rs['id'];?>" class="checkbox" /> </td>
							<td height="25" class="left td1"><a href="newsEdit.php?Result=modify&id=<?=$rs['id'];?>" class="showimg_a" style="text-decoration:none;" title="查看新闻"><?=$rs['ad_name'];?></a></td>   
							<td height="25" class="left td1"><a href="newsEdit.php?Result=modify&id=<?=$rs['id'];?>" class="showimg_a" style="text-decoration:none;" title="查看新闻"><?=$rs['en_name'];?></a></td>
							<td class="td1"><?=$cat_name;?></td>			
							<td class="td1"><?=$rs['stor'];?></td>
							<td class="td1"><a href="?act=edit&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td>
							<td class="td2">
							<a href="newsEdit.php?Result=modify&id=<?=$rs['id'];?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;<a href="javascript:deldata('dexw',<?=$rs['id'];?>,'<?=$page?>')" title="删除"><img src="images/icon_drop.gif" border=0></a>
							</td>
						</tr>
						<?PHP
							$i++;
						}
						?>        
					</table>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="left2">
							<input type="checkbox" name="selectAll"  id="productall" value="all" onClick="javascript:checkAll(myform);" class="checkbox" /> 全选 <input type="submit" value=" 删除 " name="submit" class="button"></td>
							<td class="fengye" colspan="10">
								<div class="admin_pages">
								<?PHP
								page_list($page,$pagetotal,$pagesize,'newsList.php?page=',$totals);
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
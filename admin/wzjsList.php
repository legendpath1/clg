<?
include_once("include/init.php");
$act=$_REQUEST['act'];
$page=$_REQUEST['page'];

$keywords=htmlspecialchars(trim($_REQUEST['keyword']), ENT_QUOTES);

if($act=='edit')
{
	$id=intval($_REQUEST['id']);
/* 	$xw_index=intval($_REQUEST['xw_index']);
	$hd_index=intval($_REQUEST['hd_index']); */
	$issue=intval($_REQUEST['issue']);
	
/* 	$xw_index = $xw_index ? 0 : 1;
	$hd_index = $hd_index ? 0 : 1; */
	$issue = $issue ? 0 : 1;
	$db->query("update ".$db_prefix."wzjs set issue=$issue where id='$id'");
}elseif($act=='del')
{
	$fid=implode(',',$_POST['fid']);
	$db->query("delete from ".$db_prefix."wzjs where id in($fid)");
}


$arr=array('彩乐宫背景','彩乐宫技术','彩乐宫信誉','彩乐宫保障');



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
					<li tabid="list" class="list"><a><span>网站介绍</span></a></li>
				</ul>
			</div>      
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器<!--  →　<a href="wzjsEdit.php?Result=add">添加内容</a> --></div>
				<!-- <form name="form1" method="post" action="wzjsList.php">
					<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
						<tr>
							<td width="32" height="25"><input type="hidden" name="act" value="search"/></td>
							<td width="32" class="left EAEAF3"><img src="images/search.gif" width="26" height="22" border="0" /></td>
							<td width="" height="25" class="EAEAF3 left"> 
								关键词：
								<input name="keyword" type="text" id="keyword"  value="<?=$keywords?>" size="25" maxlength="30" />&nbsp;&nbsp;
								<input type="submit" name="Submit3" class="button" value="搜索" />
							</td>
						</tr>
					</table>
				</form> -->
				<form action="?act=del&page=<?=$page?>" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">
					<table width="100%"  border="0" cellpadding="0" cellspacing="0" algin="center">
						<tr class="bgc1">
					
							<td width="25%" height="25" class="td1"><b>标题</b></td>
							<td width="15%" height="25" class="td1"><b>图片预览</b></td>														
							<td width="10%" class="td1"><b>顺序</b></td>
							<td width="15%" height="25" class="td1"><b>发布时间</b></td>
							<td width="12%" class="td2"><b>操作</b></td>
						</tr>
						<?

						$where=" where 1=1 ";
						if(!empty($keywords)){
						$where.=" and (ad_name like '%".$keywords."%')";
						}


						$totals = $db->counter($db_prefix."wzjs",$where,'id');
						if($totals>0)
						{
							$page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
							$startpage=($page-1)*$pagesize;
							$pagetotal=ceil($totals/$pagesize);
							$result=$db->get_all("select * from ".$db_prefix."wzjs".$where." order by stor asc,id desc limit ".$startpage.','.$pagesize);
						}
						foreach($result as $key=>$rs){
						?>
						<tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
							<td height="25" class="left td1"   style="text-align:center;!important" ><a href="wzjsEdit.php?Result=modify&id=<?=$rs['id'];?>&page=<?=$page?>" class="showimg_a" style="text-decoration:none;" title="查看"><?=$arr[$key];?></a></td>   
							<td class="td1">
								<a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(<?=$rs['id'];?>)" onMouseOut="hideImgDiv(<?=$rs['id'];?>)"><img src="<?='../'.$rs['index_pic'];?>" height="40" /><span style="z-index:9999;" class="showimg" id="showimg_<?=$rs['id'];?>"><img src="<?='../'.$rs['index_pic'];?>" width="350"/></span></a>
							</td>							
							<td class="td1"><?=$rs['stor'];?></td>
							
							<td class="td1"><?=date('Y-m-d H:i:s',$rs['addtime']);?></td>
							<td class="td2">
							<a href="wzjsEdit.php?Result=modify&id=<?=$rs['id'];?>&page=<?=$page?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;<!-- <a href="javascript:deldata('syjc',<?=$rs['id'];?>,'<?=$page?>')" title="删除"><img src="images/icon_drop.gif" border=0> --></a>
							</td>
						</tr>
					    <?php } ?>
					</table>
					
				</form>
		</div>
	</div>
</div>	
</body>
</html>
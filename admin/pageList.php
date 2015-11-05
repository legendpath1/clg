<?
include_once("include/init.php");

$keywords=htmlspecialchars(trim($_REQUEST['keyword']), ENT_QUOTES);
$BigID = $_REQUEST['Category'];
$act=$_REQUEST['act'];
$lid=$_REQUEST['lid'];
if($act=='edit')
{
	$id=intval($_REQUEST['id']);

	$issue=intval($_REQUEST['issue']);
	$issue = $issue ? 0 : 1;
	$db->query("update ".$db_prefix."pton set issue=$issue where id='$id'");
	
	$isindex=intval($_REQUEST['isindex']);
	$isindex = $isindex ? 0 : 1;
	$db->query("update ".$db_prefix."pton set isindex=$isindex where id='$id'");
	
}
elseif($act=='del')
{
	$fid=implode(',',$_POST['fid']);
	$db->query("delete from ".$db_prefix."pton where id in($fid)");
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
					<?php if($lid==1){?>
					<li tabid="list" class="list"><a><span>商业中心列表</span></a></li>
					<?php }elseif($lid==2){ ?>
					<li tabid="list" class="list"><a><span>交通枢纽列表</span></a></li>
					<?php }elseif($lid==3){ ?>
					<li tabid="list" class="list"><a><span>市政公共列表</span></a></li>
					<?php }elseif($lid==4){ ?>
					<li tabid="list" class="list"><a><span>连锁经营列表</span></a></li>
					<?php }?>					
				</ul>
			</div>
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）</div>
		
			<form name="form1" method="post" action="pageList.php?lid=<?=$lid?>">
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
					<tr>
						<td width="32" class="left EAEAF3"> <img src="images/search.gif" width="26" height="22" border="0" /></td>
						<input type="hidden" name="act" value="search"/>
						<td width="" height="25" class="EAEAF3 left"> 
							<!--<select name="Category_big" size="1" onChange="changeselect1(this.value)">
							  <option value="0">---请选择类别---</option>
							  <?PHP
							   $result2 = $db->query("select id,title from ".$db_prefix."mtype order by stor asc,id desc");
							   if($db->num_rows($result2)){
							   while($brs = $db->fetch_array($result2)){
							  ?>
							<option value="<?=$brs["id"]?>" <? if ($brs["id"]==$rs['big_id']){echo "selected";}?> ><?=$brs["title"]?></option>
							 <?PHP }}?></select>&nbsp;&nbsp;-->
							关键词：
							<input name="keyword" type="text" id="keyword"  value="<?=$keywords?>" size="25" maxlength="30" />&nbsp;&nbsp;
							<input type="submit" name="Submit3" class="button" value="搜索" />
						</td>
					</tr>
				</table>
			</form>	
			<form action="?act=del&lid=<?=$lid?>" method="post"  name="myform" onSubmit="javascript:return chkbox(myform);">
				<table width="100%"  border="0" cellpadding="0" cellspacing="0">
					<tr class="bgc1">
						<td width="5%" class="td1" height="25"><b>选择</b></td>
						<td width="15%" class="td1"><b>标题</b></td>
						<td width="15%" class="td1"><b>图片预览</b></td>
						<td width="10%" class="td1"><b>产品类型</b></td>				
						<!--<td width="5%" class="td1"><b>发布</b></td>-->	
						<td width="5%" class="td1"><b>序号</b></td>
						<td width="10%" class="td2"><b>操 作</b></td>
					</tr>
					<?
					$where=" where 1=1 and lid='".$lid."'";
					if(!empty($keywords)){
						$where.=" and (ad_name like '%".$keywords."%')";
					}
					$totals = $db->counter($db_prefix."pton",$where,'id');
					if($totals>0)
					{
					   
						$page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
						$startpage=($page-1)*$pagesize;
						$pagetotal=ceil($totals/$pagesize);
						$result=$db->query("select * from ".$db_prefix."pton ".$where." order by stor asc,id desc limit ".$startpage.','.$pagesize);
						if($db->num_rows($result)){
						  while($rs = $db->fetch_array($result)){
						  //$cat_name = $db->getOne('select title from '.$db_prefix.'mtype where id='.$rs['catid']);
					?>
				  <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
					<td class="td1" height="25"><input type="checkbox" name="fid[]" value="<?=$rs['id'];?>" class="checkbox" /> </td>
					<td height="23" class="td1" style="padding-left:12px;text-align:left;"><a href="pageEdit.php?Result=modify&id=<?=$rs['id'];?>&lid=<?=$lid?>" class="showimg_a" style="text-decoration:none;" title="编辑产品" onMouseOver="showImgDiv(<?=$i?>)" onMouseOut="hideImgDiv(<?=$i?>)">
						<?=$rs['ad_name'];?><?php if($rs['media_type']==0){?><?php }?></a></td>					
					<td class="td1"><a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(<?=$rs['id'];?>)" onMouseOut="hideImgDiv(<?=$rs['id'];?>)"><img src="<?='../'.$rs['ad_code'];?>" height="40" /><span style="z-index:9999;" class="showimg" id="showimg_<?=$rs['id'];?>"><img src="<?='../'.$rs['ad_code'];?>" width="250"/></span></a></td>
					<!--<td class="td1"><?=$cat_name;?></td>-->
					<td class="td1"><a href="?act=edit&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td>  
					<td class="td1"><?=$rs['stor'];?></td>     		    			
					<td class="td2">
					<a href="pageEdit.php?Result=modify&id=<?=$rs['id'];?>&lid=<?=$lid?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;
					<a href="javascript:deldata('sjzj2',<?=$rs['id'];?>,<?=$page?>,<?=$lid?>)"title="删除"><img src="images/icon_drop.gif" border=0></a></td>
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
					<td class="fengye">
					<div class="admin_pages">
					<?PHP
					page_list($page,$pagetotal,$pagesize,'pageList.php?keyword='.$keywords.'&lid='.$lid.'&page=',$totals);
			  ?>
			 </div></td>
				  </tr> 
			  </table>
				<?  }
				}else{ ?>
				<table width="100%"  border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td height="45" align="center" class="DADAE9">暂无案例。</td>
				  </tr>
				</table>
				<? }?>
			</form>
		</div>
	</div>
</div>
</body>
</html>
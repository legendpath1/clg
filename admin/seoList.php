<?
include_once("include/init.php");
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
				<li tabid="list" class="list"><a><span>优化栏目</span></a></li>
			  </ul>
			</div>       
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">优化栏目列表</div>
		
			<form action=""  class="pageForm required-validate" >
				<div class="pageContent">   
					<table class="table" width="100%" layoutH="116">
						<thead>
							<tr>
								<th width="10%" >栏目名称</th>
								<th width="20%">网页标题</th>
								<th width="28%">关 键 词</th>
								<th width="30%">页面描述</th>     
								<th width="12%">操 作</th>
							</tr>
						</thead>
						<tbody>
						<?
						
							$rs=$db->query("select * from ".$db_prefix."seo where id!=100 order by id asc");
							if($db->num_rows($rs)){
								while($srs = $db->fetch_array($rs)){
						?>
						<tr target="dataid">
							<td height="25">
								<a href="seoEdit.php?Result=modify&id=<?=$srs['id']; ?>" title="编辑"><?=$srs['webname'];?></a>
							</td>   
							<td><?=$srs['seotitle'];?></td>		         
							<td><?=$srs['seokey'];?></td>
							<td><?=$srs['seodesc'];?></td>
							<td>
								<a href="seoEdit.php?Result=modify&id=<?=$srs['id']; ?>" title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;&nbsp;<!--<a href="javascript:deldata('seo',<?=$srs['id']; ?>)" title="删除"><img src="images/icon_drop.gif" border=0></a>-->
							</td>
						</tr>
						<? }?>
						</tbody>
						<?}else{?>
						<tbody >
							<tr>
								<td height="45" align="center">没找到相关信息</td>
							</tr>
						</tbody>
						<? }?>
					</table>

				</div>
			</form>		
		</div>
	</div>	
</div>
</body>
</html>
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
			<li tabid="list" class="list"><a><span>作品分类</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：如果要删除分类请一定记得先删除该分类下的内容</div>

   <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
      <tr>
        <td height="25" style="text-align:left;"><a href="worksClass.php?Result=add" style="padding-left:20px; padding-right:10px;">添加分类</a><!--<a href="proSmallClass.php?Result=add" style="padding-left:10px; padding-right:10px;">添加第二大类</a>--></td>
        </tr>
    </table>
        <table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr class="bgc1">
            <td width="55%" height="25" class="td1"><b>分类名称</b></td>
			<!--<td width="20%" class="td1" style="display:none;"><b>英文名称</b></td>-->
			<td width="10%" class="td1"><b>顺序</b></td>
            <td width="15%" class="td2" ><b>操作</b></td>
          </tr>
             <?
		$result = $db->query("select * from ".$db_prefix."worksclass order by stor asc,id desc");
		if($db->num_rows($result)){
		 	while($rs = $db->fetch_array($result)){
		?>
          <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
            <td class="left td1"><a href="productBigClass.php?Result=modify&id=<?=$rs['id'];?>" title="编辑"><?=$rs['title'];?></a></td>
			<!--<td class="td1" style="display:none;"><?=$rs['title_en'];?></td>-->
			<td class="td1"><?=$rs['stor'];?></td>
             <td class="td2"><a href="worksClass.php?Result=modify&id=<?=$rs['id'];?>" title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;&nbsp;<a href="javascript:deldata('worksClass',<? echo $rs['id'];?>)"title="删除"><img src="images/icon_drop.gif" border=0></a></td>
          </tr>
		  <?	} ?>
         
      </table>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td  class="fengye"></td>
          </tr>
        </table>
        <? }else{?>
        <table width="100%"  border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td height="45" align="center" bgcolor="#DADAE9">没有分类。</td>
          </tr>
      </table>
        <? }?>
   
		</div>
	</div>

</div>
</body>
</html>



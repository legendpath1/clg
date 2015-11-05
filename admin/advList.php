<?
include_once("include/init.php");


$act=$_REQUEST['act'];
if($act=='edit')
{
	$id=intval($_REQUEST['id']);
	$issue=intval($_REQUEST['issue']);
	$issue = $issue ? 0 : 1;
	$db->query("update ".$db_prefix."adv set issue=$issue where id='$id'");
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
			<li tabid="list" class="list"><a><span>Logo图片</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">图片列表</div>
        <table width="100%"  border="0" cellpadding="0" cellspacing="0" algin="center">
          <tr class="bgc1">
            <td width="28%" height="25" class="td1"><b>图片标题</b></td>
			<td width="10%" class="td1"><b>预览图</b></td>
      			<td width="12%" class="td1"><b>图片类型</b></td>
      			<td width="10%" class="td1"><b>排列顺序</b></td>
      			<td width="10%" class="td1"><b>发布</b></td>
            <td width="12%" class="td2"><b>操作</b></td>
          </tr>
          <?
		   $totals = $db->counter($db_prefix."adv",'','id');
		   if($totals>0)
		   {
			   $page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
				$startpage=($page-1)*$pagesize;
				$pagetotal=ceil($totals/$pagesize);
			  $result=$db->query("select c.adv_postion, a.* from ".$db_prefix."adv as a left join ".$db_prefix."advtype as c on c.id = a.catid ".$where." order by a.catid asc,a.stor asc,a.id desc limit ".$startpage.','.$pagesize);
			  if($db->num_rows($result)){
				  $i=1;
				  while($rs = $db->fetch_array($result)){
					$cat_name = $db->getOne('select title from '.$db_prefix.'advtype where id='.$rs['catid']);
		  ?>
          <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
            <td height="25" class="EAEAF3 left td1"><a href="advEdit.php?Result=modify&id=<?=$rs['id'];?>" class="showimg_a" style="text-decoration:none;" title="查看图片" onMouseOver="showImgDiv(<?=$i?>)" onMouseOut="hideImgDiv(<?=$i?>)">
      			<?=$rs['ad_name'];?><?php if($rs['media_type']==0){?><span class="showimg" id="showimg_<?=$i?>"><img src="<?='../'.$rs['ad_code'];?>" width="888" height="383" /></span><?php }?></a></td>
      			<td class="td1"><? if(!empty($rs['ad_code'])){?><img src="<?='../'.$rs['ad_code'];?>" height="20" /><? }else{echo'&nbsp;';}?></td>
      			<td class="td1"><?=$cat_name;?></td>
      			<td class="td1"><?=$rs['stor'];?></td>
      			<td class="td1"><a href="?act=edit&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td>
            <td class="td2">
            <a href="advEdit.php?Result=modify&id=<?=$rs['id'];?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;
            </td>
          </tr>
          <?PHP
          	$i++;
		  	}
		  ?>
          <tr>
            <td class="fengye" colspan="6"><div class="admin_pages">
			<?PHP
			page_list($page,$pagetotal,$pagesize,'advList.php?page=',$totals);
			?></div></td>
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
		</div>
	</div>
</div>	
</body>
</html>
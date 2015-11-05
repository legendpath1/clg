<?
include_once("include/init.php");


$act=$_REQUEST['act'];
if($act=='edit')
{
	$id=intval($_REQUEST['id']);
	$issue=intval($_REQUEST['issue']);
	$issue = $issue ? 0 : 1;
	$db->query("update ".$db_prefix."khjz set issue=$issue where id='$id'");
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
			<li tabid="list" class="list"><a><span>图片列表</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">图片列表</div>
		<form name="form1" method="post" action="khjz_List.php">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
          <tr>
       <td width="32" height="25"><input type="hidden" name="act" value="search"/></td>
      <td width="32" class="left EAEAF3"><img src="images/search.gif" width="26" height="22" border="0" /></td>
            <td width="" height="25" class="EAEAF3 left"> 
            <select name="Category_big" size="1" onclick="submit">
              <option value="0">---请选择类别---</option>
              <?PHP
               $result2 = $db->query("select id,title from ".$db_prefix."khjztype order by stor asc,id desc");
               if($db->num_rows($result2)){
               while($brs = $db->fetch_array($result2)){
      		  ?>
            <option value="<?=$brs["id"]?>" <? if ($brs["id"]==$rs['big_id']){echo "selected";}?> ><?=$brs["title"]?></option>
             <?PHP }}?></select>
             <!--<select name="Category_small" size="1" style=" margin-left:10px;">
              <option>---请选择类别---</option>
             </select>-->
			&nbsp;&nbsp;关键词：
        <input name="keyword" type="text" id="keyword"  value="<?=$keywords?>" size="25" maxlength="30" />&nbsp;&nbsp;
      <input type="submit" name="Submit3" class="button" value="搜索" />
	  <input style="margin-left:15px" type="button" name="button" class="button" value="添加内容" onClick="window.location.href='khjz_Edit.php?Result=add'" />
		
	  </td>
          </tr>
        </table>
    </form>
        <table width="100%"  border="0" cellpadding="0" cellspacing="0" algin="center">
          <tr class="bgc1">
            <td width="48%" height="25" class="td1"><b>图片标题</b></td>
			<td width="10%" class="td1"><b>预览图</b></td>
      			<td width="12%" class="td1"><b>图片类型</b></td>
      			<td width="10%" class="td1"><b>排列顺序</b></td>
      			<td width="10%" class="td1"><b>发布</b></td>
            <td width="12%" class="td2"><b>操作</b></td>
          </tr>
          <?
		   $totals = $db->counter($db_prefix."khjz",'','id');
		   if($totals>0)
		   {
			   $page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
				$startpage=($page-1)*$pagesize;
				$pagetotal=ceil($totals/$pagesize);
			  $result=$db->query("select c.adv_postion, a.* from ".$db_prefix."khjz as a left join ".$db_prefix."khjztype as c on c.id = a.catid ".$where." order by a.catid asc,a.stor asc,a.id desc limit ".$startpage.','.$pagesize);
			  if($db->num_rows($result)){
				  $i=1;
				  while($rs = $db->fetch_array($result)){
					$cat_name = $db->getOne('select title from '.$db_prefix.'khjztype where id='.$rs['catid']);
		  ?>
          <tr class="bgc2" onMouseOver="rowOver(this)" onMouseOut="rowOut(this)">
            <td height="25" class="EAEAF3 left td1"><a href="khjz_Edit.php?Result=modify&id=<?=$rs['id'];?>" class="showimg_a" style="text-decoration:none;" title="查看图片" onMouseOver="showImgDiv(<?=$i?>)" onMouseOut="hideImgDiv(<?=$i?>)">
      			<?=$rs['ad_name'];?><?php if($rs['media_type']==0){?><span class="showimg" id="showimg_<?=$i?>"><img src="<?='../'.$rs['ad_code'];?>" width="888" height="383" /></span><?php }?></a></td>
      			<td class="td1"><? if(!empty($rs['ad_code'])){?><img src="<?='../'.$rs['ad_code'];?>" height="20" /><? }else{echo'&nbsp;';}?></td>
      			<td class="td1"><?=$cat_name;?></td>
      			<td class="td1"><?=$rs['stor'];?></td>
      			<td class="td1"><a href="?act=edit&id=<?=$rs['id']?>&issue=<?=$rs['issue']?>"><? echo editimg($rs['issue']);?></a></td>
            <td class="td2">
            <a href="khjz_Edit.php?Result=modify&id=<?=$rs['id'];?>"title="编辑"><img src="images/icon_edit.gif" border=0></a>&nbsp;&nbsp;
			<a href="javascript:deldata('khjz',<?=$rs['id'];?>)"title="删除"><img src="images/icon_drop.gif" border=0></a></td>
            </td>
          </tr>
          <?PHP
          	$i++;
		  	}
		  ?>
          <tr>
            <td class="fengye" colspan="6"><div class="admin_pages">
			<?PHP
			page_list($page,$pagetotal,$pagesize,'khjz_List.php?page=',$totals);
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
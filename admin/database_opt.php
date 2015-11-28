<?PHP
include_once("include/init.php");
include_once("include/db_sql_manager.cls.php");
$db_sql = new db_sql_manager($db,$limitsize,DATA_DIR,$db_charset);
$tables = $db_sql->list_tables();

$act=$_REQUEST['act'];
if($act=='optimization'){
	$table_arr = $_POST['table_name'];
	if(empty($table_arr)){
		showmessage("请选择要优化的数据库表！");
	}

	if($db_sql->data_tbl_opt($table_arr)){
		showmessage("数据库表已优化完成！",'database_opt.php');
	}else{
		showmessage("系统错误，请联系管理员！");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<link rel="stylesheet" href="style.css" type="text/css"/>
<script language="javascript" src="js/function.js"></script>
</head>

<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab1">
			<li tabid="list" class="list"><a><span>数据表优化</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">温馨提示：请至少每年进行一次数据表优化操作</div>
   
<form id="myform" name="myform" method="post" action="database_opt.php?act=optimization" onsubmit="javascript:return chkbox(myform);">

        <table width="100%"  border="0" cellpadding="0" cellspacing="0">
          <tr class="bgc1">
		    <td width="5%" class="td1" height="25"><b>选择</b></td>
			<td width="7%" class="td1"><b>序号</b></td>
			<td width="88%" class="td2"><b>数据库表</b></td>
          </tr>
          <?
		  	$i=0;
		   while(list($table_key,$table_name)=@each($tables)){
		   		$i=$i+1;
		  ?>

          <tr class="bgc2" onmouseover="rowOver(this)" onmouseout="rowOut(this)">
		    <td class="EAEAF3 td1"><input type="checkbox" name="table_name[]" value="<?=$table_name?>" class="checkbox" />&nbsp;</td>
		    <td class="EAEAF3 td1"><?=$i?>&nbsp;</td>
		    <td class="EAEAF3 left td2"><?=$table_name?>&nbsp;</td>
		 </tr>
          <? }?>

      </table>

        <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="tablebo">
		 <tr><td class="EAEAF3 left" height="35">
   		 <input type="hidden" name="formact" value="1"/>
		 <input type="checkbox" name="selectAll" onclick="javascript:checkAll(myform);" class="checkbox" /> 全选/反选 <input type="submit" value="优化" name="submit" class="button" />
		  </td>

          </tr>
        </table>
	</form>
   
		</div>
	</div>
</div>

</body>
</html>
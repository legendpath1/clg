<? 
include_once("include/init.php");
check_admin_login();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<title>menu</title>

</head>

<body>
<div id="layout">
<div id="leftside">
    <div id="sidebar">
      <div class="toggleCollapse">
        <h2>主菜单</h2>
      </div>
      <div class="accordion" fillSpace="sidebar">
<?
	$ad_id = intval($_SESSION['admin_id']);
	
$admin_power=$db->getOne("SELECT admin_power FROM ".$db_prefix."admin WHERE admin_id = '$ad_id'");
	if(!empty($admin_power)){
		$this_ad_power = @explode(',', $admin_power);
	}else{
		$this_ad_power = array();
	}
	$result=$db->query("SELECT * FROM ".$db_prefix."admin_power WHERE isshow='1' and parent_id=0 order by stor asc,power_id desc");
	if($db->num_rows($result)){
		$m=1;
		while($rs = $db->fetch_array($result)){
		//for($i=0;$i<$count;$i++){
			$powerid=$rs['power_id'];
			$m++;
			if (in_array($rs['power_name_en'], $this_ad_power)|| $this_ad_power==array('all')){
?>
        <div class="accordionHeader">
          <h2><span>Folder</span><? echo $rs['power_name_cn'];?></h2>
        </div>
        <div class="accordionContent">
          <ul class="tree treeFolder">
			<?
		  	$result2=$db->query("SELECT * FROM ".$db_prefix."admin_power WHERE isshow='1' and parent_id='$powerid' order by stor asc,power_id desc");
				if($db->num_rows($result2)){
					while($rs2 = $db->fetch_array($result2)){

		  ?>
            <li><a href="<?=$rs2['power_filename'];?>" target="main"><?=$rs2['power_name_cn']?></a></li>
            <?
					}
				}
		  ?>	
          </ul>
        </div>
<?
			}
		}
	}
?>		
        
      </div>
    </div>
  </div>
  <div id="container" style="display:none">
    <div id="navTab" class="tabsPage">
      <div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab">
            
          </ul>
        </div>
        <div class="tabsLeft">left</div>
        
        <!--<div class="tabsRight">right</div>
        <div class="tabsMore">more</div>-->
      </div>
      
      
    </div>
  </div>

</div>
</body>
</html>


<?
include_once("./include/init.php");

$act=$_REQUEST['act'];
$config = $_CFG;
if($act=='edit'){
	if(isset($_POST['formact']) and intval($_POST['formact'])==1){
		//include_once("include/check_form.php");
		//$errmsg = check_config_form($_POST);
		//if(!empty($errmsg)){
		//	showmessage($errmsg,"systemConfig.php");
		//}
		$formval = $_POST;
		foreach($formval as $key=>$val){
			if(strtolower($key)=='formact'|| strtolower($key)=='submit' || strtolower($key)=='hidden'){
				continue;
			}
			if(@array_key_exists($key, $config)){
				$db->query("UPDATE ".$db_prefix."config SET option_value='".$val."' WHERE option_name = '".$key."'");
			}else{
				$addsql .= empty($addsql)? "('".$key."','".$val."')" : ",('".$key."','".$val."')";
			}
		}

		if(!empty($addsql)){
			$db->query("INSERT INTO ".$db_prefix."config(option_name,option_value) VALUES $addsql");
		}
	}
	clear_cache();
	goToUrl("systemConfig.php");
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
<link rel="stylesheet" href="../js/swfupload/swfupload-jquery/css/swfupload.css" type="text/css">
<script type="text/javascript" charset="utf-8" src="../include/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script language="javascript">
var TextUtil=new Object();
TextUtil.isNotMax=function(otextarea){
return otextarea.value.length<otextarea.getAttribute("maxlength");     //1
}
</script>
</head>
<body>
<div id="container">
	<div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
			<div class="tabsPageHeaderContent">
				<ul class="navTab-tab1">
					<li tabid="list" class="list"><a><span>网站信息配置</span></a></li>
				</ul>
			</div>
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
				<form action="?act=edit" method="post" enctype="multipart/form-data" name="form1">
					<table cellpadding="0" cellspacing="1" border="0" width="100%" class="tableBorder" align=center>
						<tr>
							<td colspan="2">
								<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
								  
								  <tr>
									<td width="120" class="EAEAF3 right td1">公司名称：</td>
									<td class="EAEAF3 left td2"><input name="site_name" type="text" style="width:50%;" value="<? echo $config['site_name'];?>"></td>
								  </tr>
								  <tr>
									<td class="EAEAF3 right td1">客服服务电话：</td>
									<td class="EAEAF3 left td2"><input name="service_phone" type="text" style="width:50%" value="<? echo $config['service_phone'];?>">
									</td>
								  </tr>
								  <tr>
									<td class="EAEAF3 right td1">售后服务电话：</td>
									<td class="EAEAF3 left td2"><input name="top_phone" type="text" style="width:50%" value="<? echo $config['top_phone'];?>">
									</td>
								  </tr>						  
								  <tr>
									<td class="EAEAF3 right td1">企业邮箱：</td>
									<td class="EAEAF3 left td2"><input name="site_url" type="text" style="width:50%" value="<? echo $config['site_url'];?>"></td>
								  </tr>
								  <tr>
									<td class="EAEAF3 right td1">客服经理邮箱：</td>
									<td class="EAEAF3 left td2"><input name="site_foot3" type="text" style="width:50%" value="<? echo $config['site_foot3'];?>">
									</td>
								  </tr>
								  <tr>
									<td class="EAEAF3 right td1">版权所有：</td>
									<td class="EAEAF3 left td2"><input name="copyright" type="text" style="width:50%" value="<? echo $config['copyright'];?>">
									</td>
								  </tr>
								  <tr>
									<td class="EAEAF3 right td1">ICP&nbsp;备案：</td>
									<td class="EAEAF3 left td2"><input name="site_icp" type="text" style="width:50%" value="<? echo $config['site_icp'];?>">
									</td>
								  </tr>
								  
								  
								  
								  <!--<tr>
									<td class="EAEAF3 right td1">公司中文地址：</td>
									<td class="EAEAF3 left td2"><input name="service_address" type="text" style="width:50%" value="<? echo $config['service_address'];?>">
									</td>
								  </tr>
								  <tr>
									<td class="EAEAF3 right td1">公司英文地址：</td>
									<td class="EAEAF3 left td2"><input name="site_foot2" type="text" style="width:50%" value="<? echo $config['site_foot2'];?>">
									</td>
								  </tr>							  
								  <tr>
									<td class="EAEAF3 right td1">传  真：</td>
									<td class="EAEAF3 left td2"><input name="service_cz" type="text" style="width:50%" value="<? echo $config['service_cz'];?>">
									</td>
								  </tr>
								  
								  <!--
								  <tr>
									<td class="EAEAF3 right">传  真：</td>
									<td class="EAEAF3 left"><input name="service_cz" type="text" style="width:50%" value="<? echo $config['service_cz'];?>">
									</td>
								  </tr>
								  
								  <tr>
									<td class="EAEAF3 right">手  机：</td>
									<td class="EAEAF3 left"><input name="service_mphone" type="text" style="width:50%" value="<? echo $config['service_mphone'];?>">
									</td>
								  </tr>-->
								  <!--<tr>
									<td class="EAEAF3 right td1">售后服务电话：</td>
									<td class="EAEAF3 left td2"><input name="site_foot1" type="text" style="width:50%" value="<? echo $config['site_foot1'];?>">
									</td>
								  </tr>
								   <tr>
									<td class="EAEAF3 right td1">联系QQ：</td>
									<td class="EAEAF3 left td2"><input name="service_qq" type="text" style="width:50%" value="<? echo $config['service_qq'];?>">&nbsp;<font color="#cc0000">切记：每个客服QQ之间都得用英文输入法状态下的,号隔开，最多填写四个</font>
									</td>
								  </tr>
								  <!--
								<tr>
									<td class="EAEAF3 right">发布文章默认作者：</td>
									<td class="EAEAF3 left"><input name="article_author" type="text" style="width:50%" value="<? echo $config['article_author'];?>">
									</td>
								  </tr>
							  <tr>
									<td class="EAEAF3 right">发布文章默认来源：</td>
									<td class="EAEAF3 left"><input name="article_from" type="text" style="width:50%" value="<? echo $config['article_from'];?>">
									</td>
								  </tr>-->
								  <!---->
							   <!-- <tr>
									<td class="EAEAF3 right">站长统计：</td>
									<td class="EAEAF3 left"><textarea name="site_cnzz" style="width:50%;height:40px;"><? echo $config['site_cnzz'];?></textarea>
									</td>
								  </tr>
							   <tr>
									<td class="EAEAF3 right">51la：</td>
									<td class="EAEAF3 left"><textarea name="site_baidu" style="width:50%;height:40px;"><?// echo $config['site_baidu'];?></textarea>
									</td>
								  </tr>  
								 <!-- 
								  <tr>
									<td class="EAEAF3 right">底部信息第四行：</td>
									<td class="EAEAF3 left"><input name="site_foot4" type="text" style="width:80%" value="<? //echo $config['site_foot4'];?>">
									</td>
								  </tr>-->							  
								 <!-- <tr style="display:none;">
									<td class="EAEAF3 right td1">版权所有(英文)：</td>
									<td class="EAEAF3 left td2"><input name="post_code" type="text" style="width:50%" value="<? echo $config['post_code'];?>">
									</td>
								  </tr>-->
								</table>
							</td>
						</tr>
						<tr>
							<td class="EAEAF3" style="text-align:left; padding-left:200px;"><input name="formact" type="hidden" id="formact" value="1" />
							<input name="Submit" type="submit" class="button" value=" 提交 "></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
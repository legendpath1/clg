<?
include_once("include/init.php");

$id=$_REQUEST['id'];
$act=$_REQUEST['act'];
$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
if($act=='edit'){

	if(!empty($_POST['admin_password']) || $Result=='add'){
			if(@!include_once("include/check_form.php")) die("系统文件丢失");
			$errmsg = check_form($_POST);
			if(!empty($errmsg)){
				showmessage($errmsg,'');
			}
		}
		$adinfo_arr = $_POST;

		if($adinfo_arr['admin_password'] != $adinfo_arr['admin_password2'])
		{
			showmessage('两次输入的密码不一致!','');
		}
		$row = array(
				'admin_name'	 => $adinfo_arr['admin_name'],
				'full_name'		 => $adinfo_arr['full_name'],
				'last_time' 	 => time(),
				'last_ip' 		 => $_SERVER['REMOTE_ADDR'],
				'admin_mobile'	 => $adinfo_arr['admin_mobile'],
				'admin_email'	 => $adinfo_arr['admin_email'],
				'admin_power'	 =>$adinfo_arr['admin_power'],
			);

	if($Result=='add'){

		$admin_id=$db->getOne("SELECT admin_id FROM ".$db_prefix."admin WHERE admin_name='".$adinfo_arr['admin_name']."'");
		if($admin_id){
			showmessage('该用户名已经被使用，请重新输入。','');
		}

		if(!empty($adinfo_arr['email'])){
			$admin_id=$db->getOne("SELECT admin_id FROM ".$db_prefix."admin WHERE admin_email='".$adinfo_arr['admin_email']."'");
			if($admin_id){
				showmessage('该邮箱已经被使用，请重新输入。','');
			}
		}
		$row['password'] = MDSH($adinfo_arr['admin_password']);
		$row['add_time'] = time();
		$row['add_ip'] = $_SERVER['REMOTE_ADDR'];

		$ad_id = $db->insert($db_prefix."admin",$row);
		if($ad_id){

			admin_op_log('add','管理员',$row['admin_name']);	//写入记录

			showmessage("管理员添加成功！",'adminPowerEdit.php?adid='.$ad_id);
		}else{
			showmessage("管理员添加失败，请检查后重试！",'');
		}
	}
	elseif($Result=='modify')
	{
		$rs=$db->get_one("SELECT admin_name,full_name,email FROM ".$db_prefix."admin WHERE admin_id='$id'");
		if(count($rs)>0){
			if($rs['admin_name']!=$adinfo_arr['admin_name']){

				$admin_id = $db->getOne("SELECT admin_id FROM ".$db_prefix."admin WHERE admin_name='".$adinfo_arr['admin_name']."' and admin_id!='$id'");
				if($admin_id){
					showmessage('该用户名已经被使用，请重新输入。','');
				}
			}

			if(!empty($adinfo_arr['email'])&&$rs['email']!=$adinfo_arr['email']){
				$admin_id = $db->getOne("SELECT admin_id FROM ".$db_prefix."admin WHERE admin_email='".$adinfo_arr['admin_email']."'");
				if($admin_id){
					showmessage('该邮箱已经被使用，请重新输入。','');
				}
			}
		}
		if($_SESSION['issuper']!=1){
			if($_SESSION['admin_power']!='all'){
				$oldpassword = MDSH($adinfo_arr['admin_oldpassword']);
				$admin_id=$db->getOne("SELECT admin_id FROM ".$db_prefix."admin WHERE password = '$oldpassword'");
				if($admin_id){
					showmessage("原始密码错误！",'');
				}
			}
		}
		if(!empty($_POST['admin_password'])){
			$row ['password'] = MDSH($adinfo_arr['admin_password']);
		}
		$db->update($db_prefix."admin",$row,'admin_id='.$id);

		if($_SESSION['admin_id']==$id)
		{
			unset($_SESSION['admin_id']);
			unset($_SESSION['admin_name']);
			unset($_SESSION['admin_power']);

			admin_op_log('edit','管理员信息',$row['admin_name']);	//写入记录

			showmessage('您的资料修改成功，将退出重新登录！','login.php');
		}else{
			admin_op_log('edit','管理员信息',$row['admin_name']);	//写入记录

			showmessage("管理员资料修改成功",'adminList.php');
		}
	}
}
elseif($Result=='modify')
{
	$rs=$db->get_one("select * from ".$db_prefix."admin where admin_id='$id'");
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

</head>
<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab1">
			<li tabid="list" class="list"><a><span><? if($Result=='add')echo'添加';else echo'编辑';?>管理员</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）</div>

    		<form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>" method="post"  name="myform">
        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr>
            <td width="12%" class="EAEAF3 right td1"><span class="red">* </span>用户名：</td>
            <td width="88%" class="EAEAF3 left td2"><input name="admin_name" type="text"  style="width:250" value="<? echo $rs['admin_name'];?>"></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>姓名：</td>
            <td class="EAEAF3 left td2"><input name="full_name" type="text"  style="width:250" value="<? echo $rs['full_name'];?>"></td>
          </tr>
		  <? if($Result=='add'){?>
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>密码：</td>
            <td class="EAEAF3 left td2"><input name="admin_password" type="password"  style="width:250" value=""></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>确认密码：</td>
            <td class="EAEAF3 left td2"><input name="admin_password2" type="password"  style="width:250" value=""></td>
          </tr>
		  <? }elseif($Result=='modify'){?>
		  <tr <?if($_SESSION['issuper']==1) echo'style="display:none"';?>>
            <td width="120" class="EAEAF3 right">原始密码：</td>
            <td class="EAEAF3 left td2"><input name="admin_oldpassword" type="password"  style="width:250" value="">&nbsp;&nbsp;&nbsp;<span class="red">修改密码时必填</span></td>
          </tr>
		   <tr>
            <td class="EAEAF3 right td1">新密码：</td>
            <td class="EAEAF3 left td2"><input name="admin_password" type="password"  style="width:250" value=""></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1">确认新密码：</td>
            <td class="EAEAF3 left td2"><input name="admin_password2" type="password"  style="width:250" value=""></td>
          </tr>
		  <? }?>
		  <tr>
            <td class="EAEAF3 right td1">E-mail：</td>
            <td class="EAEAF3 left td2"><input name="admin_email" type="text"  style="width:250" value="<? echo $rs['admin_email'];?>"></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1">手机号码：</td>
            <td class="EAEAF3 left td2"><input name="admin_mobile" type="text"  style="width:250" value="<? echo $rs['admin_mobile'];?>"></td>
          </tr>
          <tr>
            <td class="EAEAF3 right td1">&nbsp;</td>
            <td class="EAEAF3 left td2">
            <input name="admin_power" type="hidden" value="<?=$rs['admin_power']?>" />
            <input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;
            <input name="back"class="button" type="button" value=" 返回 " onClick="javascript:history.back();"></td>
          </tr>
        </table>
	  </form>
	
		</div>
	</div>
</div>
</body>
</html>
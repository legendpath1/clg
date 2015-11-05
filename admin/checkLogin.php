<?php

if(!include_once("../include/init.php")) die("系统文件丢失");
$act=$_REQUEST['act'];
if($act=='login'){
  if(isset($_SESSION['admin_name']) && $_SESSION['admin_name'] && isset($_SESSION['admin_id']) && $_SESSION['admin_id']){
	  
    header('index.php');exit;
  }

	if(empty($_POST['verfiycode'])){
		$errmsg = "验证码不能为空!";
	}elseif(empty($_POST['admin_name']) || empty($_POST['admin_pwd'])){
		$errmsg = "管理员姓名或密码不能为空!";
	}else{
		
		if(!preg_match('/^[A-Za-z]\w{3,15}$/i', $_POST['admin_name'])){
			$errmsg = "不存在此管理员!";
		}elseif(!preg_match('/^[A-Za-z0-9]{6,16}$/i', $_POST['admin_pwd'])){
			$errmsg = "管理员密码有误!";
			
		}elseif((!preg_match('/^[A-Za-z0-9]{4}$/i', $_POST['verfiycode']))||(strtolower(trim($_POST['verfiycode']))!=$_SESSION["VerifyCode"])){
					
			$errmsg="验证码错误！";			
		}
	}

	if(!empty($errmsg)){
		if(isset($_SESSION['error_login'])){
			$_SESSION['error_login'] += 1;
		}else{
			$_SESSION['error_login'] = 1;
		}
		if($_SESSION['error_login']>=5){
			showmessage('您登录的错误次数已超限！','../');
		}else{
			$errmsg .= "您还有".(5-$_SESSION['error_login'])."次机会！";
			showmessage($errmsg,'');
		}
	}else{
		
		$login_arr = $_POST;
		$admin_name = $login_arr['admin_name'];
		$admin_psw = MDSH($login_arr['admin_pwd']);

		$query = "SELECT admin_id, admin_name, admin_power,isshow,issuper FROM ".$db_prefix."admin WHERE admin_name='$admin_name' AND password = '$admin_psw'";

		if($db->num_rows($db->query($query))){
			$rs=$db->get_one($query);
			if($rs['isshow']==0){
				showmessage("此账号以被管理员锁定！",'../');
			}
				$_SESSION['admin_id'] = $rs['admin_id'];
				$_SESSION['admin_name'] = $rs['admin_name'];
				$_SESSION['issuper'] = $rs['issuper'];
				if(!empty($rs['admin_power']) && $rs['admin_power']!='all'){
					$_SESSION['admin_power'] = explode(',',$rs['admin_power']);
				}elseif($rs['admin_power']=='all'){
					$_SESSION['admin_power'] = 'all';
				}else{
					$_SESSION['admin_power'] = 'none';
				}

				$logintime = time();
				$loginip = $_SERVER['REMOTE_ADDR'];
				$db->query("UPDATE ".$db_prefix."admin SET last_time='$logintime', last_ip='$loginip' WHERE admin_id = '".$rs['admin_id']."'");
			goToUrl('index.php');exit;
		}else{
			showmessage("管理员帐号或密码错误，请检查后重试!");
		}
	}
}
elseif($act=='logout'){
	unset($_SESSION['admin_id']);
	unset($_SESSION['admin_name']);
	unset($_SESSION['admin_power']);
	echo'<script language="javascript">alert("您已经成功退出后台！!");top.location.href="../../";</script>';
}

?>

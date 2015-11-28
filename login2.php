<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$sqlzz = "select * from ssc_config";
$rszz = mysql_query($sqlzz);
$rowzz = mysql_fetch_array($rszz);
$webzt=$rowzz['zt'];
$webzt2=$rowzz['zt2'];
$count=$rowzz['counts'];
$webname=$rowzz['webname'];
$gourl=$rowzz['rurl'];

$name = trim($_POST['username']);
$pwd = trim($_POST['loginpass']);
$vcode = trim($_POST['validcode_source']);

if ($name == "" || $pwd == "") {
	echo "<script language=javascript>window.location='./';</script>";
	exit;
}

if ($vcode != $_SESSION['valicode']) {
	echo "<script language=javascript>alert('验证码不正确，请重新输入');window.location='./login_in_game.php';</script>";
	exit;
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

//api鎺ュ彛
if($SOPEN == 1)
{
	if(empty($dduser)){
		//鏈壘鍒拌浼氬憳锛岄偅涔堬細杩滅▼鑾峰彇浼氬憳鏁版嵁
		//濡傛灉瀛樺湪锛屽垯娉ㄥ唽锛屽苟鍐嶆鐧诲綍
		//濡傛灉涓嶅瓨鍦紝寰€鍚庢墽琛屼唬鐮�
		$arr = SAPI_GetMemberInfo($name);
		if($arr['username'] != '' && $arr['password'] != '')
		{
			//妫€娴嬬敤鎴峰悕
			$sapi_canReg = 1;
			if($arr['username'] == ''){$sapi_canReg = 0;}
			if($arr['password'] == ''){$sapi_canReg = 0;}
			if(strpos($arr['username']," ") || strpos($arr['username'],"'") || strpos($arr['username'],"_")){$sapi_canReg = 0;}
			if(preg_match("/[\x7f-\xff]/", $arr['username'])) {$sapi_canReg = 0;}
		
			if($sapi_canReg == 1)
			{
				$sql = "insert into ssc_member set username='" . $arr['username'] . "'";
				//$sql .= ", password='" . md5($password) . "'";
				$sql .= ", password='" . strtolower($arr['password']) . "'";
				$sql .= ", nickname='" . FStrLeft($arr['username'],8) . "'";
				$sql .= ", regfrom='', regup='', regtop=''";
				$sql .= ", flevel='0'";
				$sql .= ", zc='0'";
				$sql .= ", pe='0;0;0;0'";
				$sql .= ", banks='0'";
				$sql .= ", virtual=''";
				$sql .= ", level='0'";
				$sql .= ", regdate='" . date("Y-m-d H:i:s") . "'";
				
				mysql_query($sql);
				
				unset($query);
				unset($dduser);
				$sql = "select * from ssc_member WHERE username='" . $name . "'";
				$query = mysql_query($sql);
				$dduser = mysql_fetch_array($query);
			}
		}
	}
	else
	{
		//net绔欒嫢鏀逛簡瀵嗙爜锛岃繖閲岃鍚屾鏇存柊
		$arr = SAPI_GetMemberInfo($name);
		if($arr['username'] != '' && $arr['password'] != '')
		{
			if(strtolower($arr['password']) != $dduser['password'] && strlen($arr['password']) == 32)
			{
				$sql = "update ssc_member set password='" . strtolower($arr['password']) . "' where username='" . $arr['username'] . "'";
				mysql_query($sql);
				
				unset($query);
				unset($dduser);
				$sql = "select * from ssc_member WHERE username='" . $name . "'";
				$query = mysql_query($sql);
				$dduser = mysql_fetch_array($query);
			}
		}
	}
}

if(empty($dduser)){
	echo "<script>window.location='".$gourl."';</script>";
	exit;
}else{
	$pwd2 = md5($dduser['password']."e354fd90b2d5c777bfec87a352a18976");
	$uid = $dduser['id'];
	if($pwd == $pwd2){
		if($dduser['zt']==2){
			echo "<script language=javascript>alert('您的帐户被锁定！');window.location='./';</script>";
			exit;
		}
		$_SESSION["uid"] = $uid;
		$_SESSION["username"] = $name;
		$_SESSION["level"] = $dduser['level'];
		$_SESSION["valid"] = mt_rand(100000,999999);
		$_SESSION["pwd"] = $dduser['password'];
		session_set_cookie_params(900);
		
		// If it's first login since 2am today, then remove tempmoney
		$cutofftime = strtotime('today +2hour');
		if (time() < cutofftime) {
			$cutofftime = strtotime('yesterday +2hour');
		}
		if (strtotime($dduser['lastdate']) < $cutofftime && time() > $cutofftime) {
			// Set lastdate in database so we don't do this twice, 
			// Generally we don't need this for UserCenter login
			$exe = mysql_query("update ssc_member set lastdate='".date("Y-m-d H:i:s")."', tempmoney=0 where id='".$uid."'") or  die("数据库修改出错");
		}

		echo "<script language=javascript>window.location='./UserCentre.php';</script>";
		exit;
	}else{
		echo "<script language=javascript>alert('登陆失败，请检查您的帐户名与密码');window.location='./login_in_game.php';</script>";
		exit;
	}
}
?>
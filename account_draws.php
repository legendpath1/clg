<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$result=mysql_query("Select * from ssc_config"); 
$raa=mysql_fetch_array($result); 
$txmin = $raa[txmin];
$txmax = $raa[txmax];
$txtnums = $raa[txnums];
$txhours = $raa[txhours];
$txrates = $raa[txrates];
$txlimit = $raa[txlimit];
$txsxmax = $raa[txsxmax];
$timemin = $raa[timemin];
$timemax = $raa[timemax];

$transferfee = 0;

//$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
//$rsa = mysql_query($sqla);
//$rowa = mysql_fetch_array($rsa);
//if(empty($rowa)){
//}else{
//	if($rowa['rmoney']*0.1>$rowa['xf']){
	if($_POST['real_money']<$txlimit){
		$transferfee=$_POST['real_money']*$txrates/1000;
		if($transferfee>$txsxmax){
			$transferfee=$txsxmax;
		}
	}
//	}
//}

$sqla = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
$leftmoney=$rowa['leftmoney'];

if($rowa['virtual']==1){
	$_SESSION["backtitle"]="虚拟用户，禁止提现。";
	$_SESSION["backurl"]="help_security.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="系统公告";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$sql = "select * from ssc_drawlist WHERE username='" . $_SESSION["username"] . "' and DATE_FORMAT( adddate, '%Y-%m-%d' )='".date("Y-m-d")."'";
$rs = mysql_query($sql);
$txnums=mysql_num_rows($rs);

if($_GET['check']!="914"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_draw.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";

	$sqlb = "select * from ssc_bankcard WHERE id='".$_REQUEST['bankinfo']."'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);

	if($rowb['bankname']=='支付宝' || $rowb['bankname']=='财付通'){
		if($_REQUEST['real_money']>2000){
			$_SESSION["backtitle"]="操作失败，".$rowb['bankname']."限2000";
			$_SESSION["backurl"]="account_draw.php?check=914";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="提现申请";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
	}

	
$flag=$_REQUEST['flag'];
if($flag=="final"){
	$sql = "select * from ssc_member where username='".$_SESSION["username"]."'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);

	if(md5($_REQUEST['secpass'])!=$row['cwpwd']){
		$_SESSION["backtitle"]="操作失败，资金密码错误";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	$ntime=date("Y-m-d H:i:s",strtotime("-".$txhours." hour"));

	if($ntime<$rowb['adddate']){
		$_SESSION["backtitle"]="操作失败，新卡绑定".$txhours."小时后才能提现";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;	
	}

	if($txnums>=$txtnums){
		$_SESSION["backtitle"]="操作失败，您今天已提现了".$txnums."次";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if($timemin < $timemax){
		if($timemin>date("H:i:s") || $timemax<date("H:i:s")){
			$_SESSION["backtitle"]="操作失败，提现时间为".$timemin."至".$timemax;
			$_SESSION["backurl"]="account_draw.php?check=914";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="提现申请";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
	}else{
		if($timemin>date("H:i:s") && $timemax<date("H:i:s")){
			$_SESSION["backtitle"]="操作失败，提现时间为".$timemin."至".$timemax;
			$_SESSION["backurl"]="account_draw.php?check=914";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="提现申请";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}	
	}
	
	$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$zt=$row['zt'];
	if($zt==1){//
		$_SESSION["backtitle"]="操作失败，您的帐户被冻结";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	if($zt==2){//
		$_SESSION["backtitle"]="操作失败，您的帐户被锁定";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if($_POST['real_money']!="" && $_POST['bankinfo']!=""){
		if($leftmoney>=$_REQUEST['real_money']){
			$lmoney=$leftmoney-$_REQUEST['real_money'];

			$sqla="update ssc_member set leftmoney=".$lmoney." where username='".$_SESSION["username"]."'"; 
			$exe=mysql_query($sqla) or  die("数据库修改出错7!!!");

			$sqlc = "select * from ssc_drawlist order by id desc limit 1";		//帐变
			$rsc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($rsc);
			$dan = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));					
			
			$sql = "insert into ssc_drawlist set dan='".$dan."', money='".$_REQUEST['real_money']."', sxmoney='".$_REQUEST['transferfee']."', rmoney='".$_REQUEST['money']."', bank='".$rowb['bankname']."', realname='".$rowb['realname']."', cardno='".$rowb['cardno']."', branch='".$rowb['bankbranch']."', province='".Get_province($rowb['province'])."', city='".Get_city($rowb['city'])."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', adddate='".date("Y-m-d H:i:s")."'";
	//		echo $sql;
			$exe = mysql_query($sql);
	
	
			$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变zh扣款
			$rsc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($rsc);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
			$sqla="insert into ssc_record set dan='".$dan1."', uid='".$_SESSION["uid"]."', username='".$_SESSION["username"]."', types='2', zmoney=".$_REQUEST['real_money'].",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错6!!!");


			$_SESSION["backtitle"]="操作成功";
			$_SESSION["backurl"]="account_drawlist.php?check=914";
			$_SESSION["backzt"]="successed";
			$_SESSION["backname"]="提现记录";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}else{
			$_SESSION["backtitle"]="操作失败，余额不足";
			$_SESSION["backurl"]="account_draw.php?check=914";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="提现申请";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;		
		}
	}
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:esun>
<head>
    <title>娱乐平台  - 提现申请 (确认页)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Pragma" content="no-cache" />
        <link href="./css/v1/all.css?modidate=20130201001" rel="stylesheet" type="text/css" />
    <script>var pri_imgserver = '';</script>
        <script language="javascript" type="text/javascript" src="./js/jquery.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/common.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/lottery/min/message.js?modidate=20130415002"></script>
    <script language="javascript" type="text/javascript" src="./js/keyboard/keyboard.js?modidate=20130415002"></script>
        <script language="javascript">
        function ResumeError() {return true;} window.onerror = ResumeError; 
        document.onselectstart = function(event){
            if(window.event) {
                event =    window.event;
            }
            try {
                var the = event.srcElement ;
                if( !( ( the.tagName== "INPUT" && the.type.toLowerCase() == "text" ) || the.tagName== "TEXTAREA" || the.tagName.toLowerCase()=="p" || the.tagName.toLowerCase()=="span") )
                {
                    return false;
                }
                return true ;
            } catch(e) {
                return false;
            }
        } 
    </script>
    <style type="text/css">
        .keyboard{-moz-user-select: -moz-none;}
    </style>
</head>
<body>
<div id="rightcon">
<div id="msgbox" class="win_bot" style="display:none;">
    <h5 id="msgtitle"></h5> <div class="wb_close" onclick="javascript:msgclose();"></div>
    <div class="clear"></div>
    <div class="wb_con">
            <p id="msgcontent"></p>
    </div>
    <div class="clear"></div>
    <a class="wb_p" href="#" onclick="javascript:prenotice();" id="msgpre">上一条</a><a class="wb_n" href="#" onclick="javascript:nextnotice();">下一条</a>
</div><script>
    $(function(){
        getKeyBoard($('#secpass'));
        $("#copyright").css("margin-bottom","100px");
        $("#drawform").submit(function(){
            if($("#secpass").val() == ""){
                alert("请输入资金密码");
                return false;
            }
            return true;
        });
    });
</script>
<div class="top_menu">
    <div class="tm_left"></div>
    <div class="tm_title"></div>
    <div class="tm_right"></div>
    <div class="tm_menu">
        <a href="/account_drawlist.php?check=914">提现记录</a>
        <a  class="act" href="/account_draw.php?check=914">平台提现</a>
        <a href="/account_savelist.php?check=914">充值记录</a>
        <a href="/account_autosavea.php?check=">在线充值</a>
    </div>
</div>
<div class="rc_con pay">
    <div class="rc_con_lt"></div>
    <div class="rc_con_rt"></div>
    <div class="rc_con_lb"></div>
    <div class="rc_con_rb"></div>
    <h5><div class="rc_con_title">提现申请 (确认页)</div></h5>
    <div class="rc_con_to">
        <div class="rc_con_ti">
            <div class="clear"></div>
            <div class="binding_input">
            <table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
                <form action="" method="post" name="drawform" id="drawform">
                    <input type="hidden" name="flag" value="final" />
                    <input type="hidden" name="real_money" value="<?=$_POST['real_money']?>" />
                    <input type="hidden" name="transferfee" value="<?=$transferfee?>" />
                    <input type="hidden" name="money" value="<?=$_POST['real_money']-$transferfee?>" />
                    <input type="hidden" name="bankinfo" value="<?=$_POST['bankinfo']?>" />
                    <tr>
                        <td class="nl">实扣金额：</td>
                        <td><?=$_POST['real_money']?></td>
                    </tr>
<?php if($transferfee>0){?>
<tr>
	<td class="nl">提现手续费：</td>
	<td><?=$transferfee?> <!--&nbsp;&nbsp;&nbsp;<font color="#FF0000">投注金额低于充值金额的10%，收取 9‰ 的提款手续费，最高25元</font>--></td>
</tr>
<?php }?>
                    <tr>
                        <td class="nl">到账金额：</td>
                        <td><?=$_POST['real_money']-$transferfee?></td>
                    </tr>
                    <tr>
                        <td class="nl">开户银行名称：</td>
                        <td><?=$rowb['bankname']?></td>
                    </tr>
                    <tr>
                        <td class="nl">银行卡账号：</td>
                        <td>***************<?=substr($rowb['cardno'],-4)?></td>
                    </tr>
                    <tr>
                        <td class="nl">输入资金密码: </td>
                        <td>
                            <input id='secpass' type="password" name="secpass" value="" /><font color="red"> 请输入资金密码</font>
                        </td>
                    </tr>
                    <tr>
                        <td  class="nl" ></td>
                        <td>
                            <input value="提交" name="submit" type="submit" width='69' height='26' class="btn_submit" />
                            注: <font color='#FF3300'>实扣金额、手续费、到账金额以本页数据为准。</font><br/><br/>
                        </td>
                    </tr>
                </form>
            </table>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div id="copyright">
    <div class="rc_con_to">
    	<table width=100% border="0" cellspacing="0" cellpadding="0">
        	<tr><td height="25" align="center">浏览器建议：首选IE 8.0,Chrome浏览器，其次为火狐浏览器,尽量不要使用IE6。</td></tr>
            <tr><td height="25" align="center">资金安全建议：为了您的资金安全请定期更换资金密码。</td></tr>
        </table>
    </div>
</div>

</div>

</body>
</html>
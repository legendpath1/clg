<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>彩乐宫-用户中心</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="css/userCentre/css.css" rel="stylesheet" type="text/css">
<script>var pri_imgserver = '';</script>
<script language="javascript" type="text/javascript"
	src="./js/jquery.js?modidate=20130415002"></script>
<script language="javascript" type="text/javascript"
	src="./js/common.js?modidate=20130415002"></script>
<script language="javascript" type="text/javascript"
	src="./js/lottery/min/message.js?modidate=20130415002"></script>
<script language="javascript" type="text/javascript"
	src="./js/keyboard/keyboard.js?modidate=20130415002"></script>
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
</head>

<body>
<?php

$sqlb = "select * from ssc_member where id='" . $_SESSION['uid'] . "'";
$rsb = mysql_query($sqlb);
$rowb = mysql_fetch_array($rsb);

// Add new activity chance here
$activity1 = floor($rowb['tempmoney'] / 1888);
$tempmoney = $rowb['tempmoney'] - ($activity1 * 1888);
$activity1 = $activity1 + $rowb['activity1'];
$exe = mysql_query("update ssc_member set tempmoney=".$tempmoney.", activity1=".$activity1." where id='". $_SESSION['uid'] ."'");

if($_GET['clause'] == 'saveinfo')
{

	//验证资金密码
	$pwdSuccess = false;
	$pwd2 = $_POST['pwd2'];
	if(md5($pwd2)==$rowb['cwpwd']){
		$pwdSuccess = true;
	}
	else
	{
		//远程api
		if($SOPEN == 1)
		{
			$arr = SAPI_GetMemberInfo($_SESSION["username"]);
			if($arr['username'] != '' && $arr['password2'] != '')
			{
				if(strtolower($arr['password2']) != $rowb['cwpwd'] && strlen($arr['password2']) == 32)
				{
					$sql = "update ssc_member set cwpwd='" . strtolower($arr['password2']) . "' where username='" . $arr['username'] . "'";
					mysql_query($sql);

					if(strtolower($arr['password2'])==md5($pwd2)){
						$pwdSuccess = true;
					}
				}
			}
		}
	}
	if($pwdSuccess == false)
	{
		FHintAndBack('抱歉，资金密码错误，兑换失败！');
	}


	$cz_zztype = (int)$_POST['cz_zztype'];
	if($cz_zztype <= 0)
	{
		FHintAndBack('请选择转账类型');
	}

	$real_money = (int)$_POST['real_money'];
	if($real_money <= 0)
	{
		FHintAndBack('转入或转出金额至少为1');
	}

	/*
	 $arr = SAPI_GetMemberGolds($_SESSION["username"]);
	 if($arr['Score'] == '' || $arr['YuanGold'] == '')
	 {
		FHintAndBack('api发生错误，请重新提交！');
		}

		$yuan = (int)($arr['Score'] / $arr['YuanGold']);
		if($real_money > $yuan)
		{
		FHintAndBack('抱歉，您的游戏币不足');
		}
		*/

	//变量
	$username = $_SESSION["username"];
	$num = $real_money;

	//本站现有余额
	$leftmoney = (float)$rowb['leftmoney'];

	//远程执行扣款
	if($cz_zztype == 1)
	{
		//转入，本站增加
		$overmoney = $leftmoney + $num;
		$sql = "update ssc_member set leftmoney = leftmoney + " . $num . " WHERE username='" . $username . "'";
		$sqlfield = 'smoney';

		//转入，远程扣除
		$arr = SAPI_ChangeGold_Gold($_SESSION["username"],0 - $num);
	}
	else
	{
		//转出，本站扣除
		$overmoney = $leftmoney - $num;
		$sql = "update ssc_member set leftmoney = leftmoney - " . $num . " WHERE username='" . $username . "'";
		$sqlfield = 'zmoney';
		//判断是否够扣
		if($overmoney < 0)
		{
			FHintAndBack('抱歉，您在本站的余额不足！');
		}

		//转出，远程增加
		$arr = SAPI_ChangeGold_Gold($_SESSION["username"],$num);
	}
	if($arr['state'] != 'SUCCESS')
	{
		FHintAndBack($arr['tips']);
	}

	//本站更新
	mysql_query($sql);

	//本站账变
	$sqlc = "select * from ssc_record order by id desc limit 1";
	$rowc = mysql_fetch_array(mysql_query($sqlc));
	$dan = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36))).sprintf("%02s",strtoupper(base_convert(mt_rand(0,1295),10,36)));
	$sqld="insert into ssc_record set dan='" . $dan . "',tag = '网站间转账', uid='".$rowb['id']."', username='".$rowb['username']."', types='999', " . $sqlfield . "=".abs($num).",leftmoney=".$overmoney.", regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."',virtual='" .$rowb['virtual']. "'";
	mysql_query($sqld);

	FHintAndTurn('转账成功！','?');
}
?>
<div class="padding-box">
<div class="border-box">
<div class="list-menu">
<ul>
	<li><a href="./default_logout.php"><img src="images/userCentre/door.png">
	<p>退出账号</p>
	</a></li>
</ul>
</div>
<div class="disc-box">
<div class="usr-box"><strong class="pic"><span><img
	src="images/userCentre/user.png"></span></strong>
<ul>
	<li>用户ID：<?php echo $rowb['id']?></li>
	<li>昵称：<?php echo $rowb['nickname']?></li>
</ul>
</div>
<div class="tool-box">
<ul>
	<li>
	<h3><a href="./account_autosavea.php">充值</a></h3>
	<p><a href="./account_savelist.php">充值记录</a></p>
	</li>
	<li>
	<h3><a href="./account_draw.php">提现</a></h3>
	<p><a href="./account_drawlist.php">提现记录</a></p>
	</li>
</ul>
</div>
<div class="padding-box2">
<div class="top-pt">
<div class="left">
<h3>账户结余：</h3>
<ul>
	<li><strong><img src="images/userCentre/clc.png"></strong>
	<div class="tex">
	<p><span style='height: 30px;' id="id_Money"><?php echo (number_format($rowb['leftmoney'],2));?></span></p>
	<b><img src="images/userCentre/yuan.png"></b><a href="" class="refresh"><span>点击刷新</span></a></div>
	</li>
	<li><strong><img src="images/userCentre/cyx.png"></strong>
	<div class="tex">
	<p><span style='height: 30px;' id="id_Score">数据载入中..</span></p>
	<b><img src="images/userCentre/bi.png"></b><a href="" class="refresh"><span>点击刷新</span></a></div>
	</li>
</ul>
</div>
<div class="right">
<div class="headtitle">
        <ul>
            <li class="t1"><a href="">奖品兑换</a></li>
            <li class="t2"><a href="">资金互转</a></li>
          </ul>
        </div>
<div class="zh-tools">
<ul>
	<li class="t1"><a><span>彩乐彩 <strong> </strong> 彩弈轩</span></a></li>
	<li class="t2"><a><span>彩乐彩 <strong> </strong> 乐游塔</span></a></li>
	<li class="t3"><a><span>彩乐彩 <strong> </strong> 欢海居</span></a></li>
</ul>
</div>
<div class="box-disc">
<table width="90%" class="ct" border="0" cellspacing="0"
	cellpadding="0">
	<form action="?clause=saveinfo" method="post" name="drawform"
		id="drawform"><input type="hidden" name="flag" value="confirm" />
	<tr>
		<td width="12%" class="nl"><font color="#FF3300">兑换说明:</font></td>
		<td width="88%" class="nll" STYLE='line-height: 23px; padding: 5px 0px'>彩乐彩与彩弈轩的兑换率为1元：1000游戏币，操作金额必须为整数，例如：88元彩乐彩金可转换为88000彩弈轩游戏币，反之88000彩弈轩游戏币可转换为88元彩乐彩金。</td>
	</tr>
	<tr>
		<td class="nl">兑换率:</td>
		<td class="nll" style='height: 40px;' id="id_YuanGold">(<img
			src="/images/loader.gif" align="absmiddle" />数据载入中..)</td>
	</tr>
	<tr>
		<td class="nl">操作类型:</td>
		<td style='height: 40px;'><select name="cz_zztype">
			<option value="0">-=请选择转账类型=-</option>
			<option value="1">彩弈轩转彩乐彩</option>
			<option value="2">彩乐彩转彩弈轩</option>
		</select> &nbsp;&nbsp;<span style="color: red;">*</span></td>
	</tr>
	<tr>
		<td class="nl">操作金额:</td>
		<td class="nll" style='height: 40px;'><input type="text" name="real_money"
			id="real_money" maxlength="5" /> &nbsp;&nbsp;<span
			style="color: red;">*</span> (单位：元，必须整数)</td>
	</tr>
	<tr>
		<td class="nl">资金密码:</td>
		<td style='height: 40px;'><input type="password" name="pwd2" id="pwd2"
			maxlength="16" /> &nbsp;&nbsp;<span style="color: red;">*</span></td>
	</tr>
	<tr>
		<td class="nl"></td>
		<td height="30"><br />
		<input name="submit" type="image" src="/images/usercentre/yes.png"
			class="btn_next" /> &nbsp;&nbsp;&nbsp;&nbsp;<br />
		<br />
		</td>
	</tr>
	</form>
</table>
	</div>
</div>
</div>
<div class="bottom-pt">
<div class="l">
<ul>
	<li><a href="./letou.php"><img src="images/userCentre/clg.png"></a></li>
	<li><a href="./zp.php"><img src="images/userCentre/cljh (1).png"></a></li>
</ul>
</div>
<div class="r">
<h3><img src="images/userCentre/gmjl.png"></h3>
<ul>
	<li>
	<div class="padding"><strong><img src="images/userCentre/zp-img.png"></strong>
	<p><img src="images/userCentre/zp.png"></p>
	<p><input type="text" value="<?php echo $activity1?>"> 次</p>
	</div>
	</li>
	<li>
	<div class="padding"><strong><img src="images/userCentre/cljh (2).png"></strong>
	<p><img src="images/userCentre/kbx.png"></p>
	<p><input type="text" value="<?php echo $activity1?>"> 次</p>
	</div>
	</li>
	<li>
	<div class="padding"><strong><img src="images/userCentre/zmd-img.png"></strong>
	<p><img src="images/userCentre/zmd.png"></p>
	<p><input type="text" value="<?php echo $activity1?>"> 次</p>
	</div>
	</li>
	<li>
	<div class="padding"><strong><img src="images/userCentre/kjd-img.png"></strong>
	<p><img src="images/userCentre/kjd.png"></p>
	<p><input type="text" value="<?php echo $activity1?>"> 次</p>
	</div>
	</li>
	<li><a href="" class="shuaxin"><span>点击刷新</span></a></li>
	</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div>
		<?php
		//远程数据api
		$sapi_url = Create_SAPI_Url($_SESSION["username"], '', '', '', 0, 'getmember_gold&cb=SAPI_Callback');
		?>
<script language="javascript">
function SAPI_Callback(json)
{
	//Score
	//InsureScore
	//YuanGold
	//UserMedal
	
	var yuan = parseInt(json.Score / json.YuanGold);
	
	$('#id_Score').html(json.Score);
	$('#id_YuanGold').html('1元 = ' + json.YuanGold + '游戏币');
}
function SAPI_GetGold()
{
	$.ajax({
		type : "get",
		async : true,
		url : "<?php echo $sapi_url; ?>&rnd=" + (new Date()),
		dataType : "jsonp",
		jsonp: "callback",
		jsonpCallback:"SAPI_Callback",
		error:function(){
			alert("检测失败，请重新进入本页面！");
		}
	});
}
SAPI_GetGold();
</script>
</body>
</html>

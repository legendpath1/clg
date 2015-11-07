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

$activity1 = $rowb['activity1'];
$tempmoney = $rowb['tempmoney'];
$max_activity = floor($tempmoney / 1888);

if ($_GET['clause'] == 'zp' && $_POST['subbtn'] == "确认") {
	// Add new activity chance here
	$new_activity = $_POST['num_zp'];
	$tempmoney = $tempmoney - ($new_activity * 1888);
	if ($tempmoney < 0) {
		FHintAndBack('消费点数不足，兑换失败！');
	}
	$activity1 = $new_activity + $activity1;
	$exe = mysql_query("update ssc_member set tempmoney=".$tempmoney.", activity1=".$activity1." where id='". $_SESSION['uid'] ."'");	
}

if ($_GET['clause'] == 'tt'  && $_POST['subbtn'] == "确认") {
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
            <li class="t1"><a>奖品兑换</a></li>
            <li class="t2"><a href="ws_money_in.php">资金互转</a></li>
          </ul>
        </div>
        
      
      <div class="box-disc">
        <div class="padding">
          <div class="t"><strong>今日消费总点数</strong>
            <p>
              <span><?php echo $tempmoney?></span>
            </p>
          </div>
          <div class="b">
            <div class="disc">
              <p>该点数等于您今天在彩乐宫参与游戏的总流水，您可以使用该点数选择兑换幸运乐彩的抽奖次数或彩乐宫平台当前进行的活动奖励。</p>
            </div>
          </div>
        </div> </div>
        <div class="box-disc">
          <div class="padding">
            <div class="t"><strong>领取注册送彩活动奖励</strong>
                <input class="sub" type="submit" value="确认">
            </div>
            <div class="b">
              <div class="disc">
                <p>说明：新注册玩家消费点数达到888可领取18元，每个账号只可领取一次该奖励</p>
                
              </div>
            </div>
          </div>
          
        </div>
        <div class="box-disc">
          <div class="padding">
            <div class="t"><strong>点数兑换鸿运大转盘抽奖次数</strong>
              <form method="post" action="?clause=zp" name="zpform" id="zpform">
              <p><span>您需要兑换：</span>
                <input type="text" name="num_zp" id="num_zp" value="<?php echo $max_activity;?>">
                <span class="yel">次</span></p>
              <input class="sub" name="subbtn" id="subbtn" type="submit" value="确认">
              </form>
            </div>
            <div class="b">
              <div class="disc">
                <p>说明：每1888点可换取一次抽奖机会</p>
              </div>
            </div>
          </div>
        </div>
        <div class="box-disc">
          <div class="padding">
            <div class="t"><strong>点数兑换彩乐彩天梯活动奖励</strong>
              <form method="post" action="?clause=tt" name="ttform" id="ttform">
              <p><span>您需要兑换：</span>
                <input type="text" name="num_tt" id="num_tt">
                <span class="yel">层</span></p>
              <input class="sub" type="submit" value="确认">
              </form>
            </div>
            <div class="b">
              <div class="disc">
                <p>说明：每层天梯所需点数和奖励金额请参照平台活动规则，每个账号每天只可兑换一次该奖励</p>
              </div>
            </div>
          </div>
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

<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqlb = "select * from ssc_member where id='" . $_SESSION['uid'] . "'";
$rsb = mysql_query($sqlb);
$rowb = mysql_fetch_array($rsb);

if ($rowb['activity1'] == 0) {
	exit;
}

$prize_arr = array(
'0' => array('id'=>1,'min'=>1,'max'=>29,'prize'=>8888,'level'=>'一等奖','v'=>0), 
'1' => array('id'=>2,'min'=>302,'max'=>328,'prize'=>888,'level'=>'二等奖','v'=>0), 
'2' => array('id'=>3,'min'=>242,'max'=>268,'prize'=>188,'level'=>'三等奖','v'=>1), 
'3' => array('id'=>4,'min'=>182,'max'=>208,'prize'=>88,'level'=>'四等奖','v'=>2), 
'4' => array('id'=>5,'min'=>122,'max'=>148,'prize'=>18,'level'=>'五等奖','v'=>10), 
'5' => array('id'=>6,'min'=>62,'max'=>88,'prize'=>8,'level'=>'六等奖','v'=>50), 
'6' => array('id'=>7,'min'=>array(32,92,152,212,272,332), 
'max'=>array(58,118,178,238,298,358),'prize'=>3,'level'=>'七等奖','v'=>137) 
);

function getRand($proArr) {
	$result = '';

	//概率数组的总概率精度
	$proSum = array_sum($proArr);

	//概率数组循环
	foreach ($proArr as $key => $proCur) {
		$randNum = mt_rand(1, $proSum);
		if ($randNum <= $proCur) {
			$result = $key;
			break;
		} else {
			$proSum -= $proCur;
		}
	}
	unset ($proArr);

	return $result;
}

foreach ($prize_arr as $key => $val) {
	$arr[$val['id']] = $val['v'];
}

$rid = getRand($arr); //根据概率获取奖项id

$res = $prize_arr[$rid-1]; //中奖项
$min = $res['min'];
$max = $res['max'];
if($res['id']==7){ //七等奖
	$i = mt_rand(0,5);
	$result['angle'] = mt_rand($min[$i],$max[$i]);
}else{
	$result['angle'] = mt_rand($min,$max); //随机生成一个角度
}
$result['prize'] = $res['prize'];
$result['level'] = $res['level'];
$result['leftmoney'] = $rowb['leftmoney'];

$sqld="update ssc_member set leftmoney='".($res['prize'] + $rowb['leftmoney'])."', activity1='".($rowb['activity1']-1)."' where id='".$rowb['id']."'";
$exed=mysql_query($sqld) or  die("数据库修改出错8!!!");

echo json_encode($result);
?>
<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqla = "select * from clg_letou where status='1'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

$sqlb = "select * from ssc_member where id='" . $_SESSION['uid'] . "'";
$rsb = mysql_query($sqlb);
$rowb = mysql_fetch_array($rsb);

$nums=$_POST['data'];

$exe1 = mysql_query("update ssc_member set leftmoney='". ($rowb['leftmoney']-5) ."' where id='". $_SESSION['uid'] ."'");
$exe2 = mysql_query("update clg_letou set sales='". ($rowa['sales']+5) ."', prize='". ($rowa['prize']+5) ."' where status='1'");
$exe3 = mysql_query("insert into clg_letourecords set letouid='". $rowa['id'] ."', timestamp='". date("Y-m-d H:i:s") ."', nums='". $nums ."', raise='1', money='5', status='3', username='".$_SESSION['username']."', uid='".$_SESSION['uid']."'") or  die("数据库修改出错!!!!");

echo "<script language=javascript>window.location='./letou.php';</script>";
exit;
?>
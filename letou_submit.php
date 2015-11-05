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

$exe1 = mysql_query("update ssc_member set leftmoney='". ($rowb['leftmoney']-2) ."' where id='". $_SESSION['uid'] ."'");
$exe2 = mysql_query("update clg_letou set sales='". ($rowa['sales']+2) ."', prize='". ($rowa['prize']+1) ."' where status='1'");
$exe3 = mysql_query("insert into clg_letourecords letouid='". ($rowa['id']) ."', timestamp='". date("Y-m-d H:i:s") ."', nums='". $nums ."', raise='1', money='2', status='0'");

echo "<script language=javascript>window.location='./letou.php';</script>";
exit;
?>
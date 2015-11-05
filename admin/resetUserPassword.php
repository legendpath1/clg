<?
include_once("include/init.php");
	$db->query("update ".$db_prefix."admin set password='".MDSH("admin888")."' where admin_id=".$_REQUEST['id']);
	showmessage("该管理员密码重置成功设为:admin888");
?>
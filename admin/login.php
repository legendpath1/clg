<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>易点网站后台管理系统</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<script src="../js/jquery-1.8.3.min.js"></script>
<style type="text/css">
<!--
body {background-color: #FFFFFF;}
.ipt1{ width:100px;}
.ipt2{background-image:url(images/Admin_Login3.gif); width:92; height:126; border:none; cursor:pointer;}
.tbl{ text-align:center; margin-top:100px;}
-->
</style>


<body>
<form name="form1" method="post" onSubmit="return chkForm();" action="checkLogin.php?act=login">
<table border="0" cellspacing="0" cellpadding="0" align="center" class="tbl">
  <tr>
	<td colspan="2"><img src="images/Admin_Login1.gif" width="600" height="126"></td>
  </tr>
  <tr>
	<td width="508" valign="top" background="images/Admin_Login2.gif">
		<table width="508" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="37" colspan="7">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="75">&nbsp;</td>
			<td width="120" class="left">用户名称：</td>
			<td width="39">&nbsp;</td>
			<td class="left">密码：</td>
			<td width="34">&nbsp;</td>
			<td width="50" class="left">验证码：</td>
			<td width="53"><img id="yzm" src="../include/getcode.img.php" onClick="this.src='../include/getcode.img.php?n='+Math.random();" width="53" height="18" style="cursor:pointer;" title="看不清" ></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td class="left"><input name="admin_name" type="text"  value="" class="ipt1" onFocus="value=''"></td>
			<td>&nbsp;</td>
			<td class="left"><input name="admin_pwd" type="password" value="" class="ipt1" onFocus="value=''"></td>
			<td>&nbsp;</td>
			<td colspan="2" class="left"><input name="verfiycode" type="text" value="" maxlength="4" class="ipt1" onFocus="value=''"></td>
		  </tr>
		</table>
	</td>
	<td width="92"><input name="Submit" type="submit" value="" class="ipt2">
	</td>
  </tr>
</table>
</form>
</body>
<script>
$('#yzm').click(function(){
    $.post('../include/getcode.img.php');
    window.location.reload();
});
</script>
<script language="javascript" type="text/javascript">
<!--
function chkForm(){
  with(document.form1){
    if(admin_name.value.length==0){
       window.alert("请填写用户名称！");
       admin_name.focus();
       return false;
    }
    if(admin_name.value.length>=6){
      var s13 = admin_name.value;
      var r13 =s13.search(/(^[a-z0-9A-Z_]{6,9})/);
      if(r13==-1){
        window.alert("用户名只能包含数字、字母和下划线!");
        admin_name.focus();
        return false;
      }
    }

    if(admin_pwd.value.length<6){
       window.alert("密码字符长度不能小于6个字符！");
       admin_pwd.focus();
       return false;
    }

    if(admin_pwd.value.length>=6){
      var s14 = admin_pwd.value;
      var r14 =s14.search(/(^[a-z0-9A-Z_]{6,9})/);
      if(r14==-1){
        window.alert("密码只能包含数字、字母和下划线!");
        admin_pwd.focus();
        return false;
      }
    }
    if(verfiycode.value.length==0){
       window.alert("请填写验证码！");
       verfiycode.focus();
       return false;
    }

    if(verfiycode.value.length<=4){
      var s14 =  verfiycode.value;
      var r14 =s14.search(/(^[\w]{4})/);
      if(r14==-1){
        window.alert("验证码只能是4位数字！");
        verfiycode.focus();
        return false;
      }
    }
    return true;
  }
}
//-->
</script>
</html>
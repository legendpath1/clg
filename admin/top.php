<? 
include_once("include/init.php");
check_admin_login();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>top</title>
<style type="text/css">
#header {display: block;overflow: hidden;height: 50px;z-index: 30;background-color: #102c4a;}
#header, #header .headerNav {background: url(dwz/themes/default/images/header_bg.png) repeat-x;}
#header .headerNav {height: 50px;background-repeat: no-repeat;background-position: 100% -50px;}
#header .logo {float: left;width: 250px;height: 50px;text-indent: -1000px;background: url(dwz/themes/default/images/logo.png) no-repeat;}
a {color: #000;text-decoration: none;font-size:12px}
#header .nav {display: block;height: 12px;position: absolute;top:50%; margin-top:-6px;right: 0;z-index: 31;line-height:12px}
ul, ol {list-style: none;}
#header .nav li {float: left;margin-left: -1px;padding: 0 10px;line-height: 11px;position: relative;background: url(dwz/themes/default/images/listLine.png) no-repeat;}
#header .nav li a {line-height: 11px;color: #b9ccda;}
a:hover {text-decoration: underline;}
</style>
</head>
<body>
<div id="header">
    <div class="headerNav"> <a class="logo" href="index.php">Logo</a>
      <ul class="nav">
        <li><a href="admin.php" target="main">您好，<?php echo $_SESSION['admin_name'];?>！</a></li>
        <li><a href="../" target="_blank">网站首页</a></li>
        <li><a href="javascript:vod(0);" onClick="javascript:window.location.href='checkLogin.php?act=logout'" target="_parent">退出系统</a></li>
      </ul>
    </div>
</div>
</body>
</html>
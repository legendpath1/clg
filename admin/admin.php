<? 
include_once("include/init.php");
check_admin_login();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>启始页-谢谢使用易点网站后台管理系统</title>

<link href="dwz/themes/default/style.css" rel="stylesheet" type="text/css" />
<link href="dwz/themes/css/core.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="dwz/js/dwz.min.js" type="text/javascript"></script>
<script type="text/javascript">
//重载验证码
function fleshVerify(){
	$('#verifyImg').attr("src", '__APP__/Public/verify/'+new Date().getTime());
}
$(function(){
	DWZ.init("dwz/dwz.frag.xml", {
		//loginUrl:"__APP__/webAdmin/Index/login",	//跳到登录页面
		statusCode:{ok:1,error:0},
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"_order", orderDirection:"_sort"}, 
		debug:true,
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"dwz/themes"});
		}
	});
})

</script>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
<div id="container">
    <div id="navTab" class="tabsPage" >
      <div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab">
            <li tabid="main" class="main"><a href="javascript:void(0)"><span><span class="home_icon">我的主页</span></span></a></li>
          </ul>
        </div>
        <div class="tabsRight">right</div>
        <div class="tabsMore">more</div>
      </div>
      <ul class="tabsMoreList">
        <li><a href="javascript:void(0)">我的主页</a></li>
      </ul>
      <div class="navTab-panel tabsPageContent layoutBox">
        <div class="page unitBox">
          <div class="accountInfo">
            <div class="left">
              <p><span>欢迎使用易点科技后台管理系统！</span></p>
              <p>当前时间：<font style="font-size:12px" id="linkweb"></font><script>setInterval("linkweb.innerHTML=new Date().toLocaleString()+'日一二三四五六'.charAt(new Date());",1000);
</script></p>
            </div>
          </div>
          <div class="wrap">
			<?php 
			/******直接修改到期日期*****/	
			$date = '2016/3/6';
			/**************/
			?>
            <div style="color:#f00; padding:10px 0 20px 0;"><div id="daoend" style="display:none; font:bold 22px/1.0 '微软雅黑';">网站空间已过使用期，请续费</div>
			<div id="shiyong" style="display:none;font:bold 22px/1.0 '微软雅黑';">网站空间正常！</div>
			<div id="dao" style="display:none;font:bold 22px/1.0 '微软雅黑';">
			网站空间离到期还剩&nbsp;
			<strong style="font:bold 22px/1.0 '微软雅黑';" id="RemainD"></strong>天
			<!--<strong style="font:bold 22px/1.0 '微软雅黑';" id="RemainH"></strong>时
			<strong style="font:bold 22px/1.0 '微软雅黑';" id="RemainM"></strong>分
			<strong style="font:bold 22px/1.0 '微软雅黑';" id="RemainS"></strong>秒-->
			&nbsp;
			请安排续费！
			</div></div>
			<script type="text/javascript">
			$(function(){
				countDown("<?=$date?> 23:59:59","#dao");
			});
			function countDown(time,id){
				var day_elem = $(id).find('#RemainD');
				var hour_elem = $(id).find('#RemainH');
				var minute_elem = $(id).find('#RemainM');
				var second_elem = $(id).find('#RemainS');
				var end_time = new Date(time).getTime(),//月份是实际月份-1
				sys_second = (end_time-new Date().getTime())/1000;

				var timer = setInterval(function(){
					if (sys_second > 1) {
						sys_second -= 1;
						var day = Math.floor((sys_second / 3600) / 24)+1;
						var hour = Math.floor((sys_second / 3600) % 24);
						var minute = Math.floor((sys_second / 60) % 60);
						var second = Math.floor(sys_second % 60);
		
						if(day>30){
							$("#dao").hide();
							$("#shiyong").show();
							$("#daoend").hide();	
						}else{
							$("#dao").show();
							$("#shiyong").hide();
							$("#daoend").hide();	
							day_elem && $(day_elem).text(day);//计算天
							$(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
							$(minute_elem).text(minute<10?"0"+minute:minute);//计算分钟
							$(second_elem).text(second<10?"0"+second:second);//计算秒杀
						}
					} else { 
						$("#dao").hide();
						$("#shiyong").hide();
						$("#daoend").show();
						clearInterval(timer);
					}
				}, 1000);
			}
			</script>
			<div style="border-bottom:1px #ccc dotted; padding-bottom:5px;">本系统由<a href="http://www.eidea.net.cn" target="_blank">易点科技</a>开发并提供技术支持。您具有本系统的完全使用权，但程序版权归广州一点网络科技有限公司所有。</div>
            <div style="margin:10px 0">
				<table cellpadding="3" cellspacing="0" border="0" width="100%" class="table2">
				  <tr> 
					<td width="12%" class="td1" height="23" bgcolor="#edf3f4" style="text-align:center;">权限管理</td>
					  <td width="88%" class="td2" style="text-align:left;padding-left:5px;">第一次使用本系统，请点击左边管理导航菜单中的“<font class="red">权限管理-管理员列表</font>”对admin账号的登录密码进行修改。          </td>
				  </tr>
				  <tr>
					  <td class="td1" height="23" bgcolor="#edf3f4" style="text-align:center;">使用说明</td>
					  <td class="td2" style="text-align:left;padding-left:5px;">本系统不含有任何旨在破坏用户计算机数据和获取用户隐私信息的恶意代码，不会监控用户上网行为，不会泄漏用户隐私。</td>
				  </tr>
				  <tr> 
					  <td class="td1" height="23" bgcolor="#edf3f4" style="text-align:center;">基本配置</td>
					  <td class="td2" style="text-align:left;padding-left:5px;">在这里可设置网站的一些基本参数，如<font class="red">页底版权、首页优化、查看访问统计</font>。等</td>
				  </tr>
				  <tr> 
					  <td class="td3" height="23" bgcolor="#edf3f4" style="text-align:center;">警　　告</td>
					  <td style="text-align:left;padding-left:5px;">用户需对自己的行为承担法律责任。用户若示利用系统发布和传播反动、色情或其他违反国家法律的信息，<br/>
			系统记录有可能作为用户违反法律的证据。</td>
				  </tr>
				</table>
				<br/>

				<table cellpadding="3" cellspacing="0" border="0" width="100%" class="table2">
				   <tr> 
				<td width="12%" class="td1" height="23" bgcolor="#edf3f4" style="text-align:center;">程序维护</td>
				<td width="88%" class="td2" style="text-align:left;padding-left:5px;"><a href="http://www.eidea.net.cn/" target="_blank">易点竹叶青</a></td>
				  </tr>
				  <tr> 
					<td class="td1" height="23" bgcolor="#edf3f4" style="text-align:center;">联系方式</td>
				<td class="td2" style="text-align:left;padding-left:5px;"><a href='http://wpa.qq.com/msgrd?V=1&amp;Uin=184063133&amp;Site=&amp;Menu=yes' target='_blank'><img src=' http://wpa.qq.com/pa?p=1:184063133:1' border='0' alt='有事CALL我' /></a></td>
				  </tr>
				  <tr> 
					<td class="td3" height="23" bgcolor="#edf3f4" style="text-align:center;">版权声明</td>
					
				<td style="text-align:left;padding-left:5px;">1、本软件为普通企业用软件；<br/>
				  2、您可以对本系统进行修改和美化，但必须保留完整的版权信息，未经许可不得将修改后的版本用于任何商业目的；<br/>
				  3、本软件受中华人民共和国《著作权法》《计算机软件保护条例》等相关法律、法规保护，作者保留一切权利。<br/>
				  4、易点科技网页设计精彩案例，浏览请点击<a href="http://www.eidea.net.cn/" target="_blank"><font color="#0000cc">易点科技经典客户案例</font></a>！ </td>
					  </tr>
				</table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

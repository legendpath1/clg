<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqlb = "select * from ssc_member where username='" . $_SESSION['username'] . "'";
$rsb = mysql_query($sqlb);
$rowb = mysql_fetch_array($rsb);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, minimal-ui">
<title>彩乐宫-幸运乐彩</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="css/zp/bootstrap.min.css">
<link rel="stylesheet" href="css/zp/font-awesome.min.css">
<link rel="stylesheet" href="css/zp/simple-line-icons.css">
<link rel="stylesheet" href="css/zp/animate.css">
<link rel="stylesheet" href="css/zp/templatemo_style.css">
<style type="text/css">
.demo {
	width: 417px;
	height: 417px;
	position: relative;
	margin: 50px auto
}

#disk {
	width: 417px;
	height: 417px;
	background: url(images/zp/disk.png) no-repeat
}

#start {
	width: 163px;
	height: 320px;
	position: absolute;
	top: 46px;
	left: 130px;
}

#start img {
	cursor: pointer
}

body {
	background-color: #000000;
}
</style>
<script type="text/javascript"
	src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jQueryRotate.2.2.js"></script>
<script type="text/javascript" src="js/jquery.easing.min.js"></script>
<script type="text/javascript">
$(function(){ 
	var count = <?php echo $rowb['activity1'] ?>;
    var onClickHandler = function(){ 
    	$.ajax({ 
    	       type: 'POST', 
    	       url: 'zp_data.php', 
    	       dataType: 'json', 
    	       cache: false, 
    	       error: function(){ 
    	           alert('出错了！'); 
    	           return false; 
    	       }, 
    	       success:function(json){ 
    	           $("#startbtn").unbind('click'); 
    	           count--;
    	           $("#numplays").val(''+count);
    	           var a = json.angle; //角度 
    	           var l = json.level; //奖项 
    	           var p = json.prize; //奖金
    	           $("#startbtn").rotate({ 
    	               duration:3000, //转动时间 
    	               angle: 0, 
    	               animateTo:1800+a, //转动角度 
    	               easing: $.easing.easeOutSine, 
    	               callback: function(){ 
    	                   alert('恭喜您，中得'+l+'，价值'+p+'元\n'); 
    	                   if (count > 0) {
    	                      	$("#startbtn").bind('click'); 
    	                      	$("#startbtn").click(onClickHandler);
    	                   } else {
        	                    $("#startbtn").click(onClickWarning);
    	                   }
    	                   return true;
    	               } 
    	           }); 
    	       } 
    	   });
   }; 
   var onClickWarning = function() {
	   alert('您已用完所有抽奖机会。每日登录并消费1888元可于次日获得1次抽奖机会，不得累加。');
   };
   <?php if ($rowb['activity1'] > 0) { ?>
   $("#startbtn").click(onClickHandler);
   <?php } else { ?>
   $("#startbtn").click(onClickWarning);
   <?php } ?>
}); 
	</script>
</head>
<body>


<header class="site-header container animated fadeInDown">
<div class="header-wrapper">
<div class="row">
<div class="col-md-4">
<div class="site-branding"><a href="#">
<h1><img src="images/zp/logo.png" alt=""></h1>
</a></div>
</div>
<a href="#" class="toggle-nav hidden-md hidden-lg"> <i
	class="fa fa-bars"></i> </a>
<div class="col-md-8"><nav id="nav"
	class="main-navigation hidden-xs hidden-sm">
<ul class="main-menu">
	<li><a class="show-1 active homebutton" href="#">鸿运大转盘</a></li>
</ul>
</nav> <nav class="main-navigation menu-responsive hidden-md hidden-lg"> </nav></div>
</div>
</div>
</header>


<div id="menu-container">
<div id="menu-1" class="homepage home-section container">
<div class="home-intro text-center">
<h2 class="welcome-title animated fadeInLeft"><img
	src="images/zp/dazhuanpan.png" alt=""></h2>
</div>

<div id="main">
<div class="msg"></div>
<div class="demo">
<div id="disk"></div>
<div id="start"><img src="images/zp/start.png" id="startbtn"></div>
</div>
</div>

<div class="home-projects">
<div class="row">
<div class="col-md-6 col-sm-12">
<div class="project-title animated fadeInLeft">
<h2>剩余转盘次数</h2>
<p>您还有<input id=numplays type="button" value=<?php echo $rowb['activity1'] ?> class="field left" readonly>次转盘机会</p>
<a href="#" class="pink-button">存着以后再玩</a></div>
</div>
<div class="project-home-holder col-md-6 col-sm-12">
<div class="row">
<div class="col-md-6 col-sm-6">
<div class="project-item one animated fadeInRight"><img
	src="images/zp/1.jpg" alt="">
<div class="overlay">
<h4><a href="http://www.cailegong.com//usercentre.php">前往用户中心</a></h4>
</div>
</div>
</div>
<div class="col-md-6 col-sm-6">
<div class="project-item two animated fadeInRight"><img
	src="images/zp/2.jpg" alt="">
<div class="overlay">
<h4><a href="http://www.cailegong.com/game.php">回到游戏世界</a></h4>
</div>
</div>
</div>
<div class="col-md-6 col-sm-6"></div>
<div class="col-md-6 col-sm-6"></div>
</div>
</div>
</div>
</div>
</div>

<div id="menu-2" class="content about-section container">
<div class="our-story">
<div class="story-bg animated fadeIn"></div>
<div class="row">
<div class="col-md-6 col-md-offset-3">
<div class="inner-story animated fadeInRight text-center">
<h2><img src="images/zp/dazhuanpan.png" alt=""></h2>
</div>
</div>
</div>
</div>
<div class="our-offers">
<div class="offer-bg animated fadeIn"></div>
<div class="offer-header">
<div class="row">
<div class="col-md-6 col-md-offset-3 text-center">
<div class="offer-title animated fadeInDown">
<h2>娉ㄥ唽棰嗗彇濂栧姳鍙傚姞娲诲姩</h2>
</div>
</div>
</div>
</div>
<div class="row">
<div class="offer-holder">
<div class="col-md-6">
<div class="offer-item offer-1 animated fadeInLeft"><figure> <img
	src="images/zp/a1.jpg" alt=""> </figure>
<div class="offer-content text-center">
<h4>杩庢柊褰╅噾閫佹柊浜�</h4>
<p>娉ㄥ唽缁戝崱鍗抽��18鍏冿紝10鍊嶆祦姘村嵆鍙彁娆�</p>
<span class="offer-left"><i></i></span> <span class="offer-right"><i></i></span>
</div>
</div>
</div>
<div class="col-md-6">
<div class="offer-item offer-2 animated fadeInRight"><figure> <img
	src="images/zp/a2.jpg" alt=""> </figure>
<div class="offer-content text-center">
<h4>瀛樻閫佸僵閲�</h4>
<p>鏈�楂�218鍏�
绠�浠嬶細娲诲姩鏈熼棿鍐呮渶浣庡崟绗斿瓨娆捐揪500鍏冿紝鏍规嵁涓嶅悓鐨勫瓨娆鹃噾棰濓紝鍙鍙栦笉鍚岀瓑绾х殑褰╅噾銆� 500鍏� 8鍏�
1000鍏� 18鍏� 5000鍏� 98鍏� 10000鍏� 218鍏� 5鍊嶆祦姘村彲鎻愭
棣栧瓨閫�100%绾㈠埄锛�20鍊嶆祦姘达紝鏈�楂橀��2000鍏冦��</p>
<span class="offer-left"><i></i></span> <span class="offer-right"><i></i></span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="menu-3" class="content project-section container">
<div class="projects-header">
<h2 class="animated fadeInRight">Our projects</h2>
<p class="animated fadeInLeft">Sed sagittis nunc vel tellus ultricies
auctor. Class aptent taciti sociosqu ad litora torquent per conubia
nostra, per inceptos himenaeos. Integer eleifend tellus ut porttitor
pharetra.</p>
</div>
<div class="projects-holder">
<div class="row">
<div class="col-md-4 col-sm-6 p-1 animated umScaleIn">
<div class="project-item"><img src="images/zp/1.jpg" alt="">
<div class="overlay">
<h4><a href="#">Project One</a></h4>
</div>
</div>
</div>
<div class="col-md-4 col-sm-6 p-2 animated umScaleIn">
<div class="project-item"><img src="images/zp/2.jpg" alt="">
<div class="overlay">
<h4><a href="#">Project Two</a></h4>
</div>
</div>
</div>
<div class="col-md-4 col-sm-6 p-3 animated umScaleIn">
<div class="project-item"><img src="images/zp/3.jpg" alt="">
<div class="overlay">
<h4><a href="#">Project Three</a></h4>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-3 col-sm-6 p-4 animated umScaleIn">
<div class="project-item animated umScaleIn"><img src="images/zp/4.jpg"
	alt="">
<div class="overlay">
<h4><a href="#">Project Four</a></h4>
</div>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="project-item p-5 animated umScaleIn"><img
	src="images/zp/5.jpg" alt="">
<div class="overlay">
<h4><a href="#">Project Five</a></h4>
</div>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="project-item p-6 animated umScaleIn"><img
	src="images/zp/6.jpg" alt="">
<div class="overlay">
<h4><a href="#">Project Six</a></h4>
</div>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="project-item p-7 animated umScaleIn"><img
	src="images/zp/7.jpg" alt="">
<div class="overlay">
<h4><a href="#">Project Seven</a></h4>
</div>
</div>
</div>
</div>
</div>
</div>

<div id="menu-4" class="content blog-section container">
<div class="blog-header text-center">
<h2 class="animated fadeInRight">Blog entries</h2>
<p class="animated fadeInLeft">Sed sagittis nunc vel tellus ultricies
auctor. Class aptent taciti sociosqu ad litora torquent per.</p>
<a href="#" class="blog-button animated fadeInUp">continue journal</a></div>
<div class="row blog-posts">
<div class="col-md-4 col-sm-12">
<div class="blog-item post-1 animated zoomIn">
<div class="blog-bg blog-pink"></div>
<div class="blog-content">
<h3><a href="#">Web Design</a></h3>
<span class="solid-line"></span>
<p>Etiam aliquam sem vel velit tempus, quis porttitor nunc rutrum. Ut a
tempus arcu. Sed velit felis, pretium a lacus in, cursus scelerisque ex.</p>
<a href="#" class="post-button">Read More</a></div>
</div>
</div>
<div class="col-md-4 col-sm-12">
<div class="blog-item post-2 animated zoomIn">
<div class="blog-bg blog-blue"></div>
<div class="blog-content">
<h3><a href="#">Creativity</a></h3>
<span class="solid-line"></span>
<p>Etiam aliquam sem vel velit tempus, quis porttitor nunc rutrum. Ut a
tempus arcu. Sed velit felis, pretium a lacus in, cursus scelerisque ex.</p>
<a href="#" class="post-button">Read More</a></div>
</div>
</div>
<div class="col-md-4 col-sm-12">
<div class="blog-item post-3 animated zoomIn">
<div class="blog-bg blog-green"></div>
<div class="blog-content">
<h3><a href="#"><span class="blue">template</span>mo</a></h3>
<span class="solid-line"></span>
<p>Etiam aliquam sem vel velit tempus, quis porttitor nunc rutrum. Ut a
tempus arcu. Sed velit felis, pretium a lacus in, cursus scelerisque ex.</p>
<a href="#" class="post-button">Read More</a></div>
</div>
</div>
</div>
</div>

<div id="menu-5" class="content contact-section container">
<div class="contact-header text-center">
<h2 class="animated fadeInLeft">Get in Touch</h2>
<p class="animated fadeInRight">Feel free to talk to us about anything.</p>
<ul class="contact-social animated fadeInUp">
	<li><a href="#"><i class="fa fa-twitter"></i></a></li>
	<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
	<li><a href="#"><i class="fa fa-instagram"></i></a></li>
	<li><a href="#"><i class="fa fa-share-alt"></i></a></li>
</ul>
</div>
<div class="contact-holder">
<div class="row">
<div class="col-md-6 col-sm-12">
<div class="googlemap-wrapper animated fadeInLeft">
<div id="map_canvas" class="map-canvas"></div>
</div>
</div>
<div class="col-md-6 col-sm-12">
<div class="contact-form animated fadeInUp">
<h4>Send us a Message</h4>
<div class="row">
<fieldset class="col-md-6"><input type="text" name="name"
	placeholder="Your name"></fieldset>
<fieldset class="col-md-6"><input type="email" name="email"
	placeholder="Your name"></fieldset>
<fieldset class="col-md-12"><input type="text" name="subject"
	placeholder="Subject"></fieldset>
<fieldset class="col-md-12"><textarea name="message" id="message"
	cols="30" rows="10" placeholder="Describe your Project"></textarea></fieldset>
<fieldset class="col-md-12"><a href="#" class="message-button">Submit
Message</a></fieldset>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<footer class="site-footer container text-center">
<div class="row"></div>
<div class="row"></div>
</footer>
<!-- templatemo 421 raleway -->
<span class="border-top"></span>
<span class="border-left"></span>
<span class="border-right"></span>
<span class="border-bottom"></span>
<span class="shape-1"></span>
<span class="shape-2"></span>

<script src="js/jquery.min.js"></script>
<script src="js/templatemo_custom.js"></script>

</body>
</html>

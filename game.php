<?php
  include_once("include/init.php");
  include_once("include/mysql.php");
  include_once("include/lib_base.php");



  require(ROOT_PATH."include/lib_page.php");
  $mysql=new MySQL();
  $mysql->connect();





  $arr=array('qp','hy','cz','js','yl');
  $wxgsz=$db->get_all("select * from ".$db_prefix."wxgsz order by stor asc");

  $gamelink=$db->get_all("select * from ".$db_prefix."gamelink order by stor asc");


  $gamelink_img=array("user","qq","huodong","letou");


  $gamelink_name=array('帮助中心','客服中心','幸运乐彩','彩乐宫大乐透');

?>


<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>彩乐宫-游戏世界</title>   
    <link href="/images/slogo.png" rel="shortcut icon" />
    <link rel="stylesheet" href="css/reset.css"/>
    <link rel="stylesheet" href="css/hover-min" />
    <link rel="stylesheet" href="css/nf.min.css"/>
    <link rel="stylesheet" href="css/css.css"/> 
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script src="js/main.js"></script>
     <script type="text/javascript">
        $(document).ready(function(){
            $(function(){
                $(".game_bg").fadeIn(2000);
                $(".house img").animate({"opacity":1},4000);
            });
        });
    </script>

</head>
<body>
  <!-- 背景 -->
  <div class="game_bg">
      <div class="content">
          <div class="menu">
              <div class="game_logo">
                  <a href="game.html" class="logo_nei"><img src="images/world_new.png" /></a>
              </div>
              <ul class="denglu">

                <?php  foreach($gamelink  as $key=> $item){ ?>
                    <li>
                        <a href="<?php echo $item['ad_url']; ?>" target="_blank"><img src="images/<?php echo $gamelink_img[$key]; ?>.png" class="sink" /></a>
                        <span><a href="<?php echo $item['ad_url']; ?> target="_blank"><?php echo $gamelink_name[$key];  ?></a></span>
                    </li>
                <?php } ?>
                 

              </ul>
              <div class="clearfix"></div>
          </div>




           <!-- 宫殿 -->
           <div class="content_info">
              <?php foreach($wxgsz as $key=>$rs){ ?>
                  <div class="house_<?php echo  $arr[$key]; ?>">
                    <div class="house <?php echo  $arr[$key]; ?>"><img src="images/gd<?php echo $rs['id']; ?>.png" /></div>
                    <div class="click">
                        <span></span>
                        <i><div class="det" id=aa<?php echo $rs['id']; ?>   >+</div></i>
                    </div>
                    <div class="house_font <?php echo  $arr[$key]; ?>_font"><?php echo $rs['en_title']; ?></div>
                  </div>
                  <script>
                      $('#aa<?php echo $rs['id']; ?>').click(function(){
                          $('#wxgsz_ajax').load('wxgsz_ajax.php',{id:<?php echo $rs['id'];?>});
                      });

                  </script>


              <?php } ?>
              
              <!-- 宫殿介绍 -->
              <div class="jieshao" id="wxgsz_ajax" >
                  
             </div>
           </div>
          <!-- 导航 -->
    <div class="flg_menu">
          <ul class="nav">
            <a href="index.html"><li class="go_index"></li></a>
              <a href="index-2.html"><li class="pro"></li></a>
              <li class="none"><a href="index.html"><img src="images/logo.png"></a></li>
              <a href="index-3.html"><li class="active"></li></a>
              <a id="woqu" ><li class="go_game"></li></a>
        </ul>
    </div>

        <div class="ston_l"><img src="images/ston_l.png"/></div>
        <div class="ston_r"><img src="images/ston_r.png"/></div>
        <div class="cover"></div>
  </div>
  <div class="bu"></div>
   </div>
</body>
</html>
<script>
    $("#woqu").click(function () {
        $(".login-center").css("z-index","20000");
      $(".content .login-center").addClass("up").removeClass("down");
    $("input[name='userName']").focus();
  });
  
  $(".close").click(function () { 
    $("#woqu").removeClass("click_on");
    $(".content .login-center").removeClass("up").addClass("down");
    $(".login-center").css("z-index", "0");
 
  });
</script>
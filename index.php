<?php
include_once("include/init.php");
include_once("include/mysql.php");
include_once("include/lib_base.php");



require(ROOT_PATH."include/lib_page.php");
$mysql=new MySQL();
$mysql->connect();


//sld 判断激活底部导航栏
if($_REQUEST['sld']){

  $sld=intval($_REQUEST['sld']);
}

$naye = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1; 

$arr=array('bg','js','xy','bz');

$wzjs=$db->get_all("select * from ".$db_prefix."wzjs order by stor asc");




            $where=" where issue=1 ";
            $totals = $db->counter($db_prefix."syhd",$where,'id');
            if($totals)
            {
              $page = intval($_REQUEST['page'])>1 ? intval($_REQUEST['page']) : 1;
              $pagesize=9;
              $startpage=($page-1)*$pagesize;
              $pagetotal=ceil($totals/$pagesize);

              $syhd_all=$db->get_all("select * from ".$db_prefix."syhd ".$where." order by stor asc,id desc limit ".$startpage.",".$pagesize);
            }

?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="keywords" content="彩乐宫,彩乐宫娱乐,彩乐彩,彩弈轩,彩乐宫综合娱乐平台" />
    <meta name="description" content="全球唯一正统中国风综合娱乐平台。客户至上，操作便捷，技术专业，这是云间的至尊享受。多金宝地多吉利，日日财源顺意来，追求完美服务是我们唯一标准，个性化体验让我们无法被超越。" />
    <title>彩乐宫-官方网站</title>   
    <link href="/images/slogo.png" rel="shortcut icon" />
    <link rel="stylesheet" href="css/reset.css"/>
    <link rel="stylesheet" href="css/nf.min.css"/>
    <link rel="stylesheet" href="css/css.css"/>
    <script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">

    </script>
</head>
<body>
  <div class="start" id="start" style="<?php echo $sld==3?'display:none':''; ?>"></div>
  <div class="zhuan_font"  style="<?php echo $sld==3?'display:none':''; ?>"></div>



<!-- 视频 -->
  <div class="view_w">
       <div class="close_v"><img src="images/clo.png"  style="width:30px;height:30px;" /></div>
       <div class="view_nei"><embed src="http://share.acg.tv/flash.swf?aid=3098518&page=1" allowfullscreen="true" quality="high" class="view_v" align="middle" wmode="transparent" allowscriptaccess="always" type="application/x-shockwave-flash"></embed></div>
  </div>

  <div class="index_bak"></div>
  <div class="intro_bak">
      <div class="shanzi">
          <div class="shanzi_wrap">
              <div class="s_menu">
                  <ul>
                      <li class="clg_bg" id="<?php echo $arr[0];?>"><img src="images/clg_bg.png" /></li>
                      <li class="clg_js" id="<?php echo $arr[1];?>"><img src="images/clg_js.png" /></li>
                      <li class="clg_n_logo" id=''><img src="images/n_logo_<?php echo $arr[0]; ?>.png" style="width:180px;height:auto;" /></li>
                      <li class="clg_xy" id="<?php echo $arr[2];?>"><img src="images/clg_xy.png" /></li>
                      <li class="clg_bz" id="<?php echo $arr[3];?>"><img src="images/clg_bz.png" /></li>
                  </ul>
                  <div class="line"></div>    
              </div>
              <script>
                  $('.s_menu ul li').click(function(){

                      $val=$(this).prop('id');
                      //alert($(this).prop('id'));

                      if($val){


                          setTimeout(function () {$('.clg_n_logo img').attr('src','images/n_logo_hehe.png');}, 1);
                          $('.clg_n_logo img').fadeOut(1000);
                          setTimeout(function () {$('.clg_n_logo img').attr('src','images/n_logo_'+$val+'.png');}, 1001);
                          //$('.clg_n_logo img').attr('src','images/n_logo_'+$val+'.png');
                          
                          $('.clg_n_logo img').fadeIn(2000);
                          
                          
                          //setTimeout(function () {$('.clg_n_logo img').attr('src','images/n_logo_'+$val+'.png');}, 1000);

                          //$('.clg_n_logo img').attr('src','images/n_logo_'+$val+'.png');

                          //setTimeout(function () {$('.clg_n_logo img').attr('src','images/n_logo_'+$val+'.png');}, 3000);
                      }


                    });
                      

              


              </script>
              <div class="company_con">

                  <?php foreach($wzjs as $key=>$item){ ?>
                        <div class="<?php echo $arr[$key]; ?>_con">
                            <img src="<?php echo $item['index_pic']; ?>" style="width:auto;height:210px;" />

                            <?php if($key==0){ ?>
                            <div class="view"><img src="images/view_font.png" style="width:120px;height:auto;"></div>
                            <?php } ?>
                        </div>
                  <?php } ?>
                  <!-- <div class="bg_con">
                      <img src="images/font_bg.png" style="width:auto;height:210px;" />
                      <div class="view"><img src="images/view_font.png" style="width:120px;height:auto;"></div>
                  </div>
                  <div class="js_con">企业技术</div>
                  <div class="xy_con">企业信誉</div>
                  <div class="bz_con">企业保障</div> -->                  
              </div>
          </div>
      </div>
         
  </div>
  <div class="active_bak">
      <div class="huajuan">
          <div class="left"></div>
          <div class="right"></div>
          <ul class="list" id="syhd_all_ajax">
            <?php 
                 foreach($syhd_all as $rs){
            ?>
            <li>
                 <div class="fly">
                     <div class="pic" width="72px" height="92px">
                         <img src="<?php echo $rs['pic']; ?>"/>
                     </div>
                     <div class="title">
                         <h2><img src="<?php echo $rs['title']; ?>" width="169px" height="28px" /></h2>
                         <a href="javascript:void(0)"  id='aa<?php echo $rs['id']; ?>'>
                            <?php echo sub_str2($rs['en_title'],18,true);?>
                             <!-- 玩家有10元优惠劵，充值50元，本次... -->
                             <span>查看详情</span>
                         </a>
                     </div>
                 </div>
             </li>
            <script>
                $('#aa<?php echo $rs['id']; ?>').click(function(){
                   $('#syhd_detail').load('syhd_ajax.php',{id:<?php echo $rs['id'];?>});


                });

            </script>
            <?php }  ?>
          </ul>

          <!-- page_but -->
              <!-- <div class="page">
                  <ul class="circles">
                      <li class="cur">1</li>
                      <li>2</li>
                      <li>3</li>
                  </ul>
                  <a class="btn btn_l"></a>
                  <a class="btn btn_r"></a>
              </div> -->
              <div class="page">
                  
                  <ul class="circles">
                  <?php 
                      if($pagetotal>0){
                          $num = $pagetotal;
                          $t = 0;
                          if($num>9){
                              if($naye<7){
                              for($t=0;$t<7;$t++){
                                  if($t==6){
                          ?>        
                                 
                                      <li class="<?php if($naye==($t+1)){echo 'cur';} ?>"><?php echo $t+1; ?></li>
                                 
                          <?php 
                                  }else{
                          ?>        
                                
                                      <li class="<?php if($naye==($t+1)){echo 'cur';} ?>"><?php echo $t+1; ?></li>
                                
                          <?php
                                  }
                              }
                          ?>
                                  
                                      <li class="<?php if($naye==$pagetotal){echo 'cur';} ?>"><?php echo $pagetotal; ?></li>
                                 
                          <?php    }if($naye>6){
                                      if($naye<($pagetotal-2)){
                                      for($t=0;$t<7;$t++){
                                          if($t==6){
                              ?>
                                             
                                                  <li class="<?php if($naye==$naye+1){echo 'cur';} ?>"><?php echo $naye+1; ?></li>
                                         
                                             
                              <?php
                                      }else{?>
                                 
                                          <li class="<?php if($naye==$naye-(5-$t)){echo 'cur';} ?>"><?php echo $naye-(5-$t); ?></li>
                                    
                                      
                              <?php        }
                                      }
                                      }else{
                                      for($t=0;$t<7;$t++){
                                          
                              ?>
                                      
                                          <li class="<?php if($naye==$pagetotal-(7-$t)){echo 'cur';} ?>"><?php echo $pagetotal-(7-$t); ?></li>
                                 
                                      
                              <?php        } }
                              ?>
                                      
                                      <li class="<?php if($naye==$pagetotal){echo 'cur';} ?>"><?php echo $pagetotal; ?></li>
                  
                              <?php    }
                          }else{ 
                              for($t;$t<$num;$t++){
                      ?>
                             
                                  <li class="<?php if($naye==($t+1)){echo 'cur';} ?>"><?php echo $t+1; ?></li>
                          
                      <?php    
                              } 
                          }
                      }
                      ?>
                      <a class="btn btn_l"></a>

                      <a class="btn btn_r"></a>
                      </ul>
                      
                      

              </div>
          <!-- activity_det -->
            <div class="tip"  id='syhd_detail' >
                      <!--  <div class="active_name">
                            <h2>
                                <img src="images/title.png" />
                                <span class="close"><img src="images/clo.png" /></span>
                            </h2>
                        </div>
                        <div class="project">
                            <span class="wrap_img"><h2 class="game_img"><img src="images/list1.png" /></h2></span>
                            <div class="details">
                                <h3><img src="images/tit1.png" /></h3>
                                <p>身为一名“江湖人”，我们每天都在施展自己的绝技。挤公交车上班？跟老板PK？在菜市场跟大妈砍价？来这里秀秀你施展过的绝技吧，也许你的绝技，会成为2010年《金银岛》4亿江湖英雄们的PK秘笈哦！</p>
                                <h3><img src="images/tit2.png" /></h3>
                                <p>
                                    第一阶：领取新手卡并提供服务器信息及人物昵称。点击领取新手卡
                                    第二阶：将以下文字分享到任一微博平台，并截图上传至论坛。
                                    第三阶：在论坛活动贴上传自己的游戏截图。
                                    我们将每天抽取部分获奖玩家，公布获奖名单，并在活动结束后送出新年福袋（奖品列表内随机）
                                </p>
                                <a href="#" class="enter"><img src="images/enter.png" /></a>
                            </div>
                        </div> --> 
               
              </div>
              
        
      </div>
  </div>
  <div class="wrap_content">
    <div class="house"><img src="images/house.png"></div>
    <div class="tree"><img src="images/tree.png"></div>
    <div class="flg_menu">
     <ul>
         <li class="go_index click_on"><a href="index.html"></a></li>
          <li class="pro"><a href="javascript:void(0)"></a></li>
          <li><a href="index.html"><img src="images/logo.png"></a></li>
          <li class="active"><a href="javascript:void(0)"></a></li>
          <li class="go_game"><a href="game.php"></a></li>
     </ul>
    </div>
    
    <div class="font">
     <div><img src="images/font1.png"></div>
     <div><img src="images/font2.png"></div>
    </div>
    
   <div class="cloud">
       <div class="cloud_1"><img src="images/cloud_left.png"></div>
       <div class="cloud_2"><img src="images/cloud_left.png"></div>
   </div>
   
   <div class="banquan"></div>
    
  </div>
  
  

<input type="hidden" value="0" id="hidstart" />

<div class="flow"></div>
<script src="js/snowfall.jquery.js"></script> 
        <script>
            setTimeout(function () {
                $(document).snowfall('clear');
                $(document).snowfall({
                    image: "images/fower.png",
                    flakeCount: 10,
                    minSize: 10,
                    maxSize: 20
                });
            }, 10000)
</script>
</body>
</html>

<?php if($sld==2){ ?>
<script>
    $(".flg_menu ul li").siblings().removeClass("click_on");
    $(".flg_menu .pro").addClass("click_on");



    var div = $(".intro_bak");
      $(".shanzi").delay(1000).fadeIn(1000);
      //div.animate({ "left": 0, "opacity": "1" }, 2200);
      div.animate({
          width: '2px',
      }, 1);
      div.animate({
          height: '100%',
      }, 10);
      div.animate({
          left: '50%'
      }, 500);
      div.animate({
          width: '100%',
          left: '0',
          top: '0'
      }, "slow");


      setTimeout(function () {
          $(".active_bak").animate({ "left": "100%", "opacity": "1" }, 0);
      }, 2200)
     
      $(".shanzi").addClass("current");
      $(".active_bak").css({ "z-index": "999" });
      $(".intro_bak").css({ "z-index": "1000" });




</script>
<?php }else if($sld==3){ ?>
<script>
    


    $(".flg_menu ul li").siblings().removeClass("click_on");
    $(".flg_menu .active").addClass("click_on");


          var div = $(".active_bak");
          $(".shanzi").delay(1000).fadeOut(1000);
          //div.animate({ "left": 0, "opacity": "1" }, 2200)
          div.animate({ "left": 0, "opacity": "1" }, 300)
          div.animate({
              width: '2px',
          }, 1);
          div.animate({
              height: '100%',
          }, 10);
          div.animate({
              left: '50%'
          }, 500);
          div.animate({
              width: '100%',
              left: '0',
              top: '0'
          }, "slow");



          //画卷
          setTimeout(function () {
              $(".intro_bak").animate({ "left": "100%", "opacity": "1" }, 0);
          }, 1800);
          


          //画卷打开
          setTimeout(
                  function () {
                      $(".right").animate({ "width": "933px" }, 2000, function () {
                          $(".list li,.page").fadeIn(1000);
                          $(".fly").fadeIn(3000);
                      })
                  }
                  , 2000
              );
          $(".active_bak").css({ "z-index": "1000" });
          $(".intro_bak").css({ "z-index": "999" });
          $(".shanzi").removeClass("current");
          $(".wrap_img,.game_img").removeClass("current");


</script>
<?php } ?>


<script>

    $(".circles li:first-child").css("marginLeft","40px");


    $(".circles li:last").css("paddingRight","42px");
    

</script>



<script>
      $(".circles li").click(function(){
          $a=$(this).html();

          $('#syhd_all_ajax').css('display','none');

          $('#syhd_all_ajax').load('syhd_all_ajax.php',{page:$a},function(){


              $("#syhd_all_ajax").fadeIn(1500);

          });

      });

      $(".btn_l").click(function(){

          if(parseInt($('.cur').html())-1==0){
            $a=1;
          }else{
            $a=parseInt($('.cur').html())-1;
          }
          //alert($a);

          $('#syhd_all_ajax').css('display','none');


          $('#syhd_all_ajax').load('syhd_all_ajax.php',{page:$a},function(){

                $("#syhd_all_ajax").fadeIn(1500);

          });


      });
      $(".btn_r").click(function(){

          if(parseInt($('.cur').html())+1>$(".circles li").length){
            $a=$(".circles li").length;
          }else{
            $a=parseInt($('.cur').html())+1;
          }
          //alert($a);

          $('#syhd_all_ajax').css('display','none');

          $('#syhd_all_ajax').load('syhd_all_ajax.php',{page:$a},function(){

              $("#syhd_all_ajax").fadeIn(1500);

          });

      });


</script>

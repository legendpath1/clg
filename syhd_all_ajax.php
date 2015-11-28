<?php
include_once("include/init.php");
include_once("include/mysql.php");
include_once("include/lib_base.php");
require(ROOT_PATH."include/lib_page.php");
$mysql=new MySQL();
$mysql->connect();


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


            <?php 
                foreach($syhd_all as $rs){           	
            ?>
			  
			<li style="display: list-item;">
                 <div class="fly" style="display: block;" >
                     <div class="pic" width="72px" height="92px">
                         <img src="<?php echo $rs['pic']; ?>"/>
                      </div>
                     <div class="title">
                         <h2><img src="<?php echo $rs['title']; ?>" width="169px" height="28px" /></h2>
                         <a href="javascript:void(0)"  id='aa<?php echo $rs['id']; ?>' >
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

             <?php } ?>


    <script>
    	var $list = $(".list");
		var $listLis = $(".list li a span");
		var $tip = $(".tip");
		var $page = $(".page");
		var $clo = $(".tip .active_name .close");

	    // open det
		$listLis.click(function () {
		    $page.fadeOut(1000);
		    $list.fadeOut(1000);
		    $tip.delay(1000).fadeIn();
		    $(".game_img,.game_img").addClass("current");
		    $ddr='in';
		});
    </script>

            
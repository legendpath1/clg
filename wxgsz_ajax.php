<?php
include_once("include/init.php");
include_once("include/mysql.php");
include_once("include/lib_base.php");


require(ROOT_PATH."include/lib_page.php");
$mysql=new MySQL();
$mysql->connect();



if($_REQUEST['id']){

	$id=intval($_REQUEST['id']);
}
$wxgsz_detail=$db->get_one("select * from ".$db_prefix."wxgsz where id=".$id);


?>
<script>
	var $house = $(".qp,.hy,.cz,.js,.yl")
	var $houseimg = $(".qp img,.hy img,.cz img,.js img,.yl img")
	var $stages = $(".content .click i .det");
	var $jieshao = $(".jieshao");
	var $leave = $(".jieshao .close");
	var $bu = $(".bu");
	//close pro
	$leave.click(function(){
	    $jieshao.fadeOut(1000);
	    $bu.fadeOut(800);
	});
</script>


					<div class="pic">
                      <img src="images/bgt.png">
                    </div>
                    <div class="title">
						<img src="<?php echo $wxgsz_detail['title']; ?>" alt="">

                      <!-- <img src="images/jt.png"> -->
                    </div>
					<p style="line-height:198%"><?php echo sub_str2(nl2br($wxgsz_detail['content']),250,true); ?></p>
                    <!-- <p>我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍我是文字介绍</p> -->
                    <div class="close"></div>
                    <div class="go_game_l">
                      <!--<li><img src="images/ct.png"></li>
                      <li><img src="images/hy.png"></li>
                      <li><img src="images/js.png"></li>
                      <li><img src="images/yl.png"></li>
                      <li><img src="images/qp.png"></li>-->
                        <a href="<?php echo $wxgsz_detail['fileurl']; ?>" target="_blank"><img src="images/go_game_l.png" /></a>
                    </div>
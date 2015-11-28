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

$syhd_detail=$db->get_one("select * from ".$db_prefix."syhd where issue=1 and id=".$id);

?>
<style type="text/css">
.active_name .close_syhd{
	width:42px;
	height:50px;
	float:right;
	cursor: pointer;
}
</style>
<script>
	var $list = $(".list");
	var $tip = $(".tip");
	var $page = $(".page");
	var $clo = $(".tip .active_name .close_syhd");
	$(".wrap_img,.game_img").addClass("current");


	//  //close det
	$clo.click(function () {
		$ddr="out";
	    $(".wrap_img,.game_img").removeClass("current");
	    $list.delay(1000).fadeIn(1000);
	    $page.delay(1000).fadeIn(1000);
	    $tip.fadeOut();

    });

</script>

					 <div class="active_name">
	                      <h2>
	                          <img src="<?php echo $syhd_detail['title']; ?>" />
	                          <span class="close_syhd"><img src="images/clo.png" /></span>
	                      </h2>
	                  </div>
	                  <div class="project">
	                      <span class="wrap_img"><h2 class="game_img"><img src="<?php echo $syhd_detail['pic'];?>" /></h2></span>
	                      <div class="details" >
	                          <h3><img src="images/tit1.png" /></h3>
	                          <div style="line-height: 175%;margin-bottom: 10px;"><?php echo nl2br($syhd_detail['en_title']); ?></div>
	                          <h3><img src="images/tit2.png" /></h3>
							  <div style="line-height: 175%;margin-bottom: 10px;"><?php echo nl2br($syhd_detail['content']); ?></div>
	                         
	                          <a href="<?php echo $syhd_detail['fileurl']; ?>" class="enter"><img src="images/enter.png" /></a>
	                      </div>
                	  </div>



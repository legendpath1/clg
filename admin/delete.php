<?
include_once("include/init.php");
header("content-type:text/html;charset=utf-8");
$id=intval($_REQUEST['id']);
$page=intval($_REQUEST['page']);
$action=$_REQUEST['action'];
$lid=intval($_REQUEST['lid']);


if($action=='protype')
{
	$count=$db->counter($db_prefix."protype","parentid='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";

	}else{
		$count2=$db->counter($db_prefix."product","catid='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."protype where id = '$id'");
			admin_op_log('del','产品分类',$title);

			$db->query("delete from ".$db_prefix."protype where id='$id'");
			$msg = "删除成功!";

		}
	}
	showmessage($msg,"proClsList.php");
}

//删除页页配置
elseif($action=='pages')
{
	$title = $db->getOne("select title from ".$db_prefix."pages where id = '$id'");
	admin_op_log('del','配置信息',$title);

	$db->query("delete from ".$db_prefix."pages where id='$id'");
	showmessage("删除成功!","companyList.php?page=".$page);
}
//删除下载资源
elseif($action=='dhpt_xzwl')
{
	$title = $db->getOne("select title from ".$db_prefix."dhpt_xzwl where id = '$id'");
	admin_op_log('del','会员下载',$title);

	$db->query("delete from ".$db_prefix."dhpt_xzwl where id='$id'");
	showmessage("删除成功!","dhpt_wlxz_List.php?page=".$page);
}
//删除尚景之家
elseif($action=='sjzj')
{
	$title = $db->getOne("select title from ".$db_prefix."sjzj where id = '$id'");
	admin_op_log('del','尚景之家',$title);

	$db->query("delete from ".$db_prefix."sjzj where id='$id'");
	showmessage("删除成功!","sjzjList.php?page=".$page."&lid=".$lid);
}
elseif($action=='sjzj2')
{
	$title = $db->getOne("select title from ".$db_prefix."pton where id = '$id'");
	admin_op_log('del','尚景之家',$title);

	$db->query("delete from ".$db_prefix."pton where id='$id'");
	showmessage("删除成功!","pageList.php?page=".$page."&lid=".$lid);
}
elseif($action=='sjzj3')
{
	$title = $db->getOne("select title from ".$db_prefix."pton where id = '$id'");
	admin_op_log('del','尚景之家',$title);

	$db->query("delete from ".$db_prefix."pton where id='$id'");
	showmessage("删除成功!","mProductL.php?page=".$page."&lid=".$lid);
}
//删除页页配置
elseif($action=='imgs')
{
	$title = $db->getOne("select title from ".$db_prefix."imgs where id = '$id'");
	admin_op_log('del','配置信息',$title);
	$db->query("delete from ".$db_prefix."imgs where id='$id'");
	echo"<script>alert('删除成功!');
	window.location.href='imgsList.php?Result=add&id=$page';</script>";
}

//删除页页配置
elseif($action=='images')
{
	$title = $db->getOne("select title from ".$db_prefix."imgs where id = '$id'");
	admin_op_log('del','配置信息',$title);	
	$db->query("delete from ".$db_prefix."imgs where id='$id'");
	echo"<script>alert('删除成功!');
	window.location.href='clientsEdit.php?Result=modify&id=$page';</script>";
}
//删除页页配置
elseif($action=='serve')
{
	$title = $db->getOne("select title from ".$db_prefix."serve where id = '$id'");
	admin_op_log('del','客户服务',$title);

	$db->query("delete from ".$db_prefix."serve where id='$id'");
	showmessage("删除成功!","serveList.php?page=".$page);
}

//删除页页配置
elseif($action=='location')
{
	$title = $db->getOne("select title from ".$db_prefix."location where id = '$id'");
	admin_op_log('del','项目位置',$title);

	$db->query("delete from ".$db_prefix."location where id='$id'");
	showmessage("删除成功!","locationCategorys.php?page=".$page);
}

//删除页页配置
elseif($action=='detect')
{
	$title = $db->getOne("select title from ".$db_prefix."detect where id = '$id'");
	admin_op_log('del','配置信息',$title);

	$db->query("delete from ".$db_prefix."detect where id='$id'");
	showmessage("删除成功!","detectList.php?page=".$page);
}
//删除页页配置
elseif($action=='zhili')
{
	$title = $db->getOne("select title from ".$db_prefix."zhili where id = '$id'");
	admin_op_log('del','配置信息',$title);

	$db->query("delete from ".$db_prefix."zhili where id='$id'");
	showmessage("删除成功!","zhiliList.php?page=".$page);
}
//删除页页配置
elseif($action=='guangchumei')
{
	$title = $db->getOne("select title from ".$db_prefix."guangchumei where id = '$id'");
	admin_op_log('del','配置信息',$title);

	$db->query("delete from ".$db_prefix."guangchumei where id='$id'");
	showmessage("删除成功!","guangchumeiList.php?page=".$page);
}
//删除留言
elseif($action=='message')
{
	$db->query("delete from ".$db_prefix."message where id='$id'");
	showmessage("删除成功!","msgList.php?page=".$page);
}
//删除有奖调查
elseif($action=='prize')
{
	$db->query("delete from ".$db_prefix."prize where id='$id'");
	showmessage("删除成功!","prizeList.php?page=".$page);
}

//删除建议留言
elseif($action=='wenda')
{
	$db->query("delete from ".$db_prefix."wenda where id='$id'");
	showmessage("删除成功!","wdaList.php?page=".$page);
}
//删除加盟留言
elseif($action=='jiam')
{
	$db->query("delete from ".$db_prefix."jiam where id='$id'");
	showmessage("删除成功!","joinusList.php?page=".$page);
}
//删除公益录播留言
elseif($action=='gylb')
{
	$db->query("delete from ".$db_prefix."gylb where id='$id'");
	showmessage("删除成功!","gylbList.php?page=".$page);
}
//删除广告分类
elseif($action=="advtype")
{
	$count = $db->counter($db_prefix."adv","catid='$id'",'id');
	if($count){
		showmessage("删除失败，该类别下还有广告不能删除!","advClsList.php");
	}else{

		$title = $db->getOne("select title from ".$db_prefix."advtype where id = '$id'");
		admin_op_log('del','广告分类',$title);

		$db->query("delete from ".$db_prefix."advtype where id=$id");
		showmessage("删除成功!","advClsList.php");
	}
}
//删除广告
elseif($action=="adv")
{
	showmessage("大图banner不能删除!","advList.php?page=".$page);
}
//删除首页图分类
elseif($action=="indexype")
{
	$count = $db->counter($db_prefix."adv","catid='$id'",'id');
	if($count){
		showmessage("删除失败，该类别下还有广告不能删除!","advClsList.php");
	}else{

		$title = $db->getOne("select title from ".$db_prefix."advtype where id = '$id'");
		admin_op_log('del','广告分类',$title);

		$db->query("delete from ".$db_prefix."advtype where id=$id");
		showmessage("删除成功!","advClsList.php");
	}
}
//删除首页图
elseif($action=="index")
{
	//删除首页图片
	$img = $db->getOne("select pic from ".$db_prefix."index_pic where catid=11&&id='$id'");
	if(!empty($img)){
		@unlink(ROOT_PATH.ADV_IMG_DIR.$img);
	}
	$title = $db->getOne("select title from ".$db_prefix."index_pic where catid=11&&id='$id'");
	admin_op_log('del','图片',$title);

	$db->query("delete from ".$db_prefix."index_pic where catid=11&&id=$id");
	showmessage("删除成功!","index_picList.php?page=".$page);
}
elseif($action=="index2")
{
	//删除首页图片
	$img = $db->getOne("select pic from ".$db_prefix."index_pic where catid=13&&id='$id'");
	if(!empty($img)){
		@unlink(ROOT_PATH.ADV_IMG_DIR.$img);
	}
	$title = $db->getOne("select title from ".$db_prefix."index_pic where catid=13&&id = '$id'");
	admin_op_log('del','图片',$title);

	$db->query("delete from ".$db_prefix."index_pic where catid=13&&id=$id");
	showmessage("删除成功!","index_picList2.php?page=".$page);
}
elseif($action=="index3")
{
	//删除首页图片
	$img = $db->getOne("select pic from ".$db_prefix."index_pic where catid=15&&id='$id'");
	if(!empty($img)){
		@unlink(ROOT_PATH.ADV_IMG_DIR.$img);
	}
	$title = $db->getOne("select title from ".$db_prefix."index_pic where catid=15&&id = '$id'");
	admin_op_log('del','图片',$title);

	$db->query("delete from ".$db_prefix."index_pic where catid=15&&id=$id");
	showmessage("删除成功!","index_picList3.php?page=".$page);
}

//删除新闻中心
elseif($action=='newscenterdel'){ 
	//删除图片
	$img = $db->getOne("select index_pic from ".$db_prefix."newscenter where id='$id'");


	if(!empty($img)){

		//echo ROOT_PATH.$img;
		//@unlink(ROOT_PATH.ADV_IMG_DIR.$img);
	}
	$title = $db->getOne("select ad_name from ".$db_prefix."newscenter where id = '$id'");
	admin_op_log('del','新闻',$title);



	$catid = $db->getOne("select catid as a from ".$db_prefix."newscenter where id = '$id'");

	$catid=$catid[a];

	$db->query("delete from ".$db_prefix."newscenter where id=$id");


	showmessage("删除成功!","newsCenterList.php?catid=".$catid."&page=".$page);

}




//删除广告
elseif($action=="imgs")
{
	//删除广告图片
	$img = $db->getOne("select pic from ".$db_prefix."imgs where id='$id'");
	if(!empty($img)){
		@unlink(ROOT_PATH.ADV_IMG_DIR.$img);
	}
	$title = $db->getOne("select title from ".$db_prefix."imgs where id = '$id'");
	admin_op_log('del','图片',$title);

	$db->query("delete from ".$db_prefix."imgs where id=$id");
	showmessage("删除成功!","imgsList.php?page=".$page);
}
//删除文章大类
elseif($action=='newsBigClass')
{
	$count=$db->counter($db_prefix."newssmallclass","big_id='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$count2=$db->counter($db_prefix."news","big_id='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."newsclass where id = '$id'");
			admin_op_log('del','文章大类',$title);

			$db->query("delete from ".$db_prefix."newsclass where id='$id'");
			$msg="删除成功!";
		}
	}
	showmessage($msg,"newsCategorys.php");
}
//删除文章小类
elseif($action=='newsSmallClass')
{
	$count=$db->counter($db_prefix."newsthreeclass","small_id='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$count2=$db->counter($db_prefix."news","small_id='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."newssmallclass where id = '$id'");
			admin_op_log('del','文章小类',$title);

			$db->query("delete from ".$db_prefix."newssmallclass where id='$id'");
			$msg="删除成功!";
		}
	}
	showmessage($msg,"newsCategorys.php");
}
//删除文章第三类
elseif($action=='newsThreeClass')
{
	$count2=$db->counter($db_prefix."news"," three_id='$id'",'id');
	if($count2){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$title = $db->getOne("select title from ".$db_prefix."newsthreeclass where id = '$id'");
		admin_op_log('del','文章第三类',$title);

		$db->query("delete from ".$db_prefix."newsthreeclass where id='$id'");
		$msg="删除成功!";
	}
	showmessage($msg,"newsCategorys.php");
}
//删除产品大类
elseif($action=='worksClass')
{
	$count=$db->counter($db_prefix."workssmallclass","big_id='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$count2=$db->counter($db_prefix."works","big_id='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."worksclass where id = '$id'");
			admin_op_log('del','作品大类',$title);

			$db->query("delete from ".$db_prefix."worksclass where id='$id'");
			$msg="删除成功!";
		}
	}
	showmessage($msg,"worksCategorys.php");
}
//删除产品小类
elseif($action=='proSmallClass')
{
	$count=$db->counter($db_prefix."prothreeclass","small_id='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$count2=$db->counter($db_prefix."product","small_id='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."prosmallclass where id = '$id'");
			admin_op_log('del','礼品小类',$title);

			$db->query("delete from ".$db_prefix."prosmallclass where id='$id'");
			$msg="删除成功!";
		}
	}
	showmessage($msg,"proCategorys.php");
}
//删除产品第三类
elseif($action=='proThreeClass')
{
	$count2=$db->counter($db_prefix."product"," three_id='$id'",'id');
	if($count2){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$title = $db->getOne("select title from ".$db_prefix."prothreeclass where id = '$id'");
		admin_op_log('del','礼品第三类',$title);

		$db->query("delete from ".$db_prefix."prothreeclass where id='$id'");
		$msg="删除成功!";
	}
	showmessage($msg,"proCategorys.php");
}
//删除产品大类
elseif($action=='teamBigClass')
{
	$count=$db->counter($db_prefix."teamsmallclass","big_id='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$count2=$db->counter($db_prefix."team","big_id='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."teamclass where id = '$id'");
			admin_op_log('del','活动团队大类',$title);

			$db->query("delete from ".$db_prefix."teamclass where id='$id'");
			$msg="删除成功!";
		}
	}
	showmessage($msg,"teamCategorys.php");
}
//删除售后服务
elseif($action=="afservice")
{
	
	$title = $db->getOne("select title from ".$db_prefix."afservice where id='$id'");

	$big_id=$db->getOne("select big_id  from ".$db_prefix."afservice where id='$id'");

	admin_op_log('del','售后服务',$title);

	$db->query("delete from ".$db_prefix."afservice where id=$id");
	showmessage("删除成功!","afserviceMsgList.php?big_id=$big_id and page=".$page);
}

//删除产品小类
elseif($action=='teamSmallClass')
{
	$count=$db->counter($db_prefix."teamthreeclass","small_id='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$count2=$db->counter($db_prefix."team","small_id='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."teamsmallclass where id = '$id'");
			admin_op_log('del','活动团队小类',$title);

			$db->query("delete from ".$db_prefix."teamsmallclass where id='$id'");
			$msg="删除成功!";
		}
	}
	showmessage($msg,"teamCategorys.php");
}
//删除产品第三类
elseif($action=='teamThreeClass')
{
	$count2=$db->counter($db_prefix."team"," three_id='$id'",'id');
	if($count2){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$title = $db->getOne("select title from ".$db_prefix."teamthreeclass where id = '$id'");
		admin_op_log('del','活动团队第三类',$title);

		$db->query("delete from ".$db_prefix."teamthreeclass where id='$id'");
		$msg="删除成功!";
	}
	showmessage($msg,"teamCategorys.php");
}
//删除文章分类
elseif($action=='newstype')
{
	$count=$db->counter($db_prefix."newstype","parentid='$id'",'id');
	if($count){
		$msg = "删除失败，该类别下还有子类不能删除!";
	}else{
		$count2=$db->counter($db_prefix."news","catid='$id'",'id');
		if($count2){
			$msg = "删除失败，该类别下还有子类不能删除!";
		}else{
			$title = $db->getOne("select title from ".$db_prefix."newstype where id = '$id'");
			admin_op_log('del','文章分类',$title);

			$db->query("delete from ".$db_prefix."newstype where id='$id'");
			$msg="删除成功!";
		}
	}
	showmessage($msg,"newsClsList.php");
}


//删除客户案例
elseif($action=="clients")
{
	$img=$db->getOne("select pic from ".$db_prefix."clients where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.NEWS_IMG_DIR.$img);
	}
	$title = $db->getOne("select title from ".$db_prefix."clients where id = '$id'");
	admin_op_log('del','客户案例',$title);

	$db->query("delete from ".$db_prefix."clients where id='$id'");
	showmessage("删除成功!","clientsList.php?page=".$page);
}

//删除文章
elseif($action=="news")
{
	$img=$db->getOne("select pic from ".$db_prefix."news where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.NEWS_IMG_DIR.$img);
	}
	$title = $db->getOne("select title from ".$db_prefix."news where id = '$id'");
	admin_op_log('del','文章',$title);

	$db->query("delete from ".$db_prefix."news where id='$id'");
	showmessage("删除成功!","newsList.php?page=".$page);
}
elseif($action=="news6")
{
	$img=$db->getOne("select pic from ".$db_prefix."news6 where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.NEWS_IMG_DIR.$img);
	}
	$title = $db->getOne("select title from ".$db_prefix."news6 where id = '$id'");
	admin_op_log('del','文章',$title);

	$db->query("delete from ".$db_prefix."news6 where id='$id'");
	showmessage("删除成功!","newsList5.php?page=".$page);
}
//删除作品
elseif($action=="works")
{
	$img=$db->getOne("select pic from ".$db_prefix."works where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.PRODUCT_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."works where id = '$id'");
	admin_op_log('del','作品',$title);

	$db->query("delete from ".$db_prefix."works where id='$id'");
	showmessage("删除成功!","worksList.php?page=".$page);
}
elseif($action=="works2")
{
	$img=$db->getOne("select pic from ".$db_prefix."abppxx where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.PRODUCT_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."abppxx where id = '$id'");
	admin_op_log('del','作品',$title);

	$db->query("delete from ".$db_prefix."abppxx where id='$id'");
	showmessage("删除成功!","ab_ppxx_List.php?page=".$page);
}
elseif($action=="works3")
{
	$img=$db->getOne("select pic from ".$db_prefix."czzs where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.PRODUCT_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."czzs where id = '$id'");
	admin_op_log('del','作品',$title);

	$db->query("delete from ".$db_prefix."czzs where id='$id'");
	showmessage("删除成功!","czzsList.php?page=".$page);
}



//clg   首页活动
elseif($action=="syhd"){

	$img=$db->getOne("select pic from ".$db_prefix."syhd where id='$id'");

	$img_title=$db->getOne("select title from ".$db_prefix."syhd where id='$id'");

	if(!empty($img))
	{
		@unlink(ROOT_PATH.$img);
	}

	if(!empty($img_title))
	{
		@unlink(ROOT_PATH.$img_title);
	}




	$title = $db->getOne("select title from ".$db_prefix."syhd where id = '$id'");
	admin_op_log('del','首页活动',$title);

	$db->query("delete from ".$db_prefix."syhd where id='$id'");
	showmessage("删除成功!","syhdList.php?page=".$page);

}



//首页解决方案
elseif($action=="jjfa")
{
	

	$title = $db->getOne("select title from ".$db_prefix."jjfa where id = '$id'");
	admin_op_log('del','首页解决方案',$title);

	$db->query("delete from ".$db_prefix."jjfa where id='$id'");
	showmessage("删除成功!","jjfa_sy_List.php?page=".$page);
}






//文档
elseif($action=="document")
{
	$img=$db->getOne("select pic from ".$db_prefix."document where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.PRODUCT_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."document where id = '$id'");
	admin_op_log('del','文档',$title);

	$db->query("delete from ".$db_prefix."document where id='$id'");
	showmessage("删除成功!","documentList.php?page=".$page);
}

//尾部导航栏
elseif($action=="dolink")
{
	
	$title = $db->getOne("select title from ".$db_prefix."dolink where id = '$id'");
	admin_op_log('del','导航栏',$title);


	//首级导航栏
	$db->query("delete from ".$db_prefix."dolink where id='$id'");


	//次级导航栏
	$db->query("delete from ".$db_prefix."dolink where catid='$id'");

	showmessage("删除成功!","dolinkList.php?page=".$page);
}



//尾部次级导航栏

elseif($action=='dolink2')




{
	


	$ab = $db->get_one("select * from ".$db_prefix."dolink where id = '$id'");

	
	admin_op_log('del','尾部次级导航栏',$ab['id']);


	//次级导航栏
	$db->query("delete from ".$db_prefix."dolink where id='$id'");


	

	showmessage("删除成功!","dolinkchildList.php?catid=".$ab['catid']."&page=".$page);
}





elseif($action=="zpxx")
{
	$img=$db->getOne("select pic from ".$db_prefix."zhaop where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.PRODUCT_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."zhaop where id = '$id'");
	admin_op_log('del','作品',$title);

	$db->query("delete from ".$db_prefix."zhaop where id='$id'");
	showmessage("删除成功!","zpList.php?page=".$page);
}

elseif($action=='personnel'){
	$title = $db->getOne("select title from ".$db_prefix."personnel where id = '$id'");
	admin_op_log('del','人才招聘',$title);

	$db->query("delete from ".$db_prefix."personnel where id='$id'");
	showmessage("删除成功!","personnelList.php?page=".$page);

}



elseif($action=='companybeneList'){
	$title = $db->getOne("select title from ".$db_prefix."personnel where id = '$id'");
	admin_op_log('del','公司福利',$title);

	$db->query("delete from ".$db_prefix."personnel where id='$id'");
	showmessage("删除成功!","companybeneList.php?page=".$page);

}







//用户
elseif($action=="user")
{
	$img=$db->getOne("select pic from ".$db_prefix."user where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.PRODUCT_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."user where id = '$id'");
	admin_op_log('del','作品',$title);

	$db->query("delete from ".$db_prefix."user where id='$id'");
	showmessage("删除成功!","userList.php?page=".$page);
}
//下载
elseif($action=="dnl")
{
	$img=$db->getOne("select pic from ".$db_prefix."dnl where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.PRODUCT_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."dnl where id = '$id'");
	admin_op_log('del','作品',$title);

	$db->query("delete from ".$db_prefix."dnl where id='$id'");
	showmessage("删除成功!","downloadList.php?page=".$page);
}
//删除手稿
elseif($action=="manu")
{
	$img=$db->getOne("select pic from ".$db_prefix."manu where id='$id'");
	if(!empty($img))
	{
		@unlink(ROOT_PATH.CLIENTS_IMG_DIR.$img);
	}

	$title = $db->getOne("select title from ".$db_prefix."manu where id = '$id'");
	admin_op_log('del','手稿',$title);

	$db->query("delete from ".$db_prefix."manu where id='$id'");
	showmessage("删除成功!","manuList.php?page=".$page);
}


elseif($action=="service")
{
  //$img=$db->getOne("select pic from ".$db_prefix."news where id='$id'");
  //if(!empty($img))
  //{
  //  @unlink(ROOT_PATH.NEWS_IMG_DIR.$img);
 // }
  $title = $db->getOne("select title from ".$db_prefix."news where id = '$id'");
  admin_op_log('del','服务内容',$title);

  $db->query("delete from ".$db_prefix."news where id='$id'");
  showmessage("删除服务内容成功!","serviceList.php?page=".$page);
}


elseif($action=="seo")
{
  $title = $db->getOne("select title from ".$db_prefix."seo where id = '$id'");
  admin_op_log('del','seo',$title);
  $db->query("delete from ".$db_prefix."seo where id='$id'");
  showmessage("删除seo成功!","seoList.php");
}

//删除权限配置
elseif($action=='powerList')
{
	$db->query("delete from ".$db_prefix."admin_power where power_id='$id'");
	showmessage("删除成功!","powerList.php");
}
//删除管理用户
elseif($action=='admin')
{
	$db->query("delete from ".$db_prefix."admin where admin_id='$id'");
	showmessage("删除成功!","adminList.php");
}
//删除用户
elseif($action=='client')
{
	$db->query("delete from ".$db_prefix."client where admin_id='$id'");
	showmessage("删除成功!","clientList.php");
}
//删除友情链接
elseif($action=='link')
{
	$img = $db->getOne("select pic from ".$db_prefix."link where id='$id'");
		if(!empty($img)){
			@unlink(ROOT_PATH.LINK_IMG_DIR.$img);
		}
	$title = $db->getOne("select title from ".$db_prefix."link where id = '$id'");
	admin_op_log('del','友情链接',$title);

	$db->query("delete from ".$db_prefix."link where id='$id'");
	showmessage("删除成功！","linkList.php?page=".$page);
}
//删除头部大图
elseif($action=='banner')
{
	$img = $db->getOne("select pic from ".$db_prefix."banner where id='$id'");
		if(!empty($img)){
			@unlink(ROOT_PATH.LINK_IMG_DIR.$img);
		}
	$title = $db->getOne("select title from ".$db_prefix."banner where id = '$id'");
	admin_op_log('del','头部大图',$title);

	$db->query("delete from ".$db_prefix."banner where id='$id'");
	showmessage("删除成功！","bannerList.php?page=".$page);
}
//删除金牌客户
elseif($action=='kehu')
{
	$img = $db->getOne("select pic from ".$db_prefix."kehu where id='$id'");
		if(!empty($img)){
			@unlink(ROOT_PATH.LINK_IMG_DIR.$img);
		}
	$title = $db->getOne("select title from ".$db_prefix."kehu where id = '$id'");
	admin_op_log('del','金牌客户',$title);

	$db->query("delete from ".$db_prefix."kehu where id='$id'");
	showmessage("删除成功！","kehuList.php?page=".$page);
}
//删除投票
elseif($action=='voteCls')
{
	$db->query("delete from ".$db_prefix."vote where parentid='$id'");
	$db->query("delete from ".$db_prefix."vote where id='$id'");
	showmessage("删除成功！","voteList.php");
}
//删除投票
elseif($action=='svote')
{
	$db->query("delete from ".$db_prefix."vote where id='$id'");
	showmessage("删除成功！","voteList.php");
}
//删除自定义导航栏
elseif($action=='nav')
{
  $db->query("delete from ".$db_prefix."nav where id='$id'");
  showmessage("删除导航栏成功！","navList.php?page=".$page);
}

elseif($action=='abppxx')
{
  $db->query("delete from ".$db_prefix."abppxx where id='$id'");
  showmessage("删除导航栏成功！","ab_ppxx_List.php?page=".$page);
}

elseif($action=='client')
{
  $db->query("delete from ".$db_prefix."client where id='$id'");
  showmessage("删除导航栏成功！","clientList.php?page=".$page);
}

elseif($action=='dhpt')
{
  $db->query("delete from ".$db_prefix."dhpt where id='$id'");
  showmessage("删除成功！","dhpt_List.php?page=".$page);
}

elseif($action=='dhpt')
{
  $db->query("delete from ".$db_prefix."dhpt where id='$id'");
  showmessage("删除成功！","dhpt_List.php?page=".$page);
}

elseif($action=='dhpt_cpxh')
{
  $db->query("delete from ".$db_prefix."dhpt_cpxh where id='$id'");
  showmessage("删除成功！","dhpt_cpxhList.php?page=".$page);
}

elseif($action=='khjz')
{
  $db->query("delete from ".$db_prefix."khjz where id='$id'");
  showmessage("删除成功！","khjz_List.php?page=".$page);
}

elseif($action=='zxdt')
{
  $db->query("delete from ".$db_prefix."zxdt where id='$id'");
  showmessage("删除成功！","zxdt_List.php?page=".$page);
}
elseif($action=='syjc')
{
  $db->query("delete from ".$db_prefix."shiyon where id='$id'");
  showmessage("删除成功！","scList.php?page=".$page);
}
elseif($action=='dexw')
{
  $db->query("delete from ".$db_prefix."news where id='$id'");
  showmessage("删除成功！","newsList.php?page=".$page);
}
elseif($action=='documentdel')
{
  $db->query("delete from ".$db_prefix."document where id='$id'");
  showmessage("删除成功！","documentList.php?page=".$page);
}

elseif($action=='videodel')
{
  $db->query("delete from ".$db_prefix."video where id='$id'");
  showmessage("删除成功！","videoList.php?page=".$page);
}

elseif($action=='spzx')
{
  $db->query("delete from ".$db_prefix."spzx where id='$id'");
  showmessage("删除成功！","spzx_List.php?page=".$page);
}

elseif($action=='nxxy')
{
  $db->query("delete from ".$db_prefix."nxxy where id='$id'");
  showmessage("删除成功！","nxxy_List.php?page=".$page);
}


?>


<?php
 header("content-type:text/html;charset=utf-8");
class cutpage{

	//@ $page=$_GET['page'];
	//if(($page=="")|($page==0)){
	//$page=1;
	//}
	
	function article_addpage($article,$word_number=2000)
	{
	//===本函数的作用是按照字节数给文章增加分页代码
	//作者:www.52link.net 叶藤
	//QQ：383569
	//演示效果： www.52fengshou.cn
	//本程序为共享程序，请尊重作者劳动和版权法，任何人不得将此程序用于商业
	//转载、发布本程序，请务必保留作者版权信息,请支持原创
	//部分变量说明：
	//$art_num 确定段落数
	//$artinfo[$i] 段落内容
	//$page_num_word[$i] 段落字节
	//$word_number每段字数
	//$weor_cha=浮动字数
	$con = explode("<table",$article);
	if (count($con)>1){
	return $article; //如果包含了表格就跳过，不进行分页处理
	}else{
	$word_all="";
	$word_num=0;
	$n="";
	$weor_cha=($word_number/10);//(上下浮动每页字数的10%)
	  $article=preg_replace("/<div(.*?)>/m", "<br>",  $article);
	  $article= str_replace("</div>","",  $article);
	 // $article=preg_replace("/<span(.*?)>/m", "<br>",  $article);
	 // $article= str_replace("</span>","",  $article);
	 // $article=preg_replace("/<p(.*?)>/m", "<br>",  $article);
	//  $article= str_replace("</p>","",  $article);
	 // $article= str_replace(chr(10),"<br>",  $article);
	 // $article=preg_replace("/<(.*?)<br>(.*?)>/m", "<\\1 \\2>",  $article);
	  $artinfo=split("<br>",$article);//根据字符串确定段落
	
	  $art_num=count($artinfo);//确定段落数
	$page_num_word=array();
	
	  for($i=0;$i<=$art_num-1;$i++)
		{
		 $page_num_word[$i]=strlen($artinfo[$i]);
		 $word_num=$word_num+$page_num_word[$i];//得到字数
	
	if ($word_num-$weor_cha<=$word_number or $i==0){
	$word_all.=$artinfo[$i]."<br>";
	}else{
	
	$word_all.="[nextpage]<br>".$artinfo[$i];
	$word_num=0;
	}
		 }
	
	return $word_all; 
	
		  }//=========if 表格
	}
	
	
	function article_fenpage($article,$id,$page,$url)
	{
	
	  $artinfo=explode("[nextpage]",$article);//根据字符串确定段落
	  $pages=count($artinfo);//确定段落数
	  $tempurla="";
	  $fenyedh="";

	 // echo $pages;
	//=======================================分页导航
				//显示总页数
	if ($pages > 1)
	{
		$fenyedh="";
		$fenyedh= $fenyedh."<div class='page'>";
		//$fenyedh= $fenyedh."<div align='center'>共有".$pages."页 ";
		$substart=$page-10;
		$sybend=$page+10;
		if ($substart<=1 ){
		$substart=1;
		}
		if ($sybend>=$pages ){
		$sybend=$pages;
		}
		//显示分页数
		$first=1;
		$prev=$page-1;
		if($prev==0) $prev=1;
		$next=$page+1;
		if($next>$pages)
		{
			$next=$pages;
		}
		
		$last=$pages;
	
		//$fenyedh= $fenyedh."<a href='$url-".$id."-1.html'>第一页</a> ";
		$fenyedh= $fenyedh."<a href='$url-".$id."-".$prev.".html'>上一页</a>";
		for ($i=$substart;$i<$page;$i++){
		$fenyedh= $fenyedh."<a href='$url-".$id."-".$i.".html'>[".$i."]</a>";
		}
		$fenyedh= $fenyedh."<font style='color:red'>[".$page."]</font>";
		for ($i=$page+1;$i<=$sybend;$i++){
			$fenyedh= $fenyedh."<a href='$url-".$id."-".$i.".html'>[".$i."]</a>";
			}
		$fenyedh= $fenyedh."<a href='$url-".$id."-".$next.".html'>下一页</a> ";
		//$fenyedh= $fenyedh."<a href='$url-".$id."-".$last.".html'>最后一页</a>";
		$fenyedh= $fenyedh."</div>";
		}
		//=======================================分页导航end
		return $artinfo[$page-1]."<br>".$fenyedh; 
	}

}

?>


<?
include_once("include/init.php");

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	set_time_limit("60000");

	$siteurl = $_CFG['site_url'];
	if(substr($siteurl,-1,1) != '/'){
	  $siteurl .= '/';
	}

	$save = $_REQUEST['save'];
 	switch ($save)
	{

		case "index":
		{
			phpToHtml(lyhwebroot."index.php","index.html");
			showmessage('生成成功');
			break;
		}

		//生成单页
		case "other":
		{
			$ca_result = $db->query("select id,fileurl from ".$db_prefix."pages where issue=1");
			if ($db->num_rows($ca_result)>0){
				while($ca_list  = $db->fetch_array($ca_result)){
				  $paths = explode('.', $ca_list['fileurl']);
				  phpToHtml(lyhwebroot."info.php?id=".$ca_list['id'], 'index.html', $paths[0]);
			 }
			}
			 phpToHtml(lyhwebroot."sitemap.php","sitemap.html");
			 phpToHtml(lyhwebroot."links.php","links.html");
			 showmessage('生成成功');
			 break;
		}

    //生成主题婚礼
		case "wedding":
		  {
		    $qeury = $db->query("select fileurl,id from ".$db_prefix."news where big_id = 3 order by hit desc");
		    if($db->num_rows($qeury)){
		       $i=1;
		      while ($list = $db->fetch_object($qeury)){
            phpToHtml(lyhwebroot.'wedding.php?id='.$list->id, $list->fileurl,'wedding');
            if($i==1){
              copy(ROOT_PATH.'wedding/'.$list->fileurl, ROOT_PATH.'wedding/index.html');
            }
            $i++;
		      }
		    }
		    showmessage('生成主题婚礼成功!');
        break;
		  }

	    case "planList":
      {
        $pagesize = 5;
        $counter = $db->counter($db_prefix."news",'big_id=2 and issue=1');
      $totalpages=ceil($counter/$pagesize) ? ceil($counter/$pagesize) : 1;
      if($counter>0){
        for($k=1;$k<=$totalpages;$k++)
        {
            phpToHtml(lyhwebroot.'plan.php?page='.$k, 'index-'.$k.'.html','plan');
            if($k==1){
              copy(ROOT_PATH.'plan/index-1.html', ROOT_PATH.'plan/index.html');
            }
            $k++;
          }
        }else{
           phpToHtml(lyhwebroot.'plan.php', 'index.html','plan');
        }

       $ca_result = $db->query("select id,fileurl from ".$db_prefix."news where big_id = 2 and  issue=1");
      if ($db->num_rows($ca_result)>0)
      {
         while($rs  = $db->fetch_array($ca_result))
         {
            phpToHtml(lyhwebroot."plan_view.php?id=".$rs['id'], $rs['fileurl'], 'plan');
         }
        }

        showmessage('生成婚庆策划成功!');
        break;
      }

	    //生成婚礼资讯
    case "newsList":
    {
      $pagesize = 15;
//      $big_file_name1 = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = 1");
//      $big_file_name_4 = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id = 4");
//      $file_name_4 = explode(".", $big_file_name_4);
//      $big_file_name_5 = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id = 5");
//      $file_name_5 = explode(".", $big_file_name_5);
//      $big_file_name = explode(".", $big_file_name1);
//      $file_name = $big_file_name[0] .'/'. $file_name_4[0];
//      $file_name2 = $big_file_name[0] .'/'. $file_name_5[0];

      $counter = $db->counter($db_prefix."news",'small_id=4 and issue=1');
      $totalpages=ceil($counter/$pagesize) ? ceil($counter/$pagesize) : 1;
      if($counter>0){
        for($k=1;$k<=$totalpages;$k++)
        {
          if ($k==1){
            phpToHtml(lyhwebroot."news.php?ordby=".$ordby."&cid=1&sid=4&page=".$k."&page2=1", "index.html", 'news');
            copy(ROOT_PATH."news/index.html", ROOT_PATH."news/index-1-1.html");
          }else{
            phpToHtml(lyhwebroot."news.php?ordby=".$ordby."&cid=1&sid=4&page=".$k."&page2=1", "index-".$k."-1.html", 'news');
          }
        }
      }else{
        phpToHtml(lyhwebroot."news.php?ordby=".$ordby."&cid=1&sid=4&page=1&page2=1", "index.html",  'news');
      }

      //第二个
      $counter1 = $db->counter($db_prefix."news",'small_id=5 and issue=1');
      $totalpages1=ceil($counter/$pagesize) ? ceil($counter/$pagesize) : 1;
      if($counter1>0){
        for($k=1;$k<=$totalpages1;$k++)
        {
            phpToHtml(lyhwebroot."news.php?ordby=".$ordby."&cid=1&sid=5&page=1&page2=".$k, "index-1-".$k.".html",  'news');

        }
      }

      //生成列表
    $ca_result = $db->query("select id,fileurl,small_id,big_id from ".$db_prefix."news where big_id = 1 and  issue=1");
      if ($db->num_rows($ca_result)>0)
      {
         while($rs  = $db->fetch_array($ca_result))
         {
          //$big_file_name = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = " . $rs['big_id']);
          //  $big_file_name_1 = explode(".", $big_file_name);
            $file_name = 'news';
            if($rs['small_id']){
              $small_file_name = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id = " . $rs['small_id']);
              $small_file_name_1 = explode(".", $small_file_name);
              $file_name .= '/'. $small_file_name_1[0];
            }
            phpToHtml(lyhwebroot."news_view.php?id=".$rs['id'], $rs['fileurl'], $file_name);
         }
        }

       showmessage('生成婚礼资讯成功!');
      break;
    }

	    //生成婚庆作品
    case "worksList":
    {
       $pagesize = 5;
       $result = $db->query("select id,fileurl,big_id from ".$db_prefix."newssmallclass where big_id = 5");
       if ($db->num_rows($result)>0)
        {
          while($rs  = $db->fetch_array($result))
         {
          // $big_file_name = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = " . $rs['big_id']);
          $big_file_name_1 = explode(".", $rs['fileurl']);
          $file_name = 'works/'.$big_file_name_1[0];
          $counter = $db->counter($db_prefix."news",'small_id='.$rs['id'].' and issue=1');
          $rs[totalpages]=ceil($counter/$pagesize) ? ceil($counter/$pagesize) : 1;
          if($counter>0){
            for($k=1;$k<=$rs[totalpages];$k++)
            {
              if ($k==1){
                phpToHtml(lyhwebroot."works.php?ordby=".$ordby."&sid=".$rs['id']."&page=".$k, "index.html", $file_name);
                copy(ROOT_PATH.$file_name."/index.html", ROOT_PATH.$file_name."/index-1.html");
                copy(ROOT_PATH.$file_name."/index.html", ROOT_PATH."works/index.html");
              }else{
                phpToHtml(lyhwebroot."works.php?ordby=".$ordby."&sid=".$rs['id']."&page=".$k, "index-".$k.".html", $file_name);
              }
            }
          }else{
            phpToHtml(lyhwebroot."works.php?ordby=".$ordby."&sid=".$rs['id'], "index.html", $file_name);
          }
        }
       }

      //生成列表
    $ca_result = $db->query("select id,fileurl,small_id,big_id from ".$db_prefix."news where big_id = 5 and  issue=1");
      if ($db->num_rows($ca_result)>0)
      {
         while($rs  = $db->fetch_array($ca_result))
         {
          //$big_file_name = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = " . $rs['big_id']);
          //  $big_file_name_1 = explode(".", $big_file_name);
            $file_name = 'works';
            if($rs['small_id']){
              $small_file_name = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id = " . $rs['small_id']);
              $small_file_name_1 = explode(".", $small_file_name);
              $file_name .= '/'. $small_file_name_1[0];
            }
            phpToHtml(lyhwebroot."works_view.php?id=".$rs['id'], $rs['fileurl'], $file_name);
         }
        }

       showmessage('生成婚庆作品成功!');
      break;
    }


      //生成婚庆服务
    case "serviceList":
    {
       $pagesize = 5;
       $result = $db->query("select id,fileurl,big_id from ".$db_prefix."newssmallclass where big_id = 4");
       if ($db->num_rows($result)>0)
        {
          $j=1;
          while($rs  = $db->fetch_array($result))
         {
          // $big_file_name = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = " . $rs['big_id']);
          $big_file_name_1 = explode(".", $rs['fileurl']);
          $file_name = 'service/'.$big_file_name_1[0];

          //第三类
          $squery = $db->query("select fileurl,id from ".$db_prefix."newsthreeclass where small_id=".$rs['id']." order by stor asc, id desc");
          if($db->num_rows($squery)){
            while ($slist = $db->fetch_array($squery)){
              $scounter = $db->counter($db_prefix."news",'small_id='.$rs['id'].' and three_id = '.$slist['id'].' and issue=1');
              $tfileurl = explode('.', $slist['fileurl']);
              $tfile_path = $file_name.'/'.$tfileurl[0];
              $stotalpages=ceil($scounter/$pagesize) ? ceil($scounter/$pagesize) : 1;
              if($scounter>0){
                for($k=1;$k<=$stotalpages;$k++)
                {
                  if ($k==1){
                    phpToHtml(lyhwebroot."service.php?ordby=".$ordby."&sid=".$rs['id']."&tid=".$slist['id']."&page=".$k, "index.html", $tfile_path);
                    copy(ROOT_PATH.$tfile_path."/index.html", ROOT_PATH.$tfile_path."/index-1.html");
                    copy(ROOT_PATH.$tfile_path."/index.html", ROOT_PATH.$file_name."/index.html");
                    if($j==1){
                      copy(ROOT_PATH.$tfile_path."/index.html", ROOT_PATH."service/index.html");
                    }
                  }else{
                    phpToHtml(lyhwebroot."service.php?ordby=".$ordby."&sid=".$rs['id']."&tid=".$slist['id']."&page=".$k, "index-".$k.".html", $tfile_path);
                  }
                  $j++;
                }
              }else{
                 phpToHtml(lyhwebroot."service.php?ordby=".$ordby."&sid=".$rs['id']."&tid=".$slist['id'], "index.html", $tfile_path);
                 copy(ROOT_PATH.$tfile_path."/index.html", ROOT_PATH.$file_name."/index.html");
              }
            }
          }
          //只有第二类
          else{
            $counter = $db->counter($db_prefix."news",'small_id='.$rs['id'].' and issue=1');
            $rs[totalpages]=ceil($counter/$pagesize) ? ceil($counter/$pagesize) : 1;
            if($counter>0){
              for($k=1;$k<=$rs[totalpages];$k++)
              {
                if ($k==1){
                  phpToHtml(lyhwebroot."service.php?ordby=".$ordby."&sid=".$rs['id']."&page=".$k, "index.html", $file_name);
                  copy(ROOT_PATH.$file_name."/index.html", ROOT_PATH.$file_name."/index-1.html");
                     if($j==1){
                        copy(ROOT_PATH.$file_name."/index.html", ROOT_PATH."service/index.html");
                      }
                }else{
                  phpToHtml(lyhwebroot."service.php?ordby=".$ordby."&sid=".$rs['id']."&page=".$k, "index-".$k.".html", $file_name);
                }
                $j++;
              }
            }else{
              phpToHtml(lyhwebroot."service.php?ordby=".$ordby."&sid=".$rs['id'], "index.html", $file_name);
            }
          }
        }
       }

      //生成列表
    $ca_result = $db->query("select id,fileurl,small_id,big_id,three_id from ".$db_prefix."news where big_id = 4 and  issue=1");
      if ($db->num_rows($ca_result)>0)
      {
         while($rs  = $db->fetch_array($ca_result))
         {
          //$big_file_name = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = " . $rs['big_id']);
          //  $big_file_name_1 = explode(".", $big_file_name);
            $file_name = 'service';
            if($rs['small_id']){
              $small_file_name = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id = " . $rs['small_id']);
              $small_file_name_1 = explode(".", $small_file_name);
              $file_name .= '/'. $small_file_name_1[0];
            }
          if($rs['three_id']){
              $small_file_name = $db->getOne("select fileurl from ".$db_prefix."newsthreeclass where id = " . $rs['three_id']);
              $small_file_name_1 = explode(".", $small_file_name);
              $file_name .= '/'. $small_file_name_1[0];
            }
            phpToHtml(lyhwebroot."service_view.php?id=".$rs['id'], $rs['fileurl'], $file_name);
         }
        }

       showmessage('生成婚庆服务成功!');
      break;
    }

		//生成网站地图
		case "sitemap":
		{
			$XmlClear = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$RssHead = "<urlset  xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
			$RssEnd = "</urlset>";
			$contents.= $XmlClear;
			$contents.=$RssHead;
			$contents_chang="\t\t<lastmod>" . date ( 'Y-m-d\TH:i:s+00:00' ) . "</lastmod>\n".
							"\t\t<changefreq>0.8</changefreq>\n".
							"\t\t<priority>hourly</priority>\n";
			$contents.="<url>\n";
			$contents.="\t\t<loc>".$siteurl."</loc>\n";
			$contents .= $contents_chang;
			$contents.="</url>\n";

			$ca_result = $db->query("select fileurl from ".$db_prefix."pages where issue=1  order by stor asc, id asc");
         if ($db->num_rows($ca_result)>0){
           while($ca_list  = $db->fetch_array($ca_result))
					{
					  $paths = explode('.', $ca_list['fileurl']);
						$contents.="<url>\n";
						$contents.="\t\t<loc>".$siteurl.$paths[0]."/</loc>\n";
						$contents .= $contents_chang;
						$contents.="</url>\n";
					}
				}

       $ca_result = $db->query("select id,fileurl from ".$db_prefix."newsclass order by stor asc,id desc");
       if ($db->num_rows($ca_result)>0){
          while($ca_list  = $db->fetch_array($ca_result))
				 {
					  $paths = explode('.', $ca_list['fileurl']);
            $contents.="<url>\n";
            $contents.="\t\t<loc>".$siteurl.$paths[0]."/</loc>\n";
            $contents .= $contents_chang;
            $contents.="</url>\n";
				}
			}

			$ca_result = $db->query("select id,fileurl from ".$db_prefix."newssmallclass order by stor asc,id desc");
      if ($db->num_rows($ca_result)>0){
         while($ca_list  = $db->fetch_array($ca_result))
				 {
				    $big_file_name = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = " . $ca_list['big_id']);
            $big_file_name_1 = explode(".", $big_file_name);
            $file_name = $big_file_name_1[0];
					  $paths = explode('.', $ca_list['fileurl']);
					  $file_name .= $paths[0];
            $contents.="<url>\n";
            $contents.="\t\t<loc>".$siteurl.$file_name."/</loc>\n";
            $contents .= $contents_chang;
            $contents.="</url>\n";
				}
			}


      $ca_result = $db->query("select fileurl,big_id,small_id,three_id from ".$db_prefix."news where issue=1  order by id desc");
       if ($db->num_rows($ca_result)>0){
         while($ca_list  = $db->fetch_array($ca_result))
				 {
				    $big_file_name = $db->getOne("select fileurl from ".$db_prefix."newsclass where id = " . $ca_list['big_id']);
            $big_file_name_1 = explode(".", $big_file_name);
            $file_name = $big_file_name_1[0].'/';
            if($ca_list['small_id']){
              $small_file_name = $db->getOne("select fileurl from ".$db_prefix."newssmallclass where id = " . $ca_list['small_id']);
              $small_file_name_1 = explode(".", $small_file_name);
              $file_name .=  $small_file_name_1[0].'/';
            }
				    if($ca_list['three_id']){
              $three_file_name = $db->getOne("select fileurl from ".$db_prefix."newsthreeclass where id = " . $ca_list['three_id']);
              $three_file_name_1 = explode(".", $three_file_name);
              $file_name .=  $three_file_name_1[0].'/';
            }
					$contents.="<url>\n";
					$contents.="\t\t<loc>".$siteurl.$file_name.$ca_list['fileurl']."</loc>\n";
					$contents .= $contents_chang;
					$contents.="</url>\n";
				}
			}
 			$contents.=$RssEnd;
			$fic = fopen(ROOT_PATH."sitemaps.xml", "w");
			fwrite($fic, $contents);//写入文件
			fclose($fic);
			showmessage('生成站点地图成功');
			break;
	}

}
?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">

<title></title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<style type="text/css">
.button{margin-right:10px;}
.right{padding-right:10px}
.left{padding-left:10px;}
</style>
<body>
<table cellpadding="0" cellspacing="1" border="0" width="100%" class="tableBorder" align="center">
  <tr>
    <th class="bg1" colspan=2 height=25>发布系统管理:随着数据库记录的增加，生成会比较耗服务器资源，请你尽量在服务器压力小的时候生成</th>
  </tr>
  <tr>
    <td colspan="2">
      <form name="Public_index" method="post" action="">
		<table cellpadding="0" cellspacing="1" border="0" width="100%" class="tableBorder" align="center">
		<tr >
		  <td width="120" class="EAEAF3 right">发布首页</td>
		  <td class="EAEAF3 left">
			  <input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=index';this.form.submit();"  name="Submit4" value="发布站点首页">
              <input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=sitemap';this.form.submit();"  name="Submit4" value="生成站点地图">

		  </td>
		</tr>
	</table>
	 </form>
	     <form name="Public_menu" method="post" action="">
    <table cellpadding="0" cellspacing="1" border="0" width="100%" class="tableBorder" align="center">
		<tr>
			 <th class="bg1" colspan=2 height=25>发布导航页</th>
		</tr>
		<tr>
		 <td width="120" class="EAEAF3 right">发布导航页</td>
		 <td class="EAEAF3 left">
			  <input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=other';this.form.submit();"  name="Submit5" value="开始发布导航页">
			  </td>
		</tr>
    </table>
      </form>
   <form name="Public_menu" method="post" action="">
   <table cellpadding="0" cellspacing="1" border="0" width="100%" class="tableBorder" align="center">
    <tr>
      <th class="bg1" colspan=2 height=25>发布文章</th>
    </tr>
    <tr >
     <td width="120" class="EAEAF3 right" height=25>&nbsp;</td>
     <td class="EAEAF3 left">
       <input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=wedding';this.form.submit();"  name="Submit125" value="生成主题婚礼">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=newsList';this.form.submit();"  name="Submit125" value="生成婚礼资讯">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=planList';this.form.submit();"  name="Submit125" value="生成婚庆策划">
       &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=worksList';this.form.submit();"  name="Submit125" value="生成婚庆作品">
       &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="button" onClick="this.form.action='phpToHtml.php?save=serviceList';this.form.submit();"  name="Submit125" value="生成婚礼服务"></td>
     </tr>
   </table>
   </form>
	</td>
  </tr>
</table>
</body>
</html>
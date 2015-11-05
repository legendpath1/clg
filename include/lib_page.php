<?PHP

   // 页面 URL
function page_list($current_page="1", $total_page="0", $list_num="15", $page_num="10", $url, $first_page="[1]", $post_page="..", $post_start="[前翻10页]", $next_page="..", $last_page="", $next_start="[后翻10页]", $link_color="#EF5900") {
	 global $rewrite;
    if($rewrite==1){
    	$exc ='.html';
    }else {
    	$exc='';
    }
    $link_str .= "<font class='page_list'>";
    $start_page = @(((int)(($current_page-1)/$page_num))*$page_num)+1;
    $temp_pnum = $page_num - 1 ;
    $end_page = $start_page + $temp_pnum;

    if ($end_page >= $total_page) $end_page = $total_page;
    if ($start_page > 1) {
        $link_str .= " <a href='".$url.($start_page-1).$exc."'>".$post_start."</a>";
    }
    if ($current_page > 1) {
        $link_str .= "&nbsp;<a href='".$url."1$exc'>".$first_page."</a>";
        $link_str .= "&nbsp;<a href='".$url.($current_page-1)."'>".$post_page."</a>";
    }
    if ($total_page > 1) {
        for ($i=$start_page;$i<=$end_page;$i++) {
            if ($current_page != $i) {
                $link_str .= "&nbsp;<a href='$url$i$exc'>[$i]</a>";
            } else {
                $link_str .= "&nbsp;<font color='".$link_color."'><b>$i</b></font>";
            }
        }
    }
    if ($current_page < $total_page) {
        $link_str .= "&nbsp;<a href='$url".($current_page+1).$exc."'>".$next_page."</a>";
        if(!$last_page) {
            $last_page = "[".$total_page."]";
            $link_str .= "&nbsp;<a href='$url$total_page$exc'>".$last_page."</a>&nbsp;";
        }
    }
    if ($total_page > $end_page) {
        $link_str .= " <a href='".$url.($end_page+1).$exc."'>".$next_start."</a>";
    }
    $link_str .= "</font>";

    return $link_str;
}

function page_list2($ps_page, $total_page, $list_num, $file_name, $total_count, $page_num=10, $rewrite = false)
{
	if($rewrite){
    	$exc ='.html';
    }else {
    	$exc='';
    }
	$page_turn='';
	if ($total_count >0)
	{
		if($ps_page==1)
		{
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}
		else
		{
		if($ps_page==2){
			$page_pre=$ps_page-1;
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}else{
			$page_pre=$ps_page-1;
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.$page_pre.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}
	}

	$half = ceil($page_num/2);
	if ($ps_page<=$half and $total_page<=$page_num)
	{
		$page_small=1;
		$page_big=$total_page;
	}
	elseif ($ps_page<=$half and $total_page>$page_num)
	{
		$page_small=1;
		$page_big=$page_num;
	}
	elseif ($ps_page>=$half and $total_page<=$page_num)
	{
		$page_small=1;
		$page_big=$total_page;
	}
	else
	{
		if ($ps_page+$half>=$total_page)
		{
			$page_small=$total_page-$page_num+1;
			$page_big=$total_page;
		}
		else
		{
			$page_small=$ps_page-$half;
			$page_big=$ps_page+$half;
		}
	}

	for ($page_i=$page_small;$page_i<=$page_big;$page_i++)
	{
		if ($page_i!=$ps_page)
		{
			if($page_i==1){
				$page_count.="<a class=\"diany\" href='".$file_name.'1'.$exc."'>".$page_i."</a>";
			}else{
				$page_count.="<a class=\"diany\" href='".$file_name.$page_i.$exc."'>".$page_i."</a>";
			}
		}
		else
		{
			if($page_i==1){
				$page_count.="<a class=\"diany\" href='".$file_name.'1'.$exc."'><b><font color=#FF9933>".$page_i."</font></b></a>";
			}else{
				$page_count.="<a class=\"diany\" href='".$file_name.$page_i.$exc."'><b><font color=#FF9933>".$page_i."</font></b></a>";
			}
		}
	}

	$page_turn.=$page_count;
	if($ps_page==$total_page)
	{
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/next.jpg\" /></a>";
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/last.jpg\" /></a>";
	}else{
		$page_next=$ps_page+1;
		$page_turn.="<a href='".$file_name.$page_next.$exc."'><img src=\"images/next.jpg\" /></a>";
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/last.jpg\" /></a>";
	}

	}

	return $page_turn;

}
function page_list3($ps_page, $total_page, $list_num, $file_name, $total_count, $page_num=10, $rewrite = false)
{
	if($rewrite){
    	$exc ='.html';
    }else {
    	$exc='';
    }
	$page_turn='';
	if ($total_count >0)
	{
		if($ps_page==1)
		{
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}
		else
		{
		if($ps_page==2){
			$page_pre=$ps_page-1;
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}else{
			$page_pre=$ps_page-1;
			$page_turn.="<a href='".$file_name.'1'.$exc."'><img src=\"images/first.jpg\" /></a>";
			$page_turn.="<a href='".$file_name.$page_pre.$exc."'><img src=\"images/prev.jpg\" /></a>";
		}
	}

	$half = ceil($page_num/2);
	if ($ps_page<=$half and $total_page<=$page_num)
	{
		$page_small=1;
		$page_big=$total_page;
	}
	elseif ($ps_page<=$half and $total_page>$page_num)
	{
		$page_small=1;
		$page_big=$page_num;
	}
	elseif ($ps_page>=$half and $total_page<=$page_num)
	{
		$page_small=1;
		$page_big=$total_page;
	}
	else
	{
		if ($ps_page+$half>=$total_page)
		{
			$page_small=$total_page-$page_num+1;
			$page_big=$total_page;
		}
		else
		{
			$page_small=$ps_page-$half;
			$page_big=$ps_page+$half;
		}
	}

	for ($page_i=$page_small;$page_i<=$page_big;$page_i++)
	{
		if ($page_i!=$ps_page)
		{
			if($page_i==1){
				$page_count.="<a class=\"diany\" href='".$file_name.'1'.$exc."'>".$page_i."</a>";
			}else{
				$page_count.="<a class=\"diany\" href='".$file_name.$page_i.$exc."'>".$page_i."</a>";
			}
		}
		else
		{
			if($page_i==1){
				$page_count.="<a class=\"diany\" href='".$file_name.'1'.$exc."'><b><font color=#FF9933>".$page_i."</font></b></a>";
			}else{
				$page_count.="<a class=\"diany\" href='".$file_name.$page_i.$exc."'><b><font color=#FF9933>".$page_i."</font></b></a>";
			}
		}
	}

	$page_turn.=$page_count;
	if($ps_page==$total_page)
	{
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/next.jpg\" /></a>";
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/last.jpg\" /></a>";
	}else{
		$page_next=$ps_page+1;
		$page_turn.="<a href='".$file_name.$page_next.$exc."'><img src=\"images/next.jpg\" /></a>";
		$page_turn.="<a href='".$file_name.$total_page.$exc."'><img src=\"images/last.jpg\" /></a>";
	}

	}

	return $page_turn;

}


//没总共多少条记录，没显示在第几页
function page_list4($ps_page, $total_page, $file_name, $total_count, $page_num=10, $rewrite = false , $page2)
{
  if($rewrite){
      $exc ='.html';
    }else {
      $exc='';
    }
    if(isset($page2) && $page2){
      $exc = '-'.$page2.$exc;
    }
  $page_turn='';
  if ($total_count >0)
  {
    if($ps_page==1)
    {
      $page_turn.="<a href='".$file_name.'1'.$exc."'>首&nbsp;&nbsp;页</a>";
      $page_turn.="<a href='".$file_name.'1'.$exc."'>上一页</a>";
    }
    else
    {
    if($ps_page==2){
      $page_pre=$ps_page-1;
      $page_turn.="<a href='".$file_name.'1'.$exc."'>首&nbsp;&nbsp;页</a>";
      $page_turn.="<a href='".$file_name.'1'.$exc."'>上一页</a>";
    }else{
      $page_pre=$ps_page-1;
      $page_turn.="<a href='".$file_name.'1'.$exc."'>首&nbsp;&nbsp;页</a>";
      $page_turn.="<a href='".$file_name.$page_pre.$exc."'>上一页</a>";
    }
  }

  $half = ceil($page_num/2);
  if ($ps_page<=$half and $total_page<=$page_num)
  {
    $page_small=1;
    $page_big=$total_page;
  }
  elseif ($ps_page<=$half and $total_page>$page_num)
  {
    $page_small=1;
    $page_big=$page_num;
  }
  elseif ($ps_page>=$half and $total_page<=$page_num)
  {
    $page_small=1;
    $page_big=$total_page;
  }
  else
  {
    if ($ps_page+$half>=$total_page)
    {
      $page_small=$total_page-$page_num+1;
      $page_big=$total_page;
    }
    else
    {
      $page_small=$ps_page-$half;
      $page_big=$ps_page+$half;
    }
  }

  for ($page_i=$page_small;$page_i<=$page_big;$page_i++)
  {
    if ($page_i!=$ps_page)
    {
      if($page_i==1){
        $page_count.="<a href='".$file_name.'1'.$exc."'>[".$page_i."]</a>";
      }else{
        $page_count.="<a href='".$file_name.$page_i.$exc."'>[".$page_i."]</a>";
      }
    }
    else
    {
      if($page_i==1){
        $page_count.="<a class=\"diany\" href='".$file_name.'1'.$exc."'><font color=#FF0000>[".$page_i."]</font></a>";
      }else{
        $page_count.="<a class=\"diany\" href='".$file_name.$page_i.$exc."'><font color=#FF0000>[".$page_i."]</font></a>";
      }
    }
  }

  $page_turn.=$page_count;
  if($ps_page==$total_page)
  {
    $page_turn.="<a href='".$file_name.$total_page.$exc."'>下一页</a>";
    $page_turn.="<a href='".$file_name.$total_page.$exc."'>末&nbsp;&nbsp;页</a>";
  }else{
    $page_next=$ps_page+1;
    $page_turn.="<a href='".$file_name.$page_next.$exc."'>下一页</a>";
    $page_turn.="<a href='".$file_name.$total_page.$exc."'>末&nbsp;&nbsp;页</a>";
  }

  }

  return $page_turn;

}


//显示总共多少条记录，显示在第几页
function page_list5($ps_page, $total_page, $file_name, $total_count, $page_num=10, $rewrite = false , $page2)
{
  if($rewrite){
      $exc ='.html';
    }else {
      $exc='';
    }
    if(isset($page2) && $page2){
      $exc = '-'.$page2.$exc;
    }
  $page_turn='';
  //$page_turn="<span>当前<font color=#FF0000>".$ps_page."</font>/".$total_page."页</span>";
 // $page_turn.="<span>共<font color=#FF0000>".$total_count."</font>条记录</span>";
  if ($total_count >0)
  {
    if($ps_page==1)
    {
      $page_turn.="<a class='top' href='".$file_name.'1'.$exc."'>首页</a>";
      $page_turn.="<a class='prev' href='".$file_name.'1'.$exc."'>上一页</a>";
    }
    else
    {
    if($ps_page==2){
      $page_pre=$ps_page-1;
      $page_turn.="<a class='top' href='".$file_name.'1'.$exc."'>首页</a>";
      $page_turn.="<a class='prev' href='".$file_name.'1'.$exc."'>上一页</a>";
    }else{
      $page_pre=$ps_page-1;
      $page_turn.="<a class='top' href='".$file_name.'1'.$exc."'>首页</a>";
      $page_turn.="<a class='prev' href='".$file_name.$page_pre.$exc."'>上一页</a>";
    }
  }

  $half = ceil($page_num/2);
  if ($ps_page<=$half and $total_page<=$page_num)
  {
    $page_small=1;
    $page_big=$total_page;
  }
  elseif ($ps_page<=$half and $total_page>$page_num)
  {
    $page_small=1;
    $page_big=$page_num;
  }
  elseif ($ps_page>=$half and $total_page<=$page_num)
  {
    $page_small=1;
    $page_big=$total_page;
  }
  else
  {
    if ($ps_page+$half>=$total_page)
    {
      $page_small=$total_page-$page_num+1;
      $page_big=$total_page;
    }
    else
    {
		//$page_small=$ps_page-$half;这样会多加一个
      //$page_big=$ps_page+$half;这样会多加一
      $page_small=$ps_page-$half+1;
      $page_big=$ps_page+$half-1;
    }
  }

  for ($page_i=$page_small;$page_i<=$page_big;$page_i++)
  {
    if ($page_i!=$ps_page)
    {
      if($page_i==1){
        $page_count.="<a  href='".$file_name.'1'.$exc."'>".$page_i."</a>";
      }else{
        $page_count.="<a  href='".$file_name.$page_i.$exc."'>".$page_i."</a>";
      }
    }
    else
    {
      if($page_i==1){
        $page_count.="<a class='num' href='".$file_name.'1'.$exc."'>".$page_i."</a>";
      }else{
        $page_count.="<a class='num' href='".$file_name.$page_i.$exc."'>".$page_i."</a>";
      }
    }
  }

  $page_turn.=$page_count;
  if($ps_page==$total_page)
  {
    $page_turn.="<a class='next' href='".$file_name.$total_page.$exc."'>下一页</a>";
    $page_turn.="<a class='fot' href='".$file_name.$total_page.$exc."'>尾页</a>";
  }else{
    $page_next=$ps_page+1;
    $page_turn.="<a class='next' href='".$file_name.$page_next.$exc."'>下一页</a>";
    $page_turn.="<a class='fot' href='".$file_name.$total_page.$exc."'>尾页</a>";
  }

  }

  return $page_turn;

}



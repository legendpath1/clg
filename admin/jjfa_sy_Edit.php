<?
include_once("include/init.php");

$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
$act=$_REQUEST['act'];
$id=intval($_REQUEST['id']);


$rs['issue'] = 1;
$rs['isnew'] = 1;
$rs['stor'] = 99;
$page=$_REQUEST['page'];
if($act=='save'){
    include("include/check_form.php");
    $errmsg = check_form($_POST);
    if(!empty($errmsg)){
      showmessage($errmsg);
    }
    $formval = $_POST;

	
	
	
    $Title = trim($_POST['title']);
    //$Title = str_replace($str_del_title, "", $Title);

    $s_title=trim($_POST['s_title']);

    $en_title=trim($_POST['en_title']);

    $pic=$_POST['pic'];

    $fileurl=$_POST['fileurl'];

    $row = array(

      'title'   => $Title,
      's_title' => $s_title,
	  'en_title' => $en_title,
	  'fileurl' => $fileurl,
	  'pic'   => $pic,
      'issue'   => intval($_POST['issue']),
	  'isnew'   => intval($_POST['isnew']),
	  'stor'   => intval($_POST['stor']),
      'seotitle'  => trim($_POST['seotitle']),
      'seodesc' => trim($_POST['seodesc']),
      'seokey'  => trim($_POST['seokey']),
      'addtime'   => time(),
    );

    if($Result=='add'){

		if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."jjfa where title='$Title' ORDER BY id desc"))>0){
			showmessage("大标题已存在!");
		}
        if (!$Title){
			showmessage("大标题不能为空!");
		}
		if(!$s_title){

			showmessage("小标题不能为空!");
		}
		if(!$en_title){
			showmessage("英文注释不能为空!");

		}
		if(!$pic){
			showmessage("LOGO不能为空!");
		}







       $id = $db->insert($db_prefix.'jjfa',$row);
       if($id){
         admin_op_log('add','首页解决方案',$row['title']);  //写入记录

        showmessage("添加成功！","jjfa_sy_List.php?page=".$page);
       }else{
         showmessage("添加失败！","jjfa_sy_Edit.php?Result=modify&id=".$id."&page=".$page);
       }

    }elseif($Result=='modify'){
		if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."jjfa where title='$Title' and id!='$id' ORDER BY id desc"))>0){
			showmessage("大标题已存在!");
		}
		if (!$Title){
			showmessage("大标题不能为空!");
		}
		if(!s_title){

			showmessage("小标题不能为空!");
		}
		if(!en_title){
			showmessage("英文注释不能为空!");

		}

		$flg = $db->update($db_prefix.'jjfa',$row,'id='.$id);
		if($flg){
			admin_op_log('edit','首页解决方案',$row['title']);  //写入记录

			showmessage("编辑成功！","jjfa_sy_List.php?page=".$page);
		}else{
			showmessage("编辑失败！","jjfa_sy_Edit.php?Result=modify&id=".$id."&page=".$page);
		}
    }

}
elseif($Result=='modify'){
    $rs = $db->get_one("select * from ".$db_prefix."jjfa where id='$id'");
}

?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">

<title></title>
<link href="dwz/themes/default/style.css" rel="stylesheet" type="text/css" />
<link href="dwz/themes/css/core.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="dwz/js/dwz.min.js" type="text/javascript"></script>
<script type="text/javascript">
//重载验证码
function fleshVerify(){
	$('#verifyImg').attr("src", '__APP__/Public/verify/'+new Date().getTime());
}
$(function(){
	DWZ.init("dwz/dwz.frag.xml", {
		//loginUrl:"__APP__/webAdmin/Index/login",	//跳到登录页面
		statusCode:{ok:1,error:0},
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"_order", orderDirection:"_sort"}, 
		debug:true,
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"dwz/themes"});
		}
	});
})

</script>
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="../js/swfupload/swfupload-jquery/css/swfupload.css" type="text/css">
<script type="text/javascript" charset="utf-8" src="../include/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="js/function.js"></script>

<!--<script language="javascript">
<!--
function chkForm(){
  with(document.form1){
  if(title.value==""){
    alert("请输入作品名称.");
    title.focus();
    return false;
    }
  if(Category_big.value=="0"){
    alert("请选择作品类别.");
    Category_big.focus();
    return false;
  }
   }
}

var editor;
KindEditor.ready(function(K){
	editor = K.create('#content',{allowFileManager : true,filterMode:false});
});

//
</script>-->
<script language="javascript">
var TextUtil=new Object();
TextUtil.isNotMax=function(otextarea){
return otextarea.value.length<otextarea.getAttribute("maxlength");     //1
}
</script>
</head>
<body >
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
			<div class="tabsPageHeaderContent">
				<ul class="navTab-tab1">
					<li tabid="list" class="list"><a><span><? if(empty($rs['title']))echo '添加解决方案连接';else echo'编辑解决方案连接'?></span></a></li>
				</ul>
			</div>      
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
			<form action="?act=save&Result=<?=$Result?>&id=<?=$id?>&page=<?=$page?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkForm();">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red">* </span>大标题：</td>
						<td width="88%"  class="EAEAF3 left td2"><input name="title" type="text" style="width:700px" value="<?=$rs['title'];?>" ></td>
					</tr>
					<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red">* </span>小标题：</td>
						<td width="88%"  class="EAEAF3 left td2"><input name="s_title" type="text" style="width:700px" value="<?=$rs['s_title'];?>" ></td>
					</tr>
					<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red"></span>英文标签：</td>
						<td width="88%"  class="EAEAF3 left td2"><input name="en_title" type="text" style="width:700px" value="<?=$rs['en_title'];?>" ></td>
					</tr>
					<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red"></span>链接地址：</td>
						<td width="88%"  class="EAEAF3 left td2"><input name="fileurl" type="text" style="width:700px" value="<?=$rs['fileurl'];?>" ></td>
					</tr>
					<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red"></span>LOGO图片：</td>
						<td width="88%"  class="EAEAF3 left td2">

							<input type="radio" name="pic" value="xy" <?php if($rs['pic']=='xy'){echo "checked";} ?> /><img src="<?='../images/xy01.png';?>" width="48px" height="48px" alt="">&nbsp;&nbsp;&nbsp;
							<input type="radio" name="pic" value="yy" <?php if($rs['pic']=='yy'){echo "checked";} ?>  /><img src="<?='../images/yy01.png';?>" width="48px" height="48px" alt="">&nbsp;&nbsp;&nbsp;
							<input type="radio" name="pic" value="fl" <?php if($rs['pic']=='fl'){echo "checked";} ?>  /><img src="<?='../images/fl01.png';?>" width="48px" height="48px" alt="">&nbsp;&nbsp;&nbsp;
							<input type="radio" name="pic" value="xs" <?php if($rs['pic']=='xs'){echo "checked";} ?>  /><img src="<?='../images/xs01.png';?>" width="48px" height="48px" alt="">&nbsp;&nbsp;&nbsp;
						</td>
					</tr>







					<!--
					<tr>
						<td  class="EAEAF3 right td1"><span class="red">* </span>活动类别：</td>
						<td class="EAEAF3 left td2">
							<select name="Category_big" size="1">
								<option value="0">---请选择类别---</option>
								<option value="1" <? if ($rs['big_id']==1){echo "selected";}?> >AVA农庄</option>
								<option value="2" <? if ($rs['big_id']==2){echo "selected";}?> >AVA人在一起</option>
							</select>
						</td>
					</tr> -->
				
					
					<tr style="display:none">
						<td  class="EAEAF3 right td1">浏览次数：</td>
						<td class="EAEAF3 left td2"><input name="hit" type="text" style="width:20%" value="<?=$rs['hit'];?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['hit'];?>'}" onFocus="if(value=='<?=$rs['hit'];?>'){value=''}">&nbsp;<span class="red">点击次数只能为正整数</span></td>
					</tr>
					<tr style="display:none">
						<td  class="EAEAF3 right td1">招聘人数：</td>
						<td class="EAEAF3 left td2"><input name="author" type="text" style="width:50%" value="<?=$rs['author']?>" onBlur="if (value == '') {value='<?=$rs['author'];?>'}">&nbsp;</td>
					</tr>
					<tr>
						<td  class="EAEAF3 right td1">是否发布：</td>
						<td class="EAEAF3 left td2">
						<!--<input name="isnew" type="checkbox" value="1" <? if($rs['isnew']==1)echo'checked';?> class="checkbox" />&nbsp;是否新品&nbsp;&nbsp;-->
						<input name="issue" type="checkbox" value="1" <? if($rs['issue']==1)echo'checked';?> class="checkbox" />&nbsp;是否发布</td>
					</tr>					
					<tr  style="display:none">
						<td  class="EAEAF3 right td1">文章来源：</td>
						<td class="EAEAF3 left td2"><input name="filefrom" type="text" style="width:50%" value="<?=$rs['filefrom']?>" onBlur="if (value == '') {value='<?=$rs['filefrom'];?>'}">&nbsp;</td>
					</tr>					
					<tr>
						<td class="EAEAF3 right td1">排列顺序：</td>
						<td class="EAEAF3 left td2"><input name="stor" type="text" style="width:50" value="<?=$rs['stor']?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['stor']?>'}" onFocus="if (value == '<?=$rs['stor']?>') {value =''}" ><font style="color:#F00; margin-left:30px;display:none;">在希望分页的文本位置输入 [nextpage] 这个代码即可</font></td>
					</tr>					  
					<tr>
						<td class="EAEAF3 td1"  height="30"></td>
						<td class="EAEAF3 left td2"><input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;
						<input name="back" type="button" class="button"  value=" 返回 " onClick="javascript:history.back();" ></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
</body>
<script language="JavaScript">
<!--
var subcat = new Array();
<?
$i=0;
$result3 = $db->query("select id,big_id,title from ".$db_prefix."workssmallclass order by stor asc,id desc");
               if($db->num_rows($result3)){
               while($brs3 = $db->fetch_array($result3)){
             echo "subcat[".$i++."] = new Array('".$brs3["big_id"]."','".$brs3["title"]."','".$brs3["id"]."');\n";
 }
			   }
?>

function changeselect1(locationid)
{
document.form1.Category_small.length = 0;
document.form1.Category_small.options[0] = new Option('---请选择类别---','0');
for (i=0; i<subcat.length; i++)
{
if (subcat[i][0] == locationid)
{document.form1.Category_small.options[document.form1.Category_small.length] = new Option(subcat[i][1], subcat[i][2]);}
}
}
//-->
</script>
</html>
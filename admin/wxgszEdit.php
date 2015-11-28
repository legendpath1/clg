<?
include_once("include/init.php");

$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
$act=$_REQUEST['act'];
$id=intval($_REQUEST['id']);
// $big_id=intval($_REQUEST['Category_big']);
// $sm_id=intval($_REQUEST['Category_small']);
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


    //上传图片  标题图片
    if(!empty($_FILES['title']['tmp_name'])){
			include_once(ROOT_PATH."include/Image.class.php");
			$uploadimg = new upimages();
			$uploadimg->img_save_dir = ROOT_PATH.WXGSZ_IMG_DIR;
			if(!$uploadimg->upload_img($_FILES['title'])){
				showmessage($uploadimg->errmsg);
			}else{
				$proimg_title = WXGSZ_IMG_DIR.$uploadimg->img_new_name; //图片名称
				delete_file(ROOT_PATH.WXGSZ_IMG_DIR.$formval['proimg_title']);
			}
		}else{
			$proimg_title=$formval['proimg_title'];
		}








	// //上传图片 活动图片
	// 	if(!empty($_FILES['pic']['tmp_name'])){
	// 		include_once(ROOT_PATH."include/Image.class.php");
	// 		$uploadimg = new upimages();
	// 		$uploadimg->img_save_dir = ROOT_PATH.wxgsz_IMG_DIR;
	// 		if(!$uploadimg->upload_img($_FILES['pic'])){
	// 			showmessage($uploadimg->errmsg);
	// 		}else{
	// 			$proimg = wxgsz_IMG_DIR.$uploadimg->img_new_name; //图片名称
	// 			delete_file(ROOT_PATH.wxgsz_IMG_DIR.$formval['proimg']);
	// 		}
	// 	}else{
	// 		$proimg=$formval['proimg'];
	// 	}
	
	
	
    $Title = trim($_POST['title']);
    //$Title = str_replace($str_del_title, "", $Title);
	$content = $_POST['content'];

	$en_title= $_POST['en_title'];


	$fileurl=$_POST['fileurl'];

    $row = array(
    	'title'=>$proimg_title,

	  //'pic'   => $proimg,

	  author => $_POST['author'],

	  'en_title' => $_POST['en_title'],
      'content' => $_POST['content'],
      'fileurl' => $_POST['fileurl'],
      'issue'   => intval($_POST['issue']),
	  'isnew'   => intval($_POST['isnew']),
	  //'stor'   => intval($_POST['stor']),
      'seotitle'  => trim($_POST['seotitle']),
      'seodesc' => trim($_POST['seodesc']),
      'seokey'  => trim($_POST['seokey']),
      'addtime'   => time(),
    );

    if($Result=='add'){
		//dump($row);exit;
		// if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."wxgsz where title='$Title' ORDER BY id desc"))>0){
		// 	showmessage("活动标题已存在!");
		// }
  //       if (!$Title){
		// 	showmessage("活动标题不能为空!");
		// }

    	if(!$proimg_title){
    		showmessage("标题图片不能为空!");

    	}
    	if(!$en_title){
			showmessage("标题不能为空!");
		}
		if (!$content){
			showmessage("不能为空!");
		}



       $id = $db->insert($db_prefix.'wxgsz',$row);
       if($id){
         admin_op_log('add','首页活动',$row['title']);  //写入记录

        showmessage("添加成功！","wxgszList.php");
       }else{
         showmessage("添加失败！","wxgszEdit.php");
       }

    }elseif($Result=='modify'){

		// if (!$Title){
		// 	showmessage("活动标题图片不能为空!");
		// }

		if(!$proimg_title){
		showmessage("标题图片不能为空!");

    	}
    	if(!$en_title){
			showmessage("标题不能为空!");
		}
		if (!$content){
			showmessage("详细内容不能为空!");
		}

		if(!$fileurl){
			showmessage("链接地址不能为空!");
		}
		$flg = $db->update($db_prefix.'wxgsz',$row,'id='.$id);
		if($flg){
			admin_op_log('edit','证书',$row['title']);  //写入记录

			showmessage("编辑成功！","wxgszList.php?page=".$page);
		}else{
			showmessage("编辑失败！","wxgszEdit.php?Result=modify&id=".$id."&page=".$page);
		}
    }

}
elseif($Result=='modify'){
    $rs = $db->get_one("select * from ".$db_prefix."wxgsz where id='$id'");
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
					<li tabid="list" class="list"><a><span><? if(empty($rs['title']))echo '添加首页活动';else echo'编辑五仙宫'?></span></a></li>
				</ul>
			</div>      
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
			<form action="?act=save&Result=<?=$Result?>&id=<?=$id?>&page=<?=$page?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkForm();">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<!-- <tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red">* </span>标题：</td>
						<td width="88%"  class="EAEAF3 left td2"><input name="title" type="text" style="width:700px" value="<?=$rs['title'];?>" ></td>
					</tr> -->

					<tr>
						<td class="EAEAF3 right td1"><span class="red">* </span>标题图片：</td>
						<td class="EAEAF3 left td2">
						<?PHP
						if(!empty($rs['title'])){
						?>
						<a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(1)" onMouseOut="hideImgDiv(1)">[查看图片]
						<span style="z-index:9999;" class="showimg" id="showimg_1"><img src="<?='../'.$rs['title'];?>" width="300"/></span></a>
						<?PHP } ?>&nbsp;&nbsp;<input name="title" type="file" style="width:200px"> 或者图片网址： <input name="proimg_title" type="text" style="width:300px" value="<?=$rs['title'];?>"> <font style="color:#F00">图片最佳大小：232px*90px</font>
						</td>
					</tr>


					<tr>
						<td class="EAEAF3 right td1"><span class="red">* </span>标题：</td>
						<td class="EAEAF3 left td2" style="padding:5px">
						<input type="text" name="en_title" value="<?PHP echo $rs['en_title']?>" style="width:500px;"  >
						</td>
					</tr>
					<tr>
						<td class="EAEAF3 right td1"><span class="red">* </span>详细内容：</td>
						<td class="EAEAF3 left td2" style="padding:5px">
						<textarea name="content" id="content" style="width:500px; height:100px;"><?PHP echo $rs['content']?></textarea>
						</td>
					</tr>
					<!-- <tr>
						<td  class="EAEAF3 right td1"><span class="red">* </span>活动类别：</td>
						<td class="EAEAF3 left td2">
							<select name="Category_big" size="1">
								<option value="0">---请选择类别---</option>
								<option value="1" <? if ($rs['big_id']==1){echo "selected";}?> >AVA农庄</option>
								<option value="2" <? if ($rs['big_id']==2){echo "selected";}?> >AVA人在一起</option>
							</select>
						</td>
					</tr> -->
					<!--<tr>
						<td  class="EAEAF3 right td1">类别：</td>
						<td class="EAEAF3 left td2"><select name="Category_big" size="1" onChange="changeselect1(this.value)">
						<option value="0">---请选择类别---</option>
						<?PHP
						$result = $db->query("select id,title from ".$db_prefix."abppxxclass order by stor asc,id desc");
						if($db->num_rows($result)){
						while($brs = $db->fetch_array($result)){
						?>
						<option value="<?=$brs["id"]?>" <? if ($brs["id"]==$rs['big_id']){echo "selected";}?> ><?=$brs["title"]?></option>
						<? }}?>
						</select>
						</td>
					</tr>-->
					<tr>
						<td class="EAEAF3 right td1"><span class="red">* </span>仙宫图片：</td>
						<td class="EAEAF3 left td2">
							<img src="<?='../images/gd'.$rs['id'].'.png';?>" height="100px" alt="">
						</td>
					</tr>	
					<tr>
						<td class="EAEAF3 right td1"><span class="red">* </span>链接地址：</td>
						<td class="EAEAF3 left td2" style="padding:5px">
						<input type="text" name="fileurl" value="<?PHP echo $rs['fileurl']?>" style="width:500px;"  >
						</td>
					</tr>
					<tr style="display:none">
						<td  class="EAEAF3 right td1">浏览次数：</td>
						<td class="EAEAF3 left td2"><input name="hit" type="text" style="width:20%" value="<?=$rs['hit'];?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['hit'];?>'}" onFocus="if(value=='<?=$rs['hit'];?>'){value=''}">&nbsp;<span class="red">点击次数只能为正整数</span></td>
					</tr>
					<tr style="display:none">
						<td  class="EAEAF3 right td1">招聘人数：</td>
						<td class="EAEAF3 left td2"><input name="author" type="text" style="width:50%" value="<?=$rs['author']?>" onBlur="if (value == '') {value='<?=$rs['author'];?>'}">&nbsp;</td>
					</tr>
									
					<tr  style="display:none">
						<td  class="EAEAF3 right td1">文章来源：</td>
						<td class="EAEAF3 left td2"><input name="filefrom" type="text" style="width:50%" value="<?=$rs['filefrom']?>" onBlur="if (value == '') {value='<?=$rs['filefrom'];?>'}">&nbsp;</td>
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
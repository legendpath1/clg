<?
include_once("include/init.php");
$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
$act=$_REQUEST['act'];
$id=intval($_REQUEST['id']);
$big_id=3;

$sm_id=intval($_REQUEST['Category_small']);
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

	//上传图片
	if(!empty($_FILES['pic']['tmp_name'])){
		include_once(ROOT_PATH."include/Image.class.php");
		$uploadimg = new upimages();
		$uploadimg->img_save_dir = ROOT_PATH.PRODUCT_IMG_DIR;
		if(!$uploadimg->upload_img($_FILES['pic'])){
			showmessage($uploadimg->errmsg);
		}else{
			$proimg = PRODUCT_IMG_DIR.$uploadimg->img_new_name; //图片名称
			delete_file(ROOT_PATH.PRODUCT_IMG_DIR.$formval['proimg']);
		}
	}else{
		$proimg=$formval['proimg'];
	}
	
	
	
    $Title = trim($_POST['title']);
    //$Title = str_replace($str_del_title, "", $Title);
	$content = $_POST['content'];

    $row = array(
		'big_id'  => 3,
		'small_id'  => $sm_id,
		'three_id'  => "",
		'title'   => $Title,
		//'hit'   => intval($_POST['hit']),
		'pic'   => $proimg,
		'author' => $_POST['author'],
		'content' => $_POST['content'],
		'issue'   => intval($_POST['issue']),
		'isnew'   => intval($_POST['isnew']),
		'stor'   => intval($_POST['stor']),
		'seotitle'  => trim($_POST['seotitle']),
		'seodesc' => trim($_POST['seodesc']),
		'seokey'  => trim($_POST['seokey']),
		'addtime'   => time(),
    );

    if($Result=='add'){
		//dump($row);exit;
		//if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."personnel where title='$Title' ORDER BY id desc"))>0){
			//showmessage("作品名称已存在!");
		//}
		if (!$Title){
			showmessage("标题不能为空!");
		}


		if (!$content){
			showmessage("内容不能为空!");
		}
		$id = $db->insert($db_prefix.'personnel',$row);
		if($id){
			admin_op_log('add','招聘信息',$row['title']);  //写入记录
			showmessage("添加信息成功！","companybeneList.php?page=".$page);
		}else{
			showmessage("添加信息失败！","companybeneEdit.php?Result=add");
		}

		}elseif($Result=='modify'){
			//if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."personnel where title='$Title' and id!='$id' ORDER BY id desc"))>0){
				//showmessage("招聘信息名称已存在!");
			// }
			if (!$Title){
				showmessage("标题不能为空!");
			}


			if (!$content){
				showmessage("内容不能为空!");
			}
			$flg = $db->update($db_prefix.'personnel',$row,'id='.$id);
			if($flg){
				admin_op_log('edit','公司福利',$row['title']);  //写入记录

				showmessage("编辑信息成功！","companybeneList.php?page=".$page);
			}else{
				showmessage("编辑信息失败！","companybeneEdit.php?Result=modify&id=".$id."&page=".$page);
			}
	}

}
elseif($Result=='modify'){
	$rs = $db->get_one("select * from ".$db_prefix."personnel where id='$id'");
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

<script language="javascript">
var editor;
KindEditor.ready(function(K){
	editor = K.create('#content',{allowFileManager : true,filterMode:false});
});
</script>

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
<body>
<div id="container">
	<div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
			<div class="tabsPageHeaderContent">
			  <ul class="navTab-tab1">
				<li tabid="list" class="list"><a><span><? if(empty($rs['title']))echo '添加人才信息';else echo'编辑人才信息'?></span></a></li>
			  </ul>
			</div>
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>

			<form action="?act=save&Result=<?=$Result?>&id=<?=$id?>&page=<?=$page?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkForm();">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red">* </span>标题：</td>
						<td width="88%"  class="EAEAF3 left td2"><input name="title" type="text" style="width:700px" value="<?=$rs['title'];?>" ></td>
					</tr>

					<tr>
						<td  class="EAEAF3 right td1">发布：</td>
						<td class="EAEAF3 left td2">
						<input name="issue" type="checkbox" value="1" <? if($rs['issue']==1)echo'checked';?> class="checkbox" />&nbsp;是否发布</td>
					</tr>
					<tr>
						<td class="EAEAF3 right td1"><span class="red">* </span>内容：</td>
						<td class="EAEAF3 left td2" style="padding:5px">
							<!-- <textarea name="content" id="content" style="width:100%; height:300px;"><?PHP echo $rs['content']?></textarea> -->

							<textarea name="content"  style="width:100%; height:71px;"><?PHP echo $rs['content']?></textarea>
							
						</td>
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
</html>
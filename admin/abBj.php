<?
include_once("include/init.php");
global $clientTime;
$id=intval($_REQUEST['id']);
$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='modify';
$act=$_REQUEST['act'];

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
  		$uploadimg->img_save_dir = ROOT_PATH.ADV_IMG_DIR;
  		if(!$uploadimg->upload_img($_FILES['pic'])){
  			showmessage($uploadimg->errmsg);
  		}else{
  			$ad_code = ADV_IMG_DIR.$uploadimg->img_new_name; //图片名称
  			delete_file(ROOT_PATH.ADV_IMG_DIR.$formval['advimg']);
  		}
  	}else{
  		$ad_code=$formval['advimg'];
  	}

    $Title = trim($_POST['title']);
    $Title = str_replace($str_del_title, "", $Title);
	
    $row = array(
		'title'   => $Title,
		'fileurl'	=> $ad_code
    );

    if($Result=='modify'){
      //if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."pages where title='$Title' and id!='$id' ORDER BY id desc"))>0){
        //showmessage("标题已存在!");
      // }
      // if (!$Title){
     // showmessage("标题不能为空!");
   // }

		$flg = $db->update($db_prefix.'pages',$row,"id='$id'");
		if($flg){
			admin_op_log('edit','单页',$row['title']);  //写入记录

			showmessage("编辑成功！","abBj.php?Result=modify&id=$id");
		}else{
			showmessage("编辑失败！","abBj.php?Result=modify&id=$id");
		}
    }

 }
elseif($Result=='modify'){
	
	$rs=$db->get_one("select * from ".$db_prefix."pages where id='$id'");
	if(isset($rs['fileurl']) && $rs['fileurl']){
	  if(in_array(substr($rs['fileurl'], -3, 3), array('gif','jpg','png','jpeg'))){
	    $img_url = $rs['fileurl'];
	  }elseif (substr($rs['fileurl'], -3, 3) == 'swf'){
	    $flash_url = $rs['fileurl'];
	  }
	}
}

?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<script language="javascript" src="../js/DatePicker/WdatePicker.js"></script>
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
	editor = K.create('#en_content',{allowFileManager : true,filterMode:false});
});


</script>
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
			<li tabid="list" class="list"><a><span>公司简介</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
		

      <form action="?act=save&Result=<?=$Result?>&id=<?=$id?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkForm();">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="12%" class="EAEAF3 right td1"><span class="red">* </span>标题：</td>
				<td width="88%"  class="EAEAF3 left td2"><input name="title" type="text" style="width:700px" value="<?=$rs['title'];?>" ></td>
			</tr>
			<tr>
				<td class="EAEAF3 right td1"><span class="red">* </span>上传图片：</td>
				<td class="EAEAF3 left td2">
				<a href="../<?=$img_url;?>" target="_blank" class="red">[查看图片]</a>&nbsp;&nbsp;<input name="pic" type="file" style="width:200px"> 或者图片网址： <input name="advimg" type="text" value="<?php echo isset($img_url)? $img_url : null;?>" style="width:300px;"><span style="color:red;"> 图片最佳大小 1920px*940px</span>
				</td>
			</tr>
			<tr>
				<td class="EAEAF3 td1"  height="30">&nbsp;</td>
				<td class="EAEAF3 left td2"><input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
        </table>
    </form>

		</div>
	</div>
</div>
</body>
</html>
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
			$uploadimg->img_save_dir = ROOT_PATH.CLIENTS_IMG_DIR;
			if(!$uploadimg->upload_img($_FILES['pic'])){
				showmessage($uploadimg->errmsg);
			}else{
				$clientimg = CLIENTS_IMG_DIR.$uploadimg->img_new_name; //图片名称
				delete_file(ROOT_PATH.CLIENTS_IMG_DIR.$formval['clientimg']);
			}
		}else{
			$clientimg=$formval['clientimg'];
		}
	//上传图片
		if(!empty($_FILES['fileurl']['tmp_name'])){
			include_once(ROOT_PATH."include/Image.class.php");
			$uploadimg = new upimages();
			$uploadimg->img_save_dir = ROOT_PATH.CLIENTS_IMG_DIR;
			if(!$uploadimg->upload_img($_FILES['fileurl'])){
				showmessage($uploadimg->errmsg);
			}else{
				$clientimg2 = CLIENTS_IMG_DIR.$uploadimg->img_new_name; //图片名称
				delete_file(ROOT_PATH.CLIENTS_IMG_DIR.$formval['clientimg2']);
			}
		}else{
			$clientimg2=$formval['clientimg2'];
		}
	
	
	
    $Title = trim($_POST['title']);
    $Title = str_replace($str_del_title, "", $Title);
	$content = $_POST['content'];
	$jianjie = $_POST['jianjie'];
	
    $row = array(
      'title'   => $Title,
      //'fileurl' => $FileUrl,
      'content' => $_POST['content'],
	  'jianjie' => $_POST['jianjie'],
	  'pic'   => $clientimg,
	  'fileurl'   => $clientimg2,
      'seotitle'  => trim($_POST['seotitle']),
      'seodesc' => trim($_POST['seodesc']),
      'seokey'  => trim($_POST['seokey']),
	
    );

    if($Result=='modify'){
      /* if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."pages where title='$Title' and id!='$id' ORDER BY id desc"))>0){
        showmessage("名称已存在!");
       } */
       if (!$Title){
      showmessage("名称不能为空!");
    }

	if (!$content){
      showmessage("内容不能为空!");
    }
      $flg = $db->update($db_prefix.'pages',$row,'id=10');
      if($flg){
        admin_op_log('edit','单页',$row['title']);  //写入记录

        showmessage("编辑成功！","sjcp.php?Result=modify&id=10");
       }else{
         showmessage("编辑失败！","sjcp.php?Result=modify&id=10");
       }
    }

  }
  elseif($Result=='modify'){
    $rs = $db->get_one("select * from ".$db_prefix."pages where id=10");
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
	//editor = K.create('#content',{allowFileManager : true,filterMode:false});
	//editor = K.create('#jianjie',{allowFileManager : true,filterMode:false});
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
			<li tabid="list" class="list"><a><span>设计产品</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
		

      <form action="?act=save&Result=<?=$Result?>&id=<?=$id?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkForm();">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="12%" class="EAEAF3 right td1">标题：</td>
            <td width="88%"  class="EAEAF3 left td2"><input name="title" type="text" style="width:700px" value="<?=$rs['title'];?>" ></td>
          </tr>
          <tr>
            <td class="EAEAF3 right td1">上传产品一图片：</td>
            <td class="EAEAF3 left td2"><?PHP
            if(!empty($rs['pic'])){
      ?>
            <a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(1)" onMouseOut="hideImgDiv(1)">[查看图片]
            <span class="showimg" id="showimg_1"><img src="<?='../'.$rs['pic'];?>" /></span></a>
            <?PHP } ?>
             <input id="pic" name="pic" type="file" style="width:200px;" value="上传图片" >
            或者填写地址： <input name="clientimg" type="text" style="width:300px" value="<?=$rs['pic'];?>"><span style="color:red;"> 图片最佳大小 375px*506px</span></td>
          </tr>
          <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>产品一内容：</td>
            <td class="EAEAF3 left td2" style="padding:5px">
			<textarea name="content" id="content" style="width:750px; height:100px;"><?PHP echo $rs['content']?></textarea>
           </td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1">上传产品二图片：</td>
            <td class="EAEAF3 left td2"><?PHP
            if(!empty($rs['fileurl'])){
      ?>
            <a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(2)" onMouseOut="hideImgDiv(2)">[查看图片]
            <span class="showimg" id="showimg_2"><img src="<?='../'.$rs['fileurl'];?>" /></span></a>
            <?PHP } ?>
             <input id="fileurl" name="fileurl" type="file" style="width:200px;" value="上传图片" >
            或者填写地址： <input name="clientimg2" type="text" style="width:300px" value="<?=$rs['fileurl'];?>"><span style="color:red;"> 图片最佳大小 448px*506px</span></td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>产品二内容：</td>
            <td class="EAEAF3 left td2" style="padding:5px">
			<textarea name="jianjie" id="jianjie" style="width:750px; height:100px;"><?PHP echo $rs['jianjie']?></textarea>
           </td>
          </tr>
		  <tr style="display:none">
            <td class="EAEAF3 right td1"><span class="red">* </span>电子地图：<br /><span class="red">750px*350px</span></td>
            <td class="EAEAF3 left td2" style="padding:5px">
			<textarea name="map" id="map" style="width:1000px; height:300px; display:none"><?PHP echo $rs['map']?></textarea>
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
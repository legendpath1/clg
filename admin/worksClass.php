<?
include_once("include/init.php");

$id = $_REQUEST['id'];
$act = $_REQUEST['act'];
$Result = $_REQUEST['Result'];
if(empty($Result)) $Result='add';
$rs['stor'] = 99;
if($act=='edit'){
//上传图片
    if(!empty($_FILES['pic']['tmp_name'])){
      include_once(ROOT_PATH."include/Image.class.php");
      $uploadimg = new upimages();
      $uploadimg->img_save_dir = ROOT_PATH.NEWS_IMG_DIR;
      if(!$uploadimg->upload_img($_FILES['pic'])){
        showmessage($uploadimg->errmsg);
      }else{
        $proimg = NEWS_IMG_DIR.$uploadimg->img_new_name; //图片名称
        delete_file(ROOT_PATH.NEWS_IMG_DIR.$_POST['proimg']);
      }
    }else{
      $proimg = $_POST['proimg'];
    }


	  $Title = trim($_POST['title']);
	  $Title = str_replace($str_del_title, "", $Title);
	  if (strpos($FileUrl,".html") <= 0) $FileUrl=$FileUrl.".html";
	$row = array(
		'title'		=> $Title,
		'fileurl'	=> "",
	    'pic'    => $proimg,
		'stor'		=> intval($_POST['stor']),
		'content'	=> trim($_POST['content']),
		'seotitle'	=> trim($_POST['seotitle']),
		'seodesc'	=> trim($_POST['seodesc']),
		'seokey'	=> trim($_POST['seokey'])
	);


	if($Result=='add'){
		if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."worksclass where title='$Title' ORDER BY id desc"))>0){
			showmessage("分类名称已存在!");
		}
        if (!$Title){
			showmessage("分类名称不能为空!");
		}
		$id = $db->insert($db_prefix.'worksclass',$row);
		if($id){
			admin_op_log('add','分类',$row['title']);	//写入记录
			showmessage("添加分类成功","worksCategorys.php");
		}else{
			showmessage("添加分类失败","worksCategorys.php");
		}
	}elseif($Result=='modify'){
		 if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."worksclass where title='$Title' and id!='$id' ORDER BY id desc"))>0){
			showmessage("分类名称已存在!");
		 }
		 if (!$Title){
			showmessage("分类名称不能为空!");
		}
		$flg = $db->update($db_prefix.'worksclass',$row,'id='.$id);
		if($flg){
			admin_op_log('edit','分类',$row['title']);	//写入记录
			showmessage("编辑分类成功！","worksCategorys.php");
		 }else{
			 showmessage("编辑大类失败！","worksClass.php?Result=modify&id=".$id);
		 }
	}
}
elseif($Result=='modify'){
	$rs=$db->get_one("select * from ".$db_prefix."worksclass where id='$id'");
}

?>
<html>
<head>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<!-- 技术支持：http://www.gzseo.cn -->
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
<!--<script type="text/javascript" charset="utf-8" src="../include/kindeditor/kindeditor.js"></script>-->
<script type="text/javascript" src="js/function.js"></script>
<script language="javascript">
<!--
function chkForm(){
  with(document.form_type){
	if(title.value==""){
	  alert("请输入分类名称.");
	  title.focus();
	  return false;}

}};
//KE.show({id : 'content'});
-->
</script>
</head>
<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab1">
			<li tabid="list" class="list"><a><span>作品分类</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left"><? if($Result=='add')echo'添加';else echo'编辑';?>分类</div>

  <form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>" method="post" enctype="multipart/form-data" name="form_type" onSubmit="return chkForm();">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
          <tr>
            <td width="12%" class="EAEAF3 right td1"><span class="red">* </span>分类名称：</td>
            <td width="88%" class="EAEAF3  left td2"><input name="title" type="text"  style="width:50%" value="<? echo $rs['title'];?>" ></td>
          </tr>
		      <tr style="display:none;">
            <td width="12%" class="EAEAF3 right td1"><span class="red">* </span>英文名称：</td>
            <td class="EAEAF3  left td2"><input name="title_en" type="text"  style="width:250" value="<? echo $rs['title_en'];?>"></td>
          </tr>
		     <tr>
            <td class="EAEAF3 right td1">顺序：</td>
           <td class="EAEAF3 left td2"> <input name="stor" type="text" value="<?=$rs['stor']?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['stor']?>'}" onFocus="if(value=='<?=$rs['stor']?>'){value=''}"></td>
          </tr>
          <tr style="display:none">
            <td class="EAEAF3 right td1">上传文件：</td>
            <td class="EAEAF3 left td2"><?PHP
            if(!empty($rs['pic'])){
      ?>
            <a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(1)" onMouseOut="hideImgDiv(1)">[查看图片]
            <span class="showimg" id="showimg_1"><img src="<?='../'.$rs['pic'];?>" /></span></a>
            <?PHP } ?>&nbsp;
             <input id="pic" name="pic" type="file" style="width:200px;" value="上传图片" >
            或者填写地址： <input name="proimg" type="text" style="width:300px" value="<?=$rs['pic'];?>"></td>
          </tr>
		      <tr style="display:none">
            <td class="EAEAF3  right td1">分类简介：</td>
            <td class="EAEAF3  left td2">
			       <textarea name="content" id="content" style="width:600px; height:300px; display:none"><?PHP echo $rs['content']?></textarea>
            </td>
          </tr>
		      
          <tr>
            <td class="EAEAF3 td1" height="30">&nbsp;</td>
            <td class="EAEAF3  left td2"><input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;
            <input name="back"class="button" type="button" value=" 返回 " onClick="javascript:history.back();" ></td>
          </tr>
        </table>
 </form>

		</div>
	</div>
</div>
</body>
</html>
<?
include_once("include/init.php");
$id=intval($_REQUEST['id']);
$act=$_REQUEST['act'];
$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
$rs['stor'] = 99;
$rs['issue'] = 1;
$rs['media_type'] = 0;
$rs['catid']=8;
$page=$_REQUEST['page'];



$arr=array('用户中心','客服中心','每日活动','彩乐宫大乐透');




if($act=='edit'){
	include("include/check_form.php");
	$errmsg = check_form($_POST);
	if(!empty($errmsg)){
		showmessage($errmsg);
	}
	$formval = $_POST;
	
  	//上传图片
		if(!empty($_FILES['index_pic']['tmp_name'])){
			include_once(ROOT_PATH."include/Image.class.php");
			$uploadimg = new upimages();
			$uploadimg->img_save_dir = ROOT_PATH.gamelink_IMG_DIR;
			if(!$uploadimg->upload_img($_FILES['index_pic'])){
				showmessage($uploadimg->errmsg);
			}else{
				$clientimg = gamelink_IMG_DIR.$uploadimg->img_new_name; //图片名称
				delete_file(ROOT_PATH.gamelink_IMG_DIR.$formval['clientimg']);
			}
		}else{
			$clientimg=$formval['clientimg'];
		}
	
	
    $ad_name = trim($_POST['ad_name']);
	$zlei = intval($_POST['media_type']);
	$row = array(
				'ad_name' => $ad_name,
				'en_name' => $formval['en_name'],
				'catid' => $formval['catid'],
				'ad_url'	=> $formval['ad_url'],
				'ad_code'	=> $ad_code,
				'index_pic'	=> $clientimg,
				'ad_alt'	=> $formval['ad_alt'],
	            'media_type' => $zlei,			
				'hd_index'	=> intval($formval['hd_index']),
				'tj_index'	=> intval($formval['tj_index']),
				'issue'	=> intval($formval['issue']),
				'addtime' => time(),
				'content' => $formval['content'],
				'en_content' => $formval['en_content'],
				'jianjie' => $formval['jianjie'],
				'en_jianjie' => $formval['en_jianjie']
			);

	if($Result=='add'){
		if (!$ad_name){
			showmessage("标题不能为空!");
		}
		//if ($zlei==0){
			//showmessage("请选择类别!");
		//}
		$id = $db->insert($db_prefix."gamelink",$row);
		if($id){
			admin_op_log('add','banner',$row['title']);	//写入记录
			showmessage("添加成功",'gamelinkList.php');
		}else{
			showmessage("添加失败",'gamelinkEdit.php?Result=add');
		}
	}elseif($Result=='modify'){
		// if (!$ad_name){
		// 	showmessage("标题不能为空!");
		// }
		// if(!$clientimg){
		// 	showmessage("图片不能为空!");
		// }




		$flg = $db->update($db_prefix."gamelink",$row,"id='$id'");
		if($flg){
			admin_op_log('edit','网站介绍',$row['id']);	//写入记录
			showmessage("编辑成功！","gamelinkList.php?page=".$page);
		 }else{
			 showmessage("编辑失败！","gamelinkEdit.php?Result=modify&id=".$id."&page=".$page);
		 }
	}
}elseif($Result=='modify'){
	
	$rs=$db->get_one("select * from ".$db_prefix."gamelink where id='$id'");
			$start_date=$rs['starttime'];
			$stop_date=$rs['stoptime'];
			$index_pic=$rs['index_pic'];
	if(isset($rs['ad_code']) && $rs['ad_code']){
	  if(in_array(substr($rs['ad_code'], -3, 3), array('gif','jpg','png','jpeg'))){
	    $img_url = $rs['ad_code'];
	  }elseif (substr($rs['ad_code'], -3, 3) == 'swf'){
	    $flash_url = $rs['ad_code'];
	  }
	}
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
<!--
function chkForm(){
  with(document.form1){
  if(title.value==""){
    alert("请输入 名称.");
    title.focus();
    return false;
    }
  /*if(Category_big.value=="0"){
    alert("请选择作品类别.");
    Category_big.focus();
    return false;
  }*/
   }
}

var editor;
KindEditor.ready(function(K){
	editor = K.create('#content',{allowFileManager : true,filterMode:false});
	editor = K.create('#en_content',{allowFileManager : true,filterMode:false});
});

//-->
</script>
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
					<li tabid="list" class="list"><a><span><? if(empty($rs['ad_name']))echo '添加使用教程';else echo'编辑使用教程'?></span></a></li>
				</ul>
			</div>
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
				<form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>&page=<?=$page?>" method="post" name="form" enctype="multipart/form-data" onSubmit="return chkForm();">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
						<tbody>
							<tr>
								<td width="120" class="EAEAF3 right td1"><span class="red"></span>标题：</td>
								<td class="EAEAF3 left td2">
									<?=$arr[$rs['id']];?>
								</td>
							</tr>
							<tr>
								<td width="120" class="EAEAF3 right td1"><span class="red"></span>地址链接：</td>
								<td class="EAEAF3 left td2"><input name="ad_url" type="text" style="width:355px" value="<?=$rs['ad_url'];?>"></td>
							</tr>
							<tr style="display:none;">
								<td width="120" class="EAEAF3 right td1"><span class="red">* </span>英文标题：</td>
								<td class="EAEAF3 left td2"><input name="en_name" type="text" style="width:355px" value="<?=$rs['en_name'];?>"></td>
							</tr>
							<!--<tr>
								<td class="EAEAF3 right td1"><span class="red">* </span>案例类别：</td>
								<td class="EAEAF3 left td2">
									<select name="media_type" size="1">
										<option value="0">---请选择类别---</option>
										<option value="1" <? if ($rs['media_type']==1){echo "selected";}?> >教育行业</option>
										<option value="2" <? if ($rs['media_type']==2){echo "selected";}?> >公检法行业</option>
										<option value="3" <? if ($rs['media_type']==3){echo "selected";}?> >政企行业</option>
										<option value="4" <? if ($rs['media_type']==4){echo "selected";}?> >医疗行业</option>
									</select>
								</td>
							</tr>-->        
							<tr style="display:none;">
								<td width="120" class="EAEAF3 right td1">图片ALT：</td>
								<td class="EAEAF3 left td2"><input name="ad_alt" type="text" style="width:355px" value="<?=$rs['ad_alt'];?>"></td>
							</tr>						  		                 
							<!-- <tr>
								<td class="EAEAF3 right td1"><span class="red">* </span>展示图片：</td>
								<td class="EAEAF3 left td2"><?PHP
								if(!empty($rs['index_pic'])){
								?>
								<a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(1)" onMouseOut="hideImgDiv(1)">[查看图片]
								<span class="showimg" id="showimg_1"><img src="<?='../'.$rs['index_pic'];?>" style="z-index:999;"/></span></a>
								<?PHP } ?>
								<input id="index_pic" name="index_pic" type="file" style="width:200px;" value="上传图片" >
								或者填写地址： <input name="clientimg" type="text" style="width:300px" value="<?=$rs['index_pic'];?>"><span style="color:red;"> 图片最佳大小 497px*290px</span></td>
							</tr>  -->        
							<!--<tr>
								<td class="EAEAF3 right td1"><span class="red">* </span>简介：</td>
								<td class="EAEAF3 left td2" style="padding:5px">
								<textarea name="jianjie" id="jianjie" style="width:750px; height:100px;"><?PHP echo $rs['jianjie']?></textarea>
								</td>
							</tr>-->
							<tr style="display:none;">
								<td class="EAEAF3 right td1">英文简介：</td>
								<td class="EAEAF3 left td2" style="padding:5px">
								<textarea name="en_jianjie" id="en_jianjie" style="width:750px; height:100px;"><?PHP echo $rs['en_jianjie']?></textarea>
								</td>
							</tr>
							<!-- <tr>
								<td class="EAEAF3 right td1"><span class="red">* </span>正文：</td>
								<td class="EAEAF3 left td2" style="padding:5px">
								<textarea name="content" id="content" style="width:100%; height:300px; display:none"><?PHP echo $rs['content']?></textarea>
								</td>
							</tr> -->
							<tr style="display:none;">
								<td class="EAEAF3 right td1">英文正文：</td>
								<td class="EAEAF3 left td2" style="padding:5px">
								<textarea name="en_content" id="en_content" style="width:100%; height:300px; display:none"><?PHP echo $rs['en_content']?></textarea>
								</td>
							</tr>
							<!-- <tr>
								<td  class="EAEAF3 right td1">是否发布：</td>
								<td class="EAEAF3 left td2">
								<input name="issue" type="checkbox" value="1" <? if($rs['issue']==1)echo'checked';?> class="checkbox" />&nbsp;是否发布</td>
							</tr>  
							<tr>
								<td class="EAEAF3 right td1">序号：</td>
								<td class="EAEAF3 left td2"><input name="stor" type="text"  value="<?=$rs['stor']?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['stor']?>'}" onFocus="if (value == '<?=$rs['stor']?>') {value =''}" ></td>
							</tr> -->
							<tr>
								<td class="EAEAF3 right td1">&nbsp;</td>
								<td class="EAEAF3 left td2"  height="30"><input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;<input name="back" type="button" class="button"  value="返回" onClick="javascript:history.back();"></td>
							</tr>
						</tbody>
					</table>
				</form><!--
					 <table width="100%" border="0">
					  <tr>
						<td>
						<?PHP
						if(!empty($rs['pic'])){
							 if(strtolower(substr($rs['pic'],0,7))!='http://') $rs['pic'] = '../'.$rs['pic'];
							?>
					   <img src="<?=$rs['pic']?>" />
						<?PHP }?></td>
					  </tr>
					</table>

					-->
		</div>
	</div>
</div>	
</body>
<script type="text/javascript">
var MediaList = new Array('0', '1', '2', '3');

function showMedia(AdMediaType)
{
 for (I = 0; I < MediaList.length; I ++)
{
 if (MediaList[I] == AdMediaType)
 document.getElementById(AdMediaType).style.display = "";
 else
 document.getElementById(MediaList[I]).style.display = "none";
 }
}
</script>
</html>
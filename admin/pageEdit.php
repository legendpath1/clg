<?
include_once("include/init.php");
global $start_date,$stop_date ;
$id=intval($_REQUEST['id']);
$start_date=date("Y-m-d");
$stop_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-date('w')+7,date("Y")));
$start_date=$_POST['start_date'];
$stop_date=$_POST['stop_date'];
$act=$_REQUEST['act'];
$lid=$_REQUEST['lid'];
$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
$rs['stor'] = 99;
$rs['issue'] = 1;
if($act=='edit'){
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
		
		

	
	$ad_name = trim($_POST['ad_name']);
	$ad_pic_con = trim($_POST['ad_pic_con']);

	$row = array(
				'ad_name' => $ad_name,
				'lid' => $lid,
				'en_name' => $formval['en_name'],
				'ad_pic_con' => $ad_pic_con,
				'en_pic_con' => $formval['en_pic_con'],
				'catid' => $formval['catid'],
				// 'ad_url'	=> $formval['adv_url'],
				'ad_code'	=> $ad_code,
				//'spic'   => $ad_code2,
				'ad_index_url'	=> $formval['ad_url'],
				'stor'	=> $formval['stor'],
				'issue'	=> 1,
				'isindex'	=> $formval['isindex'],
				'addtime' => time(),
			);

	if($Result=='add'){
		if (!$ad_name){
      	showmessage("标题不能为空!");
		}
		$id = $db->insert($db_prefix."pton",$row);
		if($id){
			admin_op_log('add','商业中心',$row['title']);	//写入记录
			showmessage("添加成功",'pageList.php?lid='.$lid);
		}else{
			showmessage("添加失败",'pageEdit.php?Result=add&lid='.$lid);
		}
	}elseif($Result=='modify'){
		$flg = $db->update($db_prefix."pton",$row,"id='$id'");
		if($flg){
			admin_op_log('edit','商业中心',$row['title']);	//写入记录
			showmessage("编辑成功！","pageList.php?lid=".$lid);
		 }else{
			 showmessage("编辑失败！","pageEdit.php?Result=modify&id=".$id."&lid=".$lid);
		 }
	}
}elseif($Result=='modify'){
	$rs=$db->get_one("select * from ".$db_prefix."pton where id='$id'");
			$start_date=$rs['starttime'];
			$stop_date=$rs['stoptime'];
	if(isset($rs['ad_code']) && $rs['ad_code']){
	  if(in_array(substr($rs['ad_code'], -3, 3), array('gif','jpg','png','jpeg'))){
	    $img_url = $rs['ad_code'];
	  }
	}
	if(isset($rs['ad_index_play']) && $rs['ad_index_play']){
	  if(in_array(substr($rs['ad_index_play'], -3, 3), array('gif','jpg','png','jpeg'))){
	    $img_url2 = $rs['ad_index_play'];
	  }
	}
}

?>
<html>
<head>
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="swfupload/jquery.min.js"></script>
<script type="text/javascript" src="swfupload/jquery.uploadify-3.1.min.js"></script>
<script type="text/javascript">
	  //多图片上传
	$(document).ready(function() {
		
        $('#file_upload').uploadify({
            'onSelect' :function(){shows3();},
			'onUploadSuccess' : function(file, data, response) {  
 		       //alert(response);
			  var board=document.getElementById("pic2");
			  if(board.value!='')
			  {
			  	  $("#allpics").append("<div class='imgall'><img src='"+data+"' width='100' height='100' /><span><input type='button' title='删除'></span></div>");
				  board.value=board.value+','+data;
			  }else
			  {
			  	 $("#allpics").html("<div class='imgall'><img src='"+data+"' width='100' height='100' /><span><input type='button' title='删除'></span></div>");
			      board.value=data;
			  }
			  
			//成功后加载	删除修改图片代码		  
			$(".imgall input").each(function(i){
				$(this).click(function(){
					$(this).parent().parent().remove();
					var im="";
					$(".imgall").each(function(index){
						
						if(im==""){
							im=$(".imgall img:eq("+index+")").attr('src');
							}else{
							im+=","+$(".imgall img:eq("+index+")").attr('src');	
							}
					})
					  board.value=im;
					  if(im==""){
						 $("#allpics").html('<img src="swfupload/moren.jpg" width="100px" height="100px" >');//如果为空，显示默认的图片
					   }
				})	
			})	  
		}, 	
		
		'onUploadStart' : function(file) {
		$("#file_upload").uploadify("settings","formData",{"pic1":$("#aaa").val()});
		},	
		
		'removeTimeout':'6',//进度条消失时间
		'method'   : 'post',
		'buttonImage':'',					
		'height': '30',
		'width': '75',
		'queueID' : 'some_file_queue',
		'displayData'    : 'percentage',
		'fileTypeExts'     : '*.jpg;*.jpeg;*.png;*.gif;*.bmp',
		'fileTypeDesc'    : '支持的格式(.JPG,.JPEG,.PNG,.GIF,.BMP)',//允许的格式
		'fileSizeLimit':'100024KB',//上传文件大小限制
		'queueSizeLimit':'10',//同时上传的文件最大数
		//'auto':false,//是否选取文件后自动上传
		'swf' : 'swfupload/uploadify.swf?ver='+ Math.random(),//是组件自带的flash，用于打开选取本地文件的按钮 
		'uploader' : 'swfupload/poster.php',
		'buttonText': '上传图片'	 
		// Your options here
     });		
});	
	//$('#file_upload').uploadify('upload','*')//控制文件上传		
</script>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<!-- 技术支持：http://www.eidea.net.cn -->
<title></title>
<link href="dwz/themes/default/style.css" rel="stylesheet" type="text/css" />
<link href="dwz/themes/css/core.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" />
<![endif]-->
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
<script language="javascript" src="../js/DatePicker/WdatePicker.js"></script>
<script type="text/javascript" charset="utf-8" src="../include/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script language="javascript">

function chkForm(){
  with(document.form1){
  if(ad_name.value==""){
    alert("请输入名称.");
    ad_name.focus();
    return false;
    }
  
   }
}
</script>
<script language="javascript">
var editor;
KindEditor.ready(function(K){
	editor = K.create('#ad_pic_con',{allowFileManager : true,filterMode:false});
	//editor = K.create('#en_pic_con',{allowFileManager : true,filterMode:false});
});
</script>
<style>
#allpics{ height:auto}
.imgall{position: relative; width:200px; height:100px; float:left; margin-right:10px}
.imgall span{ position:absolute; width:100px; height:32px;bottom:0px; right:0px; display:none; }
.imgall:hover span{display:block;}
.imgall span input{float:right; cursor:pointer; background-image: url(images/trash-alt-empty-32.png); width:32px; height:32px; border:0; }
</style>
</head>
<body>
<div id="container">
	<div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
			<div class="tabsPageHeaderContent">
			  <ul class="navTab-tab1">
				<li tabid="list" class="list">
					<a>
						<span><? if($Result=='add')echo'添加';else echo'编辑'?><?php if($lid==1){?>商业中心<?php }elseif($lid==2){ ?>交通枢纽<?php }elseif($lid==3){ ?>市政公共<?php }elseif($lid==4){ ?>连锁经营<?php }elseif($lid==5){ ?>产品系列<?php } ?></span>
					</a>
				</li>
			  </ul>
			</div>        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）</div>
			<form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>&lid=<?=$lid?>" method="post" name="form" enctype="multipart/form-data" onSubmit="return chkForm();">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tbody>		
					<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red">* </span>标题：</td>
						<td width="88%" class="EAEAF3 left td2"><input name="ad_name" type="text" style="width:355px" value="<?=$rs['ad_name'];?>"></td>
					</tr>
					<!--<tr>
						<td width="12%" class="EAEAF3 right td1"><span class="red">* </span>英文标题：</td>
						<td width="88%" class="EAEAF3 left td2"><input name="en_name" type="text" style="width:355px" value="<?=$rs['en_name'];?>"></td>
					</tr>-->
					<tr>
						<td class="EAEAF3 right td1">列表图片：</td>
						<td class="EAEAF3 left td2"><?PHP
						if(!empty($rs['ad_code'])){
						?>
						<a href="javascript:vod(0);" class="red showimg_a" onMouseOver="showImgDiv(1)" onMouseOut="hideImgDiv(1)">[查看图片]
						<span style="z-index:9999;" class="showimg" id="showimg_1"><img src="<?='../'.$rs['ad_code'];?>" width="300"/></span></a>
						<?PHP } ?>&nbsp;&nbsp;<input name="pic" type="file" style="width:200px"> 或者图片网址： <input name="advimg" type="text" value="<?php echo isset($img_url)? $img_url : null;?>" style="width:300px;"> <font style="color:#F00">图片最佳大小：420px*300px</font>
						</td>
					</tr>
					<!--<tr>
						<td class="EAEAF3 right td1"><span class="red">* </span>产品类别：</td>
						<td class="EAEAF3 left td2"><select name="catid" size="1">
						<?PHP
							$result = $db->query("select * from ".$db_prefix."mtype order by stor asc,id desc");
							echo ("select * from ".$db_prefix."mtype order by stor asc,id desc");
							if($db->num_rows($result)){
								while( $list = $db->fetch_array($result)){
						?>
							<option value="<?=$list['id']?>"<? if($rs['catid']==$list['id'])echo' selected'?>><?=$list['title'];?></option>
						<?PHP } }?>
						</select></td>
					</tr>-->		
					<tr>
						<td class="EAEAF3 right td1">正文：</td>
						<td class="EAEAF3 left td2" style="padding:5px">
						<textarea name="ad_pic_con" id="ad_pic_con" style="width:100%; height:250px;"><?PHP echo $rs['ad_pic_con']?></textarea>
					   </td>
					</tr>
					<!--<tr>
						<td class="EAEAF3 right td1">英文正文：</td>
						<td class="EAEAF3 left td2" style="padding:5px">
						<textarea name="en_pic_con" id="en_pic_con" style="width:100%; height:250px;"><?PHP echo $rs['en_pic_con']?></textarea>
					   </td>
					</tr>-->		  
				</tbody>
				<tbody>
					<tr>
						<td  class="EAEAF3 right td1">是否发布：</td>
						<td class="EAEAF3 left td2">
						<!--<input name="isindex" type="checkbox" value="1" <? if($rs['isindex']==1)echo'checked';?> class="checkbox" />&nbsp;是否首页展示&nbsp;&nbsp;-->
						<input name="issue" type="checkbox" value="1" <? if($rs['issue']==1)echo'checked';?> class="checkbox" />&nbsp;发布</td>
					</tr>
				</tbody>
					<tr>
						<td class="EAEAF3 right td1">序号：</td>
						<td class="EAEAF3 left td2"><input name="stor" type="text"  value="<?=$rs['stor']?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['stor']?>'}" onFocus="if (value == '<?=$rs['stor']?>') {value =''}" ></td>
					</tr>
					<tr>
						<td class="EAEAF3 td1">&nbsp;</td>
						<td class="EAEAF3 left td2"  height="30"><input name="Submit" type="submit" class="button" value=" 保存 ">&nbsp;&nbsp;&nbsp;<input name="back" type="button" class="button"  value="返回" onClick="javascript:history.back();"></td>
					</tr>
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
							<?PHP }?>
						</td>
					</tr>
				</table>-->
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
<!--编辑时删除图片操作-->
<!--编辑时删除图片操作-->
<script>
$(document).ready(function() {
var board=document.getElementById("pic2");	  
	$(".imgall input").each(function(i){
		$(this).click(function(){
			$(this).parent().parent().remove();
			var im="";
			$(".imgall").each(function(index){
				if(im==""){
					im=$(".imgall img:eq("+index+")").attr('src');
				}else{
					im+=","+$(".imgall img:eq("+index+")").attr('src');	
				}
			})
			board.value=im;
			if(im==""){
				$("#allpics").html('<img src="swfupload/moren.jpg" width="100px" height="100px" >');//如果为空，显示默认的图片
			}
		})
	})	
})
</script>
</html>
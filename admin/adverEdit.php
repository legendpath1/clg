<?
include_once("include/init.php");
global $start_date,$stop_date ;
$id=intval($_REQUEST['id']);
$start_date=date("Y-m-d");
$stop_date=date("Y-m-d",mktime(0,0,0,date("m"),date("d")-date('w')+7,date("Y")));
$start_date=$_POST['start_date'];
$stop_date=$_POST['stop_date'];
$act=$_REQUEST['act'];
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
		
		if(!empty($_FILES['index_pic']['tmp_name'])){
			include_once(ROOT_PATH."include/Image.class.php");
			$uploadimg = new upimages();
			$uploadimg->img_save_dir = ROOT_PATH.ADV_IMG_DIR;
			if(!$uploadimg->upload_img($_FILES['index_pic'])){
				showmessage($uploadimg->errmsg);
			}else{
				$ad_index_play = ADV_IMG_DIR.$uploadimg->img_new_name; //图片名称
				delete_file(ROOT_PATH.ADV_IMG_DIR.$formval['adv_index_pic']);
			}
		}else{
			$ad_index_play=$formval['adv_index_pic'];
		}
	
	$ad_name = trim($_POST['ad_name']);
	$ad_pic_con = trim($_POST['ad_pic_con']);

	$row = array(
				'ad_name' => $ad_name,
				'ad_pic_con' => $ad_pic_con,
				'catid' => $formval['catid'],
				'advclass' => $formval['adverid'],
				// 'ad_url'	=> $formval['adv_url'],
				'ad_index_play'	=> $ad_index_play,
				'ad_code'	=> $ad_code,
				'ad_index_url'	=> $formval['ad_url'],
	            'media_type' => intval($_POST['media_type']),
				'stor'	=> $formval['stor'],
				'issue'	=> 1,
				'isindex'	=> $formval['isindex'],
				'addtime' => time(),
			);
	if($Result=='add'){
		if (!$ad_name){
      	showmessage("标题不能为空!");
		}
		$id = $db->insert($db_prefix."advert",$row);
		if($id){
			admin_op_log('add','图片',$row['title']);	//写入记录
			showmessage("添加成功",'adverList.php');
		}else{
			showmessage("添加失败",'adverEdit.php?Result=add');
		}
	}elseif($Result=='modify'){
		$flg = $db->update($db_prefix."advert",$row,"id='$id'");
		if($flg){
			admin_op_log('edit','图片',$row['title']);	//写入记录
			showmessage("编辑成功！","adverList.php");
		 }else{
			 showmessage("编辑失败！","adverEdit.php?Result=modify&id=".$id);
		 }
	}
}elseif($Result=='modify'){
	$rs=$db->get_one("select * from ".$db_prefix."advert where id='$id'");
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
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<!-- 技术支持：http://www.eidea.net.cn -->
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
<script language="javascript" src="../js/DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script language="javascript">

function chkForm(){
  with(document.form1){
  if(ad_name.value==""){
    alert("请输入标题.");
    ad_name.focus();
    return false;
    }
  
   }
}

</script>
</head>
<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab1">
			<li tabid="list" class="list"><a><span><? if($Result=='add')echo'添加';else echo'编辑'?>产品</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：输入的内容中请不要含有非法字符（比如半角状态下的引号）</div>

      <form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>" method="post" name="form" enctype="multipart/form-data" onSubmit="return chkForm();">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tbody>
		 <tr>
            <td width="12%" class="EAEAF3 right td1">产品标题：</td>
            <td width="88%" class="EAEAF3 left td2"><input name="ad_name" type="text" style="width:355px" value="<?=$rs['ad_name'];?>"></td>
        </tr>
		<tr>
		    <td class="EAEAF3 right"><span class="red">* </span>产品类型：</td>
            <td class="EAEAF3 left"><select name="catid" size="1">
			<?PHP
            	$result = $db->query("select * from ".$db_prefix."imgstype order by stor asc,id desc");
				echo ("select * from ".$db_prefix."imgstype order by stor asc,id desc");
				if($db->num_rows($result)){
					while( $list = $db->fetch_array($result)){
			?>
				<option value="<?=$list['id']?>"<? if($rs['catid']==$list['id'])echo' selected'?>><?=$list['title'];?></option>
			<?PHP } }?>
			</select></td>
		</tr>
		<tr>
		    <td class="EAEAF3 right"><span class="red">* </span>图片位置：</td>
            <td class="EAEAF3 left"><select name="adverid" size="1">
			<?PHP
            	$result = $db->query("select * from ".$db_prefix."adverclass order by id asc,id desc");
				echo ("select * from ".$db_prefix."adverclass order by id asc,id desc");
				if($db->num_rows($result)){
					while( $list = $db->fetch_array($result)){
			?>
				<option value="<?=$list['id']?>"<? if($rs['advclass']==$list['id'])echo' selected'?>><?=$list['title'];?></option>
			<?PHP } }?>
			</select></td>
		</tr>
        <!-- <tr>
            <td width="12%" class="EAEAF3 right td1">产品标题：</td>
            <td width="88%" class="EAEAF3 left td2"><input name="ad_name" type="text" style="width:355px" value="<?=$rs['ad_name'];?>"></td>
        </tr> -->
		<tr>
            <td width="12%" class="EAEAF3 right td1">产品说明：</td>
            <td width="88%" class="EAEAF3 left td2"><input name="ad_pic_con" type="text" style="width:355px" value="<?=$rs['ad_pic_con'];?>"></td>
        </tr>
		<!-- <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>内容：</td>
            <td class="EAEAF3 left td2" style="padding:5px">
			<textarea name="ad_pic_con"  style="width:700px; height:100px;"><?PHP echo $rs['ad_pic_con']?></textarea>
           </td>
          </tr> -->
		  
          </tbody>
          <tbody>
          <tr>
            <td  class="EAEAF3 right td1">推荐：</td>
            <td class="EAEAF3 left td2">
			<!-- <input name="isindex" type="checkbox" value="1" <? if($rs['isindex']==1)echo'checked';?> class="checkbox" />&nbsp;是否首页展示&nbsp;&nbsp; -->
            <input name="issue" type="checkbox" value="1" <? if($rs['issue']==1)echo'checked';?> class="checkbox" />&nbsp;是否发布</td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>上传首页展示图片：</td>
            <td class="EAEAF3 left td2">
            <a href="../<?=$img_url2;?>" target="_blank" class="red">[查看图片]</a>&nbsp;&nbsp;<input name="index_pic" type="file" style="width:400px"><br/>
            或者图片网址： <input name="adv_index_pic" type="text" value="<?php echo isset($img_url2)? $img_url2 : null;?>" style="width:300px;"> 图片最佳大小：715px*260px
            </td>
          </tr>
		  <tr>
            <td width="12%" class="EAEAF3 right td1">首页跳转链接：</td>
            <td width="88%" class="EAEAF3 left td2"><input name="ad_url" type="text" style="width:355px" value="<?=$rs['ad_index_url'];?>"></td>
		  </tr>
		  <!--<tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>上传产品图片：</td>
            <td class="EAEAF3 left td2">
            <a href="../<?=$img_url;?>" target="_blank" class="red">[查看图片]</a>&nbsp;&nbsp;<input name="pic" type="file" style="width:400px"><br/>
            或者图片网址： <input name="advimg" type="text" value="<?php echo isset($img_url)? $img_url : null;?>" style="width:300px;"> 图片最佳大小：715px*260px
            </td>
          </tr>-->
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
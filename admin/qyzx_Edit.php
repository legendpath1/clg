<?
include_once("include/init.php");
$id=intval($_REQUEST['id']);
$act=$_REQUEST['act'];
$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
$rs['stor'] = 99;
$rs['issue'] = 1;
$rs['media_type'] = 0;
if($act=='edit'){
	include("include/check_form.php");
	$errmsg = check_form($_POST);
	if(!empty($errmsg)){
		showmessage($errmsg);
	}
	$formval = $_POST;

	if($_POST['media_type'] == '0'){
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
	}
	elseif($_POST['media_type'] == '1'){
	   if ((isset($_FILES['upfile_flash']['error']) && $_FILES['upfile_flash']['error'] == 0) || (!isset($_FILES['upfile_flash']['error']) && isset($_FILES['ad_img']['tmp_name']) && $_FILES['upfile_flash']['tmp_name'] != 'none'))
        {
            /* 检查文件类型 */
            if ($_FILES['upfile_flash']['type'] != "application/x-shockwave-flash")
            {
                showmessage("上传的Flash文件格式不正确！");
            }

            /* 生成文件名 */
            $urlstr = date('Ymd');
            for ($i = 0; $i < 6; $i++)
            {
                $urlstr .= chr(mt_rand(97, 122));
            }

            $source_file = $_FILES['upfile_flash']['tmp_name'];
            $target      = ROOT_PATH ;
            $file_name   = ADV_IMG_DIR.$urlstr .'.swf';

            if (!move_upload_file($source_file, $target.$file_name))
            {
                showmessage("上传Flash文件失败！");
            }
            else
            {
                $ad_code = $file_name;
            }
        }
        elseif (!empty($_POST['flash_url']))
        {
            if (substr(strtolower($_POST['flash_url']), strlen($_POST['flash_url']) - 4) != '.swf')
            {
                showmessage("上传的Flash文件格式不正确！");
            }
            $ad_code = $_POST['flash_url'];
        }

        if (((isset($_FILES['upfile_flash']['error']) && $_FILES['upfile_flash']['error'] > 0) || (!isset($_FILES['upfile_flash']['error']) && isset($_FILES['upfile_flash']['tmp_name']) && $_FILES['upfile_flash']['tmp_name'] == 'none')) && empty($_POST['flash_url']))
        {
            showmessage("Flash文件不能为空！");
        }
	}
$ad_name = trim($_POST['ad_name']);
	$row = array(
				'ad_name' => $ad_name,
				'catid' => $formval['catid'],
				'ad_url'	=> $formval['adv_url'],
				'ad_code'	=> $ad_code,
				'ad_alt'	=> $formval['ad_alt'],
	            'media_type' => intval($_POST['media_type']),
				'stor'	=> $formval['stor'],
				'issue'	=> intval($formval['issue']),
				'addtime' => time(),
				'content' => $formval['content'],
			);

	if($Result=='add'){
if (!$ad_name){
      	showmessage("标题不能为空!");
		}
		$id = $db->insert($db_prefix."qyzx",$row);
		if($id){
			admin_op_log('add','banner',$row['title']);	//写入记录
			showmessage("添加成功",'qyzx_List.php');
		}else{
			showmessage("添加失败",'qyzx_Edit.php?Result=add');
		}
	}elseif($Result=='modify'){
		$flg = $db->update($db_prefix."qyzx",$row,"id='$id'");
		if($flg){
			admin_op_log('edit','banner',$row['title']);	//写入记录
			showmessage("编辑成功！","qyzx_List.php");
		 }else{
			 showmessage("编辑失败！","qyzx_Edit.php?Result=modify&id=".$id);
		 }
	}
}elseif($Result=='modify'){
	
	$rs=$db->get_one("select * from ".$db_prefix."qyzx where id='$id'");
			$start_date=$rs['starttime'];
			$stop_date=$rs['stoptime'];
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
<!-- 技术支持：http://www.gzseo.cn -->
<title></title>
<link href="dwz/themes/default/style.css" rel="stylesheet" type="text/css" />
<link href="dwz/themes/css/core.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link href="dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" />
<![endif]-->
<script language="javascript" src="../js/DatePicker/WdatePicker.js"></script>
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
<script language="javascript" src="../js/DatePicker/WdatePicker.js"></script>
<script type="text/javascript" charset="utf-8" src="../include/kindeditor/kindeditor.js"></script>
<script language="javascript">


var editor;
KindEditor.ready(function(K){
	editor = K.create('#content',{allowFileManager : true,filterMode:false});
});


</script>
</head>
<body>
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
        <div class="tabsPageHeaderContent">
          <ul class="navTab-tab1">
			<li tabid="list" class="list"><a><span>Logo图片</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left"><? if($Result=='add')echo'添加';else echo'编辑'?>图片</div>
		

      <form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>" method="post" name="form" enctype="multipart/form-data" onSubmit="return chkForm();">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
		<tbody>
           <tr>
		    <td class="EAEAF3 right td1"><span class="red">* </span>位置：</td>
            <td class="EAEAF3 left td2"><select name="catid" size="1">
			<?PHP
            	$result = $db->query("select * from ".$db_prefix."qyzxtype order by stor asc,id desc");
				if($db->num_rows($result)){
					while( $list = $db->fetch_array($result)){
			?>
				<option value="<?=$list['id']?>"<? if($rs['catid']==$list['id'])echo' selected'?>><?=$list['title'].' ['.$list['adv_width'].'×'.$list['adv_height'].']'?></option>
			<?PHP } }?>
			</select></td>
		  </tr>
        <tr>
            <td width="120" class="EAEAF3 right td1"><span class="red">* </span>标题：</td>
            <td class="EAEAF3 left td2"><input name="ad_name" type="text" style="width:355px" value="<?=$rs['ad_name'];?>"></td>
          </tr>
		  <tr>
            <td width="120" class="EAEAF3 right td1">图片ALT：</td>
            <td class="EAEAF3 left td2"><input name="ad_alt" type="text" style="width:355px" value="<?=$rs['ad_alt'];?>"></td>
          </tr>
          
		  <tr>
		    <td width="120" class="EAEAF3 right td1">类型：</td>
            <td class="EAEAF3 left td2"><select onChange="showMedia(this.value)" name="media_type">
         <option value="0" <?php if ($rs['media_type'] == 0){echo' selected';}?>>图片</option>
         <option value="1" <?php if ($rs['media_type'] == 1){echo' selected';}?>>Flash</option>
<!--         <option value="2">代码</option>-->
<!--         <option value="3">文字</option>-->
         </select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="issue" value="1" <?php if($rs['issue']==1){echo'checked';}?> align="middle" /> 显示</td>
		  </tr>

          </tbody>
          <tbody id="0" <?php if($rs['media_type']!=0){echo'style="display:none;"';}?>>
          <tr>
            <td width="120" class="EAEAF3 right td1">链接：</td>
            <td class="EAEAF3 left td2"><input name="adv_url" type="text" style="width:400px" value="<?=$rs['ad_url'];?>">
            </td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>上传图片：</td>
            <td class="EAEAF3 left td2">
            <a href="../<?=$img_url;?>" target="_blank" class="red">[查看图片]</a>&nbsp;&nbsp;<input name="pic" type="file" style="width:400px"><br/>
            或者图片网址： <input name="advimg" type="text" value="<?php echo isset($img_url)? $img_url : null;?>" style="width:300px;">
            </td>
          </tr>
          </tbody>
          <tbody id="1" <?php if($rs['media_type']!=1){echo'style="display:none;"';}?>>
          <tr>
            <td class="EAEAF3 right td1">上传Flash文件</td>
            <td class="EAEAF3 left td2">
              <input type='file' name='upfile_flash' size='35' />
              <br /><span class="notice-span" style="display:block"  id="AdCodeFlash">上传该广告的Flash文件,或者你也可以指定一个远程的Flash文件</span>
            </td>

          </tr>
          <tr>
            <td class="EAEAF3 right td1">或Flash网址</td>
            <td class="EAEAF3 left td2">
              <input type="text" name="flash_url" value="<?php echo isset($flash_url)? $flash_url : null;?>" size="35" />
            </td>
          </tr>
          </tbody>
			
		  <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>内容：</td>
            <td class="EAEAF3 left td2" style="padding:5px">
			<textarea name="content" id="content" style="width:100%; height:300px; display:none"><?PHP echo $rs['content']?></textarea>
           </td>
          </tr>
		  <tr>
            <td class="EAEAF3 right td1">序号：</td>
            <td class="EAEAF3 left td2"><input name="stor" type="text"  value="<?=$rs['stor']?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['stor']?>'}" onFocus="if (value == '<?=$rs['stor']?>') {value =''}" ></td>
          </tr>
          <tr>
            <td class="EAEAF3 right td1">&nbsp;</td>
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
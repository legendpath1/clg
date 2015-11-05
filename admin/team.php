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

    $Title = trim($_POST['title']);
    $Title = str_replace($str_del_title, "", $Title);
	$content = $_POST['content'];
	
    $row = array(
      'title'   => $Title,
      'fileurl' => $FileUrl,
      'content' => $_POST['content'],
	  //'map'     => $_POST['map'],
      'seotitle'  => trim($_POST['seotitle']),
      'seodesc' => trim($_POST['seodesc']),
      'seokey'  => trim($_POST['seokey']),
	
    );

    if($Result=='modify'){
      if ($db->num_rows($db->query("SELECT id FROM ".$db_prefix."pages where title='$Title' and id!='$id' ORDER BY id desc"))>0){
        showmessage("名称已存在!");
       }
       if (!$Title){
      showmessage("名称不能为空!");
    }

	if (!$content){
      showmessage("内容不能为空!");
    }
      $flg = $db->update($db_prefix.'pages',$row,'id=1');
      if($flg){
        admin_op_log('edit','单页',$row['title']);  //写入记录

        showmessage("编辑成功！","team.php?Result=modify&id=1");
       }else{
         showmessage("编辑失败！","team.php?Result=modify&id=1");
       }
    }

  }
  elseif($Result=='modify'){
    $rs = $db->get_one("select * from ".$db_prefix."pages where id=1");
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
			<li tabid="list" class="list"><a><span>天绣堂简介</span></a></li>
          </ul>
        </div>
        
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
		<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>

      <form action="?act=save&Result=<?=$Result?>&id=<?=$id?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkForm();">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" >
          <tr>
            <td width="12%" class="EAEAF3 right td1">标题：</td>
            <td width="88%"  class="EAEAF3 left td2"><input name="title" type="text" style="width:700px" value="<?=$rs['title'];?>" ></td>
          </tr>
          
          <tr>
            <td class="EAEAF3 right td1"><span class="red">* </span>内容：</td>
            <td class="EAEAF3 left td2" style="padding:5px">
			<textarea name="content" id="content" style="width:100%; height:300px; display:none"><?PHP echo $rs['content']?></textarea>
           </td>
          </tr>
		  <tr style="display:none">
            <td class="EAEAF3 right td1"><span class="red">* </span>电子地图：<br /><span class="red">750px*350px</span></td>
            <td class="EAEAF3 left td2">
			<textarea name="map" id="map" style="width:700px; height:300px; display:none"><?PHP echo $rs['map']?></textarea>
           </td>
          </tr>
          <tr>
            <td class="EAEAF3 td1"  height="30"></td>
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
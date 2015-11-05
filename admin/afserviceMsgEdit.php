<?
include_once("include/init.php");
$Result=$_REQUEST['Result'];
if(empty($Result)) $Result='add';
$act=$_REQUEST['act'];
$id=intval($_REQUEST['id']);
$rs['issue'] = 1;
$page=$_REQUEST['page'];
if($act=='edit'){
    // include("include/check_form.php");
    // $errmsg = check_form($_POST);
    // if(!empty($errmsg)){
    //   showmessage($errmsg);
    // }
    $formval = $_POST;
    $big_id=$formval['big_id'];
    $content=$formval['content'];

    $row = array(
      'big_id'  => intval($formval['big_id']),
      'small_id'  => 1,
      'content' => $formval['content'],
      'issue'   => intval($_POST['issue']),
	  'stor'   => intval($_POST['stor']),

    );

    if($Result=='add'){


	if (!$content){
      showmessage("内容不能为空!");
    }
    if ($big_id==10){
      showmessage("请选择类别!");
    }


	$id = $db->insert($db_prefix.'afservice',$row);
	if($id){
		admin_op_log('add','售后服务',$row['content']);  //写入记录
		showmessage("添加成功！","afserviceMsgList.php?big_id=".$big_id."&page=".$page);
	}else{
		showmessage("添加失败！","afserviceMsgEdit.php?Result=modify&id=".$id."&page=".$page);
	}

    }elseif($Result=='modify'){

		if (!$formval['content']){
			showmessage("条款不能为空!");
		}
		$flg = $db->update($db_prefix.'afservice',$row,'id='.$id);
		if($flg){
			admin_op_log('edit','售后服务',$row['content']);  //写入记录
			showmessage("编辑成功！","afserviceMsgList.php?big_id=".$big_id."&page=".$page);
		}else{
			showmessage("编辑失败！","afserviceMsgEdit.php?Result=modify&id=".$id."&page=".$page);
		}
    }

}
elseif($Result=='modify'){
    $rs = $db->get_one("select * from ".$db_prefix."afservice where id='$id'");
	
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
	//editor = K.create('#content',{allowFileManager : true,filterMode:false});
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
<body >
<div id="container">
  <div id="navTab" class="tabsPage" >
		<div class="tabsPageHeader">
			<div class="tabsPageHeaderContent">
				<ul class="navTab-tab1">
					<li tabid="list" class="list"><a><span><? if(empty($rs['title']))echo '添加售后服务';else echo'编辑售后服务'?></span></a></li>
				</ul>
			</div>      
		</div>	
		<div class="navTab-panel tabsPageContent layoutBox" >
			<div class="msgInfo left">注意：输入的内容中请不要含有非法字符，也不建议从网页或是word里直接复制内容到编辑器</div>
			<form action="?act=edit&Result=<?=$Result?>&id=<?=$id?>&page=<?=$page?>" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chkForm();">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					
					<tr>
						<td class="EAEAF3 right td1">条款细节:</td>
						<td class="EAEAF3 left td2" style="padding:5px">
						<textarea name="content" id="content" style="width: 395px; height: 41px" ><?PHP echo $rs['content']?></textarea>
						</td>
					</tr>

					<tr>
						<td  class="EAEAF3 right td1">类别：</td>
						<td class="EAEAF3 left td2">
							<select name="big_id" size="1">
								<option value="10">---请选择类别---</option>
								<option value="1" <? if ($rs['big_id']==1){echo "selected";}?> >投诉热线</option>
								<option value="2" <? if ($rs['big_id']==2){echo "selected";}?> >客户经理邮箱</option>
								<option value="3" <? if ($rs['big_id']==3){echo "selected";}?> >服务政策</option>
							</select>
						</td>
					</tr>






					<tr>
						<td class="EAEAF3 right td1">序号:</td>
						<td class="EAEAF3 left td2"><input name="stor" type="text"  value="<?=$rs['stor']?>" onKeyUp="this.value=this.value.replace(/[^\d*]/,'')" onBlur="if (value == '') {value='<?=$rs['stor']?>'}" onFocus="if (value == '<?=$rs['stor']?>') {value =''}" ></td>
						
						</td>
					</tr>
					<tr>
						<td  class="EAEAF3 right td1">是否发布：</td>
						<td class="EAEAF3 left td2">
						
						<input name="issue" type="checkbox" value="1" <? if($rs['issue']==1)echo'checked';?> class="checkbox" />&nbsp;是否发布</td>
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
<script language="JavaScript">
window.onload = function(){
strYYYY = document.form1.YYYY.outerHTML;
strMM = document.form1.MM.outerHTML;
strDD = document.form1.DD.outerHTML;
MonHead = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

//
var y = new Date().getFullYear();
var str = strYYYY.substring(0, strYYYY.length - 9);
for (var i = (y-30); i < (y+30); i++) 
{
str +="<option value='"+ i +"'>"+ i +"</option>rn";
}
document.form1.YYYY.outerHTML = str +"</select>";

//
var str = strMM.substring(0, strMM.length - 9);
for (var i = 1; i < 13; i++)
{
str +="<option value='"+ i +"'>"+ i +"</option>rn";
}
document.form1.MM.outerHTML = str +"</select>";
//判断之前是否有选择
if($("input[name='zhi']").val()==""){
	document.form1.YYYY.value = y;
	document.form1.MM.value = new Date().getMonth() + 1;
}else{
	document.form1.YYYY.value = $("input[name='sj']").val();
	document.form1.MM.value = $("input[name='tian']").val();
}
//

var n = MonHead[new Date().getMonth()];
if (new Date().getMonth() ==1 && IsPinYear(YYYYvalue)) n++;
writeDay(n); //
document.form1.DD.value = new Date().getDate();
}
function YYYYMM(str) //
{
var MMvalue = document.form1.MM.options[document.form1.MM.selectedIndex].value;
if (MMvalue ==""){DD.outerHTML = strDD; return;}
var n = MonHead[MMvalue - 1];
if (MMvalue ==2 && IsPinYear(str)) n++;
writeDay(n)
}
function MMDD(str) //
{
var YYYYvalue = document.form1.YYYY.options[document.form1.YYYY.selectedIndex].value;
if (str ==""){DD.outerHTML = strDD; return;}
var n = MonHead[str - 1];
if (str ==2 && IsPinYear(YYYYvalue)) n++;
writeDay(n)
}
function writeDay(n) //
{
var s = strDD.substring(0, strDD.length - 9);
for (var i=1; i<(n+1); i++)
s +="<option value='"+ i +"'>"+ i +"</option>rn";
document.form1.DD.outerHTML = s +"</select>";
}
function IsPinYear(year)//
{ return(0 == year%4 && (year%100 !=0 || year%400 == 0))}
//--></script>
</html>
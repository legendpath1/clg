// JavaScript Document


function chkbox(form) {
	 var ifcheck="no"
	 for(i=0;i<document.form.elements.length-1;i++){
	 	if(document.form.elements[i].checked){
		   ifcheck="yes";
		}
    }
	if(ifcheck=="no"){
 		alert("出错了，你还没选择要删除的内容呢！")
     return false;
     }
	return true;
}

function checkAll(form){
	for (var i=0;i<form.elements.length;i++){
		var e = form.elements[i];
		if (e.name != 'selectAll')
			e.checked = form.selectAll.checked;
	}
}

function change_power_sort(obj,str,num){
	if(obj.checked==false){
		document.getElementById('powerall').checked = false;
		for(var i=1; i<=num; i++){
			document.getElementById('child_id_'+str+'_'+i).checked = false;
		}
	}
	if(obj.checked==true){
		for(var i=1; i<=num; i++){
			document.getElementById('child_id_'+str+'_'+i).checked = true;
		}
	}
	
	
}

function input_check_val(obj){
	if(obj.checked == true){
		check_allpower_select();
	}else{
		document.getElementById('powerall').checked = false;
	}
}
//用于删除记录
function deldata(action,id,page,lid,catid){
	if (confirm("确定要删除吗?")){ 
		window.location.href="delete.php?action="+action+"&id="+ id+"&page="+page+"&lid="+lid+"";
	} 	
}

//添加产品页切换
function changemenu(num){
	for(var i=1; i<=5; i++){
		if(i==num){
			document.getElementById("m"+i).className = 'bgc1';
			document.getElementById("mc"+i).style.display = 'block';
		}else{
			document.getElementById("m"+i).className = '';
			document.getElementById("mc"+i).style.display = 'none';
		}
	}
}
//添加图片集输入框
var imgnum = 1;
function addimgrow(){
	if(imgnum<10){
	//添加一行 
	var newtr = img_muster.insertRow(); 
	//添加两列 
	var newtd0 = newtr.insertCell(); 
	var newtd1 = newtr.insertCell(); 
	//newtd0.setAttribute("ClassName","EAEAF3");
	//newtd1.setAttribute("ClassName","EAEAF3");
	newtd0.innerHTML = '<span class="EAEAF3">图片描述：<input class="inputstyle" type="text" name="img_desc[]" size="20" maxlength="50"></span>';  
	newtd1.innerHTML='图片位置：<input class="inputstyle" type="file" name="img_url[]" size="35" maxlength="50" />'; 
	}else{
		alert('最多可添加10张图片。');
	}
	imgnum++;
}
function delimgrow(){
	if(imgnum>1){
		img_muster.deleteRow();
	}
	imgnum--;
}
　　//点击当前选中行的时候设置当前行的颜色，同时恢复除当前行外的行的颜色及鼠标事件
function selectRow(target) 
{ 
	var sTable = document.getElementById("ServiceListTable") 
	for(var i=1;i<sTable.rows.length;i++) //遍历除第一行外的所有行 
	{ 
		if (sTable.rows[i] != target) //判断是否当前选定行 
		{ 
			//sTable.rows[i].bgColor = "#EAEAF3"; //设置背景色 
			sTable.rows[i].className = "bgc2"; //设置背景色 
			sTable.rows[i].onmouseover = resumeRowOver; //增加onmouseover 事件 
			sTable.rows[i].onmouseout = resumeRowOut;//增加onmouseout 事件 
		} 
		else 
		{ 
			//sTable.rows[i].bgColor = "#B1B4D1"; 
			sTable.rows[i].className = "bgc2_1"; 
			sTable.rows[i].onmouseover = ""; //去除鼠标事件 
			sTable.rows[i].onmouseout = ""; //去除鼠标事件 
		} 
	} 
} 
//移过时tr的背景色 
function rowOver(target) 
{ 
	//target.bgColor='#DADAE9'; 
	target.className='bgc2_2';  
} 
//移出时tr的背景色 
function rowOut(target) 
{ 
	//target.bgColor='#EAEAF3';
	target.className='bgc2';  
} 
//恢复tr的的onmouseover事件配套调用函数 
function resumeRowOver() 
{ 
	rowOver(this); 
} 
//恢复tr的的onmouseout事件配套调用函数 
function resumeRowOut() 
{ 
	rowOut(this); 
}

//显示隐藏图片
function showImgDiv(i)
{
	 document.getElementById('showimg_'+i).style.display='block';
	
}
function hideImgDiv(i)
{
	 document.getElementById('showimg_'+i).style.display='none';
	
}
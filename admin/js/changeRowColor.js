﻿// JavaScript Document
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
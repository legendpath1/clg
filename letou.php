<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqla = "select * from clg_letou where status='1' order by id desc limit 1";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
$prize = $rowa['prize'];
$temp = $prize;
for ($i=0; $i<8; $i++) {
	$digits[$i] = $temp % 10;
	$temp = $temp / 10;
}

$sqlb = "select * from ssc_member where id='" . $_SESSION['uid'] . "'";
$rsb = mysql_query($sqlb);
$rowb = mysql_fetch_array($rsb);

$sqlc = "select * from clg_letou where status='2' order by id desc limit 1";
$rsc = mysql_query($sqlc);
$rowc = mysql_fetch_array($rsc);
$last_nums = explode(",", $rowc['prize_nums']);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>彩乐宫-大乐透</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="css/letou/css.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="right-tex-box">
  <div class="disc-box">
    <div class="title"></div>
    <div class="box">
      <h2>本期累计总奖金</h2>
  
      <div class="money">
        <p><span><?php echo $digits[7];?></span>
           <span><?php echo $digits[6];?></span>
           <span><?php echo $digits[5];?></span>
           <span><?php echo $digits[4];?></span>
           <span><?php echo $digits[3];?></span>
           <span><?php echo $digits[2];?></span>
           <span><?php echo $digits[1];?></span>
           <span><?php echo $digits[0];?></span> </p>
      </div>
      <div class="last"><strong>上期奖期：<?php echo $rowc['id'];?></strong></div>
      <div class="m-box">
        <ul>
          <li class="sqhm"><strong><img src="images/letou/title-sqhm.png"></strong>
            <p><span><?php echo $last_nums[0];?></span>
               <span><?php echo $last_nums[1];?></span>
               <span><?php echo $last_nums[2];?></span> 
               <span><?php echo $last_nums[3];?></span> 
               <span><?php echo $last_nums[4];?></span> 
               <span><?php echo $last_nums[5];?></span> </p>
          </li>
          <li class="zhye"> <strong><img src="images/letou/title-zhye.png"></strong>
            <p><span><?php echo (number_format($rowb['leftmoney'],2));?></span></p>
          </li>
          <li class="rtmmjl"> <strong><img src="images/letou/title-jl.png"></strong>
            <p><a href="" class="look"></a></p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="num-box">
  <h2></h2>
     <div class="mum" id="mum">
       <span><strong>1</strong></span>
       <span><strong>2</strong></span>
       <span><strong>3</strong></span>
       <span><strong>4</strong></span>
       <span><strong>5</strong></span>
       <span><strong>6</strong></span>
       <span><strong>7</strong></span>
       <span><strong>8</strong></span>
       <span><strong>9</strong></span>
       <span><strong>10</strong></span>
       <span><strong>11</strong></span>
       <span><strong>12</strong></span>
       <span><strong>13</strong></span>
       <span><strong>14</strong></span>
       <span><strong>15</strong></span>
       <span><strong>16</strong></span>
       <span><strong>17</strong></span>
       <span><strong>18</strong></span>
       <span><strong>19</strong></span>
       <span><strong>20</strong></span>
       <span><strong>21</strong></span>
       <span><strong>22</strong></span>
       <span><strong>23</strong></span>
       <span><strong>24</strong></span>
       <span><strong>25</strong></span>
       <span><strong>26</strong></span>
       <span><strong>27</strong></span>
       <span><strong>28</strong></span>
       <span><strong>29</strong></span>
       <span><strong>30</strong></span>
       <span><strong>31</strong></span>
       <span><strong>32</strong></span>
       <span><strong>33</strong></span>
       <span><strong>34</strong></span>
       <span><strong>35</strong></span>
       <span><strong>36</strong></span>
       <span><strong>37</strong></span>
       <span><strong>38</strong></span>
       <span><strong>39</strong></span>
       <span><strong>40</strong></span>
       <span><strong>41</strong></span>
       <span><strong>42</strong></span>
       <span><strong>43</strong></span>
       <span><strong>44</strong></span>
       <span><strong>45</strong></span>
       <span><strong>46</strong></span>
       <span><strong>47</strong></span>
       <span><strong>48</strong></span>
       <span><strong>49</strong></span>
       <span><strong>50</strong></span>
       <span><strong>51</strong></span>
       <span><strong>52</strong></span>
       <span><strong>53</strong></span>
       <span><strong>54</strong></span>
       <span><strong>55</strong></span>
       <span><strong>56</strong></span>
       <span><strong>57</strong></span>
       <span><strong>58</strong></span>
       <span><strong>59</strong></span>
     </div>
  
  
  <div class="your-num">
    <h3></h3>
    
     <div class="box-had" id="box-had">
     <span><strong></strong></span>
       <span><strong></strong></span>
         <span><strong></strong></span>
           <span><strong></strong></span>
             <span><strong></strong></span>
               <span><strong></strong></span>
     </div>
     <a class="sub-buy" id="submitbtn" onclick='form_send()'></a>
  
  </div>
  
  
  </div>
</div>

     <form method='post' action='letou_submit.php' id='the_form'>
  		<input type='hidden' name='data' id='form_data' value=''>
	 </form>

<script type="text/javascript">

//  var sub=document.getElementById("submitbtn");
  var mum=document.getElementById("mum");
  var box=document.getElementById("box-had");
  var box_had=box.getElementsByTagName("strong");
  var mumSpan=mum.getElementsByTagName("strong");
  var ary=[];
  var money=<?php echo $rowb['leftmoney'];?>;

  function form_send(){
	if (ary.length != 6) {
	  alert('请选择6个数字。');
	  return false;
	}  
	if (money < 2) {
	  alert('余额不足。');
	  return false;
	}
	var aryString = '';
	for (var i=0; i<ary.length; i++) {
	  aryString = aryString+ary[i];
	  if (i!=5) {
		aryString=aryString+',';
	  }
	}

	var form = document.getElementById('the_form');
	var data = document.getElementById('form_data');
	data.value = aryString;

    if (form) {
	  form.submit();
    }
  }
  
  function muns(index){

    if(mumSpan[index].className=="hover"){
      mumSpan[index].className="";
      for(var y=0;y<ary.length;y++){
        if(mumSpan[index].innerText==ary[y]){
          ary.splice(y,1);
          console.log(ary);
          sum(box_had,ary);
          return;
        }
      }

    }
    if(ary.length>5){
      console.log(ary);
      return;
    }else{
      for(var i=0;i<ary.length;i++){
        if(mumSpan[index].innerText==ary[i]){
          return
        }else if(ary[i]==0){
          mumSpan[index].className="hover";
          ary[i]=mumSpan[index].innerText;
          sum(box_had,ary);
          return;
        }
      }
      mumSpan[index].className="hover";
      ary.push(mumSpan[index].innerText);
      sum(box_had,ary);
    }
  }

  function sum(ele,item){
    console.log(item);
    item.sort(function(a, b){return a-b;});;
    for(var s=0;s<ele.length;s++){
      if(item[s]!=undefined){
        ele[s].innerText=item[s];
      }
      else {
        ele[s].innerText='';
      }
    }
  }

  for(var i=0;i<mumSpan.length;i++){
    mumSpan[i].span=i;
    mumSpan[i].onclick=function(){
      muns(this.span);
    };
  }
</script>
</body>
</html>

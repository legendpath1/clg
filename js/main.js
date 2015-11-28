// JavaScript Document
$(function(){
    //document value
	var $window = $(window);
	var wh = $window.height();//浏览器显示区域高度
	var ww = $window.width();//浏览器显示区域宽度
	var $ddr="out";
	


	$(".wrap_content,.index_bak,.view_w,.view_v").width(ww);
	var beforeDate = new Date();
	$(".wrap_content,.index_bak,.view_w,.view_v").height(wh);
	
    //loading
	if($("#hidstart").val() == "0")
	{ 
	    var afterDate = new Date(),
        pagePreLoad = (afterDate - beforeDate),
	    time = 20 / pagePreLoad,
		n = 0,
		play = setInterval(function () {
		    if (Number(n) >= 100) {
		        clearInterval(play);
		        n = 100;
		        //页面加载完毕后执行(主线)
		        setTimeout(function () {
		                start();
		        }, 100);
		    };
		    $(".zhuan_font").text(Math.floor(n) + "%");
		    n += time;
		}, 100);

		
	}
	else
	{
	   // $(".index_bak").css("display","block");
       	$(".wrap_content").css("display","block");

	}
	
	//click
	$(".flg_menu ul li").click(function(){
		$(this).siblings().removeClass("click_on");
		$(this).addClass("click_on");
		
	})
	$(".flg_menu ul li.pro").click(function () {

	    var div = $(".intro_bak");
	    $(".shanzi").delay(1000).fadeIn(1000);
	    //div.animate({ "left": 0, "opacity": "1" }, 2200);
	    div.animate({
	        width: '2px',
	    }, 1);
	    div.animate({
	        height: '100%',
	    }, 10);
	    div.animate({
	        left: '50%'
	    }, 500);
	    div.animate({
	        width: '100%',
	        left: '0',
	        top: '0'
	    }, "slow");


	    // setTimeout(function () {
	    //     $(".active_bak").animate({ "left": "100%", "opacity": "1" }, 0);
	    // }, 2200)
	   
	    $(".shanzi").addClass("current");
	    $(".active_bak").css({ "z-index": "999" });
	    $(".intro_bak").css({ "z-index": "1000" });

	})

	$(".flg_menu ul li.active").click(function () {

		if($ddr=='out'){



			    var div = $(".active_bak");
			    $(".shanzi").delay(1000).fadeOut(1000);
			    //div.animate({ "left": 0, "opacity": "1" }, 2200)
			    div.animate({
			        width: '2px',
			    }, 1);
			    div.animate({
			        height: '100%',
			    }, 10);
			    div.animate({
			        left: '50%'
			    }, 500);
			    div.animate({
			        width: '100%',
			        left: '0',
			        top: '0'
			    }, "slow");



			    //画卷
			    setTimeout(function () {
			        $(".intro_bak").animate({ "left": "100%", "opacity": "1" }, 0);
			    }, 2200);
			    


			    //画卷打开
			    setTimeout(
		              function () {
		                  $(".right").animate({ "width": "933px" }, 2000, function () {
		                      $(".list li").fadeIn(1000);
		                      if($('.tip').css('display')=="none"){
		                     	 $(".page").fadeIn(1000);
		                  }
		                      $(".fly").fadeIn(3000);
		                  })
		              }
		              , 2000
		          );



			    $(".active_bak").css({ "z-index": "1000" });
			    $(".intro_bak").css({ "z-index": "999" });
			    $(".shanzi").removeClass("current");
			    $(".wrap_img,.game_img").removeClass("current");



				
		}else if($ddr=='in'){
				$ddr="out";
			    $(".wrap_img,.game_img").removeClass("current");
			    $list.delay(1000).fadeIn(1000);
			    $page.delay(1000).fadeIn(1000);
			    $tip.fadeOut();

		}  
	})





	// $(".go_index").click(function () {
	//     $(".shanzi").delay(1000).fadeOut(1000);
	//     var div = $(".intro_bak,.active_bak");
	//     $(".shanzi").removeClass("current");
	//     div.animate({ "left": "100%", "opacity": "1" }, 3000)
	// });

    //介绍
	$(".clg_bg,.clg_js,.clg_xy,.clg_bz").click(function () {
	    $(".shanzi").addClass("open");
	    $(".shanzi_wrap").fadeOut();
	    setTimeout(function () {
	        $(".shanzi").removeClass("open")
	        $(".shanzi_wrap").fadeIn();
	           
	    }, 1000);
	    if ($(this).attr("class") == "clg_bg") {
	        setTimeout(function () { $(".bg_con").show().siblings(".js_con,.xy_con,.bz_con").hide(); }, 1000);
	    }
	    if ($(this).attr("class") == "clg_js") {
	        setTimeout(function () { $(".js_con").show().siblings(".bg_con,.xy_con,.bz_con").hide(); }, 1000);
	    }
	    if ($(this).attr("class") == "clg_xy") {
	        setTimeout(function () { $(".xy_con").show().siblings(".js_con,.bg_con,.bz_con").hide(); }, 1000);
	    }
	    if ($(this).attr("class") == "clg_bz") {
	        setTimeout(function () { $(".bz_con").show().siblings(".js_con,.xy_con,.bg_con").hide(); }, 1000);
	    }  
	})

    //view
	$(".view").click(function () {
	    $(".view_w").fadeIn();
	})

	$(".close_v").click(function () {
	    $(".view_w").fadeOut();
	})

    //------------------ activity ---------------

	var $list = $(".list");
	var $listLis = $(".list li a span");
	var $tip = $(".tip");
	var $page = $(".page");
	var $clo = $(".tip .active_name .close");
	var $huajuan = $(".huajuan");

    // open det
	$listLis.click(function () {
	    $page.fadeOut(1000);
	    $list.fadeOut(1000);
	    $tip.delay(1000).fadeIn();
	    $(".game_img,.game_img").addClass("current");
	    $ddr='in';
	});

    //close det
	// $clo.click(function () {
	//     $(".game_img,.game_img").removeClass("current");
	//     $list.delay(1000).fadeIn(1000);
	//     $page.delay(1000).fadeIn(1000);
	//     $tip.fadeOut();
 //    });

    // page
	var $pagelis = $(".circles li");            //页码
	var $Previous = $(".circles .btn_l");		//上一页
	var $nextpage = $(".circles .btn_r");		//下一页




    //current page
	$pagelis.click(function () {
	    //var a = $(this).index() + 1;
	    $(this).addClass("cur").siblings().removeClass("cur")
	});


	//prev page
	$Previous.click(function(){

		$(".cur").prev('li').addClass("cur").siblings().removeClass("cur");

	});


	//next page
	$nextpage.click(function(){

		$(".cur").next('li').addClass("cur").siblings().removeClass("cur");


	});





    //login
	$(".login_but").click(function () {
	    if ($("[name='userName']").val() == "" || $("[name='userPwd']").val() == "") {
	        alert("用户名，密码不能为空！");
	        $("[name='userName']").focus();
	    }
	    else {
	        if ($("[name='userName']").val() == "admin" && $("[name='userPwd']").val() == "admin") {
	            window.location.href = "game.html";
	        }
	        else {
	            alert("用户名，密码有误！");
	        }
	    }
	   
       
	})

	//cloud
	setInterval(function() {
	    $(".cloud_1 img").animate({left:"+=160px",opacity: 1},10000).animate({left:"-=160px",opacity: 1},10000);
	    $(".cloud_2 img").animate({ left: "-=160px", opacity: 1 }, 10000).animate({ left: "+=160px", opacity: 1 }, 10000);
	    //$(".cover").animate({ left: "-=160px", opacity: 1 }, 10000).animate({ left: "+=160px", opacity: 1 }, 10000);
	})
	
	//start
	$(".flg_menu ul li:last-child").click(function () {
        $(".login-center").css("z-index","10001");
	    $(".wrap_content .login-center").addClass("up").removeClass("down");
		$("input[name='userName']").focus();
	})
	
	$(".close").click(function () { 
		$(".flg_menu ul li:last-child").removeClass("click_on");
		$(".wrap_content .login-center").removeClass("up").addClass("down");
		$(".login-center").css("z-index", "0");
 
	})

    // --------------game-----------------

	var $house = $(".qp,.hy,.cz,.js,.yl")
	var $houseimg = $(".qp img,.hy img,.cz img,.js img,.yl img")

	var $stages = $(".content .click i .det");
	var $jieshao = $(".jieshao");
	var $leave = $(".jieshao .close");

	var $bu = $(".bu");

    //鼠标移入圆点 换图
	$stages.mouseenter(function(){
	    $(this).addClass('cur').parents().siblings().find(".det").removeClass('cur');
	    
	});

    //open pro
	$stages.click(function(){
	    $jieshao.fadeIn(1000);
	    $bu.fadeIn(500);
	});

    //close pro
	// $leave.click(function(){
	//     $jieshao.fadeOut(1000);
	//     $bu.fadeOut(800);
	// });
	
});



function logodisplay(){
        $(".wrap_content,.index_bak").fadeIn("show");
	}
	function startdisplay(){
	    $(".start,.zhuan_font").fadeOut("show");
	}

function start(){
		setTimeout("logodisplay();startdisplay()",500);
		$("#hidstart").val("1");
}














<?php
/***********************************************************
 * Document Type: Includes
 * Update: 2006/09/22
 * Author: akon
 * Remark: 生成验证码
 ***********************************************************/
    error_reporting('0');


    function getRndCode($length=4,$onlynum=true,$upper=false) {
        $codestr = "0123456789";
        $codestr.= $onlynum ? "" :"abcdefghijklmnopqrstuvwxyz";
        $codechars="";
        for($i=0;$i=999;$i++){
            $order=mt_rand(0,strlen($codestr));
            $codechars .= $codestr[$order];
            if (strlen($codechars)>=$length){
                break;
            }
        }
        return $upper ? strtoupper($codechars) : $codechars;
    }

    // 创建图片
    $width = 45;
    $height = 18;
    $im = ImageCreate($width,$height);

    // 绘制图片背景
    ImageFilledRectangle($im,0,0,200,80,imagecolorallocate($im,mt_rand(240,250),mt_rand(240,250),mt_rand(240,250)));

    // 输出不同颜色的文字
    $gen_code="";
    for ($i=3;$i<=37;$i+=11) {
        $rnd = getRndCode(1,true,false);

        $gen_code.= $rnd;
        ImageString($im,5,$i,1,$rnd,imagecolorallocate($im,mt_rand(0,200),mt_rand(0,200),mt_rand(0,200)));
    }

    // 加入干扰象素
    for($i=0;$i<20;$i++) {
        imagesetpixel($im, mt_rand(0,$width),rand(0,$height),imagecolorallocate($im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
    }

    // 输出图片
    session_start();
    $_SESSION["VerifyCode"] = $gen_code;
    header("content-type: image/png");
    ImagePng($im);
    imagedestroy($im);
?>
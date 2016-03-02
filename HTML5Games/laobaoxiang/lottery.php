<?php
/*******************************************/
/**      author:  hoho                   **/
/**      http://www.thinkcart.net        **/
/******************************************/

//奖品配置
$award = array(
    // 奖品ID => array('奖品名称',概率)
    0 => array('没中',0.5),
    1 => array('黄金万两',0.05),
    2 => array('葵花宝典',0.15),
    3 => array('徐夫人匕首',0.1),
    4 => array('藏宝图',0.1),
    5 => array('和氏璧',0.1),
);

$r =rand(1,100);
$num = 0;
$award_id = 0;
foreach($award as $k=>$v){
    $tmp = $num;
    $num += $v[1]*100;
    if($r>$tmp && $r<=$num){
        $award_id = $k;
        break;
    }
}

jsonBack(array('award_id'=>$award_id,'award_name'=>$award[$award_id][0]));

//
function jsonBack($data){
    header("Content-type: application/json");
    if(isset($_GET['callback'])){
        echo $_GET['callback']."(".json_encode($data).")";
    }else{
        echo json_encode($data);
    }
    exit();
}
?>
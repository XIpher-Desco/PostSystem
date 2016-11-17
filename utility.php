<?php
// var_dumpを綺麗に出力！これ大事
function pure_dump($var){
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

//TimeInterval型を秒に変換
function timeIntervaltoSecond($interval){
    return $interval->days*86400 + $interval->h*3600 + $interval->i*60 + $interval->s;
}

function dateTimeDifftoSecond($dateTime1,$dateTime2){
	return timeIntervaltoSecond($dateTime1->diff($dateTime2));
}

?>
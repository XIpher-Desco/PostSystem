<?php

//ini_set('display_errors', 1);
require_once"./utility.php";
require_once"./MySQLPDOClass.php";
session_start();
$untrustedId = $_POST['my_id'];
$untrustedPass = $_POST['password'];
//$save = $_POST['save'];

//自作dbクラス
$db = new MySQLPDOClass();
$escapedId = $db->escape($untrustedId);
$escapedPass = $db->escape($untrustedPass);
//pure_dump($result->result[0]->uid);

//cookieに保存
if($db->authUser($escapedId,$escapedPass)){
    //認証成功、Session開始
    //Xipher以下でのみ送信、HTTPSのみでCookieをサーバに送信
    setcookie('my_id', $escapedId, 0,'','',1);
    //Session開始,uidがサーバーにある=認証されている。
    $_SESSION["uid"]=$escapedId;
    $message ='ユーザーを認証しました。';
    $message .='<br>';
    $message .='ID:'.$_SESSION["uid"].'<br>';
}else{
    setcookie('my_id','');
    $message = 'IDまたはPWが間違っています';
    $message .='ID:'.$escapedId.'<br>';
    $message .='PW:'.password_hash($escapedPass,PASSWORD_DEFAULT);
}


?>
<html>
<head>
<meta http-equiv="refresh" content="2;URL=./index.php">
</head>
<h1>ログイン結果</h1>
<p><?php echo $message; ?></p>
<p><a href="./index.php">戻る</a></p>
</html>
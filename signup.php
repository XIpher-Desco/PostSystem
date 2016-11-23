<?php

require_once"./utility.php";
require_once"./MySQLSimpleClass.php";

$untrustedId = $_POST['my_id'];
$untrustedPass = $_POST['password'];
$untrustedMailaddress = $_POST['mailaddress'];
//$save = $_POST['save'];


$db = new MySQLSimpleClass();
$escapedId = $db->escape($untrustedId);
$escapedPass = $db->escape($untrustedPass);
$escapedMailaddress = $db->escape($untrustedMailaddress);
$hashPass = password_hash($escapedPass,PASSWORD_DEFAULT);
$result = json_decode($db->query("INSERT INTO Users (uid,hashpw,mailaddress) VALUES ('$escapedId','$hashPass','$escapedMailaddress')"));
//pure_dump($result->result[0]->uid);

//cookieに保存
if($result->status){
//if(false){
    //認証成功、Session開始
    session_start();
    //Xipher以下でのみ送信、HTTPSのみでCookieをサーバに送信
    setcookie('my_id', $untrustedId, 0,'','',1);
    $_SESSION["uid"]=$escapedId;
    $message ='ユーザーを登録しました。';
    $message .='<br>';
    $message .='ID:'.$_SESSION["uid"].'<br>';
    $message .='PW:'.$hashPass;
}else{
    setcookie('my_id','');
    $message = '登録に失敗しました。';
    $message .='ID:'.$escapedId.'<br>';
    $message .='PW:'.password_hash($escapedPass,PASSWORD_DEFAULT);
}
?>

<html>
<head>
<meta http-equiv="refresh" content="2;URL=./index.php">
</head>
<h1>登録しました</h1>
<p><?php echo $message; ?></p>
<p><a href="./index.php">戻る</a></p>
</html>
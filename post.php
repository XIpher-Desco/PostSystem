<?php
//ini_set('display_errors', 1);
require_once"./utility.php";
require_once"./MySQLSimpleClass.php";

session_start();

$db = new MySQLSimpleClass();
$escapedPostContent = $db->escape($_POST['postContent']);
//投稿システム
if($_COOKIE['my_id']==$_SESSION["uid"]){
	$now = date('Y/m/d H:i:s');
	$result = json_decode($db->query("INSERT INTO Posts (uid,postDate,content) VALUES ('$_SESSION["uid"]','$now','$escapedPostContent')"));
	print_f($result->status);
}
?>
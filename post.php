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
	$postId = $_SESSION['uid'];
	$result = json_decode($db->query("INSERT INTO Posts (uid,postDate,content) VALUES ('$postId','$now','$escapedPostContent')"));
	echo json_encode($result->status);
}
?>
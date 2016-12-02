<?php
//ini_set('display_errors', 1);
require_once"./utility.php";
require_once"./MySQLPDOClass.php";

session_start();

$db = new MySQLPDOClass();
$escapedPostContent = $db->escape($_POST['postContent']);
//投稿システム
if($escapedPostContent!="" && $_COOKIE['my_id']==$_SESSION["uid"]){
	$postId = $_SESSION['uid'];
	$result = json_decode($db->postContent($postId,$escapedPostContent));
	echo json_encode($result->status);
}else{
	http_response_code( 400 ) ;
    return json_encode (
        array (
            "status"=>"400 Bad_Request"
        )
    );
}
<?php
//ini_set('display_errors', 1);
require_once"./utility.php";
require_once"./MySQLPDOClass.php";

session_start();
//投稿閲覧システム
$db = new MySQLPDOClass();
$result = json_decode($db->getPosts(15));
?>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LoginPage</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body>
    <div class="container contents">
    <div class="jumbotron">
    <h1>Hello, world!!</h1>
    
    <!-- Sessionがある場合 -->
    
    <?php if (isset($_SESSION["uid"])): ?>
        <h2><?php echo $_SESSION["uid"] ?>でログインしています。</h2>
        <a href="./logout.php">ログアウト</a>
        </div>
        <div class="container">
        <div id="postForm">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">今何してる？</span>
                <input type="text" class="form-control" name="postContent" id="postContentForm" size="10">
            </div>
            <button type="button" id="postButton" class="btn btn-primary">投稿</button>
        </div>
    <!-- Sessionが無い場合 -->
    <?php else: ?>
    	<h2>ログインしていません。</h2>
        <a href="./login.php">ログイン</a>
        </div>
        <div class="container">
    <?php endif; ?>
  		<table class="table">
	    	<thead>
	      		<tr>
    	        	<th>投稿日時</th>
    	        	<th>内容</th>
    	        	<th>投稿ユーザー</th>
	      	    </tr>
   		   </thead>
        <tbody>
        <dev>
        <?php 
            foreach($result->result as $resultValue){
                echo "<tr>";
                echo "<td>$resultValue->postDate</td>";
                echo "<td>$resultValue->content</td>";
                echo "<td>$resultValue->uid</td>";
                echo "</tr>";
            }
        ?>
        </dev>
        </tbody>
        </table>
    </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/index.js"></script>
    </div>
    </body>
</html>
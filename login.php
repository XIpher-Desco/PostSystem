<?php
//ini_set('display_errors', 1);
require_once"./redirectHttps.php";
require_once"./utility.php";

session_start();

?>
<!DOCTYPE html>
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
    </div>
    <!-- Session変数にuidがある場合 既にログイン済み-->
    <?php if (isset($_SESSION["uid"])): ?>
        <h2><?php echo $_SESSION["uid"] ?>でログインしています。</h2>
        <a href="./logout.php">ログアウト</a>
    <!-- Session変数にuidが無い場合 ログアウト後もしくは初回-->
    <?php else: ?>
        <h2 id="formtitle">ログインをお願いします。</h2>
        
            <form action="loginA.php" method="post" id="loginform">
                <div class="form-group"  id="my_id">
                    <label for="ID">ID</label>
                    <input type="text" class="form-control" name="my_id" size="10">
                </div>
                <div class="form-group" id="password">
                    <label for="passwd">パスワード</label>
                    <input type="password" class="form-control" name="password" placeholder="パスワードを記入">
                </div>
                <button type="submit" id="loginButton" class="btn btn-primary">ログイン ≫</button>
            </form>
        <button type="button" id="changeSingUpButton" class="btn btn-primary">新規登録</button>
    <?php endif; ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/login.js"></script>
    </div>
    </body>
</html>
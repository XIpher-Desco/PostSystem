<?php
    if (isset($_COOKIE["PHPSESSID"])) {
        setcookie("PHPSESSID", '', time() - 1800, '/');
    }

    session_destroy();
?>
<html>
<head>
<meta http-equiv="refresh" content="2;URL=./index.php">
</head>
<h1>ログアウトしました</h1>
<p><a href="./index.php">戻る</a></p>
</html>
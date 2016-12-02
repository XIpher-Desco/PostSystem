<?php 

//setcookieやSession変数は使わないこと！
ini_set('display_errors', 1);
require_once"./utility.php";
require_once"./header.php";
//require_once"./classHeader.php";

if (array_shift(get_included_files()) === __FILE__) {
    die('エラー：正しいURLを指定してください。');
}


class MySQLPDOClass
{
	public $pdo;
	//アクセスを許可するテーブル名
	private $tableWhiteList;
	//アクセスを許可するカラム名
	private $columnWhiteList;
	

	//コンストラクタ
	function __construct($host = 'localhost', $user = 'xipher', $pass = 'garuruga', $dbname = 'col')
	{
		try{
			//DBに接続
			$this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",$user,$pass);
			array(PDO::ATTR_EMULATE_PREPARES => false);
		} catch (PDOException $e) {
 			exit('データベース接続失敗。'.$e->getMessage());
 		}
 		//SQL実行時にエラーが発生すると例外を投げる
 		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 		$this->tableWhiteList = ['Users','Posts'];
 		$this->columnWhiteList[$this->tableWhiteList[0]] = ['uid','hashpw','nikname'];
		$this->columnWhiteList[$this->tableWhiteList[1]] = ['uid','postDate','content'];
	}
	//SQL実行型（ステートメント使う）
	function query($sql){
		$stmt = $this ->pdo -> prepare($sql);
		return json_encode($this->execStatement($stmt));
	}

	//ステートメントを実行（トライキャッチを関数化）
	function execStatement($stmt){
		try{
			$stmt -> execute();
		} catch(PDOException $e){
			$rtn = [
				'status'=>FALSE,
				'result'=>"",
				'error'=>$e->getMessage()
			];
			return $rtn;
		}
		$rtn = [
			'status'=>TRUE,
			'result'=>$stmt -> fetchAll(PDO::FETCH_ASSOC),
			'error'=>""
		];
		return $rtn;
	}
	//セレクト文テーブルとカラムと条件(WHERE)を指定できる(予定)
	function select($table = 'Posts', $col = ['uid','postDate','content'], $con){
		//テーブルチェック
		if(in_array($table,$this->tableWhiteList)){
			//カラムチェック
			for($i = 0;$i < count($col);$i++){
				if(!in_array($col[$i],$this->columnWhiteList[$table])){
					exit('許可されていないカラム');
				}
			}
			if(isset($con)){
				$sql = "SELECT ".implode(',', $col)." FROM ".$table." ".$con;
			}else{
				$sql = "SELECT ".implode(',', $col)." FROM ".$table;
			}
			$this->query($sql);
		}else{
			exit('許可されていないテーブル');
		}
	}
	//最新の投稿を取得
	function getPosts($numberOfPosts=10){
		$sql = 'SELECT uid,postDate,content FROM Posts ORDER BY postid desc LIMIT :number';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':number',$numberOfPosts,PDO::PARAM_INT);
		return json_encode($this->execStatement($stmt));
	}
	//記事を投稿
	function postContent($uid, $content){
		//Userチェック 本当に存在するか？
		if(!$this->existUser($uid)){
			$rtn = [
				'status'=>FALSE,
				'result'=>"",
				'error'=>'User not exist'
			];
			return json_encode($rtn);
		}
		$sql = 'INSERT INTO Posts (uid,postDate,content) VALUES (:postId,:now,:PostContent)';
		$stmt = $this->pdo->prepare($sql);
		$now = date('Y/m/d H:i:s');
		$stmt->bindParam(':postId',$uid,PDO::PARAM_STR);
		$stmt->bindParam(':now',$now,PDO::PARAM_STR);
		$stmt->bindParam(':PostContent',$content,PDO::PARAM_STR);
		return json_encode($this->execStatement($stmt));
	}

	//新規登録
	function registerUser($uid, $hashpw, $mail, $nickname){
		//Userチェック 同じuidは登録出来ないようにする
		if($this->existUser($uid)){
			$rtn = [
				'status'=>FALSE,
				'result'=>"",
				'error'=>'Username has already exists'
			];
			return json_encode($rtn);
		}
		$sql = 'INSERT INTO Users (uid,hashpw,mailaddress,nickname) VALUES (:uid, :hashpw, :mail, :nickname';
		
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
		$stmt->bindParam(':hashpw',$hashpw,PDO::PARAM_STR);
		$stmt->bindParam(':mail',$mail,PDO::PARAM_STR);
		$stmt->bindParam(':nickname',$nickname,PDO::PARAM_STR);

		return json_encode($this->execStatement($stmt));
	}

	//Userが存在するかどうか
	function existUser($userName){
		$sql = 'SELECT uid FROM Users WHERE uid = :userName';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':userName',$userName,PDO::PARAM_STR);
		if(isset($this->execStatement($stmt)['result'][0])){
			return true;
		}
		return false;
	}
	//User認証成功か失敗のみ判定
	function authUser($uid,$password){
		$sql = 'SELECT hashpw FROM Users WHERE uid = :uid';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
		if(password_verify($password,$this->execStatement($stmt)['result'][0]['hashpw'])){
			return true;
		}
		return false;
	}

	function escape($str){return htmlspecialchars($str,ENT_QUOTES);}
}

<?php 
ini_set('display_errors', 1);
require_once"./utility.php";
require_once"./header.php";

class MySQLPDOClass
{
	public $pdo;
	private $tableWhiteList;
	//アクセスを許可するテーブル名
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
 		$this->columnWhiteList[$this->tableWhiteList[0]] = ['uid','hashpw'];
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
	//セレクト文テーブルとカラムと条件(WHERE)を指定できる
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
		$sql = 'INSERT INTO Posts (uid,postDate,content) VALUES (:postId,:now,:PostContent)'
		$stmt = $this->pdo->prepare($sql);
		$now = date('Y/m/d H:i:s');
		$stmt->bindParam(':postId',$uid,PDO::PARAM_STR);
		$stmt->bindParam(':now',$now,PDO::PARAM_STR);
		$stmt->bindParam(':PostContent',$content,PDO::PARAM_STR);
		return json_encode($this->execStatement($stmt));
	}

	function escape($str){return htmlspecialchars($str,ENT_QUOTES);}
}

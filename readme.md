#投稿システム

##各ファイルの説明
###index.php
トップページ
ログインしているときだけ、投稿フォームが出現する。
最新１０件を表示

###login.php
ログインフォームページ
ログイン及び新規登録フォームがあり、ログインか新規登録が出来る。
ログイン認証の成功失敗関わらずloginA.phpに飛ばされる。

###loginA.php
ログインの認証を行う。
２秒後にトップページに飛ばされる。

###signin.php
新規登録ページ
２秒後にトップページに飛ばされる。

###logout.php
ログアウトする場所

###post.php
トップページの投稿フォームからDBに投稿する。

###utility.php
自作の便利関数まとめ場所

##出来てること
- ログイン
	- ページをまたいだログインの継続
- ログアウト
- サインイン
- 投稿フォーム
	- ログイン時のみ投稿
- 投稿閲覧
	- 最新１０件

##今後作りたい物
- 投稿削除
- post及びsigninのINSERTのセキュリティ向上
- グループ機能（Lineみたいな）
	- グループ単位に投稿

##指摘事項
- PHPのバージョン違い 5.6にしてください OK 
- セキュリティ
	- クロスサイトリクエストフォージェリ
	- クロスサイトスクリプティング
	- HTMLSPECIALCHARAS OK
		- 関数の引数指定
    - post.php postcontentの有無 
    - 与えられた値が配列じゃないか？（例）
    - Let's Encrypt使う
    - SQLを自動で生成してくれれば楽 OK
    - プレースホルダを使う（int-char） OK
    - PDO（my_sqli）以外（shift_jisはダメ） OK
- DBインデックス
    - 文字コード UTF-8 MU4
- PHP終了タグをなくしておくとよい OK
- ファイル単位で切り分ける
- DBの設定ファイル等を別に切り分ける（userのデータ）
##今後の展望
- テーマを決めて時間を使ってほしい
	- １つのこだわり
		- UI（ユーザリビディ）
		- サービス
		- 見栄え
		- 
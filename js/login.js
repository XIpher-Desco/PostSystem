function changeFormtoSignUp(){
	//メールフォーム用divを作成
	// var mailaddressDev = document.createElement('div');
	// mailaddressDev.setAttribute('class','form-group');
	// mailaddressDev.setAttribute('id','mailaddress');

	var mailaddressDev = $("<dev />",{
		"class":"form-group",
		"id":"mailaddress"
	}); 

	//メールフォームdivのラベルを作成
	// var mailLabel = document.createElement('label');
	// mailLabel.setAttribute('for','mail');

	var mailLabel = $("<label />",{
		"for":"mail"
	});

	//メールフォームdiv内のinputを作成
	// var mailinput = document.createElement('input');
	// mailinput.setAttribute('type','text');
	// mailinput.setAttribute('class','form-control');
	// mailinput.setAttribute('name','mailaddress');
	// mailinput.setAttribute('placeholder','メールアドレスを入力';)

	var mailinput = $("<input />",{
		"type":"text",
		"class":"form-control",
		"name":"mailaddress",
		"placeholder":"メールアドレスを入力"
	});

	//各エレメントをdivに追加
	// mailaddressDev.appendChild(mailLabel);
	// mailaddressDev.appendChild(mailinput);

	mailaddressDev.append(mailLabel);
	mailaddressDev.append(mailinput);

	//フォームをパスワードフォームの下に追加
	$("#password").after(mailaddressDev);

	//ボタンの内容を変更
	$("#loginButton").text('サインアップ ≫');
	$("#changeSingUpButton").text("ログインフォーム");
	$("#formtitle").text("新規登録");

	//リンク先を変更
	$("#loginform").attr("action","signup.php");

	//ボタンを変更
	//クリックイベントを削除
	$("#changeSingUpButton").off();
	//クリックイベントを追加
	$("#changeSingUpButton").on("click",function(){
		changeFormtoLogin();
	});
}

function changeFormtoLogin(){
	$("#mailaddress").remove();

	//ボタンの内容を変更
	$("#loginButton").text('ログイン ≫');
	$("#changeSingUpButton").text("新規登録");
	$("#formtitle").text("ログイン");

	//リンク先を変更
	$("#loginform").attr("action","loginA.php");

	//ボタンを変更
	//クリックイベントを削除
	$("#changeSingUpButton").off();
	//クリックイベントを追加
	$("#changeSingUpButton").on("click",function(){
		changeFormtoSignUp();
	});
}
$("#changeSingUpButton").on("click",function(){
	changeFormtoSignUp();
});


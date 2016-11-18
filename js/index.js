function postContent(){
	//フォームの内容を取得
	var postContentText = $("#postContentForm").val();
	$("#postContentForm").val("");
	//フォームの内容が空でなければ
	if(postContent!=""){
		$.post("post.php",
			{ postContent: postContentText},
			function(data){
				var postResult = data;
				if(postResult){
					//tureだったら
					location.reload()
				}
			});
	}

}
//ボタンにクリックイベントを設定
$("#postButton").on("click",function(){
	postContent();
});

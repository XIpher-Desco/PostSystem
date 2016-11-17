function postContent(){
    var postContent = $("#postContentForm").val();
    $.post("test.php",
      { postContent: postContent},
      function(data){
        var postResult = data;
    }
    );
}
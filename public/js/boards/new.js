$(document).ready(function() {
  CKEDITOR.replace("sl_content", {
    fullPage: true,
    allowedContent: true,
		 filebrowserUploadUrl: '/ckeditor/upload'
  });
  
  $(".poll_delete").click(function(){
  	if($("#poll_title li").length<=2) {
  		alert('항목은 최소 두개는 입력되어야 합니다.')
  		return false;
  	}
  	$(this).parent().remove();
  });
  
	$("#poll_add").click(function(){
  	$("#poll_title").append($("#poll_title li:last").clone(true));
  	});
});
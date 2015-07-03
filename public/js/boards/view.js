$(document).ready(function(){
	  $("a.simple_image").fancybox({
	        'opacity'   : true,
	        'overlayShow'        : true,
	        'overlayColor': '#000000',
	        'overlayOpacity'     : 0.9,
	        'titleShow':true,
	        'openEffect'  : 'elastic',
	        'closeEffect' : 'elastic'
	      });

	$(".show_comment_comment_form").click(function(){
		var comment_form=$(this).parent().parent().parent().find('.comment_comment_form');
		if(comment_form.is(':visible')) {
			$(this).text('댓글 쓰기');
			comment_form.slideUp();
		} else {
			$(this).text('댓글 쓰기 닫기');			
			comment_form.slideDown();
		}
		
		return false;
	});
	$(".new_comment_form textarea,.comment_comment_form textarea").focus(textarea_focus);
	
	function textarea_focus(){
		if($(this).attr('placeholder')) {
			if(confirm('로그인후 사용가능합니다. 지금 로그인 하시겠습니까?')) {
				location.href='/login?redirect=1';
			}
		}
	}	
	
	$(".comment-delete-button").click(function(){
		
		if(!confirm('정말로 삭제합니까?')) {
			return false;
		}
		
		var uri=$.uri.setUri($(this).attr('href'));
		var id=uri.segment(3);
		var r=$(this).parent().parent().parent();
		
		$.post('/communities/comments/delete/'+id, {
			'id' : id,
			//'category_id' : category_id,
			'json' : true
		}, function(data) {
			if(data.result=='success') {
				r.remove();
			} else {
				alert(data.message);
			}
		},'json');
		return false;
	});
	
		$(".comment-comment-delete-button").click(function(){
		
		if(!confirm('정말로 삭제합니까?')) {
			return false;
		}
		
		var uri=$.uri.setUri($(this).attr('href'));
		var id=uri.segments(3);
		var r=$(this).parent().parent().parent();	
		
		$.post('/communities/comments/comments/delete/'+id, {
			'id' : id,
		//	'category_id' : category_id,
			'json' : true
		}, function(data) {
			if(data.result=='success') {
				r.remove();
			} else {
				alert(data.message);
			}
		},'json');
		return false;
	});
});
$(document).ready(function() {
	
	$("#faqCategoryList a.title").click(getList);
	$("#faqList dt a.title").click(getContent);
	
	function getList() {
		var tt=$(this);
		var parent=$(this).parent();		
		
		$.getJSON($(this).attr('href')+'&format=json',{'json':true},function(data){
			$("#faqList").empty();
			if(data.list.length) {
				$.each(data.list,function(index,value){
					var a=$('<a class="title" href="/boards/faqs/index.php?id='+value.id+'">'+value.title+'</a>').click(getContent);
					if(data.admin) {
						var div=$('<div class="sl_faq_menu"><a></a> &nbsp; | &nbsp; <a rel="nofollow" data-method="delete" data-confirm=""></a></div>');
						div.find('a:first').attr('href','/boards/faqs/edit.php?id='+value.id);
						div.find('a:eq(1)').attr('href','/boards/faqs/index.php?id='+value.id);
						$('<dt>').appendTo("#faqList").append(a).append(div);
					} else {
						$('<dt>').appendTo("#faqList").append(a);
					}
				});
			} else {
				$('<dt></dt>').appendTo("#faqList");
			}

			$("#faqCategoryList li").removeClass('on');
			parent.addClass('on');
			
			var faqCategoryId=$.uri.setUri(tt.attr('href')).param("faq_category_id");			
			
			if(data.admin) {
				$("#faqCategoryList li .sl_faq_category_menu").remove();
				var dd=$('<div class="sl_faq_category_menu"><a></a><br /><a rel="nofollow" data-method="delete" data-confirm=""></a></div>');
				dd.find('a:first').attr('href','/boards/faq_categories/edit.php?id='+faqCategoryId);
				dd.find('a:eq(1)').attr('href','/boards/faq_categories/index.php?id='+faqCategoryId);
				parent.append(dd);
			}
			
			$('#sl_bottom_menu a:eq(1)').attr('href','/faqs/new?faq_category_id='+faqCategoryId);		
		});
		return false;
	}
	
	function getContent(){
		var gid=$.uri.setUri($(this).attr('href')).param("id");
		var parent=$(this).parent();
		$.getJSON('/boards/faqs/show.php?id='+gid,{'json':true},function(value){
			if(parent.next().get(0)) {
				if(parent.next().get(0).tagName!='DD') {
					parent.after('<dd>');	
				}
			} else {
				parent.after('<dd>');
			}
			$("#faqList dt").removeClass('on');
			$("#faqList dd").hide();
			parent.addClass('on');
			parent.next().html('<p>'+nl2br(value.content.content)+'</p>').slideDown();			
		});

		return false;
	}	
});

function nl2br (str, is_xhtml) {
	  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>';
	  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
$(document).ready(function() {
	$(".sl_search_form ul li a").click(function(){
		var search_type=$.uri.setUri($(this).attr('href')).param("search_type");
		$('.sl_search_form select[name="search_type"]').val(search_type).change();
		$(".sl_search_form:first button:first").html($(this).text()+' &nbsp; <span class="caret"></span>').parent().removeClass('open');		
		//$("#sl_search_form ul.dropdown-menu").hide();
		return false;
	});
	
	$(".search_type").change(function(){
		var search_type_text=$('.sl_search_form ul li a:contains("'+$(this).find('option[value="'+$(this).val()+'"]').text()+'")').text();		
		$("#sl_search_form:first button:first").html(search_type_text+' &nbsp; <span class="caret"></span>').parent().removeClass('open');
	//	$(".search_type").val($(this).val());
		$(this).parent().parent().find('input[type="search"]:first').focus();
	});
});
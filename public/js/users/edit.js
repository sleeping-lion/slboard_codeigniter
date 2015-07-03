$(document).ready(function() {
	var email_check = false;

	$("#sl_board_user_edit_form").submit(function() {

	});
	
	$("#delete_photo").change(function(){
		if($(this).is(':checked')) {
			$("#sl_photo").attr('disabled','disabled').hide();
		} else {
			$("#sl_photo").removeAttr('disabled').show();
		}
	});
});

function clear_message() {
	if($("#sl_message").length) {
		$("#sl_message").remove();
	}
}

function display_message(message,alert_type) {	
	if(!alert_type)
		alert_type='danger';
	if($("#sl_message").length) {
		$("#sl_message").empty();
		$("#sl_message").html('<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>'+message);
	} else {
		$("#sl_board_user_new").before('<div id="sl_message" role="alert" class="alert alert-'+alert_type+'"><button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">close</span></button>'+message+'</div>');
	}
}
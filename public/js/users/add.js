$(document).ready(function() {
	var email_check = false;

	$("#sl_board_user_new_form").submit(function() {

	});

	$('#check_email_available_button').click(function() {
		var email = $('#sl_email').val();

		if (!$.trim(email).length) {
			alert($('#message_no_email').val());
			$('#sl_email').focus();
			return false;
		}

		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(email)) {
			alert($('#message_invalid_email').val());
			$('#sl_email').focus();			
			return false;
		}

		$(this).parent().parent().removeClass('has-error').removeClass('has-success');
		
		$.getJSON('/users/check_email', {
			'email' : email,
			'json' : true
		}, function(data) {
			if(data.exists) {
				$('#sl_email').parent().parent().addClass('has-error');
				display_message($('#message_exists_email').val());
				email_check=false;
			} else {
				$('#sl_email').parent().parent().addClass('has-success');
				clear_message();				
				email_check=true;
			}
		});
	}).change(function(){
		$(this).parent().parent().removeClass('has-error').removeClass('has-success');
				
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
var	owf_display_msg_interval,
	owf_display_msg_running = false,
	owf_display_msg_ticks = 0;

function owf_admin_display_msg_periodic() {
	owf_display_msg_ticks = owf_display_msg_ticks - 1;
	console.debug(owf_display_msg_ticks);
	if(owf_display_msg_ticks <= 0) {
		$('#owf-admin-infobar').html('').slideUp('normal');
		clearInterval(owf_display_msg_interval);
		owf_display_msg_running = false;
	}
}
	
function owf_admin_display_msg(text) {
	$('#owf-admin-infobar').html(text);
	
	owf_display_msg_ticks = 2;
	if(!owf_display_msg_running) {
		$('#owf-admin-infobar').slideDown('slow');
		owf_display_msg_running = true;
		owf_display_msg_interval = setInterval("owf_admin_display_msg_periodic()", 1000);
	}
}
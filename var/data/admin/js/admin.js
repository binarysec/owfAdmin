var	owf_display_msg_interval,
	owf_display_msg_seed,
	owf_display_msg_running = false,
	owf_display_msg_ticks = 0;

function owf_admin_display_msg_periodic() {
	owf_display_msg_ticks = owf_display_msg_ticks - 1;
	if(owf_display_msg_ticks <= 0) {
		$('#owf-admin-infobar-'+owf_display_msg_seed).html('').slideUp('normal');
		clearInterval(owf_display_msg_interval);
		owf_display_msg_running = false;
	}
}
	
function owf_admin_display_msg(seed, text, seconds) {
	$('#owf-admin-infobar-'+seed).html(text);
	owf_display_msg_ticks = seconds ? seconds : 2;
	owf_display_msg_seed = seed;
	if(!owf_display_msg_running) {
		$('#owf-admin-infobar-'+seed).slideDown('slow').css("visibility", "visible");
		owf_display_msg_running = true;
		owf_display_msg_interval = setInterval("owf_admin_display_msg_periodic()", 1000);
	}
}
